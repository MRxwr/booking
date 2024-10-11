<?php
if( isset($_POST["time"]) ){
	for( $i = 0; $i < sizeof($_POST["time"]); $i++ ){
		$data = array(
			"time" => $_POST["time"][$i],
			"startDate" => $_POST["startDate"],
			"endDate" => $_POST["endDate"]
		);
		if( insertDB($_GET["p"], $data) ){}
	}
}
?>
<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Period Details","تفاصيل المدة") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">
							<div class="col-md-3">
								<label><?php echo direction("Start Date","تاريخ البداية") ?></label>
								<input type="date" name="startDate" class="form-control" required id="start_date">
							</div>
							<div class="col-md-3">
								<label><?php echo direction("End Date","تاريخ النهاية") ?></label>
								<input type="date" name="endDate" class="form-control" required id="end_date">
							</div>
							<?php
							$times = selectDB("times","`status` = '0' AND `hidden` = '0' ORDER BY `slug` ASC");
							$slug = "";
							foreach( $times as $time){
								if( $slug != $time["slug"] ){
									echo "<div class='col-md-12 pt-30'>{$time["slug"]}</div>";
									$slug = $time["slug"];
								}
								?>
								<div class="col-md-2">
								<input class="form-check-input" name="time[]" type="checkbox" id="time<?php echo $time["id"]; ?>" value="<?php echo $time["id"]; ?>">
								<label class="form-check-label" for="inlineCheckbox1"><?php echo $time["time"]; ?></label>
								</div>
								<?php
							}
							?>
							<div class="col-md-12" style="margin-top:10px">
								<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
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
									<th><?php echo direction("Start Date","تاريخ البداية") ?></th>
									<th><?php echo direction("End Date","تاريخ النهاية") ?></th>
									<th><?php echo direction("Time","الوقت") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $periods = selectDB("{$table}","`status` = '0' ORDER BY `id` DESC") ){
										for( $i = 0; $i < sizeof($periods); $i++ ){
											$times = selectDB("times","`id` = '{$periods[$i]["time"]}'");
									?>
									<tr>
										<td id="startDate<?php echo $periods[$i]["id"]?>" >
											<?php echo $periods[$i]["startDate"] ?>
										</td>
										<td id="endDate<?php echo $periods[$i]["id"]?>" >
											<?php echo $periods[$i]["endDate"] ?>
										</td>
										<td id="time<?php echo $periods[$i]["id"]?>" >
											<?php echo $times[0]["time"] ?>
										</td>
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
  