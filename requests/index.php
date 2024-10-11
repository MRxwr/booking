<?php
SESSION_START();
header("Content-Type: application/json");
require_once("../admin/includes/config.php");
require_once("../admin/includes/functions.php");

if( isset($_GET["page"]) && $_GET["page"] == "success" ){
	die();
}elseif( isset($_GET["page"]) && $_GET["page"] == "failure" ){
	die();
}

if( isset($_GET["lang"]) && !empty($_GET["lang"]) ){
	$requestLang = $_GET["lang"];
}else{
	$requestLang = "en";
}

if ( isset(getallheaders()["Authorization"]) && !empty(getallheaders()["Authorization"])){
	if( $checkToken = selectDBNew("tokens",[getallheaders()["Authorization"]],"`token` LIKE ?","") ){
		$token = $checkToken[0];
	}else{
		if( isset($_SESSION["deviceId"]) && !empty($_SESSION["deviceId"]) ){
			if( $deviceToken = selectDBNew("tokens",[$_SESSION["deviceId"]],"`deviceId` LIKE ?","") ){
				jump2:
				$newToken = password_hash(uniqid(), PASSWORD_BCRYPT);
				if( $token = selectDBNew("tokens",[$newToken],"`token` LIKE ?","") ){
					goto jump2;
				}else{
					updateDB("tokens",["token"=>$newToken],"`id` = '{$deviceToken[0]["id"]}'");
					echo outputData(array("token"=>$newToken));die();
				}
			}else{
				outputError(array("msg"=>"Invalid Device Id"));die();
			}
		}else{
			jump:
			$_SESSION["deviceId"] = md5(rand(00000,99999).time());
			if( $deviceToken = selectDBNew("tokens",[$_SESSION["deviceId"]],"`deviceId` LIKE ?","") ){
				goto jump;
			}else{
				insertDB("tokens",["deviceId"=>$_SESSION["deviceId"]]);
				jump3:
				$newToken = password_hash(uniqid(), PASSWORD_BCRYPT);
				if( $token = selectDBNew("tokens",[$newToken],"`token` LIKE ?","") ){
					goto jump3;
				}else{
					updateDB("tokens",["token"=>$newToken],"`deviceId` = '{$_SESSION["deviceId"]}'");
					echo outputData(array("token"=>$newToken));die();
				}
			}
		}
	}
}else{
	$error = array("msg"=>"Please Set Authorization Token");
	echo outputError($error);die();
}

// get viewed page from pages folder \\
if( isset($_GET["a"]) && searchFile("views","api{$_GET["a"]}.php") ){
	require_once("views/".searchFile("views","api{$_GET["a"]}.php"));
}else{
	$error = array("msg"=>"Wrong Action Request");
	echo outputError($error);die();
}
?>