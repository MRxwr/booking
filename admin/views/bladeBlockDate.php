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
							<div class="col-md-12">
								<label><?php echo direction("Vendor","البائع") ?></label>
								<select name="vendorId" class="form-control" required>
									<?php 
									$vendors = selectDB("vendors","`status` = '0' AND `hidden` = '0' ORDER BY `enTitle` ASC");
									foreach( $vendors as $vendor ){
										echo "<option value='{$vendor["id"]}'>{$vendor["enTitle"]}</option>";
									}
									?>
								</select>
							</div>
							<div class="col-md-6">
								<label><?php echo direction("Start Date","تاريخ البداية") ?></label>
								<input type="date" name="startDate" class="form-control" required id="start_date">
							</div>

							<div class="col-md-6">
								<label><?php echo direction("End Date","تاريخ النهاية") ?></label>
								<input type="date" name="endDate" class="form-control" required id="end_date">
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
									<th><?php echo direction("Start Date","تاريخ البداية") ?></th>
									<th><?php echo direction("End Date","تاريخ النهاية") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $periods = selectDB("{$table}","`status` = '0' ORDER BY `id` DESC") ){
										for( $i = 0; $i < sizeof($periods); $i++ ){	
											$vendor = selectDB("vendors","`id` = '{$periods[$i]["vendorId"]}'");
											$vendor = direction($vendor[0]["enTitle"],$vendor[0]["arTitle"]);
									?>
									<tr>
									<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
									<td ><?php echo $vendor ?></td>
										<td id="startDate<?php echo $periods[$i]["id"]?>" >
											<?php echo $periods[$i]["startDate"] ?>
										</td>
										<td id="endDate<?php echo $periods[$i]["id"]?>" >
											<?php echo $periods[$i]["endDate"] ?>
										</td>
										<td class="text-nowrap">
											<a id="<?php echo $periods[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $periods[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
												<i class="fa fa-close text-danger"></i>
											</a>
										</td>
										<div style="display: none">
											<label id="vendorId<?php echo $branch[$i]["id"]?>"><?php echo $branch[$i]["vendorId"] ?></label>
										</div>
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
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);
		var startDate = $("#startDate"+id).html();
		var endDate = $("#endDate"+id).html();
		$("input[name=startDate]").val($.trim(startDate.replace(/\n/g, ""))).focus();
		$("input[name=endDate]").val($.trim(endDate.replace(/\n/g, "")));
		$("select[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
	})
	
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
  