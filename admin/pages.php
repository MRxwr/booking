<?php 
require ("template/header.php");
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('pages',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: pages.php");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('pages',array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: pages.php");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('pages',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: pages.php");
	}
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("pages", $_POST) ){
			header("LOCATION: pages.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("pages", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: pages.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}
}
?>
				<!-- Row -->
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("Page Details","تفاصيل الصفحة") ?></h6>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<form class="" method="POST" action="" enctype="multipart/form-data">
						<div class="row m-0">
							<div class="col-md-6">
								<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
								<input type="text" name="enTitle" class="form-control" required>
							</div>

							<div class="col-md-6">
								<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
								<input type="text" name="arTitle" class="form-control" required>
							</div>

							<div class="col-md-6" style="margin-top:10px">
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
				<div class="pull-left">
					<h6 class="panel-title txt-dark"><?php echo direction("List of Pages","قائمة الصفحات") ?></h6>
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
									<th>#</th>
									<th><?php echo direction("English Title","لإسم الإنجليزي") ?></th>
									<th><?php echo direction("Arabic Title"," الإسم العربي") ?></th>
									<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if( $pages = selectDB("pages","`status` = '0' AND `hidden` != '1' ORDER BY `date` ASC") ){
									for( $i = 0; $i < sizeof($pages); $i++ ){
									if ( $pages[$i]["hidden"] == 2 ){
										$icon = "fa fa-unlock";
										$link = "?show={$pages[$i]["id"]}";
										$hide = direction("Unlock","فتح الحساب");
									}else{
										$icon = "fa fa-lock";
										$link = "?hide={$pages[$i]["id"]}";
										$hide = direction("Lock","قفل الحساب");
									}			
									?>
									<tr>
										<td><?php echo $y = $i + 1; ?></td>
										<td id="enTitle<?php echo $pages[$i]["id"]?>" >
											<?php echo $pages[$i]["enTitle"] ?></td>
										<td id="arTitle<?php echo $pages[$i]["id"]?>" >
											<?php echo $pages[$i]["arTitle"] ?></td>
										<td class="text-nowrap">
											<a id="<?php echo $pages[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit">
												<i class="fa fa-pencil text-inverse m-r-10"></i>
											</a>
											<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>">
												<i class="<?php echo $icon ?> text-inverse m-r-10"></i>
											</a>
											<a href="?delId=<?php echo $pages[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Delete">
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
<?php require_once("template/footer.php") ?>