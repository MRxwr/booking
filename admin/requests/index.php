<?php
require_once("../includes/functions.php");

// check if a file with that name exist or not
function check_file_exists($filename) {
  $filepath = dirname(__FILE__) . '/' . $filename; // Get the full path to the file
  if (file_exists($filepath)) {
    return $filename; // Return the filename if the file exists
  } else {
    return false; // Return false if the file does not exist
  }
}

if( isset($_GET["r"]) && check_file_exists("{$_GET["r"]}.php") ){
	require_once(check_file_exists("{$_GET["r"]}.php"));
}else{
	echo "0";
}
?>