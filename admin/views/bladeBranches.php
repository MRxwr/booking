<?php 
if( isset($_GET["updateTimes"]) || isset($_GET["updateServices"]) ){
	$array = array();
	if( isset($_GET["updateTimes"]) ){
		$id = $_GET["updateTimes"];
		$column = "times";
	}else{
		$id = $_GET["updateServices"];
		$column = "services";
	}
	if( !empty($_POST["time"]) ){
		$array = $_POST["time"];
	}elseif( !empty($_POST["service"]) ){
		$array = $_POST["service"];
	}
	updateDB("branches",array("{$column}"=> json_encode($array)),"`id` = '{$id}'");
	?>
	<script>
		window.location.replace("<?php echo "?v={$_GET["v"]}" ?>");
	</script>
	<?php
}
?>
<!-- Row -->
<div class="row m-0">
	<div class="col-sm-12 mb-30">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="text-center">
					<h6 class="panel-title txt-dark"><?php echo direction("Branch Details","تفاصيل الفرع") ?></h6>
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
									$vendors = selectDB("vendors","`status` = '0' AND `hidden` = '0' ORDER BY `enTitle` ASC");
									foreach( $vendors as $vendor ){
										echo "<option value='{$vendor["id"]}'>{$vendor["enTitle"]}</option>";
									}
									?>
								</select>
							</div>
						
							<div class="col-md-3">
								<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
								<input type="text" name="enTitle" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
								<input type="text" name="arTitle" class="form-control" required>
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Seats / Hour","المقاعد / ساعة") ?></label>
								<input type="number" step="any" min="1" name="seats" class="form-control" required value="1">
							</div>

							<div class="col-md-3">
								<label><?php echo direction("Location","الموقع") ?></label>
								<input type="text" name="location" class="form-control" required value="#">
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
					<h6 class="panel-title txt-dark"><?php echo direction("List of Branches","قائمة الأفرع") ?></h6>
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
									<th><?php echo direction("Location","الموقع") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $branch = selectDB("{$table}","`status` = '0' $vendorIdDb ORDER BY `id` ASC") ){
										for( $i = 0; $i < sizeof($branch); $i++ ){
											$vendor = selectDB("vendors","`id` = '{$branch[$i]["vendorId"]}'");
											$vendor = direction($vendor[0]["enTitle"],$vendor[0]["arTitle"]);
											if ( $branch[$i]["hidden"] == 1 ){
												$icon = "fa fa-unlock";
												$link = "?{$_SERVER["QUERY_STRING"]}&show={$branch[$i]["id"]}";
												$hide = direction("Unlock","فتح");
											}else{
												$icon = "fa fa-lock";
												$link = "?{$_SERVER["QUERY_STRING"]}&hide={$branch[$i]["id"]}";
												$hide = direction("Lock","قفل");
											}			
									?>
									<tr>
										<td ><?php echo str_pad(($counter = $i + 1),4,"0",STR_PAD_LEFT) ?></td>
										<td ><?php echo $vendor ?></td>
										<td ><?php echo $branch[$i]["enTitle"] ?></td>
										<td ><?php echo $branch[$i]["arTitle"] ?></td>
										<td ><?php echo $branch[$i]["seats"] ?></td>
										<td ><?php echo $branch[$i]["location"] ?></td>
										<td class="text-nowrap">
											<?php /*<a class="mr-25 timeBtn" id="<?php echo $branch[$i]["id"] ?>" title="<?php echo direction("Times","الأوقات") ?>" data-toggle="modal" data-target="#times">
												<i class="fa fa-clock-o text-inverse m-r-10"></i>
											</a>*/ ?>
											
											<a class="mr-25 serviceBtn" id="<?php echo $branch[$i]["id"] ?>" title="<?php echo direction("Services","الخدمات") ?>" data-toggle="modal" data-target="#services">
												<i class="fa fa-hand-paper-o text-inverse m-r-10"></i>
											</a>
										
											<a id="<?php echo $branch[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo "?{$_SERVER["QUERY_STRING"]}" ?>&delId=<?php echo $branch[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>">
												<i class="fa fa-close text-danger"></i>
											</a>
										</td>
										<div style="display: none">
											<label id="vendorId<?php echo $branch[$i]["id"]?>"><?php echo $branch[$i]["vendorId"] ?></label>
											<label id="enTitle<?php echo $branch[$i]["id"]?>"><?php echo $branch[$i]["enTitle"] ?></label>
											<label id="arTitle<?php echo $branch[$i]["id"]?>"><?php echo $branch[$i]["arTitle"] ?></label>
											<label id="location<?php echo $branch[$i]["id"]?>"><?php echo $branch[$i]["location"] ?></label>
											<label id="seats<?php echo $branch[$i]["id"]?>"><?php echo $branch[$i]["seats"] ?></label>
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
		$("input[name=arTitle]").val($.trim($("#arTitle"+id).html().replace(/\n/g, "")));
		$("input[name=enTitle]").val($.trim($("#enTitle"+id).html().replace(/\n/g, ""))).focus();
		$("input[name=location]").val($.trim($("#location"+id).html().replace(/\n/g, "")));
		$("select[name=vendorId]").val($.trim($("#vendorId"+id).html().replace(/\n/g, "")));
		$("input[name=seats]").val($.trim($("#seats"+id).html().replace(/\n/g, "")));
	})
	
	$(document).on("click",".timeBtn", function(){
		var branchId = $(this).attr("id");
		$.ajax({
			url: "request.php?r=times",
			type: "POST",
			data: { id : branchId },
			success: function(response) {
				$("#timesModalBody").html(response);
			}
	  });
	})
	  
	$(document).on("click",".serviceBtn", function(){
		var branchId = $(this).attr("id");
		$.ajax({
			url: "request.php?r=services",
			type: "POST",
			data: { id : branchId },
			success: function(response) {
				$("#servicesModalBody").html(response);
			}
	  });
	})
	
	
</script>

<!-- services -->
<div class="modal fade" id="services" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo direction("Services","الخدمات") ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="servicesModalBody">
        ...
      </div>
    </div>
  </div>
</div>

<!-- times -->
<div class="modal fade" id="times" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo direction("Times","الأوقات") ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="timesModalBody">
        ...
      </div>
    </div>
  </div>
</div>
  