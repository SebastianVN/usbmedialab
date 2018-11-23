@extends('layouts.admin.master')

@section('head')
	<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="http://localhost/usbmedialab2/resources/assets/css/admin/jquery-jvectormap.css" rel="stylesheet" />
    <link href="http://localhost/usbmedialab2/resources/assets/js/admin/bootstrap_calendar.css" rel="stylesheet" />
    <link href="http://localhost/usbmedialab2/resources/assets/css/admin/jquery.gritter.css" rel="stylesheet" />
    <link href="http://localhost/usbmedialab2/resources/assets/css/admin/morris.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL CSS STYLE ================== -->
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
			<h1 class="page-header">Administrator Panel <small>42nd Studio</small></h1>
			<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
				<div class="col-md-3 col-sm-4">
			        <a href="{{ url('Mr_Administrator/users') }}">
			        <div class="widget widget-stats bg-purple">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
			            <div class="stats-title">Usuarios</div>
			            <div class="stats-number"></div>
			            <div class="stats-progress progress">
                            <div class="progress-bar" style="width: 76.3%;"></div>
                        </div>
                        <div class="stats-desc">Ver Usuarios</div>
			        </div>
			        </a>
			        <br>
				</div>
				<div class="col-md-3 col-sm-4">
			        <a href="{{ url('Mr_Administrator/proyectos') }}">
			        <div class="widget widget-stats bg-purple">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
			            <div class="stats-title">Proyectos</div>
			            <div class="stats-number"></div>
			            <div class="stats-progress progress">
                            <div class="progress-bar" style="width: 76.3%;"></div>
                        </div>
                        <div class="stats-desc">Ver Proyectos</div>
			        </div>
			        </a>
			        <br>
				</div>
			</div>
			<!-- end row -->
		</div>
		<!-- end #content -->
@endsection


@section('scripts')
	<meta name="_token" content="{!! csrf_token() !!}" />
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/admin_apps.min.js"></script>
	<script>
		$(document).ready(function() {
			App.init();

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			    }
			});
			var piwikToken = '{!! env("PIWIK_TOK") !!}';
			piwikToken = piwikToken.slice(12);
			var formData ={
				module: 'API',
					method: 'VisitsSummary.getVisits',
					idSite: 1,
					period: 'day',
					date: 'today',
					format: 'JSON',
					token_auth: piwikToken,
			}
			var type = "get";
			var my_url = '/analytics/index.php';

			$.ajax({

				type:type,
				url:my_url,
				data:formData,

					success: function(data){
						console.log(data);
						var visitas = data.value;
						console.log(visitas);
						$('#VisitsSummary').text(visitas);
					},
					error: function(data){
						console.log(data);
					}
			});
		});
	</script>
@endsection