<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Extra Info Details","تفاصيل المعلومه الإضافية") ?></h6>
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

							<div class="col-md-132">
                                <label><?php echo direction("is Required ?","إلزامي ؟") ?></label>
                                <select name="isRequired" class="form-control" required>
                                    <option value='0'><?php echo direction("Yes","نعم") ?></option>
                                    <option value='1'><?php echo direction("No","لا") ?></option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label><?php echo direction("Type","نوع") ?></label>
                                <select name="type" class="form-control" required>
                                    <option value='0'><?php echo direction("Text Box","صندوق نص") ?></option>
                                    <option value='1'><?php echo direction("Taxt Area","مساحه كتابيه") ?></option>
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of Extras Info","قائمة المعلومات الإضافيه") ?></h6>
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
									if( $extras = selectDB("{$table}","`status` = '0' $vendorIdDb ORDER BY `id` ASC") ){
										for( $i = 0; $i < sizeof($extras); $i++ ){
											if ( $extras[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$extras[$i]["id"]}";
												$hide = direction("Unlock","فتح");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$extras[$i]["id"]}";
												$hide = direction("Lock","قفل");
											}
									?>
									<tr>
										<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
										<td ><?php echo $extras[$i]["enTitle"] ?></td>
										<td ><?php echo $extras[$i]["arTitle"] ?></td>
										<td class="text-nowrap">
											<a id="<?php echo $extras[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $extras[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
												<i class="fa fa-close text-danger"></i>
											</a>
											<div style="display: none">
												<label id="vendorId<?php echo $extras[$i]["id"]?>"><?php echo $extras[$i]["vendorId"] ?></label>
												<label id="isRequired<?php echo $extras[$i]["id"]?>"><?php echo $extras[$i]["isRequired"] ?></label>
												<label id="type<?php echo $extras[$i]["id"]?>"><?php echo $extras[$i]["type"] ?></label>
												<label id="enTitle<?php echo $extras[$i]["id"]?>"><?php echo $extras[$i]["enTitle"] ?></label>
												<label id="arTitle<?php echo $extras[$i]["id"]?>"><?php echo $extras[$i]["arTitle"] ?></label>
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
		$("select[name=type]").val($.trim($("#type"+id).html().replace(/\n/g, "")));
		$("select[name=isRequired]").val($.trim($("#isRequired"+id).html().replace(/\n/g, "")));
		$("input[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
		$("select[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
	})
</script>
  