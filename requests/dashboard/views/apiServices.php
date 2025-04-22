<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    if ( !$token ){
        $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
        echo outputError($response);die();
    }elseif( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
        $data["vendroId"] = $user[0]["id"];
    }
    $action = $_GET["action"];
    $data = (isset($_POST) && !empty($_POST)) ? $_POST : array();
    if( $action == "list" ){
        if( $services = selectDB2New("`id`, $titleDB as title, `price`, `period`, `seats`","services",[$data["vendroId"]],"`status` = 0 AND `hidden` = 0 AND `vendorId` = ?","") ){
            echo outputData($services);die();
        }
    }
}

?>