<?php
require ("includes/config.php");
require ("includes/functions.php");
require ("includes/checksouthead.php");
if( isset($_GET["r"]) && searchFile("requests","{$_GET["r"]}.php") ){
	require_once("requests/".searchFile("requests","{$_GET["r"]}.php"));
}else{
	require_once("requests/home.php");
}
?>