<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Days Details","تفاصيل الأيام") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">
							<div class="col-md-3">
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of Days","قائمة الأيام") ?></h6>
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
									<th><?php echo direction("Day","اليوم") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $blockedDays = selectDB("{$_GET["p"]}","`status` = '0'") ){
										for( $i = 0; $i < sizeof($blockedDays); $i++ ){
											$enDaysArray = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
											$arDaysArray = ["الأحد","الأثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"];
											for( $y = 0; $y < sizeof($enDaysArray); $y++){
												$day = direction($enDaysArray[$y],$arDaysArray[$y]);
											}
									?>
									<tr>
										<td id="day<?php echo $blockedDays[$i]["id"]?>" >
											<?php echo $day ?>
										</td>
										<td class="text-nowrap">
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $blockedDays[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
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
  