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
    $day = date('w', strtotime($date));
    $date = date('Y-m-d', strtotime($date));
    if( $timeSlots = selectDBNew("times",[$branchId,$day,$vendorId],"`branchId` = ? AND `day` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0' ORDER BY `id` DESC","") ){
        //Get Branch Details
        if( $branches = selectDBNew("branches",[$branchId,$vendorId],"`id` = ? AND `status` = '0' AND `hidden` = '0' AND `vendorId` = ?","") ){
            $branchTotalSeats = $branches[0]["seats"];
            // get services for branch
            if ( in_array($serviceId,json_decode($branches[0]["services"],true)) ){
                if( $services = selectDBNew("services",[$serviceId],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
                    $ServiceTotalSeats = $services[0]["seats"];
                    $duration = $services[0]["period"];
                }else{
                    echo outputError("Service has been removed by vendor");die();
                }
            }else{
                echo outputError("Service not exists for this branch");die();
            }
        }else{
            echo outputError("Branch not exists for this vendor");die();
        }
        $start = substr($timeSlots[0]["startTime"],0,2);
        $close = substr($timeSlots[0]["closeTime"],0,2);
        $timeSlots = [];
        $blockedTimeVendor = [];
        $blockedTimeBookings = [];
        $bookedTimes = [];
        $bookedService = [];
        $bookedTimeService = [];
        //vendor blocking time
        if( $blockTime = selectDB("blocktime","`branchId` = '{$branchId}' AND `vendorId` = '{$vendorId}' AND `serviceId` = '0' AND `hidden` = '0' AND `status` = '0'  ORDER BY `id` DESC LIMIT 1") ){
            if( strtotime($blockTime[0]["startDate"]) <= strtotime($date) && strtotime($blockTime[0]["endDate"]) >= strtotime($date) ){
                $blockedStart = substr($blockTime[0]["fromTime"],0,2);
                $blockedClose = substr($blockTime[0]["toTime"],0,2);
                
                for( $i = $blockedStart; $i < $blockedClose; $i++ ){
                    $blockedTimeVendor[] = (string)$blockedStart;
                    (int)$blockedStart++;
                }
            }
        }

        //vendor blocking time
        if( $blockTime = selectDB("blocktime","`branchId` = '{$branchId}' AND `vendorId` = '{$vendorId}' AND `serviceId` = '{$serviceId}' AND `hidden` = '0' AND `status` = '0' ORDER BY `id` DESC LIMIT 1") ){
            if( strtotime($blockTime[0]["startDate"]) <= strtotime($date) && strtotime($blockTime[0]["endDate"]) >= strtotime($date) ){
                $blockedStart = substr($blockTime[0]["fromTime"],0,2);
                $blockedClose = substr($blockTime[0]["toTime"],0,2);
                
                for( $i = $blockedStart; $i < $blockedClose; $i++ ){
                    $blockedTimeVendor[] = (string)$blockedStart;
                    (int)$blockedStart++;
                }
            }
        }

        //booking blocking number of seats per hour
        if( $booking = selectDBNew("bookings",[$branchId,$vendorId,$date],"`branchId` = ? AND `vendorId` = ? AND `bookedDate` = ? AND (`status` = '1' OR (`status` = '0' AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15))","") ){
            foreach( $booking as $book ){
                $bookedTimes[] = $book["bookedTime"];
            }
            for( $i = 0; $i < count($bookedTimes); $i++ ){
                if( $branchTotalSeats == count($bookedTimes) ){
                    $blockedTimeBookings[] = $bookedTimes[$i];
                }else{
                    break;
                }
            }
        }

        //booking blocking of services number of seats per hour
        $bookedService = array();
        if( $booking = selectDB("bookings","`branchId` = '{$branchId}' AND `vendorId` = '{$vendorId}' AND `serviceId` = '{$serviceId}' AND `bookedDate` = '{$date}' AND (`status` = '1' OR (`status` = '0' AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15))") ){
            foreach( $booking as $book ){
                $bookedService[] = $book["bookedTime"];
            }
            for( $i = 0; $i < count($bookedService); $i++ ){
                if( $ServiceTotalSeats == count($bookedService) ){
                    $blockedTimeBookings[] = $bookedService[$i];
                }else{
                    break;
                }
            }
        }

        $startTimestamp = strtotime($start . ":00"); 
        $closeTimestamp = strtotime($close . ":00"); 
        $durationInSeconds = 15 * 60; // convert minutes to seconds
        while ($startTimestamp < $closeTimestamp) {
            $endTimestamp = $startTimestamp + $durationInSeconds;
            if ($endTimestamp > $closeTimestamp) {
                break;
            }
            $currentSlotStart = date('H:i', $startTimestamp);
            $currentSlotEnd   = date('H:i', $endTimestamp);
            $currentTime = $currentSlotStart . " - " . $currentSlotEnd;
            if (!in_array($currentTime, $blockedTimeBookings)) {
                $response["timeSlots"][] = $currentSlotStart . " - " . $currentSlotEnd;
            }
            $startTimestamp = $endTimestamp;
        }
        if( count($blockedTimeVendor) > 0 ){
            var_dump($blockedTimeVendor);
            foreach( $response["timeSlots"] as $key => $timeSlot ){
                echo $response["timeSlots"][$key];
                if( in_array(substr($timeSlot,0,2),$blockedTimeVendor) ){
                    unset($response["timeSlots"][$key]);
                }
            }
        }
        echo outputData($response);die();
    }else{
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);die();
    }
}
//
?>