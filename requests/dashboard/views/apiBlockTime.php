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
        if( $BlockedTimes = selectDB2New("`id`, `startDate`, `endDate`, `fromTime`, `toTime`, `serviceId`, `hidden`","blocktime",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($BlockedTimes);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Blocked Times Found", "لا توجد الأوقات المحضورة متاحة"));
            echo outputError($response);die();
        }
    }elseif( $action == "add" ){
        if( !isset($data["branchId"]) || empty($data["branchId"]) ){
            $response = array("msg" => checkAPILanguege("Branch ID is required.", "معرف الفرع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["serviceId"]) ){
            $response = array("msg" => checkAPILanguege("Service ID is required.", "معرف الخدمة مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["startDate"]) || empty($data["startDate"]) ){
            $response = array("msg" => checkAPILanguege("Start Date is required.", "تاريخ البدء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["endDate"]) || empty($data["endDate"]) ){
            $response = array("msg" => checkAPILanguege("End Date is required.", "تاريخ الانتهاء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["fromTime"]) || empty($data["fromTime"]) ){
            $response = array("msg" => checkAPILanguege("From Time is required.", " وقت البدء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["toTime"]) || empty($data["toTime"]) ){
            $response = array("msg" => checkAPILanguege("To Time is required.", " وقت الانتهاء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("blocktime", $data) ){
            $response = array("msg" => checkAPILanguege("Blocked Time Added Successfully", "تمت إضافة الوقت المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Blocked Time", "فشل في إضافة الوقت المحضور"));
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
        if( !isset($data["serviceId"]) ){
            $response = array("msg" => checkAPILanguege("Service ID is required.", "معرف الخدمة مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["startDate"]) || empty($data["startDate"]) ){
            $response = array("msg" => checkAPILanguege("Start Date is required.", "تاريخ البدء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["endDate"]) || empty($data["endDate"]) ){
            $response = array("msg" => checkAPILanguege("End Date is required.", "تاريخ الانتهاء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["fromTime"]) || empty($data["fromTime"]) ){
            $response = array("msg" => checkAPILanguege("From Time is required.", " وقت البدء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["toTime"]) || empty($data["toTime"]) ){
            $response = array("msg" => checkAPILanguege("To Time is required.", " وقت الانتهاء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("blocktime", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Blocked Time Updated Successfully", "تم تحديث الوقت المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Blocked Time", "فشل في تحديث الوقت المحضور"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("blocktime", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Blocked Time Deleted Successfully", "تم حذف الوقت المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Blocked Time", "فشل حذف الوقت المحضور"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>