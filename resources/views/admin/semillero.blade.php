<?php
use App\Semillero;
use Carbon\Carbon;
Carbon::setLocale('es');
$semilleros = Semillero::orderBy('id', 'desc')->get();
?>


@extends('layouts.admin.master')
@section('head')
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="http://localhost/usbmedialab2/resources/assets/css/admin/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="http://localhost/usbmedialab2/resources/assets/css/admin/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="http://localhost/usbmedialab2/resources/assets/css/admin/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection

@section('content')
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
				<li class="active">Semilleros</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Semilleros<small> USB Medialab</small></h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
            <div class="col-md">
            <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Semilleros USBmedialab Website</h4>
                    </div>
                    <div class="panel-body">
                    <div id="error_display"></div>
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Lider</th>
                                    <th>Misión</th>
                                    <th>Visión</th>
                                    <th>Integrantes</th>
                                    <th>Proyectos</th>
                                    <th>Ultima modrificación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semilleros as $semillero)
                                <tr id="user_{{ $semillero->id }}">
                                    <td>{{ $semillero->id }}</td>
                                    <td>{{ $semillero->nombre}}</td>
                                    <td>{{ $semillero->lider }}</td>
                                    <td>{{ $semillero->mision }}</td>
                                    <td>{{ $semillero->vision }}</td>
                                    <td>{{ $semillero->integrantes }}</td>
                                    <td>{{ $semillero->proyectos }}</td>
                                    <td>{{ $semillero->created_at }}<br>({{ $semillero->created_at->diffForHumans() }})</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div></div>
                
                <!-- end panel -->
            </div>
		</div>
		<!-- end #content -->
@endsection


@section('scripts')
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/jquery.dataTables.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/dataTables.bootstrap.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/dataTables.buttons.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/buttons.bootstrap.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/buttons.flash.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/jszip.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/pdfmake.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/vfs_fonts.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/buttons.html5.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/buttons.print.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/dataTables.responsive.min.js"></script>
	<script src="http://localhost/usbmedialab/resources/assets/js/admin/admin_apps.min.js"></script> 
    
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
@endsection