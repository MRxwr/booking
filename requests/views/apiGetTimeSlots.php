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

    // 1) Fetch working hours (start/close times) from DB
    //    We'll just load the FIRST row from "times" that matches your conditions
    $timeSlotsData = selectDBNew(
        "times",
        [$branchId, $day, $vendorId],
        "`branchId` = ? AND `day` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0' ORDER BY `id` DESC",
        ""
    );

    if (!$timeSlotsData) {
        // No time slots found at all
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);
        die();
    }

    // We only need the first record for start/close times
    $openTime  = $timeSlotsData[0]["startTime"]; // e.g. "10:00:00"
    $closeTime = $timeSlotsData[0]["closeTime"]; // e.g. "22:00:00"

    // Convert to numeric hours, or directly to timestamps
    // Example: "10:00:00" -> 10, "22:00:00" -> 22
    $startHour = (int) substr($openTime, 0, 2);
    $closeHour = (int) substr($closeTime, 0, 2);

    // 2) Fetch branch, service, seats, etc.
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
    
    // Check if this branch has that service
    if (!in_array($serviceId, json_decode($branches[0]["services"], true))) {
        echo outputError("Service not exists for this branch");
        die();
    }

    // Get service data
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
    $duration = (int) $services[0]["period"]; // e.g. 30 (minutes)

    // 3) Prepare arrays for blocked times (vendor blocks, booking blocks, etc.)
    $blockedTimeVendor   = []; // We'll store *time ranges* here
    $blockedTimeBookings = []; // We'll store bookings to do overlap checks
    
    // 4) Vendor blocktime checks
    //    This example only shows collecting them; adapt as needed
    $blockVendorGlobal = selectDB(
        "blocktime",
        "`branchId` = '{$branchId}' AND `vendorId` = '{$vendorId}' AND `serviceId` = '0' AND `hidden` = '0' AND `status` = '0'  ORDER BY `id` DESC LIMIT 1"
    );
    if ($blockVendorGlobal) {
        // If block date range covers our $date, we store that block
        if ($blockVendorGlobal[0]["startDate"] <= $date && $blockVendorGlobal[0]["endDate"] >= $date) {
            // Example: from 10:00 to 12:00
            $blockedStart = strtotime($blockVendorGlobal[0]["fromTime"]);
            $blockedEnd   = strtotime($blockVendorGlobal[0]["toTime"]);
            // For a real app, might do $blockedTimeVendor[] = [$blockedStart, $blockedEnd];
            // But that depends on how you handle partial-hour logic below
        }
    }

    // Similarly for service-specific block
    $blockVendorService = selectDB(
        "blocktime",
        "`branchId` = '{$branchId}' AND `vendorId` = '{$vendorId}' AND `serviceId` = '{$serviceId}' AND `hidden` = '0' AND `status` = '0' ORDER BY `id` DESC LIMIT 1"
    );
    if ($blockVendorService) {
        if ($blockVendorService[0]["startDate"] <= $date && $blockVendorService[0]["endDate"] >= $date) {
            // Similarly store this block in $blockedTimeVendor
        }
    }

    // 5) Get all bookings for the day to see seat usage
    //    We'll use them to do partial-hour overlap checks
    $bookingsBranch = selectDBNew(
        "bookings",
        [$branchId, $vendorId, $date],
        "`branchId` = ? AND `vendorId` = ? AND `bookedDate` = ? 
            AND (
                `status` = '1' 
                OR (
                    `status` = '0' 
                    AND TIMESTAMPDIFF(MINUTE, `date`, NOW()) < 15
                )
            )",
        ""
    );

    // 6) Generate time slots in increments of $duration from $startHour to $closeHour
    //    Using timestamps for clarity
    $startTimestamp = strtotime($startHour . ":00");
    $closeTimestamp = strtotime($closeHour . ":00");
    $durationSeconds = $duration * 60;

    $response = ["timeSlots" => []];

    while ($startTimestamp < $closeTimestamp) {
        $endTimestamp = $startTimestamp + $durationSeconds;
        // If we go beyond close time, break
        if ($endTimestamp > $closeTimestamp) {
            break;
        }

        // Check if current slot is blocked by:
        //   - vendor block
        //   - seat capacity (branch/service)
        //   - existing bookings
        // We do an overlap check for each existing booking. 
        // If seat capacity is fully used for this half-hour, we block it.

        if (!isSlotBlocked($startTimestamp, $endTimestamp, $bookingsBranch, $branchTotalSeats, $ServiceTotalSeats, $duration)) {
            // Format times for display
            $slotStart = date('H:i', $startTimestamp);
            $slotEnd   = date('H:i', $endTimestamp);
            $response["timeSlots"][] = $slotStart . " - " . $slotEnd;
        }

        // Move to the next slot
        $startTimestamp = $endTimestamp;
    }

    // If no slots found, fall back to a “no slots” message
    if (empty($response["timeSlots"])) {
        $response["timeSlots"][0] = "No time slots available";
        echo outputError($response);
        die();
    }

    // 7) Return data
    echo outputData($response);
    die();
}

/**
 * Checks if a given slot (start -> end) is blocked by existing bookings 
 * or if the branch/service seats are fully occupied for that slot.
 * 
 * @param int   $slotStart     Unix timestamp of the slot’s start
 * @param int   $slotEnd       Unix timestamp of the slot’s end
 * @param array $bookings      Array of existing bookings for the day
 * @param int   $branchSeats   Branch total seats
 * @param int   $serviceSeats  This service’s total seats
 * @param int   $serviceDuration Minutes for the service (used to find booking end time)
 * @return bool                True if blocked, false if available
 */
function isSlotBlocked($slotStart, $slotEnd, $bookings, $branchSeats, $serviceSeats, $serviceDuration)
{
    // Track how many seats are used in this slot for branch & service
    $branchUsage  = 0;
    $serviceUsage = 0;

    foreach ($bookings as $book) {
        // Convert "bookedTime" (e.g. "10:00") to a timestamp for the day in question
        // If "bookedTime" includes date, parse that; otherwise, combine with $date. 
        // For simplicity, assume it's something like "HH:ii" so we do:
        $bookedStart = strtotime($book["bookedTime"]); 
        // If we store each booking’s actual duration, use that. Otherwise, assume the service’s duration:
        $bookedEnd = $bookedStart + ($serviceDuration * 60);

        // Check overlap between [slotStart, slotEnd) and [bookedStart, bookedEnd)
        if (timeRangesOverlap($slotStart, $slotEnd, $bookedStart, $bookedEnd)) {
            $branchUsage++;
            // If the booking is for this same service, also increment service usage
            if ((int) $book["serviceId"] === (int) $_POST["serviceId"]) {
                $serviceUsage++;
            }
        }
    }

    // If branch usage hits branchSeats, that means no seats left for branch
    if ($branchUsage >= $branchSeats) {
        return true;
    }
    // If service usage hits serviceSeats, no seats left for that service
    if ($serviceUsage >= $serviceSeats) {
        return true;
    }

    // Otherwise it’s still open
    return false;
}

/**
 * Returns true if two time ranges overlap.
 */
function timeRangesOverlap($startA, $endA, $startB, $endB)
{
    // Overlap if: startA < endB AND endA > startB
    return ($startA < $endB && $endA > $startB);
}
?>
