<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    $action = $_GET["action"];
    $data = (isset($_POST) && !empty($_POST)) ? $_POST : array();
    if ( !$token ){
        $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
        echo outputError($response);die();
    }elseif( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
        $data["vendroId"] = $user[0]["id"];
    }
    if( $action == "list" ){
        if( $services = selectDB2New("`id`, $titleDB as title, FORMAT(price, 3) AS `price`, `period`, `seats`, `hidden`","services",[$data["vendroId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($services);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Services Found", "لا توجد خدمات متاحة"));
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
        if( !isset($data["price"]) || empty($data["price"]) ){
            $response = array("msg" => checkAPILanguege("Price is required.", "السعر مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["period"]) || empty($data["period"]) ){
            $response = array("msg" => checkAPILanguege("Period is required.", "المدة مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["seats"]) || empty($data["seats"]) ){
            $response = array("msg" => checkAPILanguege("Seats is required.", "المقاعد مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) || empty($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("services", $data) ){
            $response = array("msg" => checkAPILanguege("Service Added Successfully", "تمت إضافة الخدمة بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Service", "فشل في إضافة الخدمة"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>