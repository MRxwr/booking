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
        if( $BlockedDays = selectDB2New("*","blockday",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($BlockedDays);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Blocked Days Found", "لا توجدأيام محظورة متاحة"));
            echo outputError($response);die();
        }
    }elseif( $action == "add" ){
        if( !isset($data["branchId"]) || empty($data["branchId"]) ){
            $response = array("msg" => checkAPILanguege("Branch ID is required.", "معرف الفرع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["day"]) ){
            $response = array("msg" => checkAPILanguege("Day is required.", "اليوم مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("blockday", $data) ){
            $response = array("msg" => checkAPILanguege("Blocked Day Added Successfully", "تمت إضافة اليوم المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Blocked Day", "فشل في إضافة اليوم المحضور"));
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
            $response = array("msg" => checkAPILanguege("Day is required.", "اليوم مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("blockday", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Blocked Day Updated Successfully", "تم تحديث اليوم المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Blocked Day", "فشل في تحديث اليوم المحضور"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("blockday", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Blocked Day Deleted Successfully", "تم حذف اليوم المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Blocked Day", "فشل حذف اليوم المحضور"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>