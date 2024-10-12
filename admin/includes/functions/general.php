<?php
// check if a file with that name exist or not
function check_file_exists($filename) {
  $filepath = dirname(__FILE__) . '/' . $filename; // Get the full path to the file
  if (file_exists($filepath)) {
    return $filename; // Return the filename if the file exists
  } else {
    return false; // Return false if the file does not exist
  }
}

// get file extension \\
function getFileExtension($filePath) { 
    $dotPosition = strrpos($filePath, '.');
    $extension = ( $dotPosition === false ? '' : substr($filePath, $dotPosition + 1) );
    return $extension;
}


// search for file name inside a folder \\
function searchFile($path, $fileName) {
	if ($handle = opendir($path)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry == $fileName) {
				closedir($handle);
				return $entry;
			}
		}
		closedir($handle);
	}
	return false;
}
// set main language \\
function setLanguage(){ 
	GLOBAL $_GET;
	if ( isset($_GET["lang"]) && $_GET["lang"] == "ar" ){
		setcookie("createLang","ar",time() + (86400*30),"/");
	}else{
		setcookie("createLang","en",time() + (86400*30),"/");
	}
	if( isset($_GET["page"]) && !empty($_GET["page"]) ){
		header("LOCATION: ?page={$_GET["page"]}");
	}else{
		header("LOCATION: ?page=home");
	}
}

function setLanguageFront(){ 
	GLOBAL $_GET;
	if ( isset($_GET["lang"]) && $_GET["lang"] == "ar" ){
		setcookie("createLang","ar",time() + (86400*30),"/");
	}else{
		setcookie("createLang","en",time() + (86400*30),"/");
	}
	if( isset($_GET["vendorURL"]) && !empty($_GET["vendorURL"]) ){
		header("LOCATION: /{$_GET["vendorURL"]}");
	}
}
// get file extension \\
function get_file_extension($file_name) {
    return ".".pathinfo($file_name, PATHINFO_EXTENSION);
}

// odd or even \\
function odd_or_even($num) {
    return $num % 2 == 0 ? "even" : "odd";
}

// general \\
function direction($valEn,$valAr){
	GLOBAL $_COOKIE;
	if ( isset($_COOKIE["createLang"]) && $_COOKIE["createLang"] == "ar" ){
		$response = $valAr;
	}else{
		$response = $valEn;
	}
	return $response;
}

// get header active link \\
function headerActiveClass($data){
	GLOBAL $_GET;
	if( !isset($_GET["page"]) || empty($_GET["page"]) ){
		$_GET["page"] = "home";
	}
	for( $i = 0; $i < 4; $i++ ){
		if( strtoupper($data) == strtoupper($_GET["page"]) ){
			$response = "active";
			break;
		}else{
			$response = "";
		}
	}
	return $response;
}

// convert numbers to 3 digits \\
function numTo3Float($data){
	$data = number_format((float)$data, 3);
	return $data;
}

// generating a random alphanumeric code of 8 characters \\
function generateRandomString() {
    $bytes = random_bytes(8);
    $hex   = bin2hex($bytes);
    return substr($hex, 0, 8);
}

// make sure that phone numbers are in english \\
function convertMobileNumber($phone){
	$arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
	$english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
	$phone = str_replace($arabic, $english, $phone);
	return $phone;
}

// validating emal address \\
function validateEmail($email){
	GLOBAL $settingsEmail;
	if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false ){
	  return $settingsEmail;
	}else{
	  return $email;
	}
}

// generating automatic orderId \\
function generateOrderId(){
	if($orders = selectDB("orders2", "`id` != '' ORDER BY `id` DESC")){
		$newOrderNumber = (int)$orders[0]["orderId"] + 1;
	}else{
		$newOrderNumber = 1;
	}
	return $newOrderNumber;
}

// showing the response in a json form \\
function outputData($data){
	$response["ok"] = true;
	$response["error"] = "0";
	$response["status"] = "successful";
	$response["data"] = $data;
	return json_encode($response);
}

// showing erros in json form \\
function outputError($data){
	$response["ok"] = false;
	$response["error"] = "1";
	$response["status"] = "Error";
	$response["data"] = $data;
	return json_encode($response);
}

// resoring arrays of multiple dimensions \\
function array_sort($array, $on, $order){
    $new_array = array();
    $sortable_array = array();
    if (count($array) > 0){
        foreach ($array as $k => $v){
            if (is_array($v)){
                foreach ($v as $k2 => $v2){
                    if ($k2 == $on){
                        $sortable_array[$k] = $v2;
                    }
                }
            }else{
                $sortable_array[$k] = $v;
            }
        }
        switch($order){
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }
        foreach ($sortable_array as $k => $v){
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
}


function str_lreplace($search, $replace, $subject){
    $pos = strrpos($subject, $search);
    if($pos !== false){
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

?>