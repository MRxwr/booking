<div class="row m-0 w-100">
	<div class="col-md-12">
		<label>Branch</label>
		<select name="branch" class="form-control" required>
			<option selected disabled value="0">Please select a Branch</option>
			<?php
			$orderBy = direction("enTitle","arTitle");
			$branches = selectDB("branches","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `{$orderBy}` ASC");
			foreach( $branches as $branch ){
				$branchTitle = direction($branch["enTitle"],$branch["arTitle"]);
				echo "<option value='{$branch["id"]}'>{$branchTitle}</option>";
			}
			?>
		</select>
	</div>
</div>

<div class="row m-0 w-100">
	<div class="col-12">
		<span>Services</span>
	</div>
	<div class="col-12 p-3">
		<div class="row m-0">
		<?php
		$services = selectDB("services","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `{$orderBy}` ASC");
		for( $i = 0; $i < count($services); $i++){
			?>
			<div class="col d-none align-items-center justify-content-center serviceBLk mx-2 mb-2 p-3" id="serv-<?php echo $services[$i]["id"] ?>">
				<span><?php echo direction($services[$i]["enTitle"],$services[$i]["arTitle"]); ?></span>
			</div>
			<?php
		}
		?>
		</div>
	</div>
</div>

<div class="row m-0 w-100">
	<div class="col-md-6">
		<label>Date</label>
		<input type="date" name="date" class="form-control">
	</div>
	<div class="col-md-6">
		<label>Time</label>
		<input type="time" name="time" class="form-control">
	</div>
</div>