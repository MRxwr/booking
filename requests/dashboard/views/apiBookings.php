<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    $action = $_GET["action"];
    $data = (isset($_POST) && !empty($_POST)) ? $_POST : array();
    if ( !$token ){
        $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
        echo outputError($response);die();
    }elseif( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
        $data["vendorId"] = $user[0]["vendorId"];
    }
    if( $action == "list" ){
        $joinObject = [
            "select" => ["t.id", "t.branchId", "t.serviceId", "t.extras", "t.extraInfo", "t.bookedTime", "bookedDate","JSON_UNQUOTE(JSON_EXTRACT(t.customerDetails, '$.name')) AS customerName", "JSON_UNQUOTE(JSON_EXTRACT(t.customerDetails, '$.mobile')) AS customerMobile", "JSON_UNQUOTE(JSON_EXTRACT(t.customerDetails, '$.email')) AS customerEmail", "t.chargeType","FORMAT(t.totalPrice, 3) AS totalPrice", "t.status","t1.{$titleDB} AS branchTitle", "t2.{$titleDB} AS serviceTitle"],
            "join" => ["branches","services"],
            "on" => ["t.branchId = t1.id"],
        ];
        if( $Bookings = selectJoinDB("bookings",$joinObject,"t.vendorId = '{$data["vendorId"]}'","") ){
            echo outputData($Bookings);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Bookings Found", "لا توجد حجوزات متاحة"));
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
        if( insertDB("bookings", $data) ){
            $response = array("msg" => checkAPILanguege("Calendar Added Successfully", "تمت إضافة الروزنامه بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Calendar", "فشل في إضافة الروزنامه"));
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
        if( updateDB("bookings", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Calendar Updated Successfully", "تم تحديث الروزنامه بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Calendar", "فشل في تحديث الروزنامه"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("bookings", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Calendar Deleted Successfully", "تم حذف الروزنامه بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Calendar", "فشل حذف الروزنامه"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>