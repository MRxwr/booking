<?php
//database connections
function deleteDB($table, $where){
	GLOBAL $dbconnect , $dbPrefix;
	$check = [';','"'];
	$where = str_replace($check,"",$where);
	$sql = "DELETE FROM `{$dbPrefix}{$table}` WHERE " . $where;
	if($result = $dbconnect->query($sql)){
	}else{
		$error = array("msg"=>"delete table error");
		return outputError($error);
	}
}

function selectDB($table, $where){
	GLOBAL $dbconnect , $dbPrefix;
	$check = [';','"'];
	$where = str_replace($check,"",$where);
	$sql = "SELECT * FROM `{$dbPrefix}{$table}`";
	if ( !empty($where) ){
		$sql .= " WHERE {$where}";
	}
	if($result = $dbconnect->query($sql)){
		while($row = $result->fetch_assoc() ){
			$array[] = $row;
		}
		if ( isset($array) AND is_array($array) ){
			return $array;
		}else{
			return 0;
		}
	}else{
		$error = array("msg"=>"select table error");
		return outputError($error);
	}
}

function selectDB2($select, $table, $where){
	GLOBAL $dbconnect , $dbPrefix;
	$check = [';','"'];
	$where = str_replace($check,"",$where);
	$sql = "SELECT {$select} FROM `{$dbPrefix}{$table}`";
	if ( !empty($where) ){
		$sql .= " WHERE {$where}";
	}
	if($result = $dbconnect->query($sql)){
		while($row = $result->fetch_assoc() ){
			$array[] = $row;
		}
		if ( isset($array) AND is_array($array) ){
			return $array;
		}else{
			return 0;
		}
	}else{
		$error = array("msg"=>"select table error");
		return outputError($error);
	}
}

function selectJoinDB($table, $joinData, $where){
	GLOBAL $dbconnect , $dbPrefix;
	GLOBAL $date;
	$check = [';','"'];
	$where = str_replace($check,"",$where);
	$sql = "SELECT ";
	for($i = 0 ; $i < sizeof($joinData["select"]) ; $i++ ){
		$sql .= $joinData["select"][$i];
		if ( $i+1 != sizeof($joinData["select"]) ){
			$sql .= ", ";
		}
	}
	$sql .=" FROM `{$dbPrefix}{$table}` as t ";
	for($i = 0 ; $i < sizeof($joinData["join"]) ; $i++ ){
		$counter = $i+1;
		$sql .= " JOIN `{$dbPrefix}{$joinData["join"][$i]}` as t{$counter} ";
		if( isset($joinData["on"][$i]) && !empty($joinData["on"][$i]) ){
			$sql .= " ON ".$joinData["on"][$i]." ";
		}
	}
	if ( !empty($where) ){
		$sql .= " WHERE " . $where;
	}
	if($result = $dbconnect->query($sql)){
		while($row = $result->fetch_assoc() ){
			$array[] = $row;
		}
		if ( isset($array) AND is_array($array) ){
			return $array;
		}else{
			return 0;
		}
	}else{
		$error = array("msg"=>"select table error");
		return outputError($error);
	}
}

function insertDB($table, $data){
	GLOBAL $dbconnect , $dbPrefix;
	$check = [';','"'];
	//$data = escapeString($data);
	$keys = array_keys($data);
	$sql = "INSERT INTO `{$dbPrefix}{$table}` (";
	for($i = 0 ; $i < sizeof($keys) ; $i++ ){
		$sql .= "`".$keys[$i]."`";
		if ( isset($keys[$i+1]) ){
			$sql .= ", ";
		}
	}
	$sql .= ")VALUES(";
	for($i = 0 ; $i < sizeof($data) ; $i++ ){
		$sql .= "'".$data[$keys[$i]]."'";
		if ( isset($keys[$i+1]) ){
			$sql .= ", ";
		}
	}		
	$sql .= ")";
	if($dbconnect->query($sql)){
		return 1;
	}else{
		$error = array("msg"=>"insert table error");
		return outputError($error);
	}
}

function updateDB($table ,$data, $where){
	GLOBAL $dbconnect , $dbPrefix;
	$check = [';','"'];
	//$data = escapeString($data);
	$where = str_replace($check,"",$where);
	$keys = array_keys($data);
	$sql = "UPDATE `{$dbPrefix}{$table}` SET ";
	for($i = 0 ; $i < sizeof($data) ; $i++ ){
		$sql .= "`".$keys[$i]."` = '".$data[$keys[$i]]."'";
		if ( isset($keys[$i+1]) ){
			$sql .= ", ";
		}
	}		
	$sql .= " WHERE " . $where;
	if($dbconnect->query($sql)){
		return 1;
	}else{
		$error = array("msg"=>"update table error");
		return outputError($error);
	}
}

function escapeString($data){
	GLOBAL $dbconnect , $dbPrefix;
	$keys = array_keys($data);
	for($i = 0 ; $i < sizeof($keys) ; $i++ ){
		$output[$keys[$i]] = mysqli_real_escape_string($dbconnect,$data[$keys[$i]]);
	}
	return $output;
}

function escapeStringDirect($data){
	GLOBAL $dbconnect , $dbPrefix;
	$output = mysqli_real_escape_string($dbconnect,$data);
	return $output;
}

?>