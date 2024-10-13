<?php
if( !isset($_POST["vendorId"]) || empty($_POST["vendorId"]) ){echo outputError(array("msg"=>"Vendor is required"));die();
}elseif( !isset($_POST["branchId"]) || empty($_POST["branchId"]) ){echo outputError(array("msg"=>"Branch is required"));die();
}elseif( !isset($_POST["serviceId"]) || empty($_POST["serviceId"]) ){echo outputError(array("msg"=>"Service is required"));die();
}elseif( !isset($_POST["date"]) || empty($_POST["date"]) ){echo outputError(array("msg"=>"Date is required"));die();
}elseif( !isset($_POST["time"]) || empty($_POST["time"]) ){echo outputError(array("msg"=>"Time is required"));die();
}elseif( !isset($_POST["customer"]["name"]) || empty($_POST["customer"]["name"]) ){echo outputError(array("msg"=>"Customer name is required"));die();
}elseif( !isset($_POST["customer"]["email"]) || empty($_POST["customer"]["email"]) ){echo outputError(array("msg"=>"Customer email is required"));die();
}elseif( !isset($_POST["customer"]["mobile"]) || empty($_POST["customer"]["mobile"]) ){echo outputError(array("msg"=>"Customer phone is required"));die();
}else{
    $vendorId = $_POST["vendorId"];
    $branchId = $_POST["branchId"];
    $serviceId = $_POST["serviceId"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    if( $vendor = selectDBNew("vendors",[$vendorId],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
        if( $branch = selectDBNew("branches",[$branchId],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
            if( $service = selectDBNew("services",[$serviceId],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
                if( $calendars = selectDBNew("calendar",[$vendorId,$branchId,$date,$date],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND `startDate` <= ? AND `endDate` >= ? ORDER BY `id` ASC","") ){
                    if( $blockedPeriodsBranches = selectDBNew("blockdate",[$vendorId,$branchId,$date],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND ? NOT IN BETWEEN `startDate` AND `endDate` ORDER BY `id` ASC","") ){
                        echo outputError(array("msg"=>"Date is blocked please select another date"));die();
                    }else{
                        $day = date("w",strtotime($date));
                        if( $blockedDaysBranches = selectDBNew("blockday",[$vendorId,$branchId,$day],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND `day` = ? ORDER BY `id` ASC","") ){
                            echo outputError(array("msg"=>"Date is blocked please select another date"));die();
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
                                    'customer[name]' => "{$_POST["customer"]["name"]}",
                                    'customer[mobile]' => "{$_POST["customer"]["mobile"]}",
                                    'customer[email]' => "{$_POST["customer"]["email"]}",
                                    ),
                                ));
                                $response = curl_exec($curl);
                                curl_close($curl);
                                echo outputData(json_decode($response, true));die();
                            }else{
                                echo outputError(array("msg"=>"Time is fully booked please select another time"));die();
                            }
                        }
                    }
                }else{
                    echo outputError(array("msg"=>"Date not in the allowed period"));die();
                }
            }else{
                echo outputError(array("msg"=>"Service not exists"));die();
            }
        }else{
            echo outputError(array("msg"=>"Branch not exists"));die();
        }
    }else{
        echo outputError(array("msg"=>"Vendor not exists"));die();
    }
}
?>