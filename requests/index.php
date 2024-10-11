<?php
if( isset($_GET["v"]) && searchFile("views","api{$_GET["v"]}.php") ){
	$table = strtolower($_GET["v"]);
	require_once("views/".searchFile("views","api{$_GET["v"]}.php"));
}else{
	echo outputError(array("msg"=>direction("API Not Found","صفحة غير موجودة")));
}
?>