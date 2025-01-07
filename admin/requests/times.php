<?php
if ( $times = selectDB("times","`status` = '0' $vendorIdDb AND `hidden` = '0' ORDER BY `slug` ASC") ){
	$branch = selectDB("branches","`id` = '{$_POST["id"]}'");
	?>
	<div class="form-group">
	<div class="row">
	<form action="?v=Branches&updateTimes=<?php echo $_POST["id"] ?>" method="post" enctype="multipart/form-data">
	<?php
	$slug = "";
	foreach( $times as $time){
		$checked = "";
		if( $slug != $time["slug"] ){
			echo "<div class='col-md-12 pt-30'>{$time["slug"]}</div>";
			$slug = $time["slug"];
		}
		if( !empty($branch[0]["times"]) && in_array($time["id"],json_decode($branch[0]["times"],true)) ){
			$checked = "checked";
		}
		?>
		<div class="col-md-3">
		<input class="form-check-input" name="time[]" type="checkbox" id="time<?php echo $time["id"]; ?>" value="<?php echo $time["id"]; ?>" <?php echo $checked ?>>
		<label class="form-check-label" for="inlineCheckbox1"><?php echo $time["time"]; ?></label>
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