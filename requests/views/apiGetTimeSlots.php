<?php
if (!isset($_POST["branchId"]) || empty($_POST["branchId"])) {
    echo outputError("branch is required");
} elseif (!isset($_POST["date"]) || empty($_POST["date"])) {
    echo outputError("date is required");
} elseif (!isset($_POST["vendorId"]) || empty($_POST["vendorId"])) {
    echo outputError("vendor is required");
} elseif (!isset($_POST["serviceId"]) || empty($_POST["serviceId"])) {
    echo outputError("service is required");
} else {
    $branchId  = $_POST["branchId"];
    $serviceId = $_POST["serviceId"];
    $vendorId  = $_POST["vendorId"];
    $date      = $_POST["date"];
    $day       = date('w', strtotime($date));

    // 1) Fetch working hours
    $timeSlots = selectDBNew(
        "times",
        [$branchId, $day, $vendorId],
        "`branchId` = ? AND `day` = ? AND `vendorId` = ? 
         AND `status` = '0' AND `hidden` = '0' 
         ORDER BY `id` DESC",
        ""
    );
    if (!$timeSlots) {
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);
        die();
    }

    // 2) Branch and service checks
    $branches = selectDBNew(
        "branches",
        [$branchId, $vendorId],
        "`id` = ? AND `status` = '0' AND `hidden` = '0' AND `vendorId` = ?",
        ""
    );
    if (!$branches) {
        echo outputError("Branch not exists for this vendor");
        die();
    }
    $branchTotalSeats = $branches[0]["seats"];
    if (!in_array($serviceId, json_decode($branches[0]["services"], true))) {
        echo outputError("Service not exists for this branch");
        die();
    }

    $services = selectDBNew(
        "services",
        [$serviceId],
        "`id` = ? AND `status` = '0' AND `hidden` = '0'",
        ""
    );
    if (!$services) {
        echo outputError("Service has been removed by vendor");
        die();
    }
    $ServiceTotalSeats = $services[0]["seats"];
    $duration          = (int) $services[0]["period"];

    // 3) Parse start/close hours
    $startHour = (int) substr($timeSlots[0]["startTime"], 0, 2);
    $closeHour = (int) substr($timeSlots[0]["closeTime"], 0, 2);

    // 4) Prepare arrays for vendor and booking blocks
    $blockedTimeVendor    = [];
    $blockedTimeBookings  = [];

    // 5) Vendor block times (global)
    if ($blockTime = selectDB(
        "blocktime",
        "`branchId` = '{$branchId}' 
         AND `vendorId` = '{$vendorId}'
         AND `serviceId` = '0'
         AND `hidden` = '0' 
         AND `status` = '0'  
         ORDER BY `id` DESC 
         LIMIT 1"
    )) {
        if ($blockTime[0]["startDate"] <= $date && $blockTime[0]["endDate"] >= $date) {
            $blockedStartStamp = strtotime($date . " " . $blockTime[0]["fromTime"]);
            $blockedEndStamp   = strtotime($date . " " . $blockTime[0]["toTime"]);
            $blockedTimeVendor[] = [$blockedStartStamp, $blockedEndStamp];
        }
    }

    // 6) Vendor block times (service-specific)
    if ($blockTime = selectDB(
        "blocktime",
        "`branchId` = '{$branchId}' 
         AND `vendorId` = '{$vendorId}' 
         AND `serviceId` = '{$serviceId}' 
         AND `hidden` = '0' 
         AND `status` = '0' 
         ORDER BY `id` DESC 
         LIMIT 1"
    )) {
        if ($blockTime[0]["startDate"] <= $date && $blockTime[0]["endDate"] >= $date) {
            $blockedStartStamp = strtotime($date . " " . $blockTime[0]["fromTime"]);
            $blockedEndStamp   = strtotime($date . " " . $blockTime[0]["toTime"]);
            $blockedTimeVendor[] = [$blockedStartStamp, $blockedEndStamp];
        }
    }

    // 7) Booking blocks (branch seats)
    $bookedTimesBranch = selectDBNew(
        "bookings",
        [$branchId, $vendorId, $date],
        "`branchId` = ? 
         AND `vendorId` = ? 
         AND `bookedDate` = ? 
         AND (
             `status` = '1'
             OR (
                 `status` = '0' 
                 AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15
             )
         )",
        ""
    );

    // 8) Booking blocks (service seats)
    $bookedTimesService = selectDB(
        "bookings",
        "`branchId` = '{$branchId}' 
         AND `vendorId` = '{$vendorId}' 
         AND `serviceId` = '{$serviceId}' 
         AND `bookedDate` = '{$date}'
         AND (
             `status` = '1'
             OR (
                 `status` = '0' 
                 AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15
             )
         )"
    );

    // 9) Generate time slots in increments
    $startTimestamp     = strtotime($date . " " . $startHour . ":00");
    $closeTimestamp     = strtotime($date . " " . $closeHour . ":00");
    $durationInSeconds  = $duration * 60;
    $response           = ["timeSlots" => []];

    while ($startTimestamp < $closeTimestamp) {
        $endTimestamp = $startTimestamp + $durationInSeconds;
        if ($endTimestamp > $closeTimestamp) {
            break;
        }
        if (!isSlotBlocked(
            $startTimestamp,
            $endTimestamp,
            $bookedTimesBranch,
            $bookedTimesService,
            $blockedTimeVendor,
            $branchTotalSeats,
            $ServiceTotalSeats,
            $duration
        )) {
            $currentSlotStart = date('H:i', $startTimestamp);
            $currentSlotEnd   = date('H:i', $endTimestamp);
            $response["timeSlots"][] = $currentSlotStart . " - " . $currentSlotEnd;
        }
        $startTimestamp = $endTimestamp;
    }

    if (empty($response["timeSlots"])) {
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);
        die();
    }
    echo outputData($response);
    die();
}

/**
 * Checks if the current slot is blocked by:
 *  - Vendor block times (partial hours included)
 *  - Branch seat usage
 *  - Service seat usage
 */
function isSlotBlocked(
    $slotStart,
    $slotEnd,
    $bookedBranch,
    $bookedService,
    $vendorBlocks,
    $branchSeats,
    $serviceSeats,
    $duration
) {
    // 1) Check vendor blocking
    foreach ($vendorBlocks as $vb) {
        if (timeRangesOverlap($slotStart, $slotEnd, $vb[0], $vb[1])) {
            return true;
        }
    }

    // 2) Check branch usage
    $branchUsage = 0;
    foreach ($bookedBranch as $book) {
        $bookedStart = strtotime($book["bookedDate"] . " " . $book["bookedTime"]);
        $bookedEnd   = $bookedStart + ($duration * 60);
        if (timeRangesOverlap($slotStart, $slotEnd, $bookedStart, $bookedEnd)) {
            $branchUsage++;
        }
    }
    if ($branchUsage >= $branchSeats) {
        return true;
    }

    // 3) Check service usage
    $serviceUsage = 0;
    foreach ($bookedService as $book) {
        $bookedStart = strtotime($book["bookedDate"] . " " . $book["bookedTime"]);
        $bookedEnd   = $bookedStart + ($duration * 60);
        if (timeRangesOverlap($slotStart, $slotEnd, $bookedStart, $bookedEnd)) {
            $serviceUsage++;
        }
    }
    if ($serviceUsage >= $serviceSeats) {
        return true;
    }

    return false;
}

function timeRangesOverlap($startA, $endA, $startB, $endB) {
    return ($startA < $endB && $endA > $startB);
}
?>
