<?php
if( isset($_POST["vendorId"]) && !empty($_POST["vendorId"]) && $vendor = selectDBNew("vendors",[$_POST["vendorId"]],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
}else{
    echo outputError("Missing vendor");die();
}
if( isset($_POST["serviceId"]) && !empty($_POST["serviceId"]) && $service = selectDBNew("services",[$_POST["serviceId"]],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
}else{
    echo outputError("Missing service");die();
}
if( isset($_POST["branchId"]) && !empty($_POST["branchId"]) && $branch = selectDBNew("branches",[$_POST["branchId"],$_POST["vendorId"]],"`id` = ? AND `status` = '0' AND `hidden` = '0' AND `vendorId` = ?","") ){
}else{
    echo outputError("Missing branch");die();
}
if( isset($_POST["date"]) && !empty($_POST["date"]) ){
    $_POST["bookedDate"] = $_POST["date"];
}else{
    echo outputError("Missing date");die();
}
if( isset($_POST["time"]) && !empty($_POST["time"]) ){
    $_POST["bookedTime"] = $_POST["time"];
}else{
    echo outputError("Missing time");die();
}

$orderId = date("Ymd").rand(0000,9999).time();
$paymentArray = array(
    'language' => 'en',
    'order[id]' => "{$orderId}",
    'order[currency]' => 'KWD',
    'order[amount]' => "{$service[0]["price"]}",
    'reference[id]' => "{$orderId}",
    'returnUrl' => "https://booking.createkuwait.com/{$vendor[0]["url"]}",
    'cancelUrl' => "https://booking.createkuwait.com/{$vendor[0]["url"]}",
    'notificationUrl' => "https://booking.createkuwait.com/{$vendor[0]["url"]}",
    'paymentGateway[src]' => 'knet',
    'extraMerchantData[0][amount]' => "{$service[0]["price"]}",
    'extraMerchantData[0][knetCharge]' => '0.15',
    'extraMerchantData[0][knetChargeType]' => 'fixed',
    'extraMerchantData[0][ccCharge]' => '3',
    'extraMerchantData[0][ccChargeType]' => 'percentage',
    'extraMerchantData[0][ibanNumber]' => "{$vendor[0]["iban"]}"
    );
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://sandboxapi.upayments.com/api/v1/charge',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $paymentArray,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer e66a94d579cf75fba327ff716ad68c53aae11528'
    ),
    )
);
$response = curl_exec($curl);
$response = json_decode($response, true);
curl_close($curl);
if ( $response["status"] === false ) {
    $response = outputError($response);die();
}else{
    $_POST["gatewayId"] = $orderId;
    $_POST["gatewayBody"] = json_encode($paymentArray);
    $_POST["gatewayResponse"] = json_encode($response);
    $_POST["gatewayURL"] = $response["data"]["link"];
    $_POST["customerDetails"] = json_encode($_POST["customer"]);
    unset($_POST["customer"]);
    if( insertDB("bookings",$_POST)){
    }else{
        $response = outputError("Failed to add booking");die();
    }
    echo outputData(json_decode($response, true));die();
}
?>