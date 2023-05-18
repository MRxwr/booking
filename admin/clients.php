<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('clients',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: clients.php");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('clients',array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: clients.php");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('clients',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: clients.php");
	}
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( is_uploaded_file($_FILES['logo']['tmp_name']) ){
			$directory = "../images/";
			$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). ".png";
			move_uploaded_file($_FILES["logo"]["tmp_name"], $originalfile);
			$_POST["logo"] = str_replace("../images/",'',$originalfile);
		}else{
			$_POST["logo"] = "";
		}
		if( insertDB("clients", $_POST) ){
			header("LOCATION: clients.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( is_uploaded_file($_FILES['logo']['tmp_name']) ){
			$directory = "../images/";
			$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). ".png";
			move_uploaded_file($_FILES["logo"]["tmp_name"], $originalfile);
			$_POST["logo"] = str_replace("../images/",'',$originalfile);
		}else{
			$logo = selectDB("categories","`id` = '{$id}'");
			$_POST["logo"] = $logo[0]["logo"];
		}
		if( updateDB("clients", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: clients.php");
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

<body>
	<!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!-- /Preloader -->
    <div class="wrapper  theme-1-active pimary-color-green">
		<!-- Top Menu Items -->
		<?php require ("template/navbar.php") ?>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php require("template/leftSideBar.php") ?>
		<!-- /Left Sidebar Menu -->
		
		<!-- Right Sidebar Menu -->
		<div class="fixed-sidebar-right">
		</div>
		<!-- /Right Sidebar Menu -->
		
		
		
		<!-- Right Sidebar Backdrop -->
		<div class="right-sidebar-backdrop"></div>
		<!-- /Right Sidebar Backdrop -->

        <!-- Main Content -->
		<div class="page-wrapper">
            <div class="container-fluid pt-25">
				<!-- Row -->
				<div class="row">
				
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Client Details","تفاصيل العميل") ?></h6>
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
			
			<div class="col-md-6">
			<label><?php echo direction("Link","الرابط") ?></label>
			<input type="text" name="link" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Logo","الصورة") ?></label>
			<input type="file" name="logo" class="form-control" required>
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
				
				<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Clients","قائمة العملاء") ?></h6>
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
		<th><?php echo direction("Link","الرابط") ?></th>
		<th><?php echo direction("Logo","الصورة") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $clients = selectDB("clients","`status` = '0' AND `hidden` != '1' ORDER BY `date` ASC") ){
			for( $i = 0; $i < sizeof($clients); $i++ ){
				if ( $clients[$i]["hidden"] == 2 ){
					$icon = "fa fa-unlock";
					$link = "?show={$clients[$i]["id"]}";
					$hide = direction("Unlock","فتح الحساب");
				}else{
					$icon = "fa fa-lock";
					$link = "?hide={$clients[$i]["id"]}";
					$hide = direction("Lock","قفل الحساب");
				}			
				?>
				<tr>
				<td><?php echo $y = $i + 1; ?></td>
				<td id="enTitle<?php echo $clients[$i]["id"]?>" ><?php echo $clients[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $clients[$i]["id"]?>" ><?php echo $clients[$i]["arTitle"] ?></td>
				<td id="link<?php echo $clients[$i]["id"]?>" ><?php echo $clients[$i]["link"] ?></td>
				<td><img src="../images/<?php echo $clients[$i]["logo"] ?>" style="width:100px;height:100px"></td>
				<td class="text-nowrap">
				
				<a id="<?php echo $clients[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
				</a>
				<a href="?delId=<?php echo $clients[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
				</a>
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
					<!-- /Bordered Table -->
				
				</div>
				<!-- /Row -->
			</div>
			
			<!-- Footer -->
			<?php require("template/footer.php") ?>
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
	
	<!-- JavaScript -->
	
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			$("input[name=update]").val(id);
			var enTitle = $("#enTitle"+id).html();
			var arTitle = $("#arTitle"+id).html();
			var link = $("#link"+id).html();
			$("input[name=enTitle]").val(enTitle);
			$("input[name=arTitle]").val(arTitle);
			$("input[name=link]").val(link);
		})
	</script>
	
    <!-- jQuery -->
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Data table JavaScript -->
	<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="dist/js/productorders-data.js"></script>
	<!-- Slimscroll JavaScript -->
	<script src="dist/js/jquery.slimscroll.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Sweet-Alert  -->
	<script src="../vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
	<script src="dist/js/sweetalert-data.js"></script>
		
	<!-- Switchery JavaScript -->
	<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
	<!-- Init JavaScript -->
	<script src="dist/js/init.js"></script>
</body>

</html>
