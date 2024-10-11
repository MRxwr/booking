<?php
if( !isset($_POST["branchId"]) || empty($_POST["branchId"]) ){
    echo outputError("branch is required");
}elseif( !isset($_POST["date"]) || empty($_POST["date"]) ){
    echo outputError("date is required");
}elseif( !isset($_POST["vendorId"]) || empty($_POST["vendorId"]) ){
    echo outputError("vendor is required");
}elseif( !isset($_POST["serviceId"]) || empty($_POST["serviceId"]) ){
    echo outputError("service is required");
}else{
    $branchId = $_POST["branchId"];
    $serviceId = $_POST["serviceId"];
    $vendorId = $_POST["vendorId"];
    $date = $_POST["date"];
    $day = date('l', strtotime($date));
    $values = ["0","1","2","3","4","5","6"];
	$enDaysArray = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    for( $i = 0; $i < sizeof($values); $i++){
        if( strtolower($day) == strtolower($enDaysArray[$i]) ){
            $day = $values[$i];
            break;
        }
    }
    if($timeSlots = selectDB("times","`branchId` = '{$branchId}' AND `day` = '{$day}' AND `vendorId` = '{$vendorId}'") ){
        $start = substr($timeSlots[0]["startTime"],0,2);
        $close = substr($timeSlots[0]["closeTime"],0,2);
        $timeSlots = [];
        for( $i = $start; $i < $close; $i++ ){
            $response["timeSlots"][] = ($start) . ":00 - " . ((int)($start)+1) . ":00";
            (int)$start++;
        }
        echo outputData($response);die();
    }else{
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);die();
    }
}
?>