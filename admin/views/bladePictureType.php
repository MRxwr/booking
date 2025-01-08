<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Picture Type Details","تفاصيل نوع الصور") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">
							<?php
							if( empty($vendorId) ){
								?>
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
							<?php
							}else{
								echo "<input type='hidden' name='vendorId' value='{$vendorId}'>";
							}
							?>
							<div class="col-md-4">
								<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
								<input type="text" name="enTitle" class="form-control" required>
							</div>

							<div class="col-md-4">
								<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
								<input type="text" name="arTitle" class="form-control" required>
							</div>

							<div class="col-md-4">
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of Picture Types","قائمة نوع الصور") ?></h6>
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
									<th><?php echo direction("English Title","الإسم الإنجليزي") ?></th>
									<th><?php echo direction("Arabic Title"," الإسم العربي") ?></th>
									<th><?php echo direction("Price","القيمة") ?></th>
									<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $pictureType = selectDB("{$table}","`status` = '0' $vendorIdDb ORDER BY `id` ASC") ){
										for( $i = 0; $i < sizeof($pictureType); $i++ ){
											if ( $pictureType[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$pictureType[$i]["id"]}";
												$hide = direction("Unlock","فتح");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$pictureType[$i]["id"]}";
												$hide = direction("Lock","قفل");
											}
									?>
									<tr>
										<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
										<td ><?php echo $pictureType[$i]["enTitle"] ?></td>
										<td ><?php echo $pictureType[$i]["arTitle"] ?></td>
										<td ><?php echo $pictureType[$i]["price"] ?> -/KD</td>
										<td class="text-nowrap">
											<a id="<?php echo $pictureType[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $pictureType[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
												<i class="fa fa-close text-danger"></i>
											</a>
											<div style="display: none">
												<label id="vendorId<?php echo $pictureType[$i]["id"]?>"><?php echo $pictureType[$i]["vendorId"] ?></label>
												<label id="price<?php echo $pictureType[$i]["id"]?>"><?php echo $pictureType[$i]["price"] ?></label>
												<label id="enTitle<?php echo $pictureType[$i]["id"]?>"><?php echo $pictureType[$i]["enTitle"] ?></label>
												<label id="arTitle<?php echo $pictureType[$i]["id"]?>"><?php echo $pictureType[$i]["arTitle"] ?></label>
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
		$("input[name=arTitle]").val($.trim($("#arTitle"+id).html().replace(/\n/g, "")));
		$("input[name=enTitle]").val($.trim($("#enTitle"+id).html().replace(/\n/g, ""))).focus();;
		$("input[name=price]").val($.trim($("#price"+id).html().replace(/\n/g, "")));
		$("input[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
	})
</script>
  