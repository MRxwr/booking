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
    $branchId = $_POST["branchId"];
    $serviceId = $_POST["serviceId"];
    $vendorId = $_POST["vendorId"];
    $date = $_POST["date"];
    $day = date('w', strtotime($date));

    $timeSlotsData = selectDBNew(
        "times",
        [$branchId, $day, $vendorId],
        "`branchId` = ? AND `day` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0' ORDER BY `id` DESC",
        ""
    );
    if (!$timeSlotsData) {
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);
        die();
    }

    $openTime  = $timeSlotsData[0]["startTime"];
    $closeTime = $timeSlotsData[0]["closeTime"];
    $startHour = (int) substr($openTime, 0, 2);
    $closeHour = (int) substr($closeTime, 0, 2);

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
    $duration = (int) $services[0]["period"];

    $bookingsBranch = selectDBNew(
        "bookings",
        [$branchId, $vendorId, $date],
        "`branchId` = ? AND `vendorId` = ? AND `bookedDate` = ? 
         AND (
             `status` = '1'
             OR (`status` = '0' AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15)
         )",
        ""
    );

    $startTimestamp = strtotime($startHour . ":00", strtotime($date));
    $closeTimestamp = strtotime($closeHour . ":00", strtotime($date));
    $durationSeconds = $duration * 60;
    $response = ["timeSlots" => []];

    while ($startTimestamp < $closeTimestamp) {
        $endTimestamp = $startTimestamp + $durationSeconds;
        if ($endTimestamp > $closeTimestamp) {
            break;
        }
        if (!isSlotBlocked(
            $startTimestamp,
            $endTimestamp,
            $bookingsBranch,
            $branchTotalSeats,
            $ServiceTotalSeats,
            $duration,
            $date
        )) {
            $slotStart = date('H:i', $startTimestamp);
            $slotEnd   = date('H:i', $endTimestamp);
            $response["timeSlots"][] = $slotStart . " - " . $slotEnd;
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

function isSlotBlocked(
    $slotStart,
    $slotEnd,
    $bookings,
    $branchSeats,
    $serviceSeats,
    $serviceDuration,
    $bookingDate
) {
    $branchUsage  = 0;
    $serviceUsage = 0;
    foreach ($bookings as $book) {
        $bookedStart = strtotime($bookingDate . " " . $book["bookedTime"]);
        $bookedEnd   = $bookedStart + ($serviceDuration * 60);
        if (timeRangesOverlap($slotStart, $slotEnd, $bookedStart, $bookedEnd)) {
            $branchUsage++;
            if ((int) $book["serviceId"] === (int) $_POST["serviceId"]) {
                $serviceUsage++;
            }
        }
    }
    if ($branchUsage >= $branchSeats) {
        return true;
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
