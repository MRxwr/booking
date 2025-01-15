<?php
if( !isset($_POST["vendorId"]) || empty($_POST["vendorId"]) ){
    echo outputError(array("msg"=>direction("Vendor is required","المتجر مطلوب")));die();
}elseif( !isset($_POST["branchId"]) || empty($_POST["branchId"]) ){
    echo outputError(array("msg"=>direction("Branch is required","الفرع مطلوب")));die();
}elseif( !isset($_POST["serviceId"]) || empty($_POST["serviceId"]) ){
    echo outputError(array("msg"=>direction("Service is required","الخدمة مطلوبة")));die();
}elseif( !isset($_POST["date"]) || empty($_POST["date"]) ){
    echo outputError(array("msg"=>direction("Date is required","التاريخ مطلوب")));die();
}elseif( !isset($_POST["time"]) || empty($_POST["time"]) ){
    echo outputError(array("msg"=>direction("Time is required","الوقت مطلوب")));die();
}elseif( !isset($_POST["customer"]["name"]) || empty($_POST["customer"]["name"]) ){
    echo outputError(array("msg"=>direction("Customer name is required","اسم العميل مطلوب")));die();
}elseif( !isset($_POST["customer"]["email"]) || empty($_POST["customer"]["email"]) ){
    echo outputError(array("msg"=>direction("Customer email is required","البريد الالكتروني الخاص بالعميل مطلوب")));die();
}elseif( !isset($_POST["customer"]["mobile"]) || empty($_POST["customer"]["mobile"]) ){
    echo outputError(array("msg"=>direction("Customer mobile is required","رقم الهاتف الخاص بالعميل مطلوب")));die();
}else{
    $vendorId = $_POST["vendorId"];
    $branchId = $_POST["branchId"];
    $serviceId = $_POST["serviceId"];
    $pictureType = $_POST["pictureTypeId"];
    $extras = $_POST["extras"];
    $themes = $_POST["themeId"];
    $extraInfo = $_POST["extraInfo"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    if( $vendor = selectDBNew("vendors",[$vendorId],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
        if( $vendor[0]["type"] == 3 ){
            if( $pictureTypeCheck = selectDBNew("picturetype",[$pictureType,$vendorId],"`id` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0'","") ){
            }else{
                echo outputError(array("msg"=>direction("Picture type not exists for the current vendor","نوع الصورة غير موجود للمتجر الحالي")));die();
            }
        }
        if( !empty($extras) ){
            if( $extrasCheck = selectDBNew("extras",[$vendorId,$extras],"`vendorId` = ? AND `status` = '0' AND `hidden` = '0' AND FIND_IN_SET(`id`,?)","") ){

            }else{
                echo outputError(array("msg"=>direction("Extras not exists for the current vendor","الاضافات غير موجودة للمتجر الحالي")));die();
            }
        }
        if( $branch = selectDBNew("branches",[$branchId,$vendorId],"`id` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0'","") ){
            if( $service = selectDBNew("services",[$serviceId,$vendorId],"`id` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0'","") ){
                if( $calendars = selectDBNew("calendar",[$vendorId,$branchId,$date,$date],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND `startDate` <= ? AND `endDate` >= ? ORDER BY `id` ASC","") && $date >= date("Y-m-d") ){
                    if( $blockedPeriodsBranches = selectDBNew("blockdate",[$vendorId,$branchId,$date],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND ? NOT IN BETWEEN `startDate` AND `endDate` ORDER BY `id` ASC","") ){
                        echo outputError(array("msg"=>direction("Date is blocked please select another date","تم حظر التاريخ يرجى تحديد تاريخ اخر")));die();
                    }else{
                        $day = date("w",strtotime($date));
                        if( $blockedDaysBranches = selectDBNew("blockday",[$vendorId,$branchId,$day],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND `day` = ? ORDER BY `id` ASC","") ){
                            echo outputError(array("msg"=>direction("Date is blocked please select another date","تم حظر التاريخ يرجى تحديد تاريخ اخر")));die();
                        }else{
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://booking.createkuwait.com/requests/index.php?a=GetTimeSlots',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => array(
                                    'branchId' => "{$branchId}",
                                    'vendorId' => "{$vendorId}",
                                    'date' => "{$date}",
                                    'serviceId' => "{$serviceId}",
                                ),
                            ));
                            $response = curl_exec($curl);
                            $response = json_decode($response, true);
                            curl_close($curl);
                            if( $response["ok"] == true && in_array($time, $response["data"]["timeSlots"]) ){
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://booking.createkuwait.com/requests/index.php?a=Payment',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => array(
                                    'vendorId' => "{$vendorId}",
                                    'branchId' => "{$branchId}",
                                    'serviceId' => "{$serviceId}",
                                    'date' => "{$date}",
                                    'time' => "{$time}",
                                    'extras' => "{$extras}",
                                    'pictureTypeId' => "{$pictureType}",
                                    'themes' => "{$themes}",
                                    'extraInfo' => json_encode($extraInfo),
                                    'customer[name]' => "{$_POST["customer"]["name"]}",
                                    'customer[mobile]' => "{$_POST["customer"]["mobile"]}",
                                    'customer[email]' => "{$_POST["customer"]["email"]}",
                                    ),
                                ));
                                $response = curl_exec($curl);
                                curl_close($curl);
                                echo outputData(json_decode($response, true));die();
                            }else{
                                echo outputError(array("msg"=>direction("Time is fully booked please select another time","الوقت مكتمل يرجى تحديد وقت اخر")));die();
                            }
                        }
                    }
                }else{
                    echo outputError(array("msg"=>direction("Date not in the allowed period","التاريخ ليس في الفترة المسموحة")));die();
                }
            }else{
                echo outputError(array("msg"=>direction("Service not exists","الخدمة غير موجودة")));die();
            }
        }else{
            echo outputError(array("msg"=>direction("Branch not exists","الفرع غير موجود" )));die();
        }
    }else{
        echo outputError(array("msg"=>direction("Vendor not exists","المتجر غير موجود")));die();
    }
}
?>