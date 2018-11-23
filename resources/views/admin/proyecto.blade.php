<?php
use App\Proyecto;
use Carbon\Carbon;
Carbon::setLocale('es');
$proyectos = Proyecto::orderBy('id', 'desc')->get();
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
				<li class="active">Proyectos</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Proyectos<small> USB Medialab</small></h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
            <div class="col-md-2">
                <button class="btn btn-primary btn-lg" id="crearProyecto" value="-1" type="button">Crear proyecto</button>
            </div>
            <div class="col-md-10">
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
                                    <th>Nombre</th>
                                    <th>Lider</th>
                                    <th>Objetivo</th>
                                    <th>Misión</th>
                                    <th>Visión</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proyectos as $proyecto)
                                <tr id="user_{{ $proyecto->id }}">
                                    <td>{{ $proyecto->id }}</td>
                                    <td>{{ $proyecto->nombre}}</td>
                                    <td>{{ $proyecto->lider }}</td>
                                    <td>{{ $proyecto->objetivo }}</td>
                                    <td>{{ $proyecto->mision }}</td>
                                    <td>{{ $proyecto->vision }}</td>
                                    <td>{{ $proyecto->created_at }}<br>({{ $proyecto->created_at->diffForHumans() }})</td>
                                    <td><button class="deleteProject btn btn-xs btn-danger" value="{{ $proyecto->id }}">Eliminar</button></td>
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
        <!-- Modal -->
    <div id="crear_proyecto" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuevo Registro</h4>
          </div>
          <div class="modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Identificador</label>
                    <div class="col-md-9">
                        <input id="registry_identificador" type="text" class="form-control" placeholder="Identificador" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">lang</label>
                    <div class="col-md-9">
                        <select class="form-control" id="select_lang">
                          <option value="es">Español ( es )</option>
                          <option value="en">Ingles ( en )</option>
                          <option value="link">Link</option>
                          <option value="img">Imagen ( img )</option>
                          <option value="code">Widget</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Descripcion</label>
                    <div class="col-md-9">
                        <input id="registry_descripcion" type="text" class="form-control" placeholder="Descripcion"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tipo de contenido</label>
                    <div class="col-md-9">
                        <select class="form-control" id="selectType">
                          <option value="formatted_text">Texto formatted</option>
                          <option value="short_text">Texto corto</option>
                          <option value="long_text">Texto largo</option>
                          <option value="image">Imagen</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                <label class="col-md-3 control-label">Contenido</label>
                  <div class="col-md-9">
                    <textarea class="textarea form-control" rows="3" id="registry_content" placeholder="Contenido" rows="12"></textarea>
                  </div>
                  </div>
                <div class="form-group text-center">
                    <button id="create_registry" class="btn btn-sm btn-success" value="-1">Guardar Cambios</button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div id="errorDisplay"></div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
@endsection


@section('scripts')
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/jquery.dataTables.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/dataTables.bootstrap.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/dataTables.buttons.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/buttons.bootstrap.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/buttons.flash.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/jszip.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/pdfmake.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/vfs_fonts.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/buttons.html5.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/buttons.print.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/dataTables.responsive.min.js"></script>
	<script src="http://localhost/usbmedialab2/resources/assets/js/admin/admin_apps.min.js"></script> 
    <script src="http://localhost/usbmedialab2/resources/assets/js/admin/admin_proyecto.js"></script>

	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
@endsection