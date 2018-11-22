@extends('layouts.admin.master')

@section('head')
	<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="http://localhost/usbmedialab/resources/assets/css/admin/jquery-jvectormap.css" rel="stylesheet" />
    <link href="http://localhost/usbmedialab/resources/assets/js/admin/bootstrap_calendar.css" rel="stylesheet" />
    <link href="http://localhost/usbmedialab/resources/assets/css/admin/jquery.gritter.css" rel="stylesheet" />
    <link href="http://localhost/usbmedialab/resources/assets/css/admin/morris.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL CSS STYLE ================== -->
@endsection

@section('content')
@endsection


@section('scripts')
	<meta name="_token" content="{!! csrf_token() !!}" />
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/admin_apps.min.js"></script>
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