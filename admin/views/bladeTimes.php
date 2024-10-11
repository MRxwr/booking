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
							<div class="col-md-4">
								<label><?php echo direction("Admin Slug","الإسم التعريفي") ?></label>
								<input type="text" name="slug" class="form-control" required>
							</div>
						
							<div class="col-md-4">
								<label><?php echo direction("Time","الوقت") ?></label>
								<input type="time" name="time" class="form-control" required>
							</div>

							<div class="col-md-4">
								<label><?php echo direction("Seats","المقاعد") ?></label>
								<input type="number" name="seats" class="form-control" required>
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
									<th><?php echo direction("Admin Slug","الإسم التعريفي") ?></th>
									<th><?php echo direction("Time","الوقت") ?></th>
									<th><?php echo direction("Seats","المقاعد") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $service = selectDB("{$table}","`status` = '0' ORDER BY `id` ASC") ){
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
										<td id="time<?php echo $service[$i]["id"]?>" >
											<?php echo $service[$i]["time"] ?>
										</td>
										<td id="seats<?php echo $service[$i]["id"]?>" >
											<?php echo $service[$i]["seats"] ?>
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
		var time = $("#time"+id).html();
		var seats = $("#seats"+id).html();
		var slug = $("#slug"+id).html();
		$("input[name=time]").val($.trim(time.replace(/\n/g, "")));
		$("input[name=seats]").val($.trim(seats.replace(/\n/g, "")));
		$("input[name=slug]").val($.trim(slug.replace(/\n/g, ""))).focus();
	})
</script>
  
  
 