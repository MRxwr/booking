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

        $openTimestamp   = strtotime($start . ":00");       // e.g. 10:00
$closeTimestamp  = strtotime($close . ":00");       // e.g. 20:00
$durationSeconds = $duration * 60;                  // e.g. 240 min => 240*60=14400

// We'll allow a start time up to (close - duration).
$latestStart     = $closeTimestamp - $durationSeconds;

// Step could be 15m, 30m, or 60m increments depending on your needs:
$stepSeconds = 60 * 60; // 1 hour steps, or 30*60 for 30 min, etc.

$response = ["timeSlots" => []];

for ($candidateStart = $openTimestamp; $candidateStart <= $latestStart; $candidateStart += $stepSeconds) {
    
    $candidateEnd = $candidateStart + $durationSeconds; // 4 hours later if duration=240 min
    
    // 1) Check if candidateEnd goes beyond closing
    if ($candidateEnd > $closeTimestamp) {
        // not enough time to fit the entire service, skip
        continue;
    }

    // 2) Check overlap with blocked intervals/hours
    // For example, if we have $blockedTimeVendor as a set of intervals, or
    // a function that says "14:00 - 16:00 is blocked," we do an overlap check:

    if (isOverlappingBlocked($candidateStart, $candidateEnd, $blockedTimeVendor)) {
        // If ANY overlap, skip this slot
        continue;
    }

    // 3) If we also have seat-based checks, handle those here (like “fully booked”).
    //    If it fails the seat check, continue to the next candidate.

    // 4) If we pass all checks, add to $response.
    $startStr = date('H:i', $candidateStart);
    $endStr   = date('H:i', $candidateEnd);
    $response["timeSlots"][] = $startStr . " - " . $endStr;
}

// Then echo out the $response
if (count($response["timeSlots"]) === 0) {
    // Maybe "No available slots"
} else {
    // Return your successful data
}

// Utility function (pseudo-code) to check overlapping:
function isOverlappingBlocked($startTime, $endTime, $blockedTimeVendor) {
    // $blockedTimeVendor might be an array of intervals, e.g.,
    // [
    //   [ 'start' => '14:00', 'end' => '16:00' ],
    //   [ 'start' => '18:00', 'end' => '19:00' ],
    // ]
    // Convert those strings to timestamps and do standard overlap logic:
    // Overlap occurs if (startTime < blockedEnd) && (endTime > blockedStart)

    // If you only store hours in an array, you'd need a more manual check.
    // Or if you store intervals as [14, 16], similarly handle them.
    
    foreach ($blockedTimeVendor as $block) {
        $blockStart = strtotime($block['start']); // e.g. '14:00'
        $blockEnd   = strtotime($block['end']);   // e.g. '16:00'
        
        // Check overlap
        if ($startTime < $blockEnd && $endTime > $blockStart) {
            return true; // Overlaps => blocked
        }
    }
    return false; // no overlap
}

        echo outputData($response);die();
    }else{
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);die();
    }
}
//
?>