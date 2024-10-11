<div class="row">			
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Employee Details","تفاصيل الموظف") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Name","الإسم") ?></label>
			<input type="text" name="fullName" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Email","البريد الإلكتروني") ?></label>
			<input type="text" name="email" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Password","كلمة المرور") ?></label>
			<input type="text" name="password" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Mobile","الهاتف") ?></label>
			<input type="number" min="0" maxlength="8" name="phone" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Type","النوع") ?></label>
			<select name="empType" class="form-control">
				<option value="0"><?php echo direction("Admin","مدير") ?></option>
				<option value="1"><?php echo direction("Employee","موظف") ?></option>
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
				
				<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Employees","قائمة الموظفين") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th><?php echo direction("Name","الإسم") ?></th>
		<th><?php echo direction("Email","الإيميل") ?></th>
		<th><?php echo direction("Mobile","الهاتف") ?></th>
		<th><?php echo direction("Type","النوع") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $employees = selectDB("employees","`status` = '0' AND `hidden` != '1'") ){
			for( $i = 0; $i < sizeof($employees); $i++ ){
				$counter = $i + 1;
				if ( $employees[$i]["hidden"] == 2 ){
					$icon = "fa fa-unlock";
					$link = "?show={$employees[$i]["id"]}";
					$hide = direction("Unlock","فتح الحساب");
				}else{
					$icon = "fa fa-lock";
					$link = "?hide={$employees[$i]["id"]}";
					$hide = direction("Lock","قفل الحساب");
				}
				
				if ( $employees[$i]["empType"] == 0 ){
					$type = "Admin";
				}elseif( $employees[$i]["empType"] == 1 ){
					$type = "Employee";
				}
				
				?>
				<tr>
				<td id="name<?php echo $employees[$i]["id"]?>" ><?php echo $employees[$i]["fullName"] ?></td>
				<td id="email<?php echo $employees[$i]["id"]?>" ><?php echo $employees[$i]["email"] ?></td>
				<td id="mobile<?php echo $employees[$i]["id"]?>" ><?php echo $employees[$i]["phone"] ?></td>
				<td><?php echo $type ?></td>
				<td class="text-nowrap">
				
				<a id="<?php echo $employees[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
				</a>
				<a href="?delId=<?php echo $employees[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
				</a>
				<div style="display:none">
					<label id="type<?php echo $employees[$i]["id"]?>"><?php echo $employees[$i]["empType"] ?></label>				
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
<!-- JavaScript -->
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			var email = $("#email"+id).html();
			var name = $("#name"+id).html();
			var mobile = $("#mobile"+id).html();
			var type = $("#type"+id).html();
			var shop = $("#shop"+id).html();
			var logo = $("#logo"+id).html();
			$("input[name=password]").prop("required",false);
			$("input[name=email]").val(email);
			$("input[name=phone]").val(mobile);
			$("input[name=update]").val(id);
			$("input[name=fullName]").val(name);
			$("select[name=empType]").val(type);
			$("select[name=shopId]").val(shop);
		})
	</script>