<?php

if( isset($_POST["branchId"]) && !empty($_POST["branchId"]) ){
    if( $branch = selectDB("branches","`id` = '{$_POST["branchId"]}'") ){
        for( $i = 0; $i < sizeof($branch[0]["services"]); $i++ ){
            $service = selectDB("services","`id` = '{$branch[0]["services"][$i]}' AND `status` = '0' AND `hidden` = '0'");
        }
    }else{
        echo outputError(array("msg"=>"Branch not exists"));die();
    }
}else{
    echo outputError(array("msg"=>"Please set branch"));die();
}

?>