<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Time Details","تفاصيل الوقت") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">
							<div class="col-md-6">
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
							<div class="col-md-6">
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
								<label><?php echo direction("Select a day","إختر يوم") ?></label>
								<select name="day" class="form-control" required>
								<?php 
								$values = ["0","1","2","3","4","5","6"];
								$enDaysArray = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
								$arDaysArray = ["الأحد","الأثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"];
								for( $i = 0; $i < sizeof($values); $i++){
									$day = direction($enDaysArray[$i],$arDaysArray[$i]);
									echo "<option value='{$values[$i]}'>{$day}</option>";
								}
								?>
								</select>
							</div>
	
							<div class="col-md-4">
								<label><?php echo direction("Open Time","وقت البدء") ?></label>
								<select name="startTime" class="form-control" required>
									<?php
									$values = ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00","24:00"];
									for( $i = 0; $i < sizeof($values); $i++){
										echo "<option value='{$values[$i]}'>{$values[$i]}</option>";
									}
									?>
								</select>
							</div>

							<div class="col-md-4">
								<label><?php echo direction("Close Time","وقت الاغلاق") ?></label>
								<select name="closeTime" class="form-control" required>
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of times","قائمة الوقت") ?></h6>
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
									<th><?php echo direction("Day","اليوم") ?></th>
									<th><?php echo direction("Open Time","وقت البدء") ?></th>
									<th><?php echo direction("Close Time","وقت الاغلاق") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $service = selectDB("{$table}","`status` = '0' $vendorIdDb ORDER BY `id` ASC") ){
										for( $i = 0; $i < sizeof($service); $i++ ){
											$vendor = selectDB("vendors","`id` = '{$service[$i]["vendorId"]}'");
											$vendor = direction($vendor[0]["enTitle"],$vendor[0]["arTitle"]);
											$branch = selectDB("branches","`id` = '{$service[$i]["branchId"]}'");
											$branch = direction($branch[0]["enTitle"],$branch[0]["arTitle"]);
											if ( $service[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$service[$i]["id"]}";
												$hide = direction("Unlock","فتح");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$service[$i]["id"]}";
												$hide = direction("Lock","قفل");
											}
											$values = ["0","1","2","3","4","5","6"];
											$enDaysArray = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
											$arDaysArray = ["الأحد","الأثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"];	
											$day = direction($enDaysArray[$service[$i]["day"]],$arDaysArray[$service[$i]["day"]]);
									?>
									<tr>
										<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
										<td ><?php echo $vendor ?></td>
										<td ><?php echo $branch ?></td>
										<td ><?php echo $day ?></td>
										<td ><?php echo $service[$i]["startTime"] ?></td>
										<td ><?php echo $service[$i]["closeTime"] ?></td>
										<td class="text-nowrap">
											<a id="<?php echo $service[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $service[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
												<i class="fa fa-close text-danger"></i>
											</a>
											<div style="display: none">
												<label id="vendorId<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["vendorId"] ?></label>
												<label id="branchId<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["branchId"] ?></label>
												<label id="day<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["day"] ?></label>
												<label id="startTime<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["startTime"] ?></label>
												<label id="closeTime<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["closeTime"] ?></label>
											</div>
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
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);
		$("select[name=day]").val($.trim($("#day"+id).html().replace(/\n/g, "")));
		$("select[name=startTime]").val($.trim($("#startTime"+id).html().replace(/\n/g, "")));
		$("select[name=closeTime]").val($.trim($("#closeTime"+id).html().replace(/\n/g, "")));
		$("select[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
		$("select[name=branchId]").val($.trim($("#branchId"+id).html().replace(/\n/g, "")));
	})
</script>
  
  
 