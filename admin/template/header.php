<?php
require_once("includes/config.php");
require_once("includes/functions.php");
require_once("includes/checksouthead.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>:: Create Kuwait CP :: </title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content=""/>
	<!-- Bootstrap Colorpicker CSS -->
	<link href="../vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css"/>
	<!-- select2 CSS -->
	<link href="../vendors/bower_components/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>
	<!-- switchery CSS -->
	<link href="../vendors/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" type="text/css"/>
	<!-- bootstrap-select CSS -->
	<link href="../vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
	<!-- bootstrap-tagsinput CSS -->
	<link href="../vendors/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
	<!-- bootstrap-touchspin CSS -->
	<link href="../vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css"/>
	<!-- multi-select CSS -->
	<link href="../vendors/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css"/>
	<!-- Bootstrap Switches CSS -->
	<link href="../vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
	<!-- Bootstrap Datetimepicker CSS -->
	<link href="../vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
	<!-- Custom CSS -->
	<link href="dist/css/style.css" rel="stylesheet" type="text/css">
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<!-- Data table CSS -->
	<link href="../vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
	<!-- bootstrap-touchspin CSS -->
	<link href="../vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css"/>
	<!-- Toast CSS -->
	<link href="../vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
	<!-- Calendar CSS -->
	<link href="../vendors/bower_components/fullcalendar/dist/fullcalendar.css" rel="stylesheet" type="text/css"/>
	<!-- Custom CSS -->
	<link href="dist/css/style.css" rel="stylesheet" type="text/css">
	<link href="css/system.css" rel="stylesheet" type="text/css">
	<link rel='stylesheet' href='../css/Roboto.css'>
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
	<!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!-- /Preloader -->
    <div class="wrapper theme-3-active pimary-color-green">
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
		<div class="page-wrapper" style="padding-top: 100px !important;">
            <div class="container-fluid">