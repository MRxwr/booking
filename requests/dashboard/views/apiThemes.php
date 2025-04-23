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
        if( $Themes = selectDB2New("`id`, `enTitle`, `arTitle`, `themes`, `hidden`","themes",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            $themesList = json_decode($Themes[0]["themes"],true);
            unset($Themes[0]["themes"]);
            for( $i = 0 ; $i < sizeof($themesList); $i++ ){
                $Themes[0]["themes"][] = $themesList[$i];
            }
            echo outputData($Themes);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Themes Found", "لا توجد التصاميم متاحة"));
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
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("themes", $data) ){
            $response = array("msg" => checkAPILanguege("Themes Added Successfully", "تمت إضافة التصميم بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Themes", "فشل في إضافة التصميم"));
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
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("themes", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Themes Updated Successfully", "تم تحديث التصميم بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Themes", "فشل في تحديث التصميم"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("themes", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Themes Deleted Successfully", "تم حذف التصميم بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Themes", "فشل حذف التصميم"));
            echo outputError($response);die();
        }
    }elseif( $action == "addTheme" ){
        if( !isset($_FILES["themes"]) || empty($_FILES["themes"]) ){
            $response = array("msg" => checkAPILanguege("Themes is required.", "التصميم مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        $themes = array();
        for( $i = 0; $i < sizeof($_FILES["themes"]["tmp_name"]); $i++ ){
            if( $image = uploadImageAPI($_FILES["themes"]["tmp_name"][$i], "themes") ){
                $themes[] = $image;
            }else{
                $response = array("msg" => checkAPILanguege("Failed to Upload Themes", "فشل في تحميل التصميم"));
                echo outputError($response);die();
            }
        }
        if( $preUploadedThemes = selectDB2New("`id`, `enTitle`, `arTitle`, `themes`, `hidden`","themes",[$data["id"]],"`status` = 0 AND `id` = ?","") ){
            $preUploadedThemes = json_decode($preUploadedThemes[0]["themes"],true);
            if( sizeof($preUploadedThemes) > 0 ){
                for( $i = 0; $i < sizeof($preUploadedThemes); $i++ ){
                    $themes[] = $preUploadedThemes[$i];
                }
            }
        }
        $data["themes"] = json_encode($themes);
        if( updateDB("themes", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Themes Added Successfully", "تمت إضافة التصميم بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Themes", "فشل في إضافة التصميم"));
            echo outputError($response);die();
        }
    }elseif( $action == "deleteTheme" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["index"]) ){
            $response = array("msg" => checkAPILanguege("Theme ID is required.", "معرف التصميم مطلوب."));
            echo outputError($response);die();
        }
        if( $preUploadedThemes = selectDBNew("themes",[$data["id"]],"`status` = 0 AND `id` = ?","") ){
            die();
            $preUploadedThemes = json_decode($preUploadedThemes[0]["themes"],true);
            if( sizeof($preUploadedThemes) > 0 ){
                $themes = array();
                for( $i = 0; $i < sizeof($preUploadedThemes); $i++ ){
                    if( $i != $data["index"] ){
                        $themes[] = $preUploadedThemes[$i];
                    }
                }
                $data["themes"] = json_encode($themes);
                if( updateDB("themes", $data, "`id` = {$data["id"]}") ){
                    $response = array("msg" => checkAPILanguege("Theme Deleted Successfully", "تم حذف التصميم بنجاح"));
                    echo outputData($response);die();
                }else{
                    $response = array("msg" => checkAPILanguege("Failed to Delete Theme", "فشل حذف التصميم"));
                    echo outputError($response);die();
                }
            }else{
                $response = array("msg" => checkAPILanguege("No Themes Found", "لا توجد التصاميم متاحة"));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("No Themes Found", "لا توجد التصاميم متاحة"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>