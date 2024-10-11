<?php
if( isset($_SESSION["deviceId"]) && !empty($_SESSION["deviceId"]) ){
    if( $deviceToken = selectDBNew("tokens",[$_SESSION["deviceId"]],"`deviceId` LIKE ?","") ){
        jump2:
        $newToken = password_hash(uniqid(), PASSWORD_BCRYPT);
        if( $token = selectDBNew("tokens",[$newToken],"`token` LIKE ?","") ){
            goto jump2;
        }else{
            updateDB("tokens",["token"=>$newToken],"`id` = '{$deviceToken[0]["id"]}'");
            echo outputData(array("token"=>$newToken));die();
        }
    }else{
        outputError(array("msg"=>"Invalid Device Id"));die();
    }
}else{
    jump:
    $_SESSION["deviceId"] = md5(rand(00000,99999).time());
    if( $deviceToken = selectDBNew("tokens",[$_SESSION["deviceId"]],"`deviceId` LIKE ?","") ){
        goto jump;
    }else{
        insertDB("tokens",["deviceId"=>$_SESSION["deviceId"]]);
    }
}


?>