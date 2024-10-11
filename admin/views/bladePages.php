<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Page Details","تفاصيل الصفحة") ?></h6>
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
								<label><?php echo direction("Icon","الأيقونه") ?></label>
								<input type="text" name="icon" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("File Name","إسم الملف") ?></label>
								<input type="text" name="fileName" class="form-control" required>
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of Pages","قائمة الصفحات") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="table-wrap mt-30">
						<div class="table-responsive mb-30">
						<form action="" method="post" enctype="multipart/form-data">
							<table class="table display responsive product-overview mb-30" id="myTable">
								<thead>
									<tr>
									<th>#</th>
									<th><?php echo direction("English Title","لإسم الإنجليزي") ?></th>
									<th><?php echo direction("Arabic Title"," الإسم العربي") ?></th>
									<th><?php echo direction("File Name","إسم الملف") ?></th>
									<th><?php echo direction("Icon","الأيقونه") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									var_dump(selectDB("{$_GET["v"]}","`status` = '0' ORDER BY `order` ASC"));
									if( $pages = selectDB("{$_GET["v"]}","`status` = '0' ORDER BY `order` ASC") ){
										for( $i = 0; $i < sizeof($pages); $i++ ){
											if ( $pages[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$pages[$i]["id"]}";
												$hide = direction("Unlock","فتح الحساب");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$pages[$i]["id"]}";
												$hide = direction("Lock","قفل الحساب");
											}			
									?>
									<tr>
										<td>
											<input class="form-control" name="order[]" value="<?php echo sprintf("%02d",$pages[$i]["order"]) ?>">
											<input style="display:none" name="id[]" value="<?php echo $pages[$i]["id"]?>">
										</td>
										<td id="enTitle<?php echo $pages[$i]["id"]?>" >
											<?php echo $pages[$i]["enTitle"] ?>
										</td>
										<td id="arTitle<?php echo $pages[$i]["id"]?>" >
											<?php echo $pages[$i]["arTitle"] ?>
										</td>
										<td id="fileName<?php echo $pages[$i]["id"]?>" >
											<?php echo $pages[$i]["fileName"] ?>
										</td>
										<td>
											<div id="icon<?php echo $pages[$i]["id"]?>" style="display:none"><?php echo $pages[$i]["icon"] ?></div>
											<li class="<?php echo $pages[$i]["icon"] ?>" style="font-size:25px"></li>
										</td>
										<td class="text-nowrap">
											<a id="<?php echo $pages[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $pages[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
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
							<button class="btn btn-primary"><?php echo direction("Submit new order","أدخل الترتيب الجديد") ?></button>
							</form>
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
		var fileName = $("#fileName"+id).html();
		var icon = $("#icon"+id).html();
		$("input[name=arTitle]").val($.trim(arTitle.replace(/\n/g, "")));
		$("input[name=enTitle]").val($.trim(enTitle.replace(/\n/g, "")));
		$("input[name=icon]").val($.trim(icon.replace(/\n/g, "")));
		$("input[name=fileName]").val($.trim(fileName.replace(/\n/g, ""))).focus();
	})
</script>
  