<?php 
require_once("template/header.php");

// call actions on all pages
if ( isset($_GET["hide"]) || isset($_GET["show"]) || isset($_GET["delId"]) || isset($_POST["update"]) || isset($_POST["order"]) ){
	$table = strtolower($_GET["v"]);
	if( isset($_GET["hide"]) && !empty($_GET["hide"]) && updateDB("{$table}",array('hidden'=> '1'),"`id` = '{$_GET["hide"]}'") ){
		
	}elseif( isset($_GET["show"]) && !empty($_GET["show"]) && updateDB("{$table}",array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		
	}elseif( isset($_GET["delId"]) && !empty($_GET["delId"]) && updateDB("{$table}",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		
	}elseif( isset($_POST["update"]) ){
		$id = $_POST["update"];
		unset($_POST["update"]);
		if( isset($_FILES['logo']) && is_uploaded_file($_FILES['logo']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "H." . getFileExtension($_FILES["logo"]["name"]);
			move_uploaded_file($_FILES["logo"]["tmp_name"], $originalfile1);
			$_POST["logo"] = str_replace("../logos/",'',$originalfile1);
		}
		
		if( isset($_FILES['coverImg']) && is_uploaded_file($_FILES['coverImg']['tmp_name']) ){
			$directory = "../logos/";
			$originalfile1 = $directory . date("d-m-y") . time() .  round(microtime(true)). "C." . getFileExtension($_FILES["coverImg"]["name"]);
			move_uploaded_file($_FILES["coverImg"]["tmp_name"], $originalfile1);
			$_POST["coverImg"] = str_replace("../logos/",'',$originalfile1);
		}
		
		if( isset($_POST["password"]) && !empty($_POST["password"]) ){
			$_POST["password"] = sha1($_POST["password"]);
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