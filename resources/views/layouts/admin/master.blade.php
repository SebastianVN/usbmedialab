<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>@yield('title', 'Administrador | '.env('APP_NAME', '42nd Studio'))</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="@yield('description', '42nd Studio Administrative Tools')" name="description" />
	<meta content="42nd Studio" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link href="http://localhost/usbmedialab2/resources/assets/css/admin/jquery-ui.min.css'" rel="stylesheet" />
	<link href="http://localhost/usbmedialab2/resources/assets/css/admin/admin42_bootstrap.min.css" rel="stylesheet" />
	<link href="http://localhost/usbmedialab2/resources/assets/css/admin/font-awesome.min.css" rel="stylesheet" />
	<link href="http://localhost/usbmedialab2/resources/assets/css/admin/animate.min.css" rel="stylesheet" />
	<link href="http://localhost/usbmedialab2/resources/assets/css/admin/admin42_style.min.css" rel="stylesheet" />
	<link href="http://localhost/usbmedialab2/resources/assets/css/admin/admin42_style-responsive.min.css" rel="stylesheet" />
	<!--Icono title-->
    <link rel="shortcut icon" type="image/x-icon" href="http://localhost/usbmedialab/resources/assets/img/icontitle.png" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	@yield('head')
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/analytics.js"></script>
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		
		@include('layouts.admin.master_nav_up')
		
		@include('layouts.admin.master_nav_side')
		
		@yield('content')
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/jquery-1.9.1.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.9.1.min.map"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/jquery-migrate-1.1.0.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/jquery-ui.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="assets/crossbrowserjs/html5shiv.js"></script>
		<script src="assets/crossbrowserjs/respond.min.js"></script>
		<script src="assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/jquery.slimscroll.min.js"></script>
	<!-- ================== END BASE JS ================== -->


	@yield('scripts')
	
</body>
</html>
