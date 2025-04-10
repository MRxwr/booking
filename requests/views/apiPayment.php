<?php
if( isset($_POST["vendorId"]) && !empty($_POST["vendorId"]) && $vendor = selectDBNew("vendors",[$_POST["vendorId"]],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
    if( $vendor[0]["type"] == 3 ){
        if( isset($_POST["pictureTypeId"]) && !empty($_POST["pictureTypeId"]) ){
            if( $pictureType = selectDBNew("picturetype",[$_POST["pictureTypeId"],$vendor[0]["id"]],"`id` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0'","") ){
            }else{
                echo outputError(direction("Picture type not exists for the current vendor","نوع الصورة غير موجود للمتجر الحالي"));die();
            }
        }else{
            echo outputError(direction("Missing picture type","نوع الصورة مطلوب"));die();
        }
    }
}else{
    echo outputError(direction("Missing vendor","المتجر مطلوب"));die();
}
if( isset($_POST["serviceId"]) && !empty($_POST["serviceId"]) && $service = selectDBNew("services",[$_POST["serviceId"]],"`id` = ? AND `status` = '0' AND `hidden` = '0'","") ){
}else{
    echo outputError(direction("Missing service","الخدمة مطلوبة"));die();
}
if( isset($_POST["branchId"]) && !empty($_POST["branchId"]) && $branch = selectDBNew("branches",[$_POST["branchId"],$_POST["vendorId"]],"`id` = ? AND `status` = '0' AND `hidden` = '0' AND `vendorId` = ?","") ){
}else{
    echo outputError(direction("Missing branch","الفرع مطلوب"));die();
}
if( isset($_POST["date"]) && !empty($_POST["date"]) ){
    if ( $_POST["date"] < date("Y-m-d") ) {
        echo outputError(direction("Invalid date","التاريخ غير صالح"));die();
    }
    $_POST["bookedDate"] = $_POST["date"];
}else{
    echo outputError(direction("Missing date","التاريخ مطلوب"));die();
}
if( isset($_POST["time"]) && !empty($_POST["time"]) ){
    $_POST["bookedTime"] = $_POST["time"];
}else{
    echo outputError(direction("Missing time","الوقت مطلوب"));die();
}
// get total Price
$totalPrice = $service[0]["price"];
if( $vendor[0]["type"] == 3 ){
    if( $pictureType = selectDBNew("picturetype",[$_POST["pictureTypeId"],$vendor[0]["id"]],"`id` = ? AND `vendorId` = ? AND `status` = '0' AND `hidden` = '0'","") ){
        $totalPrice = $totalPrice + $pictureType[0]["price"];
    }
}
if( $extrasCheck = selectDBNew("extras",[$vendor[0]["id"],$_POST["extras"]],"`vendorId` = ? AND `status` = '0' AND `hidden` = '0' AND `id` IN (?)","") ){
    foreach( $extrasCheck as $extra ){
        $totalPrice = $totalPrice + $extra["price"];
    }
}
if( $vendor[0]["chargeType"] == 1 ){
    $price = $totalPrice;
}elseif( $vendor[0]["chargeType"] == 2 ){
    $price = $vendor[0]["chargeTypeAmount"];
}else{
    $price = $totalPrice;
}


$orderId = date("Ymd").rand(0000,9999).time();
$paymentArray = array(
    'language' => 'en',
    'order[id]' => "{$orderId}",
    'order[currency]' => 'KWD',
    'order[amount]' => "{$price}",
    'reference[id]' => "{$orderId}",
    'customer[name]' => "{$_POST["customer"]["name"]}",
	'customer[email]' => "{$_POST["customer"]["email"]}",
	'customer[mobile]' => "{$_POST["customer"]["mobile"]}",
    'returnUrl' => "https://reservaa.com/{$vendor[0]["url"]}",
    'cancelUrl' => "https://reservaa.com/{$vendor[0]["url"]}",
    'notificationUrl' => "https://reservaa.com/{$vendor[0]["url"]}",
    'paymentGateway[src]' => 'knet',
    /*
    'extraMerchantData[0][amount]' => "{$price}",
    'extraMerchantData[0][knetCharge]' => '0.15',
    'extraMerchantData[0][knetChargeType]' => 'fixed',
    'extraMerchantData[0][ccCharge]' => '3',
    'extraMerchantData[0][ccChargeType]' => 'percentage',
    'extraMerchantData[0][ibanNumber]' => "{$vendor[0]["iban"]}"
    */
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
    CURLOPT_POSTFIELDS => $paymentArray,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer afmceR6nHQaIehhpOel036LBhC8hihuB8iNh9ACF'
    ),
    )
);
$response = curl_exec($curl);
$response = json_decode($response, true);
curl_close($curl);
if ( is_null($response) || $response["status"] == false ) {
    $response = outputError($response);die();
}else{
    $_POST["gatewayId"] = $orderId;
    $_POST["gatewayBody"] = json_encode($paymentArray);
    $_POST["gatewayResponse"] = json_encode($response);
    $_POST["gatewayURL"] = $response["data"]["link"];
    $_POST["chargeType"] = $vendor[0]["chargeType"];
    $_POST["customerDetails"] = json_encode($_POST["customer"]);
    $_POST["totalPrice"] = $totalPrice;
    unset($_POST["customer"]);
    unset($_POST["time"]);
    unset($_POST["date"]);
    if( insertDB("bookings",$_POST)){
    }else{
        $response = outputError(direction("Failed to add booking","فشل في اضافة الحجز"));die();
    }
    if( $vendor[0]["chargeType"] == 3 ){
        $response["data"]["link"] = "https://reservaa.com/{$vendor[0]["url"]}?result=CAPTURED&requested_order_id={$orderId}";
    }
    echo outputData($response);die();
}
?>