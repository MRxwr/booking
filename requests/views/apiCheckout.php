<?php
if( !isset($_POST["vendorId"]) || empty($_POST["vendorId"]) ){echo outputError(array("msg"=>"Vendor is required"));die();
}elseif( !isset($_POST["branchId"]) || empty($_POST["branchId"]) ){echo outputError(array("msg"=>"Branch is required"));die();
}elseif( !isset($_POST["serviceId"]) || empty($_POST["serviceId"]) ){echo outputError(array("msg"=>"Service is required"));die();
}elseif( !isset($_POST["date"]) || empty($_POST["date"]) ){echo outputError(array("msg"=>"Date is required"));die();
}elseif( !isset($_POST["time"]) || empty($_POST["time"]) ){echo outputError(array("msg"=>"Time is required"));die();
}else{
    $vendorId = $_POST["vendorId"];
    $branchId = $_POST["branchId"];
    $serviceId = $_POST["serviceId"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    if( $vendor = selectDBNew("vendors",[$vendorId],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
        if( $branch = selectDBNew("branches",[$branchId],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
            if( $service = selectDBNew("services",[$serviceId],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
                if( $calendars = selectDBNew("calendar",[$vendorId,$branchId,$date,$date],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND `startDate` <= ? AND `endDate` >= ? ORDER BY `id` ASC","") ){
                    if( $blockedPeriodsBranches = selectDBNew("blockdate",[$vendorId,$branchId,$date],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND ? NOT IN BETWEEN `startDate` AND `endDate` ORDER BY `id` ASC","")){
                        $day = date("w",strtotime($date));
                        if( $blockedDaysBranches = selectDBNew("blockday",[$vendorId,$branchId,$day],"`status` = '0' AND `hidden` = '0' AND `vendorId` = ? AND `branchId` = ? AND `day` = ? ORDER BY `id` ASC","") ){

                        }else{
                            echo outputError(array("msg"=>"day is blocked please select another day"));die();
                        }
                    }else{
                        echo outputError(array("msg"=>"Date is blocked please select another date"));die();
                    }
                }else{
                    echo outputError(array("msg"=>"Date not in the allowed period"));die();
                }
            }else{
                echo outputError(array("msg"=>"Service not exists"));die();
            }
        }else{
            echo outputError(array("msg"=>"Branch not exists"));die();
        }
    }else{
        echo outputError(array("msg"=>"Vendor not exists"));die();
    }
}
?>