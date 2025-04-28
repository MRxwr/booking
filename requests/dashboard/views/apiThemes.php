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
            for( $i = 0 ; $i < sizeof($Themes); $i++ ){
                if( !is_null($Themes[$i]["themes"]) ){
                    $Themes[$i]["themes"] = json_decode($Themes[$i]["themes"],true);
                }
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
            $existingThemes = [];
            if( !is_null($preUploadedThemes[0]["themes"]) ){
                $existingThemes = json_decode($preUploadedThemes[0]["themes"], true);
                // Make sure existingThemes contains only strings (image paths)
                $existingThemes = array_filter($existingThemes, function($item) {
                    return is_string($item);
                });
            }
            // Merge the new themes with existing ones
            $themes = array_merge($existingThemes, $themes);
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
        if( $theme = selectDBNew("themes",[$data["id"]],"`status` = 0 AND `id` = ?","") ){
            $themeImages = [];
            if( !is_null($theme[0]["themes"]) ){
                $themeImages = json_decode($theme[0]["themes"], true);
                
                // Make sure it's an indexed array of strings (image paths)
                if(is_array($themeImages)) {
                    // Check if the specified index exists in the array
                    if(isset($themeImages[$data["index"]])) {
                        // Remove the image at the specified index
                        unset($themeImages[$data["index"]]);
                        // Re-index the array
                        $themeImages = array_values($themeImages);
                        
                        $updatedData["themes"] = json_encode($themeImages);
                        if( updateDB("themes", $updatedData, "`id` = {$data["id"]}") ){
                            $response = array("msg" => checkAPILanguege("Theme Deleted Successfully", "تم حذف التصميم بنجاح"));
                            echo outputData($response);die();
                        }else{
                            $response = array("msg" => checkAPILanguege("Failed to Delete Theme", "فشل حذف التصميم"));
                            echo outputError($response);die();
                        }
                    } else {
                        $response = array("msg" => checkAPILanguege("Invalid theme index", "فهرس التصميم غير صالح"));
                        echo outputError($response);die();
                    }
                } else {
                    $response = array("msg" => checkAPILanguege("Invalid theme data format", "تنسيق بيانات التصميم غير صالح"));
                    echo outputError($response);die();
                }
            } else {
                $response = array("msg" => checkAPILanguege("No themes to delete", "لا توجد تصاميم للحذف"));
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