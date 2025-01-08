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

    // 1) Fetch Time Info
    if( $timeSlots = selectDBNew("times",[$branchId,$day,$vendorId],
        "`branchId` = ? AND `day` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0' ORDER BY `id` DESC","") )
    {
        // 2) Fetch Branch & Service
        if( $branches = selectDBNew("branches",[$branchId,$vendorId],
            "`id` = ? AND `status` = '0' AND `hidden` = '0' AND `vendorId` = ?","") )
        {
            $branchTotalSeats = $branches[0]["seats"];
            if ( in_array($serviceId, json_decode($branches[0]["services"],true)) ){
                if( $services = selectDBNew("services",[$serviceId],
                    "`id` = ? AND `status` = '0' AND `hidden` = '0'","") )
                {
                    $ServiceTotalSeats = $services[0]["seats"];
                    $duration = $services[0]["period"]; // e.g. 240 minutes for 4h
                }else{
                    echo outputError("Service has been removed by vendor");
                    die();
                }
            }else{
                echo outputError("Service not exists for this branch");
                die();
            }
        }else{
            echo outputError("Branch not exists for this vendor");
            die();
        }

        // 3) Assume single row's start/close
        $start = substr($timeSlots[0]["startTime"], 0, 2);
        $close = substr($timeSlots[0]["closeTime"], 0, 2);

        // 4) Arrays we'll use
        $blockedTimeVendor    = [];
        $blockedTimeBookings  = [];
        $bookedTimes          = [];
        $bookedService        = [];
        $response             = ["timeSlots" => []];

        // ---------------------------
        // 4A) Vendor blocking: serviceId=0
        // ---------------------------
        if( $blockTime = selectDB("blocktime",
            "`branchId` = '{$branchId}' 
             AND `vendorId` = '{$vendorId}' 
             AND `serviceId` = '0' 
             AND `hidden` = '0' 
             AND `status` = '0'
             ORDER BY `id` DESC LIMIT 1") )
        {
            if( strtotime($blockTime[0]["startDate"]) <= strtotime($date)
                && strtotime($blockTime[0]["endDate"]) >= strtotime($date) )
            {
                $blockedStart = substr($blockTime[0]["fromTime"], 0, 2);
                $blockedClose = substr($blockTime[0]["toTime"],   0, 2);

                for( $i = $blockedStart; $i < $blockedClose; $i++ ){
                    $blockedTimeVendor[] = (string)$blockedStart;
                    (int)$blockedStart++;
                }
            }
        }
        // ---------------------------
        // 4B) Vendor blocking: specific serviceId
        // ---------------------------
        if( $blockTime = selectDB("blocktime",
            "`branchId` = '{$branchId}' 
             AND `vendorId` = '{$vendorId}' 
             AND `serviceId` = '{$serviceId}' 
             AND `hidden` = '0'
             AND `status` = '0' 
             ORDER BY `id` DESC LIMIT 1") )
        {
            if( strtotime($blockTime[0]["startDate"]) <= strtotime($date)
                && strtotime($blockTime[0]["endDate"]) >= strtotime($date) )
            {
                $blockedStart = substr($blockTime[0]["fromTime"], 0, 2);
                $blockedClose = substr($blockTime[0]["toTime"],   0, 2);

                for( $i = $blockedStart; $i < $blockedClose; $i++ ){
                    $blockedTimeVendor[] = (string)$blockedStart;
                    (int)$blockedStart++;
                }
            }
        }

        // ---------------------------
        // 4C) Booking block: branch seats
        // ---------------------------
        if( $booking = selectDBNew("bookings",[$branchId,$vendorId,$date],
            "`branchId` = ? 
             AND `vendorId` = ? 
             AND `bookedDate` = ? 
             AND (`status` = '1' OR (`status` = '0' AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15))","") )
        {
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

        // ---------------------------
        // 4D) Booking block: service seats
        // ---------------------------
        if( $booking = selectDB("bookings",
            "`branchId` = '{$branchId}' 
             AND `vendorId` = '{$vendorId}' 
             AND `serviceId` = '{$serviceId}' 
             AND `bookedDate` = '{$date}'
             AND (`status` = '1' OR (`status` = '0' AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15))") )
        {
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

        // ==========================================================
        // 5) Generate 4-Hour Chunks in *duration* Steps
        //    BUT if there's a partial overlap, jump forward
        // ==========================================================
        $openTimestamp   = strtotime($start . ":00"); 
        $closeTimestamp  = strtotime($close . ":00"); 
        $durationSeconds = $duration * 60; // e.g. 240 min => 14400 for 4h

        $currentTimestamp = $openTimestamp;

        // We'll loop until we cannot fit a full chunk anymore
        while ($currentTimestamp + $durationSeconds <= $closeTimestamp) {
            
            // Build this chunk
            $chunkStart = $currentTimestamp;
            $chunkEnd   = $currentTimestamp + $durationSeconds;

            // Convert to something like "10:00 - 14:00"
            $currentSlotStart = date('H:i', $chunkStart);
            $currentSlotEnd   = date('H:i', $chunkEnd);
            $currentTime      = $currentSlotStart . " - " . $currentSlotEnd;
            $startHour        = (int) date('H', $chunkStart);

            // ---------------------------------------------
            // 5A) Check vendor blocking by hour
            //     If $startHour is in $blockedTimeVendor, skip entire chunk
            // ---------------------------------------------
            if (in_array($startHour, $blockedTimeVendor)) {
                // Let's jump to next hour. Or jump to blocked hour's end?
                $currentTimestamp += 3600; // skip 1 hour
                continue;
            }

            // ---------------------------------------------
            // 5B) Check if $currentTime is in $blockedTimeBookings
            //     (Your original code lumps entire day, might not be 100% accurate).
            // ---------------------------------------------
            if (in_array($currentTime, $blockedTimeBookings)) {
                // If the entire chunk is fully blocked, skip
                $currentTimestamp += $durationSeconds;
                continue;
            }

            // ---------------------------------------------
            // 5C) Check partial overlap with a blocked window 
            //     E.g. 14:00–16:00 is partially inside 10:00–14:00 or 14:00–18:00
            //     For that, we need an "interval-based" check:
            // ---------------------------------------------
            $overlapEnd = findPartialOverlap($chunkStart, $chunkEnd);
            // If findPartialOverlap returns a timestamp (the end of the blocked window)
            // that lies in [chunkStart, chunkEnd], we jump there. If there's no overlap, returns null.

            if ($overlapEnd !== null) {
                // We have a partial overlap somewhere in this chunk.
                // That means we can’t use the chunk as is.
                // We'll jump currentTimestamp to that $overlapEnd
                $currentTimestamp = $overlapEnd;
                continue;
            }

            // ---------------------------------------------
            // 5D) If we got here, the chunk is good.
            //     We add "HH:ii - HH:ii" to $response and jump by duration
            // ---------------------------------------------
            $response["timeSlots"][] = $currentTime;
            $currentTimestamp += $durationSeconds; 
        }

        // If still none found, you can indicate "No time slots available"
        if (empty($response["timeSlots"])) {
            $response["timeSlots"][] = "No time slots available";
        }

        // Output
        echo outputData($response);
        die();

    } else {
        // No rows in times table => no time slots
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);
        die();
    }
}

// --------------------------------------------------------
// 6) EXAMPLE function to detect partial overlap
//    *** You must adapt this if you store more than 1 block, or
//        need minute-level block logic. Right now, we only
//        look at $blockedTimeVendor[] which has *hours* as strings.
// --------------------------------------------------------
function findPartialOverlap($startTs, $endTs) {
    // Example: if you have a partial block from 14:00 to 16:00,
    // but all you store is ["14", "15"] in $blockedTimeVendor, you only
    // know the integer hours. Real partial overlap checks would need
    // date/time intervals, e.g. "2023-10-05 14:00" -> "2023-10-05 16:00".
    //
    // For demonstration, we'll return NULL, meaning "no partial overlap".
    // If you do have real intervals, you'd do:
    //   1) Convert them to timestamps.
    //   2) If ($startTs < $blockEnd && $endTs > $blockStart) => partial overlap.
    //   3) Return $blockEnd (the earliest time we can start again).
    //
    // Right now, we just do no partial overlap check:
    return null;
}
?>
