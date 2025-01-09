<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Theme Details","تفاصيل التصميم") ?></h6>
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
							<div class="col-md-3">
								<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
								<input type="text" name="enTitle" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
								<input type="text" name="arTitle" class="form-control" required>
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

    <div class="col-sm-12 mb-30" style="display: none;" id="uploadTheme">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Select Picture Types","حدد نوع الصور") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">

                            <div class="col-md-12">
								<label><?php echo direction("Upload New Theme","تحميل تصميم جديد") ?></label>
								<input type="file" name="theme" class="form-control" required>
							</div>

							<div class="col-md-12" style="margin-top:10px">
								<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
								<input type="hidden" name="update" value="1">
							</div>

                            <div id="listOfThemes" class="col-md-12">

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
					<h6 class="panel-title txt-dark"><?php echo direction("List of Themes","قائمة التصاميم") ?></h6>
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
									<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $themes = selectDB("{$table}","`status` = '0' $vendorIdDb ORDER BY `id` ASC") ){
										for( $i = 0; $i < sizeof($themes); $i++ ){
											if ( $themes[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$themes[$i]["id"]}";
												$hide = direction("Unlock","فتح");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$themes[$i]["id"]}";
												$hide = direction("Lock","قفل");
											}
									?>
									<tr>
										<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
										<td ><?php echo $themes[$i]["enTitle"] ?></td>
										<td ><?php echo $themes[$i]["arTitle"] ?></td>
										<td class="text-nowrap">
											<a id="<?php echo $themes[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $themes[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
												<i class="fa fa-close text-danger"></i>
											</a>
											<div style="display: none">
												<label id="vendorId<?php echo $themes[$i]["id"]?>"><?php echo $themes[$i]["vendorId"] ?></label>
												<label id="enTitle<?php echo $themes[$i]["id"]?>"><?php echo $themes[$i]["enTitle"] ?></label>
												<label id="arTitle<?php echo $themes[$i]["id"]?>"><?php echo $themes[$i]["arTitle"] ?></label>
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
		$("input[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
		$("select[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
	})
</script>
  