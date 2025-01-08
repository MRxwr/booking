<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Service Details","تفاصيل الخدمة") ?></h6>
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
									$vendors = selectDB("vendors","`status` = '0' $vendorDb AND `hidden` = '0' ORDER BY `enTitle` ASC");
									foreach( $vendors as $vendor ){
										echo "<option value='{$vendor["id"]}'>{$vendor["enTitle"]}</option>";
									}
									?>
								</select>
							</div>
						
							<div class="col-md-6">
								<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
								<input type="text" name="enTitle" class="form-control" required>
							</div>

							<div class="col-md-6">
								<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
								<input type="text" name="arTitle" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Seats / Hour","المقاعد / ساعة") ?></label>
								<input type="number" step="any" min="1" name="seats" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Duration in Mins","المدة بالدقيقة") ?></label>
								<input type="number" step="any" min="0"name="period" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Price","القيمة") ?></label>
								<input type="float" name="price" class="form-control" required>
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of services","قائمة الخدمات") ?></h6>
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
									<th><?php echo direction("English Title","الإسم الإنجليزي") ?></th>
									<th><?php echo direction("Arabic Title"," الإسم العربي") ?></th>
									<th><?php echo direction("Seats","المقاعد") ?></th>
									<th><?php echo direction("Period","المدة") ?></th>
									<th><?php echo direction("Price","القيمة") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $service = selectDB("{$table}","`status` = '0' $vendorIdDb ORDER BY `id` ASC") ){
										for( $i = 0; $i < sizeof($service); $i++ ){
											$vendorData = selectDB("vendors","`id` = '{$service[$i]["vendorId"]}'");
											$vendor = direction($vendorData[0]["enTitle"],$vendorData[0]["arTitle"]);
											if ( $service[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$service[$i]["id"]}";
												$hide = direction("Unlock","فتح");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$service[$i]["id"]}";
												$hide = direction("Lock","قفل");
											}
											if( $vendorData[0]["type"] == 3 ){
												$pictureType = "
												<a href='index.php?v=PictureType&id={$service[$i]["id"]}' class='mr-25' data-toggle='tooltip' data-original-title='" . direction("Picture Types","نوع الصور") . "'>
												<i class='fa fa-image text-inverse'></i>
												</a>";
											}else{
												$pictureType = "";
											}	
									?>
									<tr>
										<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
										<td ><?php echo $vendor ?></td>
										<td ><?php echo $service[$i]["enTitle"] ?></td>
										<td ><?php echo $service[$i]["arTitle"] ?></td>
										<td ><?php echo $service[$i]["seats"] ?></td>
										<td ><?php echo $service[$i]["period"] ?> min</td>
										<td ><?php echo $service[$i]["price"] ?> -/KD</td>
										<td class="text-nowrap">
											<?php echo $pictureType ?>
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
												<label id="price<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["price"] ?></label>
												<label id="period<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["period"] ?></label>
												<label id="enTitle<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["enTitle"] ?></label>
												<label id="arTitle<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["arTitle"] ?></label>
												<label id="seats<?php echo $service[$i]["id"]?>"><?php echo $service[$i]["seats"] ?></label>
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
		$("input[name=period]").val($.trim($("#period"+id).html().replace(/\n/g, "")));
		$("input[name=arTitle]").val($.trim($("#arTitle"+id).html().replace(/\n/g, "")));
		$("input[name=enTitle]").val($.trim($("#enTitle"+id).html().replace(/\n/g, ""))).focus();;
		$("input[name=price]").val($.trim($("#price"+id).html().replace(/\n/g, "")));
		$("input[name=seats]").val($.trim($("#seats"+id).html().replace(/\n/g, "")));
		$("select[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
	})
</script>
  