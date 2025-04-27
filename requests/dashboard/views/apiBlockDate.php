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
        if( $BlockDates = selectDB2New("*","blockdate",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($BlockDates);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Block Dates Found", "لا توجد تواريخ محظورة متاحة"));
            echo outputError($response);die();
        }
    }elseif( $action == "add" ){
        if( !isset($data["branchId"]) || empty($data["branchId"]) ){
            $response = array("msg" => checkAPILanguege("Branch ID is required.", "معرف الفرع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["startDate"]) ){
            $response = array("msg" => checkAPILanguege("Start Date is required.", "تاريخ البدء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["endDate"]) ){
            $response = array("msg" => checkAPILanguege("End Date is required.", "تاريخ الانتهاء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("blockdate", $data) ){
            $response = array("msg" => checkAPILanguege("Block Date Added Successfully", "تمت إضافة التاريخ المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Block Date", "فشل في إضافة التاريخ المحضور"));
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
        if( !isset($data["startDate"]) ){
            $response = array("msg" => checkAPILanguege("Start Date is required.", "تاريخ البدء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["endDate"]) ){
            $response = array("msg" => checkAPILanguege("End Date is required.", "تاريخ الانتهاء مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("blockdate", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Block Date Updated Successfully", "تم تحديث التاريخ المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Block Date", "فشل في تحديث التاريخ المحضور"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("blockdate", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Block Date Deleted Successfully", "تم حذف التاريخ المحضور بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Block Date", "فشل حذف التاريخ المحضور"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>