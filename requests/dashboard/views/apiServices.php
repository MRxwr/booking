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
        if( $services = selectDB2New("`id`, $titleDB as title, FORMAT(price, 3) AS `price`, `period`, `seats`, `listTypes`, `themes`, `hidden`","services",[$data["vendorId"]],"`status` = 0 AND `vendorId` = ?","") ){
            echo outputData($services);die();
        }else{
            $response = array("msg" => checkAPILanguege("No Services Found", "لا توجد خدمات متاحة"));
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
        if( !isset($data["price"]) || empty($data["price"]) ){
            $response = array("msg" => checkAPILanguege("Price is required.", "السعر مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["period"]) || empty($data["period"]) ){
            $response = array("msg" => checkAPILanguege("Period is required.", "المدة مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["seats"]) || empty($data["seats"]) ){
            $response = array("msg" => checkAPILanguege("Seats is required.", "المقاعد مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("services", $data) ){
            $response = array("msg" => checkAPILanguege("Service Added Successfully", "تمت إضافة الخدمة بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Add Service", "فشل في إضافة الخدمة"));
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
        if( !isset($data["price"]) || empty($data["price"]) ){
            $response = array("msg" => checkAPILanguege("Price is required.", "السعر مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["period"]) || empty($data["period"]) ){
            $response = array("msg" => checkAPILanguege("Period is required.", "المدة مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["seats"]) || empty($data["seats"]) ){
            $response = array("msg" => checkAPILanguege("Seats is required.", "المقاعد مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["hidden"]) ){
            $response = array("msg" => checkAPILanguege("Hidden is required.", "المخفي مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("services", $data, "`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Service Updated Successfully", "تم تحديث الخدمة بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Update Service", "فشل في تحديث الخدمة"));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( updateDB("services", array("status" => 1),"`id` = {$data["id"]}") ){
            $response = array("msg" => checkAPILanguege("Service Deleted Successfully", "تم حذف الخدمة بنجاح"));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Failed to Delete Service", "فشل حذف الخدمة"));
            echo outputError($response);die();
        }
    }elseif( $action == "addPictureTypes" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["listTypes"]) || empty($data["listTypes"]) ){
            $response = array("msg" => checkAPILanguege("List Types is required.", "قائمة الأنواع مطلوبة."));
            echo outputError($response);die();
        }
        if( $service = selectDBNew("services",[$data["id"]],"`id` = ?","") ){
            $listTypes = json_decode($service[0]["listTypes"],true);
            if( !is_null($listTypes) && in_array($data["listTypes"],$listTypes) ){
                $response = array("msg" => checkAPILanguege("List Types Already Exist", "قائمة الأنواع موجودة بالفعل"));
                echo outputError($response);die();
            }else{
                $listTypes[] = $data["listTypes"];
                $data["listTypes"] = json_encode($listTypes);
            }
            if( updateDB("services", $data, "`id` = {$data["id"]}") ){
                $response = array("msg" => checkAPILanguege("List Types Added Successfully", "تمت إضافة قائمة الأنواع بنجاح"));
                echo outputData($response);die();
            }else{
                $response = array("msg" => checkAPILanguege("Failed to Add List Types", "فشل في إضافة قائمة الأنواع"));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Service Not Found", "الخدمة غير موجودة"));
            echo outputError($response);die();
        }
    }elseif( $action == "deletePictureTypes" ){
        if( !isset($data["id"]) || empty($data["id"]) ){
            $response = array("msg" => checkAPILanguege("ID is required.", "المعرف مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["index"]) ){
            $response = array("msg" => checkAPILanguege("Index is required.", "الفهرس  مطلوبة."));
            echo outputError($response);die();
        }
        if( $service = selectDBNew("services",[$data["id"]],"`id` = ?","") ){
            $listTypes = json_decode($service[0]["listTypes"],true);
            
            if( !is_null($listTypes) && isset($listTypes[$data["index"]]) ){
                unset($listTypes[$data["index"]]);
                $listTypes = array_values($listTypes);
                var_dump($listTypes);die();
                $data["listTypes"] = json_encode($listTypes);
                if( updateDB("services", $data, "`id` = {$data["id"]}") ){
                    $response = array("msg" => checkAPILanguege("List Types Deleted Successfully", "تم حذف قائمة الأنواع بنجاح"));
                    echo outputData($response);die();
                }else{
                    $response = array("msg" => checkAPILanguege("Failed to Delete List Types", "فشل حذف قائمة الأنواع"));
                    echo outputError($response);die();
                }
            }else{
                $response = array("msg" => checkAPILanguege("List Types Not Found", "قائمة الأنواع غير موجودة"));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Service Not Found", "الخدمة غير موجودة"));
            echo outputError($response);die();
        }
    }elseif( $action == "addThemes" ){
    }elseif( $action == "deleteThemes" ){
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>