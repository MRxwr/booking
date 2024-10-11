<?php
if ( $services = selectDB("services","`status` = '0' AND `hidden` = '0' ORDER BY `slug` ASC") ){
	$branch = selectDB("branches","`id` = '{$_POST["id"]}'");
	?>
	<div class="form-group">
	<div class="row">
	<form action="?v=Branches&updateServices=<?php echo $_POST["id"] ?>" method="post" enctype="multipart/form-data">
	<?php
	$slug = "";
	foreach( $services as $service){
		$checked = "";
		if( $slug != $service["slug"] ){
			echo "<div class='col-md-12 pt-30'>{$service["slug"]}</div>";
			$slug = $service["slug"];
		}
		if( !empty($branch[0]["services"]) && in_array($service["id"],json_decode($branch[0]["services"],true)) ){
			$checked = "checked";
		}
		?>
		<div class="col-md-3">
		<input class="form-check-input" name="service[]" type="checkbox" id="service<?php echo $service["id"]; ?>" value="<?php echo $service["id"]; ?>" <?php echo $checked ?>>
		<label class="form-check-label" for="inlineCheckbox1"><?php echo direction($service["enTitle"],$service["arTitle"]); ?></label>
		</div>
		<?php
	}
		echo "<div class='col-md-12 pt-30'><input class='btn btn-primary' value='".direction("Submit","أرسل")."' type='submit'></div>";
	?>
	</form>
	</div>
	</div>
	<?php
}
?>