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
        if( $times = selectDB2New("`id`, `day`, `startTime`, `closeTime`, `hidden`","times",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($times);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Times Found", "لا توجد أوقات متاحة"));
            echo outputError($response);die();
        }
    }elseif( $action == "add" ){
        if( !isset($data["branchId"]) || empty($data["branchId"]) ){
            $response = array("msg" => checkAPILanguege("Branch ID is required.", "معرف الفرع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["day"]) ){
            $response = array("msg" => checkAPILanguege("Arabic Title is required.", "العنوان باللغة العربية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["startTime"]) ){
            $response = array("msg" => checkAPILanguege("Start Time is required.", "وقت البدء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["closeTime"]) ){
            $response = array("msg" => checkAPILanguege("close Time is required.", "وقت الإغلاق مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("times", $data) ){
            $response = array("msg" => checkAPILanguege("Time Added Successfully", "تمت إضافة الوقت بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Time", "فشل في إضافة الوقت"));
            echo outputError($response);die();
        }
    }elseif( $action == "update"){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["branchId"]) || empty($data["branchId"]) ){
            $response = array("msg" => checkAPILanguege("Branch ID is required.", "معرف الفرع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["day"]) ){
            $response = array("msg" => checkAPILanguege("Arabic Title is required.", "العنوان باللغة العربية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["startTime"]) ){
            $response = array("msg" => checkAPILanguege("Start Time is required.", "وقت البدء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["closeTime"]) ){
            $response = array("msg" => checkAPILanguege("close Time is required.", "وقت الإغلاق مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("times", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Time Updated Successfully", "تم تحديث الوقت بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Time", "فشل في تحديث الوقت"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("times", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Time Deleted Successfully", "تم حذف الوقت بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Time", "فشل حذف الوقت"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>