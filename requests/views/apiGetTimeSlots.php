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
    
    // Fetch time slot info from DB
    if( $timeSlots = selectDBNew("times",[$branchId,$day,$vendorId],
        "`branchId` = ? AND `day` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0' ORDER BY `id` DESC","") )
    {
        //Get Branch Details
        if( $branches = selectDBNew("branches",[$branchId,$vendorId],
            "`id` = ? AND `status` = '0' AND `hidden` = '0' AND `vendorId` = ?","") )
        {
            $branchTotalSeats = $branches[0]["seats"];
            // get services for branch
            if ( in_array($serviceId, json_decode($branches[0]["services"],true)) ){
                if( $services = selectDBNew("services",[$serviceId],
                    "`id` = ? AND `status` = '0' AND `hidden` = '0'","") )
                {
                    $ServiceTotalSeats = $services[0]["seats"];
                    $duration = $services[0]["period"]; // In minutes
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
        
        // For simplicity, we use only the first record's start/close times:
        $start = substr($timeSlots[0]["startTime"], 0, 2); 
        $close = substr($timeSlots[0]["closeTime"], 0, 2);
        
        // Prepare arrays
        $blockedTimeVendor = [];
        $blockedTimeBookings = [];
        $bookedTimes = [];
        $bookedService = [];
        $bookedTimeService = [];
        $response = ["timeSlots" => []];
        
        // -------------------------------------------------------------
        // VENDOR BLOCKING (serviceId = 0)
        // -------------------------------------------------------------
        if( $blockTime = selectDB("blocktime",
            "`branchId` = '{$branchId}' 
             AND `vendorId` = '{$vendorId}' 
             AND `serviceId` = '0' 
             AND `hidden` = '0' 
             AND `status` = '0'  
             ORDER BY `id` DESC LIMIT 1") )
        {
            if( strtotime($blockTime[0]["startDate"]) <= strtotime($date) &&
                strtotime($blockTime[0]["endDate"])   >= strtotime($date) )
            {
                $blockedStart = substr($blockTime[0]["fromTime"], 0, 2);
                $blockedClose = substr($blockTime[0]["toTime"],   0, 2);
                
                for( $i = $blockedStart; $i < $blockedClose; $i++ ){
                    $blockedTimeVendor[] = (string)$blockedStart;
                    (int)$blockedStart++;
                }
            }
        }

        // -------------------------------------------------------------
        // VENDOR BLOCKING (specific service)
        // -------------------------------------------------------------
        if( $blockTime = selectDB("blocktime",
            "`branchId` = '{$branchId}' 
             AND `vendorId` = '{$vendorId}' 
             AND `serviceId` = '{$serviceId}' 
             AND `hidden` = '0' 
             AND `status` = '0' 
             ORDER BY `id` DESC LIMIT 1") )
        {
            if( strtotime($blockTime[0]["startDate"]) <= strtotime($date) &&
                strtotime($blockTime[0]["endDate"])   >= strtotime($date) )
            {
                $blockedStart = substr($blockTime[0]["fromTime"], 0, 2);
                $blockedClose = substr($blockTime[0]["toTime"],   0, 2);
                
                for( $i = $blockedStart; $i < $blockedClose; $i++ ){
                    $blockedTimeVendor[] = (string)$blockedStart;
                    (int)$blockedStart++;
                }
            }
        }

        // -------------------------------------------------------------
        // Booking blocking (Branch-level seats)
        // -------------------------------------------------------------
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
                // If branch total seats == # of booked times, block
                if( $branchTotalSeats == count($bookedTimes) ){
                    $blockedTimeBookings[] = $bookedTimes[$i];
                }else{
                    break;
                }
            }
        }

        // -------------------------------------------------------------
        // Booking blocking (Service-level seats)
        // -------------------------------------------------------------
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
                // If service total seats == # of booked times, block
                if( $ServiceTotalSeats == count($bookedService) ){
                    $blockedTimeBookings[] = $bookedService[$i];
                }else{
                    break;
                }
            }
        }

        // -------------------------------------------------------------
        // Generate Potential Slots in Smaller Steps
        // -------------------------------------------------------------
        $openTimestamp   = strtotime($start . ":00"); 
        $closeTimestamp  = strtotime($close . ":00"); 
        $durationSeconds = $duration * 60;  // e.g. 240 min => 14400 sec

        // We'll move in 30-min increments (you can change to 60, 15, etc.)
        $stepSeconds     = 30 * 60;        // 30 minutes
        $latestStart     = $closeTimestamp - $durationSeconds;

        // Build slots by checking each potential start time
        for ($candidateStart = $openTimestamp; $candidateStart <= $latestStart; $candidateStart += $stepSeconds) {
            
            $candidateEnd = $candidateStart + $durationSeconds;
            if ($candidateEnd > $closeTimestamp) {
                // Not enough room to fit full duration
                break;
            }
            
            $currentSlotStart = date('H:i', $candidateStart);
            $currentSlotEnd   = date('H:i', $candidateEnd);
            $currentTime      = $currentSlotStart . " - " . $currentSlotEnd;
            
            // This logic only checks hour-based vendor blocking & exact time string booking
            $startHour = (int) date('H', $candidateStart);

            // If this start hour is vendor-blocked or the entire chunk is in "blockedTimeBookings", skip
            if (!in_array($startHour, $blockedTimeVendor) && !in_array($currentTime, $blockedTimeBookings)) {
                $response["timeSlots"][] = $currentSlotStart . " - " . $currentSlotEnd;
            }
        }

        // -------------------------------------------------------------
        // Output
        // -------------------------------------------------------------
        if (empty($response["timeSlots"])) {
            // If no slots found, you can customize the response
            $response["timeSlots"][] = "No time slots available";
        }

        echo outputData($response);
        die();

    } else {
        // If we can't find time rows in `times` table
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);
        die();
    }
}
?>
