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
        if( $PictureTypes = selectDB2New("`id`, `enTitle`, `arTitle`, `price`, `themes`, `hidden`","picturetype",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($PictureTypes);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Picture Types Found", "لا توجد انواع صور متاحة"));
            echo outputError($response);die();
        }
    }elseif( $action == "add" ){
        if( !isset($data["branchId"]) || empty($data["branchId"]) ){
            $response = array("msg" => checkAPILanguege("Branch ID is required.", "معرف الفرع مطلوب."));
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
        if( !isset($data["price"]) || empty($data["price"]) ){
            $response = array("msg" => checkAPILanguege("Price is required.", "السعر مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["themes"]) || empty($data["themes"]) ){
            $response = array("msg" => checkAPILanguege("Themes is required.", "التصاميم مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("picturetype", $data) ){
            $response = array("msg" => checkAPILanguege("Picture Type Added Successfully", "تمت إضافة نوع صورة بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Picture Type", "فشل في إضافة نوع صورة"));
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
        if( !isset($data["themes"]) || empty($data["themes"]) ){
            $response = array("msg" => checkAPILanguege("Themes is required.", "التصاميم مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("picturetype", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Picture Type Updated Successfully", "تم تحديث نوع صورة بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Picture Type", "فشل في تحديث نوع صورة"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("picturetype", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Picture Type Deleted Successfully", "تم حذف نوع صورة بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Picture Type", "فشل حذف نوع صورة"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>