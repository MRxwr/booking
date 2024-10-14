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
								<label><?php echo direction("Type","النوع") ?></label>
								<select name="type" class="form-control" required>
									<option value="1"><?php echo direction("Salon","صالون") ?></option>
									<option value="2"><?php echo direction("Clinic","عيادة") ?></option>
								</select>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Website URL","الرابط الويب") ?></label>
								<input type="text" name="url" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Subnscription","الاشتراك") ?></label>
								<input type="float" name="total" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("IBAN","IBAN") ?></label>
								<input type="text" name="iban" class="form-control" required>
							</div>

							<div class="col-md-6">
								<label><?php echo direction("Username","الإسم المستخدم") ?></label>
								<input type="text" name="username" class="form-control" required placeholder="ahmed123">
							</div>

							<div class="col-md-6">
								<label><?php echo direction("Password","كلمة المرور") ?></label>
								<input type="password" name="password" class="form-control" placeholder="123456">
							</div>

							<div class="col-md-4">
								<label><?php echo direction("Name","الاسم") ?></label>
								<input type="text" name="name" class="form-control" required placeholder="Ahmed">
							</div>
							
							<div class="col-md-4">
								<label><?php echo direction("Mobile","الجوال") ?></label>
								<input type="number" step="any" maxlength="11" name="mobile" class="form-control" placeholder="96512345678" required>
							</div>

							<div class="col-md-4">
								<label><?php echo direction("Email","البريد الالكتروني") ?></label>
								<input type="text" name="email" class="form-control" required placeholder="pJwJU@createkuwait.com">
							</div>

							<div class="col-md-6">
								<label><?php echo direction("English Website Title","الإسم الموقع الإنجليزي") ?></label>
								<input type="text" name="enTitle" class="form-control" required placeholder="Salon1">
							</div>

							<div class="col-md-6">
								<label><?php echo direction("Arabic Website Title","الإسم الموقع العربي") ?></label>
								<input type="text" name="arTitle" class="form-control" required placeholder="صالون1">
							</div>

							<div class="col-md-6">
								<label><?php echo direction("English Website Details","شرح الموقع الإنجليزي") ?></label>
								<textarea name="enDetails" class="form-control" required ></textarea>
							</div>

							<div class="col-md-6">
								<label><?php echo direction("Arabic Website Details","شرح الموقع العربي") ?></label>
								<textarea name="arDetails" class="form-control" required ></textarea>
							</div>

							<div class="col-md-6">
								<label><?php echo direction("English Website Terms","شروط الموقع الإنجليزي") ?></label>
								<textarea name="enTerms" class="form-control" required ></textarea>
							</div>

							<div class="col-md-6">
								<label><?php echo direction("Arabic Website Terms","شروط الموقع العربي") ?></label>
								<textarea name="arTerms" class="form-control" required ></textarea>
							</div>

							<?php 
							 if ( $socialMedia = selectDB("socialmedia","`status` = '0' ORDER BY `order` ASC") ){
								 for( $i = 0; $i < sizeof($socialMedia); $i++ ){
									 $name = direction($socialMedia[$i]["enTitle"],$socialMedia[$i]["arTitle"]);
									 echo '<div class="col-md-6">
									 <label>'.$name.'</label>
									 <input type="text" name="sm['.$socialMedia[$i]["enTitle"].']" class="form-control" value="">
									 </div>';
								 }
							 }
							?>

							<div class="col-md-6">
								<label><?php echo direction("Logo","الشعار") ?></label>
								<input type="file" name="logo" class="form-control">
							</div>

							<div class="col-md-6">
								<label><?php echo direction("Cover","الغلاف" ) ?></label>
								<input type="file" name="coverImg" class="form-control">
							</div>

							<div id="images" style="margin-top: 10px; display:none">
								<div class="col-md-6">
								<img id="logo" src="" style="width:250px;height:250px">
								</div>

								<div class="col-md-6">
								<img id="coverImg" src="" style="width:250px;height:250px">
								</div>
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of vendorss","قائمة الخدمات") ?></h6>
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
									<th><?php echo direction("Type","النوع") ?></th>
									<th><?php echo direction("Name","الإسم") ?></th>
									<th><?php echo direction("Mobile","الجوال") ?></th>
									<th><?php echo direction("Email","البريد الإلكتروني") ?></th>
									<th><?php echo direction("URL","الرابط") ?></th>
									<th><?php echo direction("Subscription","الاشتراك") ?></th>
									<th><?php echo direction("Payment Status","حالة الدفع") ?></th>
									<th><?php echo direction("Live Status","حالة العمل") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $vendors = selectDB("{$table}","`status` = '0' ORDER BY `id` ASC") ){
										for( $i = 0; $i < sizeof($vendors); $i++ ){
											if ( $vendors[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$vendors[$i]["id"]}";
												$hide = direction("Unlock","فتح");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$vendors[$i]["id"]}";
												$hide = direction("Lock","قفل");
											}		
											$hidden = ( $vendors[$i]["hidden"] == 1) ? direction("Active","مفعل") : direction("Inactive","غير مفعل");	
											$paymentStatus = ( $vendors[$i]["paymentStatus"] == 1) ? direction("Paid","مدفوع") : direction("Unpaid","غير مدفوع");
											$type = ( $vendors[$i]["type"] == 1) ? direction("Salon","صالون") : direction("Clinic","عيادة");
									?>
									<tr>
										<td ><?php echo $type ?></td>
										<td id="name<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["name"] ?></td>
										<td id="mobile<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["mobile"] ?></td>
										<td id="email<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["email"] ?></td>
										<td id="url<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["url"] ?></td>
										<td id="total<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["total"] ?></td>
										<td ><?php echo $paymentStatus ?></td>
										<td id="hidden<?php echo $vendors[$i]["id"]?>" ><?php echo $hidden ?></td>
										<td class="text-nowrap">
											<a id="<?php echo $vendors[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $vendors[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
												<i class="fa fa-close text-danger"></i>
											</a>
										</td>
										<div style="display:none">
											<label id="type<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["type"] ?></label>
											<label id="username<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["username"] ?></label>
											<label id="enTitle<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["enTitle"] ?></label>
											<label id="arTitle<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["arTitle"] ?></label>
											<label id="iban<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["iban"] ?></label>
											<label id="enDetails<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["enDetails"] ?></label>
											<label id="arDetails<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["arDetails"] ?></label>
											<label id="enTerms<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["enTerms"] ?></label>
											<label id="arTerms<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["arTerms"] ?></label>
											<label id="logo<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["logo"] ?></label>
											<label id="coverImg<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["coverImg"] ?></label>
											<label id="sm<?php echo $vendors[$i]["id"]?>" ><?php echo $vendors[$i]["socialMedia"] ?></label>
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

<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);
		$("select[name=type]").val($.trim($("#type"+id).html().replace(/\n/g, ""))).focus();;
		$("input[name=enTitle]").val($.trim($("#enTitle"+id).html().replace(/\n/g, "")));
		$("input[name=arTitle]").val($.trim($("#arTitle"+id).html().replace(/\n/g, "")));
		$("textarea[name=enDetails]").val($.trim($("#enDetails"+id).html().replace(/\n/g, "")));
		$("textarea[name=arDetails]").val($.trim($("#arDetails"+id).html().replace(/\n/g, "")));
		$("textarea[name=enTerms]").val($.trim($("#enTerms"+id).html().replace(/\n/g, "")));
		$("textarea[name=arTerms]").val($.trim($("#arTerms"+id).html().replace(/\n/g, "")));
		$("input[name=name]").val($.trim($("#name"+id).html().replace(/\n/g, "")));
		$("input[name=username]").val($.trim($("#username"+id).html().replace(/\n/g, "")));
		$("input[name=mobile]").val($.trim($("#mobile"+id).html().replace(/\n/g, "")));
		$("input[name=email]").val($.trim($("#email"+id).html().replace(/\n/g, "")));
		$("input[name=url]").val($.trim($("#url"+id).html().replace(/\n/g, "")));
		$("input[name=total]").val($.trim($("#total"+id).html().replace(/\n/g, "")));
		$("input[name=iban]").val($.trim($("#iban"+id).html().replace(/\n/g, "")));
		$("img[id=logo]").attr("src","../logos/"+$("#logo"+id).html());
		$("img[id=coverImg]").attr("src","../logos/"+$("#coverImg"+id).html());
		$("#images").attr("style","margin-top:10px;display:block");
		var sm = $.trim($("#sm"+id).html().replace(/\n/g, ""));
		console.log(sm);
		if(sm != ""){
		  var sm = JSON.parse(sm);
		  <?php
		for( $i = 0; $i < sizeof($socialMedia); $i++ ){
			$name = direction($socialMedia[$i]["enTitle"],$socialMedia[$i]["arTitle"]);
			echo "$('input[name=sm['{$socialMedia[$i]["enTitle"]}]']').val(sm['{$socialMedia[$i]["enTitle"]}'])";
		}
		  ?>
		}
	})
</script>
  