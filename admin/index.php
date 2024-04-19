<?php 
require_once("template/header.php");

// call actions on all pages
if ( isset($_GET["hide"]) || isset($_GET["show"]) || isset($_GET["delId"]) || isset($_POST["update"]) || isset($_POST["order"]) ){
	$table = strtolower($_GET["p"]);
	if( isset($_GET["hide"]) && !empty($_GET["hide"]) && updateDB("{$table}",array('hidden'=> '1'),"`id` = '{$_GET["hide"]}'") ){
		
	}elseif( isset($_GET["show"]) && !empty($_GET["show"]) && updateDB("{$table}",array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		
	}elseif( isset($_GET["delId"]) && !empty($_GET["delId"]) && updateDB("{$table}",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		
	}elseif( isset($_POST["update"]) ){
		$id = $_POST["update"];
		unset($_POST["update"]);
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
		window.location.replace("<?php echo "?p={$_GET["p"]}" ?>");
	</script>
	<?php
}

// get viewed page from pages folder \\
if( isset($_GET["p"]) && searchFile("pages","{$_GET["p"]}.php") ){
	$_GET["p"] = strtolower($_GET["p"]);
	require_once("pages/".searchFile("pages","{$_GET["p"]}.php"));
}else{
	require_once("pages/home.php");
}

require("template/footer.php");
?>