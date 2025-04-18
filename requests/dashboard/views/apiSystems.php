<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    $action = $_GET["action"];
    $data = (isset($_POST["data"]) && !empty($_POST["data"])) ? $_POST["data"] : array();
    if( $action == "list" ){
        if ( !$token ){
            $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
            echo outputError($response);die();
        }
        if( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
            $vendorIds = json_decode($user[0]["vendorId"]);
            if( $vendors = selectDB2New("`{$titleDB}` as title, `logo`","vendors",[$vendorIds],"`id` IN (?) AND `status` = 0","") ){
                echo outputData($vendors);die();
            }else{
                $response = array("msg" => checkAPILanguege("No data found.", "لم يتم العثور على بيانات."));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
            echo outputError($response);die();
        }
    }
                
}else{
    $error = array("msg"=>"Wrong Action Request 404");
    echo outputError($error);die();
}
?>