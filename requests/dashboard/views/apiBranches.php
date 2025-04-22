<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    $action = $_GET["action"];
    $data = (isset($_POST) && !empty($_POST)) ? $_POST : array();
    if ( !$token ){
        $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
        echo outputError($response);die();
    }elseif( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
        $data["vendorId"] = $user[0]["id"];
    }
    if( $action == "list" ){
        if( $branches = selectDB2New("`id`, $titleDB as title,`seats`, `location`, `hidden`","branches",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($branches);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Branches Found", "لا توجد فروع متاحة"));
            echo outputError($response);die();
        }
    }elseif( $action == "add" ){
        if( !isset($data["enTitle"]) || empty($data["enTitle"]) ){
            $response = array("msg" => checkAPILanguege("English Title is required.", "العنوان باللغة الإنجليزية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["arTitle"]) || empty($data["arTitle"]) ){
            $response = array("msg" => checkAPILanguege("Arabic Title is required.", "العنوان باللغة العربية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["location"]) ){
            $response = array("msg" => checkAPILanguege("Location is required.", "الموقع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["seats"]) || empty($data["seats"]) ){
            $response = array("msg" => checkAPILanguege("Seats is required.", "المقاعد مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("branches", $data) ){
            $response = array("msg" => checkAPILanguege("Branch Added Successfully", "تمت إضافة الفرع بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Branch", "فشل في إضافة الفرع"));
            echo outputError($response);die();
        }
    }elseif( $action == "update"){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["enTitle"]) || empty($data["enTitle"]) ){
            $response = array("msg" => checkAPILanguege("English Title is required.", "العنوان باللغة الإنجليزية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["arTitle"]) || empty($data["arTitle"]) ){
            $response = array("msg" => checkAPILanguege("Arabic Title is required.", "العنوان باللغة العربية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["location"]) ){
            $response = array("msg" => checkAPILanguege("Location is required.", "الموقع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["seats"]) || empty($data["seats"]) ){
            $response = array("msg" => checkAPILanguege("Seats is required.", "المقاعد مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("branches", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Branch Updated Successfully", "تم تحديث الفرع بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Branch", "فشل في تحديث الفرع"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("branches", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Branch Deleted Successfully", "تم حذف الفرع بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Branch", "فشل حذف الفرع"));
            echo outputError($response);die();
        }
    }elseif( $action == "addService" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["serviceId"]) || empty($data["serviceId"]) ){
            $response = array("msg" => checkAPILanguege("Service ID is required.", "معرف الخدمة مطلوب."));
            echo outputError($response);die();
        }
       if( $branch = selectDB("branches","`id` = '{$data["id"]}'") ){
            if( $services = selectDB("services","`id` = '{$data["serviceId"]}'") ){
                if( $servicesList = json_decode($branch[0]["services"], true)){
                    $servicesList = json_decode($branch[0]["services"], true);
                }else{
                    $servicesList = array();
                }
                if( in_array($data["serviceId"], $servicesList) ){
                    unset($servicesList[array_search($data["serviceId"], $servicesList)]);
                }else{
                    $servicesList[] = $data["serviceId"];
                }
                $servicesList = json_encode($servicesList);
                if( updateDB("branches", array("services" => $servicesList), "`id` = '{$data["id"]}'") ){
                    $list = json_decode($servicesList, true);
                    $list = selectDB2New("`id`, $titleDB as title, `price`, `period`, `seats`, `hidden`","services",[$list],"`status` = 0 AND `id` IN (?)","");
                    $response = array("msg" => checkAPILanguege("Services Updated Successfully to Branch", "تمت تحديث الخدمة بنجاح إلى الفرع"), "services" => $list);
                    echo outputData($response);die();
                }else{
                    $response = array("msg" => checkAPILanguege("Failed to Update Service", "فشل في تحديث الخدمة"));
                    echo outputError($response);die();
                }
            }else{
                $response = array("msg" => checkAPILanguege("Service Not Found", "الخدمة غير موجودة"));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Branch Not Found", "الفرع غير موجود"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>