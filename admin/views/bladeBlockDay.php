<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Blocked Day Details","تفاصيل اليوم المحظور") ?></h6>
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
									$vendors = selectDB("vendors","`status` = '0' $vendorDb AND `hidden` = '0' ORDER BY `enTitle` ASC");
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
							<div class="col-md-6">
								<label><?php echo direction("Block a day","إقفل يوم") ?></label>
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of Blocked Days","قائمة الأيام المحظورة") ?></h6>
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
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $blockedDays = selectDB("{$table}","`status` = '0' $vendorIdDb") ){
										$enDaysArray = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
										$arDaysArray = ["الأحد","الأثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"];
										for( $i = 0; $i < sizeof($blockedDays); $i++ ){
											$vendor = selectDB("vendors","`id` = '{$blockedDays[$i]["vendorId"]}'");
											$vendor = direction($vendor[0]["enTitle"],$vendor[0]["arTitle"]);
											$branch = selectDB("branches","`id` = '{$blockedDays[$i]["branchId"]}'");
											$branch = direction($branch[0]["enTitle"],$branch[0]["arTitle"]);
									?>
									<tr>
									<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
									<td ><?php echo $vendor ?></td>
									<td ><?php echo $branch ?></td>
										<td id="day<?php echo $blockedDays[$i]["id"]?>" >
											<?php echo direction($enDaysArray[$blockedDays[$i]["day"]],$arDaysArray[$blockedDays[$i]["day"]]) ?>
										</td>
										<td class="text-nowrap">
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $blockedDays[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
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
  