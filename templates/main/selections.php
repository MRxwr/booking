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