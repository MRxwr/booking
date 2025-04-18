<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    $action = $_GET["action"];
    $data = (isset($_POST) && !empty($_POST)) ? $_POST : array();
    if( $action == "list" ){
        if ( !$token ){
            $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
            echo outputError($response);die();
        }
        if( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
            if( $vendors = selectDB2New("`{$titleDB}` as title, `logo`","vendors",[$user[0]["id"]],"`clientId` = ? AND `status` = 0","") ){
                echo outputData($vendors);die();
            }else{
                $response = array("msg" => checkAPILanguege("No data found.", "لم يتم العثور على بيانات."));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
            echo outputError($response);die();
        }
    }elseif( $action == "add" ){
        if ( !$token ){
            $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
            echo outputError($response);die();
        }elseif( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
            $data["clientId"] = $user[0]["id"];
        }else{
            $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
        }
        if( !isset($data["enTitle"]) || empty($data["enTitle"]) ){
            $response = array("msg" => checkAPILanguege("English title is required.", "العنوان باللغة الإنجليزية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["arTitle"]) || empty($data["arTitle"]) ){
            $response = array("msg" => checkAPILanguege("Arabic title is required.", "العنوان باللغة العربية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($_FILES["logo"]) || empty($_FILES["logo"]) ){
            $response = array("msg" => checkAPILanguege("Logo is required.", "الشعار مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($_FILES["coverImg"]) || empty($_FILES["coverImg"]) ){
            $response = array("msg" => checkAPILanguege("Cover image is required.", "صورة الغلاف مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["type"]) || empty($data["type"]) ){
            $response = array("msg" => checkAPILanguege("Type is required.", "النوع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["url"]) || empty($data["url"]) ){
            $response = array("msg" => checkAPILanguege("URL is required.", "الرابط مطلوب."));
            echo outputError($response);die();
        }elseif( $url = selectDBNew("vendors",[$data["url"]],"`url` LIKE ? AND `status` = 0","") ){
            $response = array("msg" => checkAPILanguege("URL already exists. Please choose another one.", "الرابط موجود مسبقاً. يرجى اختيار رابط اخر."));
            echo outputError($response);die();
        }
        $data["logo"] = uploadImageAPI($_FILES["logo"]["tmp_name"]);
        $data["coverImg"] = uploadImageAPI($_FILES["coverImg"]["tmp_name"]);
        if( insertDB("vendors",$data) ){
            $response = array("msg" => checkAPILanguege("Booking System has been added successfully.", "تم إضافة نظام الحجز بنجاح."));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to add booking system.", "فشل إضافة نظام الحجز."));
            echo outputError($response);die();
        }
    }elseif( $action == "update" ){
        if ( !$token ){
            $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["enTitle"]) || empty($data["enTitle"]) ){
            $response = array("msg" => checkAPILanguege("English title is required.", "العنوان باللغة الإنجليزية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["arTitle"]) || empty($data["arTitle"]) ){
            $response = array("msg" => checkAPILanguege("Arabic title is required.", "العنوان باللغة العربية مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($_FILES["logo"]) || empty($_FILES["logo"]) ){
            $response = array("msg" => checkAPILanguege("Logo is required.", "الشعار مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($_FILES["coverImg"]) || empty($_FILES["coverImg"]) ){
            $response = array("msg" => checkAPILanguege("Cover image is required.", "صورة الغلاف مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["type"]) || empty($data["type"]) ){
            $response = array("msg" => checkAPILanguege("Type is required.", "النوع مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["url"]) || empty($data["url"]) ){
            $response = array("msg" => checkAPILanguege("URL is required.", "الرابط مطلوب."));
            echo outputError($response);die();
        }elseif( $url = selectDBNew("vendors",[$data["url"]],"`url` LIKE ? AND `status` = 0 AND `id` != {$data["id"]}","") ){
            $response = array("msg" => checkAPILanguege("URL already exists. Please choose another one.", "الرابط موجود مسبقاً. يرجى اختيار رابط اخر."));
            echo outputError($response);die();
        }
        $data["logo"] = uploadImageAPI($_FILES["logo"]["tmp_name"]);
        $data["coverImg"] = uploadImageAPI($_FILES["coverImg"]["tmp_name"]);
        if( updateDB("vendors",$data,"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Booking System has been updated successfully.", "تم تحديث نظام الحجز بنجاح."));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to update booking system.", "فشل تحديث نظام الحجز."));
            echo outputError($response);die();
        }
    }      
}else{
    $error = array("msg"=>"Wrong Action Request 404");
    echo outputError($error);die();
}
?>