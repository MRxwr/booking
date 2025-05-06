<?php
// payment
function payment($data){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://createkwservers.com/payapi/api/v2/index.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($data),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($response,true);
	$array = [
		"url" => $response["data"]["PaymentURL"],
		"id" => $response["data"]["InvoiceId"]
	];
	return $array;
}

function checkPayment($data){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://createkwservers.com/payapi/api/v2/index.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($data),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($response,true);
	if ( !isset($response["data"]["Data"]["InvoiceStatus"]) ){
		$status = "Failed";
	}else{
		$status = $response["data"]["Data"]["InvoiceStatus"];
	}
	if ( !isset($response["data"]["Data"]["InvoiceId"]) ){
		$id = $data["Key"];
	}else{
		$id = $response["data"]["Data"]["InvoiceId"];
	}
	$array = [
		"status" => $status,
		"id" => $id
	];
	return $array;
}

function upaymentSubscription($employee, $package){
	$settings = selectDB("settings","`id` = '1'");
	$orderId = date("Ymd").rand(00,99).time();
	$postBody = array(
		'language' => 'en',
		'order[id]' => $orderId,
		'order[currency]' => 'KWD',
		'order[amount]' => (string)$package[0]["price"],
		'order[description]' => "order for {$employee[0]["name"]}, {$employee[0]["phone"]}",
		'reference[id]' => $orderId,
		'customer[name]' => "{$employee[0]["name"]}",
		'customer[email]' => "{$employee[0]["email"]}",
		'customer[mobile]' => "{$employee[0]["phone"]}",
		'returnUrl' => 'https://reservaa.com/index.php',
		'cancelUrl' => 'https://reservaa.com/index.php',
		'notificationUrl' => 'https://reservaa.com/index.php',
		);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://uapi.upayments.com/api/v1/charge',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $postBody,
		CURLOPT_HTTPHEADER => array(
			"Authorization: {$settings[0]["upaymentToken"]}",
		),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($response,true);
	$response["orderId"] = $orderId;
	return $response;
}
?>