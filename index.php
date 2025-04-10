<?php
SESSION_START();
require_once("admin/includes/config.php");
require_once("admin/includes/functions.php");
setLanguageFront();

if( isset($_REQUEST["vendorURL"]) && !empty($_REQUEST["vendorURL"]) && $vendor = selectDBNew("vendors",[$_REQUEST["vendorURL"]],"`url` LIKE ? AND `hidden` = '0' AND `status` = '0'","") ){
	$vendor = $vendor[0];
	$vendorTheme = $vendor["theme"];
	$serviceList = selectDB("services","`vendorId` = '{$vendor["id"]}' AND `status` = '0' AND `hidden` = '0'");
	$bookingsList = selectDB("bookings","`vendorId` = '{$vendor["id"]}' AND `status` = '1'");
	$clientsList = selectDB("bookings","`vendorId` = '{$vendor["id"]}' AND `status` = '1' GROUP BY `customerDetails`");
	if( isset($_GET["result"]) && !empty($_GET["result"]) && $_GET["result"] == "CAPTURED"){
		if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) && $order = selectDBNew("bookings",[$_GET["requested_order_id"]],"`gatewayId` LIKE ?","") ){
			if ( $order[0]["status"] == "0" ){
				$bookingCode = generateRandomString($vendor["id"]);
				updateDB("bookings",array("status"=>"1","paymentResponse"=>json_encode($_GET),"code"=>$bookingCode),"`id` = '{$order[0]["id"]}'");
				$order = selectDBNew("bookings",[$_GET["requested_order_id"]],"`gatewayId` LIKE ?","");
			}
			$_GET["status"] = "success";
			$customer = json_decode($order[0]["customerDetails"],true);
			$service = selectDB("services","`id` = '{$order[0]["serviceId"]}'");
			$branch = selectDB("branches","`id` = '{$order[0]["branchId"]}'");
		}
	}elseif( isset($_GET["result"]) && !empty($_GET["result"]) && $_GET["result"] != "CAPTURED" ){
		if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) && $order = selectDBNew("bookings",[$_GET["requested_order_id"]],"`gatewayId` LIKE ?","") ){
			if( $order[0]["status"] == "0" ){
				updateDB("bookings",array("status"=>"2","paymentResponse"=>json_encode($_GET)),"`id` = '{$order[0]["id"]}'");
			}
			$_GET["status"] = "failure";
			$customer = json_decode($order[0]["customerDetails"],true);
			$service = selectDB("services","`id` = '{$order[0]["serviceId"]}'");
			$branch = selectDB("branches","`id` = '{$order[0]["branchId"]}'");
		}
	}
}else{
	header("Location: default");die();
}
?>
<!doctype html>
<html lang="en" style="direction:<?php echo direction("lrt","rtl") ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo direction($vendor["enTitle"],$vendor["arTitle"]) ?> - Booking System</title>
		<!-- add fav icon -->
		<link rel="icon" type="image/png" href="logos/<?php echo $vendor["logo"] ?>">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<script src="https://use.fontawesome.com/245c9398b0.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
		<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
		<?php require_once("templates/{$vendorTheme}/style.php") ?>
		<script>
			// Decrypt function
			function decryptData(encryptedData, key) {
				const rawData = atob(encryptedData);
				const iv = CryptoJS.enc.Base64.parse(rawData.slice(0, 16));
				const encrypted = CryptoJS.enc.Base64.parse(rawData.slice(16));
				const decrypted = CryptoJS.AES.decrypt({ ciphertext: encrypted }, CryptoJS.enc.Utf8.parse(key), { iv: iv });
				return JSON.parse(decrypted.toString(CryptoJS.enc.Utf8));
			}
		</script>
	</head>
	<body>
		<?php require_once("templates/{$vendorTheme}/leftSide.php") ?>
		<?php require_once("templates/{$vendorTheme}/rightSide.php") ?>
		<script>
			<?php require_once("templates/{$vendorTheme}/script.js") ?>
		</script>
	</body> 
</html>
