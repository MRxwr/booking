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
        if( $Addons = selectDB2New("*, $titleDB as title","extrainfo",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($Addons);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Extra info Found", "لا توجد معلومات إضافيه متاحة"));
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
        if( !isset($data["isRequired"]) ){
            $response = array("msg" => checkAPILanguege("Required status is required.", " حالة الإلزام مطلوبه."));
            echo outputError($response);die();
        }
        if( !isset($data["type"]) ){
            $response = array("msg" => checkAPILanguege("Type is required.", "النوع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("extrainfo", $data) ){
            $response = array("msg" => checkAPILanguege("Extra info. Added Successfully", "تمت إضافة المعلومة الإضافيه بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Extra info.", "فشل في إضافة المعلومة الإضافيه"));
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
        if( !isset($data["isRequired"]) ){
            $response = array("msg" => checkAPILanguege("Required status is required.", " حالة الإلزام مطلوبه."));
            echo outputError($response);die();
        }
        if( !isset($data["type"]) ){
            $response = array("msg" => checkAPILanguege("Type is required.", "النوع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("extrainfo", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Extra info. Updated Successfully", "تم تحديث المعلومة الإضافيه بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Extra info.", "فشل في تحديث المعلومة الإضافيه"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("extrainfo", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Extra info. Deleted Successfully", "تم حذف المعلومة الإضافيه بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Extra info.", "فشل حذف المعلومة الإضافيه"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>