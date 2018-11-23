<?php
use App\User;
use Carbon\Carbon;
Carbon::setLocale('es');
$usuarios = User::orderBy('id', 'desc')->get();
?>
@extends('layouts.admin.master')

@section('head')
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="http://localhost/usbmedialab/resources/assets/css/admin/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="http://localhost/usbmedialab/resources/assets/css/admin/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="http://localhost/usbmedialab/resources/assets/css/admin/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection

@section('content')
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
				<li class="active">Usuarios</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Usuarios <small>USB MediaLab</small></h1>
			<!-- end page-header -->
			<button class="btn btn-primary btn-lg" id="crearProyecto" value="-1" type="button">Crear proyecto</button>
			<!-- begin row -->
			<div class="row">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Usuarios 42ndStudio Website</h4>
                    </div>
                    <div class="panel-body">
                    <div id="error_display"></div>
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Creado</th>
                                    <th>Último Login</th>
                                    <th>Última Acción</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuarios as $usuario)
                                <tr id="user_{{ $usuario->id }}">
                                    <td><a href="{{ url('Mr_Administrator/users/'.$usuario->email) }}">{{ $usuario->email }}</a></td>
                                    <td>{{ $usuario->name.' '.$usuario->surname }}</td>
                                    <td>{{ $usuario->phone }}</td>
                                    <td>{{ $usuario->created_at }}<br>({{ $usuario->created_at->diffForHumans() }})</td>
                                    <td>{{ $usuario->last_login }}<br>@if(($usuario->last_login) != null) ({{ $usuario->last_login->diffForHumans() }}) @endif</td>
                                    <td>{{ $usuario->last_action }}<br>@if(($usuario->last_action) != null) ({{ $usuario->last_action->diffForHumans() }}) @endif</td>
                                    <td><button class="deleteUser btn btn-xs btn-danger" value="{{ $usuario->id }}">Eliminar</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
    <script src="http://localhost/usbmedialab/resources/assets/js/admin/admin_users.js"></script>

	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
@endsection