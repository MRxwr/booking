<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('options',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: options.php");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('options',array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: options.php");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('options',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: options.php");
	}
}

if( isset($_POST["enOption"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("options", $_POST) ){
			header("LOCATION: options.php");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("options", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: options.php");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Option Details","تفاصيل الخيار") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			
			<div class="col-md-12">
			<label><?php echo direction("Type","النوع") ?></label>
			<select name="type" class="form-control">
				<option value="0"><?php echo direction("C-Store","المتجر الإلكتروني") ?></option>
				<option value="1"><?php echo direction("C-Studio","الإستوديو الإلكتروني") ?></option>
			</select>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("En Option","الخيار  بالإنجليزي") ?></label>
			<input type="text" name="enOption" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Ar Option","الخيار بالعربي") ?></label>
			<input type="text" name="arOption" class="form-control" required>
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Options","قائمة الخيارات") ?></h6>
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
		<th><?php echo direction("Type","النوع") ?></th>
		<th><?php echo direction("En Option","الخيار بالإنجليزي") ?></th>
		<th><?php echo direction("Ar Option","الخيار بالعربي") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $options = selectDB("options","`status` = '0' AND `hidden` != '1'") ){
			for( $i = 0; $i < sizeof($options); $i++ ){
				if ( $options[$i]["hidden"] == 2 ){
					$icon = "fa fa-unlock";
					$link = "?show={$options[$i]["id"]}";
					$hide = direction("Unlock","فتح الحساب");
				}else{
					$icon = "fa fa-lock";
					$link = "?hide={$options[$i]["id"]}";
					$hide = direction("Lock","قفل الحساب");
				}
				
				if ( $options[$i]["type"] == 0 ){
					$type = "C-Store";
				}elseif( $options[$i]["type"] == 1 ){
					$type = "C-Studio";
				}
				?>
				<tr>
				<td><?php echo $type ?></td>
				<td id="enOption<?php echo $options[$i]["id"]?>" ><?php echo $options[$i]["enOption"] ?></td>
				<td id="arOption<?php echo $options[$i]["id"]?>" ><?php echo $options[$i]["arOption"] ?></td>
				<td class="text-nowrap">
				
				<a id="<?php echo $options[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
				</a>
				<a href="?delId=<?php echo $options[$i]["id"] ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
				</a>
				<div style="display:none">
					<label id="type<?php echo $options[$i]["id"]?>"><?php echo $options[$i]["type"] ?></label>				
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
			var type = $("#type"+id).html();
			var enOption = $("#enOption"+id).html();
			var arOption = $("#arOption"+id).html();
			$("input[name=enOption]").val(enOption);
			$("input[name=arOption]").val(arOption);
			$("select[name=type]").val(type).focus();
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
