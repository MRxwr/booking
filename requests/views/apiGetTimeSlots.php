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
            if( $blockTime[0]["startDate"] <= $date && $blockTime[0]["endDate"] >= $date ){
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
            if( $blockTime[0]["startDate"] <= $date && $blockTime[0]["endDate"] >= $date ){
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
                $bookedTimes[] = substr($book["bookedTime"],0,2);
            }
            $counter = (int)($start);
            for( $i = $start; $i < $close; $i++ ){
                if( $branchTotalSeats == count(array_intersect($bookedTimes,[$counter])) ){
                    $blockedTimeBookings[] = $counter;
                }
                $counter++;
            }
        }

        //booking blocking of services number of seats per hour
        if( $booking = selectDB("bookings","`branchId` = '{$branchId}' AND `vendorId` = '{$vendorId}' AND `serviceId` = '{$serviceId}' AND `bookedDate` = '{$date}' AND (`status` = '1' OR (`status` = '0' AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15))") ){
            foreach( $booking as $book ){
                $bookedService[] = substr($book["bookedTime"],0,2);
            }
            $counter = (int)($start);
            for( $i = $start; $i < $close; $i++ ){
                if( $ServiceTotalSeats == count(array_intersect($bookedService,[$counter])) ){
                    $blockedTimeBookings[] = $counter;
                }
                $counter++;
            }
        }

        $response["timeSlots"] = [];
        $current = $start;
        while ($current < $close) {
            $startTime = sprintf("%02d:00", $current);
            $endTime = date('H:i', strtotime('+' . $duration . ' minutes', strtotime($startTime)));
            
            $response["timeSlots"][] = $startTime . " - " . $endTime;
            
            $current = (int)substr($endTime, 0, 2);
        }
        echo outputData($response);die();
    }else{
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);die();
    }
}
//
?>