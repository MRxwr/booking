<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Vendor Details","تفاصيل العميل") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body ">
					<form class="mt-30 mb-30" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">
							<div class="col-md-3">
								<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
								<input type="text" name="enTitle" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
								<input type="text" name="arTitle" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Seats","المقاعد") ?></label>
								<input type="number" name="seats" class="form-control" required>
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
									<th><?php echo direction("Admin Slug","الإسم التعريفي") ?></th>
									<th><?php echo direction("English Title","الإسم الإنجليزي") ?></th>
									<th><?php echo direction("Arabic Title"," الإسم العربي") ?></th>
									<th><?php echo direction("Seats","المقاعد") ?></th>
									<th><?php echo direction("Price","القيمة") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $service = selectDB("{$_GET["p"]}","`status` = '0' ORDER BY `id` ASC") ){
										for( $i = 0; $i < sizeof($service); $i++ ){
											if ( $service[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$service[$i]["id"]}";
												$hide = direction("Unlock","فتح");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$service[$i]["id"]}";
												$hide = direction("Lock","قفل");
											}			
									?>
									<tr>
										<td id="slug<?php echo $service[$i]["id"]?>" >
											<?php echo $service[$i]["slug"] ?>
										</td>
										<td id="enTitle<?php echo $service[$i]["id"]?>" >
											<?php echo $service[$i]["enTitle"] ?>
										</td>
										<td id="arTitle<?php echo $service[$i]["id"]?>" >
											<?php echo $service[$i]["arTitle"] ?>
										</td>
										<td id="seats<?php echo $service[$i]["id"]?>" >
											<?php echo $service[$i]["seats"] ?>
										</td>
										<td id="price<?php echo $service[$i]["id"]?>" >
											<?php echo $service[$i]["price"] ?>Kd
										</td>
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
		var arTitle = $("#arTitle"+id).html();
		var enTitle = $("#enTitle"+id).html();
		var seats = $("#seats"+id).html();
		var price = $("#price"+id).html();
		var slug = $("#slug"+id).html();
		$("input[name=arTitle]").val($.trim(arTitle.replace(/\n/g, ""))).focus();
		$("input[name=enTitle]").val($.trim(enTitle.replace(/\n/g, "")));
		$("input[name=seats]").val($.trim(seats.replace(/\n/g, "")));
		$("input[name=price]").val($.trim(price.replace(/\n/g, "")));
		$("input[name=slug]").val($.trim(slug.replace(/\n/g, "")));
	})
</script>
  