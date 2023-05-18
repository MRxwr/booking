<?php
include_once ("includes/config.php");
if( setcookie("createkuwaitAdmin", "", time() - (86400*30 ), "/") ){
	header("Location: login.php");
}
?>