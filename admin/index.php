<?php 
require_once("template/header.php");

// call actions on all pages
if ( isset($_GET["hide"]) || isset($_GET["show"]) || isset($_GET["delId"]) || isset($_POST["update"]) || isset($_POST["order"]) ){
	$table = strtolower($_GET["v"]);
	if( isset($_GET["hide"]) && !empty($_GET["hide"]) && updateDB("{$table}",array('hidden'=> '1'),"`id` = '{$_GET["hide"]}'") ){
		
	}elseif( isset($_GET["show"]) && !empty($_GET["show"]) && updateDB("{$table}",array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		
	}elseif( isset($_GET["delId"]) && !empty($_GET["delId"]) && updateDB("{$table}",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		
	}elseif( isset($_POST["update"]) ){
		if( isset($_POST["listTypes"]) && !empty($_POST["listTypes"]) ){
			$_POST["listTypes"] = json_encode($_POST["listTypes"]);
		}
		if( isset($_POST["themes"]) && !empty($_POST["themes"]) ){
			$_POST["themes"] = json_encode($_POST["themes"]);
		}
		$id = $_POST["update"];
		unset($_POST["update"]);
		if ( isset($_POST["sm"]) && !empty($_POST["sm"]) ){
			$_POST["socialMedia"] = json_encode($_POST["sm"]);
			unset($_POST["sm"]);
		}
		if( isset($_FILES['logo']) && is_uploaded_file($_FILES['logo']['tmp_name']) ){
			$_POST["logo"] = uploadImage($_FILES["logo"]["tmp_name"]);
		}
		
		if( isset($_FILES['coverImg']) && is_uploaded_file($_FILES['coverImg']['tmp_name']) ){
			$_POST["coverImg"] = uploadImage($_FILES["coverImg"]["tmp_name"]);
		}

		if( isset($_FILES['theme']) && is_uploaded_file($_FILES['theme']['tmp_name'][0]) ){
			if ( $themeGroup = selectDB("themes","`id` = '{$id}'") ){
				$themes = ( is_null($themeGroup[0]["themes"]) ) ? array() : json_decode($themeGroup[0]["themes"],true);
				for( $i = 0; $i < sizeof($_FILES['theme']['tmp_name']); $i++ ){
					$newTheme = uploadImage($_FILES["theme"]["tmp_name"][$i]);
					array_push($themes, $newTheme);
				}
				$_POST["themes"] = json_encode($themes);
			}
		}
		
		if( isset($_POST["password"]) && !empty($_POST["password"]) ){
			$_POST["password"] = sha1($_POST["password"]);
		}

		// Encode vendorId as JSON if it's an array or not already JSON
		if (isset($_POST["vendorId"])) {
			// For debugging
			error_log("Original vendorId: " . print_r($_POST["vendorId"], true));
			
			if (is_array($_POST["vendorId"])) {
				$_POST["vendorId"] = json_encode($_POST["vendorId"]);
				error_log("Encoded from array: " . $_POST["vendorId"]);
			} else {
				// Try to decode, if fails, encode as JSON
				json_decode($_POST["vendorId"]);
				if (json_last_error() !== JSON_ERROR_NONE) {
					$_POST["vendorId"] = json_encode([$_POST["vendorId"]]);
					error_log("Encoded single value: " . $_POST["vendorId"]);
				} else {
					error_log("Already valid JSON: " . $_POST["vendorId"]);
				}
			}
		}

		if ( $id == 0 ){
			if( insertDB("{$table}", $_POST) ){
			}else{
			?>
			<script>
				alert("Could not process your request, Please try again.");
			</script>
			<?php
			}
		}else{
			if( updateDB("{$table}", $_POST, "`id` = '{$id}'") ){
			}else{
			?>
			<script>
				alert("Could not process your request, Please try again.");
			</script>
			<?php
			}
		}
	}elseif( isset($_POST["order"]) ){
		for( $i = 0; $i < sizeof($_POST['id']); $i++ ){
			updateDB("{$table}",array("order"=>$_POST["order"][$i]),"`id` = '{$_POST["id"][$i]}'");
		}
	}
	?>
	<script>
		window.location.replace("<?php echo "?v={$_GET["v"]}" ?>");
	</script>
	<?php
}

// get viewed page from pages folder \\
if( isset($_GET["v"]) && searchFile("views","blade{$_GET["v"]}.php") ){
	$table = strtolower($_GET["v"]);
	require_once("views/".searchFile("views","blade{$_GET["v"]}.php"));
}else{
	require_once("views/bladeHome.php");
}

require("template/footer.php");
?>