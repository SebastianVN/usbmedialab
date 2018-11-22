@extends('layouts.admin.master')

@section('head')
	
@endsection

@section('content')
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="active"><a href="javascript:;">Principal</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Reports Panel <small>42nd Studio</small></h1>
			<!-- end page-header -->
			<iframe src="http://www.gimnasiopsicopedagogico.com/analytics/index.php?module=Widgetize&action=iframe&moduleToWidgetize=Dashboard&actionToWidgetize=index&idSite=1&period=week&date=today&token_auth=3a63264a77b1355af4770c3aa2edd9a3" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="800" id="analytics_frame"></iframe>
		</div>
		<!-- end #content -->
@endsection


@section('scripts')
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{ asset('js/admin_apps.min.js') }}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			$('#analytics_frame').height(($( window ).height() - 140));
		});
	</script>
@endsection