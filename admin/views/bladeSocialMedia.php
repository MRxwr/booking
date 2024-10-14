<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Social Media Platform Details","تفاصيل منصة التواصل") ?></h6>
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
								<input type="text" name="logo" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Link","الرابط") ?></label>
								<input type="text" name="link" class="form-control" required>
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
									<th><?php echo direction("Link","الرابط") ?></th>
									<th><?php echo direction("Icon","الأيقونه") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $socialMedia = selectDB("{$table}","`status` = '0' ORDER BY `order` ASC") ){
										for( $i = 0; $i < sizeof($socialMedia); $i++ ){
											if ( $socialMedia[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$socialMedia[$i]["id"]}";
												$hide = direction("Unlock","فتح الحساب");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$socialMedia[$i]["id"]}";
												$hide = direction("Lock","قفل الحساب");
											}
									?>
									<tr>
										<td>
											<input class="form-control" name="order[]" value="<?php echo sprintf("%02d",$socialMedia[$i]["order"]) ?>">
											<input style="display:none" name="id[]" value="<?php echo $socialMedia[$i]["id"]?>">
										</td>
										<td id="enTitle<?php echo $socialMedia[$i]["id"]?>" >
											<?php echo $socialMedia[$i]["enTitle"] ?>
										</td>
										<td id="arTitle<?php echo $socialMedia[$i]["id"]?>" >
											<?php echo $socialMedia[$i]["arTitle"] ?>
										</td>
										<td id="link<?php echo $socialMedia[$i]["id"]?>" >
											<?php echo $socialMedia[$i]["link"] ?>
										</td>
										<td>
											<div id="logo<?php echo $socialMedia[$i]["id"]?>" style="display:none"><?php echo $socialMedia[$i]["logo"] ?></div>
											<li class="<?php echo $socialMedia[$i]["logo"] ?>" style="font-size:25px"></li>
										</td>
										<td class="text-nowrap">
											<a id="<?php echo $socialMedia[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $socialMedia[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
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
		var logo = $("#logo"+id).html();
		var link = $("#link"+id).html();
		$("input[name=arTitle]").val($.trim(arTitle.replace(/\n/g, "")));
		$("input[name=enTitle]").val($.trim(enTitle.replace(/\n/g, ""))).focus();
		$("input[name=logo]").val($.trim(logo.replace(/\n/g, "")));
		$("input[name=link]").val($.trim(link.replace(/\n/g, "")));
	})
</script>
  