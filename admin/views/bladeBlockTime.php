<?php
if( isset($_POST["time"]) ){
	for( $i = 0; $i < sizeof($_POST["time"]); $i++ ){
		$data = array(
			"time" => $_POST["time"][$i],
			"startDate" => $_POST["startDate"],
			"endDate" => $_POST["endDate"]
		);
		if( insertDB($_GET["v"], $data) ){}
	}
}
?>
<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Blocked Time Details","تفاصيل الوقت المحظور") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">

							<div class="col-md-4">
								<label><?php echo direction("Vendor","البائع") ?></label>
								<select name="vendorId" class="form-control" required>
									<?php 
									$vendors = selectDB("vendors","`status` = '0' AND `hidden` = '0' ORDER BY `enTitle` ASC");
									$orderBy = direction("enTitle","arTitle");
									foreach( $vendors as $vendor ){
										$vendorTitle = direction($vendor["enTitle"],$vendor["arTitle"]);
										echo "<option value='{$vendor["id"]}'>{$vendorTitle}</option>";
									}
									?>
								</select>
							</div>
							<div class="col-md-4">
								<label><?php echo direction("Branch","الفرع") ?></label>
								<select name="branchId" class="form-control" required>
									<?php 
									$vendorData = ( isset($vendorId) && !empty($vendorId) ) ? " AND `vendorId` = '{$vendorId}'" : " AND `vendorId` != '0'";
									$orderBy = direction("enTitle","arTitle");
									$branches = selectDB("branches","`status` = '0' AND `hidden` = '0' {$vendorData} ORDER BY `{$orderBy}` ASC");
									foreach( $branches as $branch ){
										$vendors = selectDB("vendors","`id` = '{$branch["vendorId"]}'");
										$branchTitle = direction($branch["enTitle"],$branch["arTitle"]);
										$vendorTitle = direction($vendors[0]["enTitle"],$vendors[0]["arTitle"]);
										echo "<option value='{$branch["id"]}'>{$vendorTitle} - {$branchTitle}</option>";
									}
									?>
								</select>
							</div>

							<div class="col-md-4">
								<label><?php echo direction("Service","الخدمة") ?></label>
								<select name="serviceId" class="form-control" required>
								<option value='0' selected><?php echo direction("All Services","كل الخدمات") ?></option>
									<?php 
									$vendorData = ( isset($vendorId) && !empty($vendorId) ) ? " AND `vendorId` = '{$vendorId}'" : " AND `vendorId` != '0'";
									$branchData = ( isset($branchId) && !empty($branchId) ) ? " AND `branchId` = '{$branchId}'" : " AND `branchId` != '0'";
									$orderBy = direction("enTitle","arTitle");
									$services = selectDB("services","`status` = '0' AND `hidden` = '0' {$vendorData} {$branchData} ORDER BY `{$orderBy}` ASC");
									foreach( $services as $service ){
										$vendors = selectDB("vendors","`id` = '{$service["vendorId"]}'");
										$serviceTitle = direction($service["enTitle"],$service["arTitle"]);
										$vendorTitle = direction($vendors[0]["enTitle"],$vendors[0]["arTitle"]);
										echo "<option value='{$service["id"]}'>{$vendorTitle} - {$serviceTitle}</option>";
									}
									?>
								</select>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Start Date","تاريخ البداية") ?></label>
								<input type="date" name="startDate" class="form-control" required id="start_date">
							</div>
							<div class="col-md-3">
								<label><?php echo direction("End Date","تاريخ النهاية") ?></label>
								<input type="date" name="endDate" class="form-control" required id="end_date">
							</div>
							
							<div class="col-md-3">
								<label><?php echo direction("From Time","من وقت") ?></label>
								<select name="fromTime" class="form-control" required>
									<?php
									$values = ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00","24:00"];
									for( $i = 0; $i < sizeof($values); $i++){
										echo "<option value='{$values[$i]}'>{$values[$i]}</option>";
									}
									?>
								</select>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("To Time","إلى وقت") ?></label>
								<select name="toTime" class="form-control" required>
									<?php
									$values = ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00","24:00"];
									for( $i = 0; $i < sizeof($values); $i++){
										echo "<option value='{$values[$i]}'>{$values[$i]}</option>";
									}
									?>
								</select>
							</div>

							<div class="col-md-12" style="margin-top:10px">
								<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
								<input type="hidden" name="update" value="0">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("List of Periods","قائمة المدد") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="table-wrap mt-30">
						<div class="table-responsive mb-30">
							<table class="table display responsive product-overview mb-30" id="myTable">
								<thead>
									<tr>
									<th>#</th>
									<th><?php echo direction("Vendor","البائع") ?></th>
									<th><?php echo direction("Branch","الفرع") ?></th>
									<th><?php echo direction("Service","الخدمة") ?></th>
									<th><?php echo direction("Start Date","تاريخ البداية") ?></th>
									<th><?php echo direction("End Date","تاريخ النهاية") ?></th>
									<th><?php echo direction("From Time","من الوقت") ?></th>
									<th><?php echo direction("To Time","الي الوقت") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $periods = selectDB("{$table}","`status` = '0' ORDER BY `id` DESC") ){
										for( $i = 0; $i < sizeof($periods); $i++ ){
											$vendor = selectDB("vendors","`id` = '{$periods[$i]["vendorId"]}'");
											$vendor = direction($vendor[0]["enTitle"],$vendor[0]["arTitle"]);
											$branch = selectDB("branches","`id` = '{$periods[$i]["branchId"]}'");
											$branch = direction($branch[0]["enTitle"],$branch[0]["arTitle"]);
											$service = selectDB("services","`id` = '{$periods[$i]["serviceId"]}'");
											$service = direction($service[0]["enTitle"],$service[0]["arTitle"]);
									?>
									<tr>
										<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
										<td ><?php echo $vendor ?></td>
										<td ><?php echo $branch ?></td>
										<td ><?php echo $service ?></td>
										<td ><?php echo $periods[$i]["startDate"] ?></td>
										<td ><?php echo $periods[$i]["endDate"] ?></td>
										<td ><?php echo $periods[$i]["fromTime"] ?></td>
										<td ><?php echo $periods[$i]["toTime"] ?></td>
										<td class="text-nowrap">
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $periods[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
												<i class="fa fa-close text-danger"></i>
											</a>
										</td>
									</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	// Get the start and end date input elements
	var startDate = document.getElementById('start_date');
	var endDate = document.getElementById('end_date');

	// Add event listeners to the input elements
	startDate.addEventListener('change', updateEndDate);
	endDate.addEventListener('change', updateStartDate);

	// Function to update the minimum value of the end date
	function updateEndDate() {
	  endDate.min = startDate.value;
	}

	// Function to update the maximum value of the start date
	function updateStartDate() {
	  startDate.max = endDate.value;
	}
</script>
  