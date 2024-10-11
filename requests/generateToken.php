<?php
SESSION_START();
header("Content-Type: application/json");
require_once("../admin/includes/config.php");
require_once("../admin/includes/functions.php");

if( isset($_SESSION["deviceId"]) && !empty($_SESSION["deviceId"]) ){
    if( $deviceToken = selectDBNew("tokens",[$_SESSION["deviceId"]],"`deviceId` LIKE ?","") ){
        jump:
        $newToken = password_hash(uniqid(), PASSWORD_BCRYPT);
        if( $token = selectDBNew("tokens",[$newToken],"`token` LIKE ?","") ){
            goto jump;
        }else{
            updateDB("tokens",["token"=>$newToken],"`id` = '{$deviceToken[0]["id"]}'");
            echo outputData(array("token"=>$newToken));die();
        }
    }else{
        jump2:
        $_SESSION["deviceId"] = md5(rand(00000,99999).time());
        if( $deviceToken = selectDBNew("tokens",[$_SESSION["deviceId"]],"`deviceId` LIKE ?","") ){
            goto jump2;
        }else{
            insertDB("tokens",["deviceId"=>$_SESSION["deviceId"]]);
            jump3:
            $newToken = password_hash(uniqid(), PASSWORD_BCRYPT);
            if( $token = selectDBNew("tokens",[$newToken],"`token` LIKE ?","") ){
                goto jump3;
            }else{
                updateDB("tokens",["token"=>$newToken],"`deviceId` = '{$_SESSION["deviceId"]}'");
                echo outputData(array("token"=>$newToken));die();
            }
        }
    }
}else{
    jump4:
    $_SESSION["deviceId"] = md5(rand(00000,99999).time());
    if( $deviceToken = selectDBNew("tokens",[$_SESSION["deviceId"]],"`deviceId` LIKE ?","") ){
        goto jump4;
    }else{
        insertDB("tokens",["deviceId"=>$_SESSION["deviceId"]]);
        jump5:
        $newToken = password_hash(uniqid(), PASSWORD_BCRYPT);
        if( $token = selectDBNew("tokens",[$newToken],"`token` LIKE ?","") ){
            goto jump5;
        }else{
            updateDB("tokens",["token"=>$newToken],"`deviceId` = '{$_SESSION["deviceId"]}'");
            echo outputData(array("token"=>$newToken));die();
        }
    }
}
?>