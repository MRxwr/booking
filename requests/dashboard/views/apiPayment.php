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
    if( $action == "submit" ){
        if( isset($data["packageId"]) && !empty($data["packageId"]) && $package = selectDB("packages","`id` = '{$data["packageId"]}' AND `status` = 0 AND `hidden` = 0") ){
            if( $response = upaymentSubscription($user,$package) ){
                if( isset($response["status"]) && $response["status"] == true && isset($response["data"]["link"]) && !empty($response["data"]["link"]) ){
                    $data["gatewayId"] = $response["orderId"];
                    if( insertDB("subscriptions",$data) ){
                        echo outputData(array("url" => $response["data"]["link"],"orderId" => $response["orderId"]));die();
                    }else{
                        echo outputError(array("msg" => checkAPILanguege($lang,"Could not create order","لا يمكن انشاء الطلب") ));die();
                    }
                }else{
                    echo outputError(array("msg" => checkAPILanguege($lang,"Payment gateway error","خطأ في بوابة الدفع") ));die();
                }
            }else{
                echo outputError(array("msg" => checkAPILanguege($lang,"Something went wrong...","حدث خطأ ما") ));die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Package not found", "الباقة غير موجودة"));
            echo outputError($response);die();
        }
            if( insertDB("subscriptions",$data) ){
                echo outputData($data);die();
            }else{
                $response = array("msg" => checkAPILanguege("Error in inserting data", "خطأ في إدخال البيانات"));
                echo outputError($response);die();
            }
        if( $Packages = selectDB("packages","`status` = 0 AND `hidden` = 0") ){
            echo outputData($Packages);die();
        }else{
            $response = array("msg" => checkAPILanguege("No packages Found", "لا توجد باقات  متاحة"));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Wrong Endpoint Request 404", "خطأ في طلب نقطة النهاية 404"));
        echo outputError($response);die();
    }
} 

?>