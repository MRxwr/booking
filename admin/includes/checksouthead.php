<?php
if ( isset($_COOKIE["createkuwaitAdmin"]) && !empty($_COOKIE["createkuwaitAdmin"]) ){
	if ( $user = selectDBNew("employees",[$_COOKIE["createkuwaitAdmin"]],"`keepMeAlive` LIKE ? AND `status` = '0'","") ){
		$userID = $user[0]["id"];
		$email = $user[0]["email"];
		$username = $user[0]["name"];
		$userType = $user[0]["empType"];
		$vendorId = $user[0]["vendorId"];
		// Decode vendorId if it's JSON
		$decodedVendorId = json_decode($vendorId, true);
		if (is_array($decodedVendorId)) {
			$vendorIds = array_filter($decodedVendorId, function($v){ return !empty($v); });
			if (count($vendorIds) > 0) {
				$inList = implode(",", array_map('intval', $vendorIds));
				$vendorIdDb = " AND `vendorId` IN ($inList)";
				$vendorDb = " AND `id` IN ($inList)";
				$vendorBookingTable = " AND t.vendorId IN ($inList)";
			} else {
				$vendorIdDb = "";
				$vendorDb = "";
				$vendorBookingTable = "";
			}
		} else {
			$vendorIdDb = ( !empty($vendorId) ) ? " AND `vendorId` = '{$vendorId}'" : "";
			$vendorDb = ( !empty($vendorId) ) ? " AND `id` = '{$vendorId}'" : "";
			$vendorBookingTable = ( !empty($vendorId) ) ? " AND t.vendorId = '{$vendorId}'" : "";
		}
	}else{
		header("Location: logout.php");die();
	}
}else{
	header("Location: login.php");die();
}
?>