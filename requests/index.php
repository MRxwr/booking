<?php
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

var_dump(getallheaders());die();

if ( isset(getallheaders()["myacadheader"]) ){
	$headerAPI =  getallheaders()["myacadheader"];
}else{
	$error = array("msg"=>"Please set headres");
	echo outputError($error);die();
}

if ( $headerAPI != "myAcadAppCreate" ){
	$error = array("msg"=>"headers value is wrong");
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