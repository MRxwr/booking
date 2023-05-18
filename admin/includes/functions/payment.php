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
?>