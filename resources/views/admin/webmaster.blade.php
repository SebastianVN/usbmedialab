<?php
use App\User;
use App\HasService;
use Carbon\Carbon;
Carbon::setLocale('es');
$clientes = HasService::where('service_id', 1)->get();
?>
@extends('layouts.admin.master')

@section('head')
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/buttons.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
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
            <h1 class="page-header">WebMaster <small>42nd Studio</small></h1>
            <!-- end page-header -->
            
            <!-- begin row -->
            <div class="row">
                <!-- begin col-2 -->
                <div class="col-md-2">
                    <h5>
                        Opciones:
                    </h5>
                    <div class="btn-group-vertical">
                        <a href="#" class="btn btn-block btn-default">Enviar Correo</a>
                        <a href="#" class="btn btn-block btn-default">Enviar Mensaje</a>
                        <button id="enableUser" class="btn btn-block btn-default">Habilitar Cliente</button>
                        <a href="#" class="btn btn-block btn-default">Bloquear Acceso</a>
                    </div>
                </div>
                <!-- end col-2 -->
                <!-- begin col-10 -->
                <div class="col-md-10">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Clientes WebMaster</h4>
                        </div>
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Nombre</th>
                                        <th>Habilitado</th>
                                        <th>Proyectos</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clientes as $cliente)
                                    <?php $usuario = User::find($cliente->user_id); ?>
                                    <tr class="{{ ($cliente->available == 0) ? ('danger') : ('') }}">
                                        <td><a href="{{ url('Mr_Administrator/users/'.$usuario->email) }}">{{ $usuario->email }}</a></td>
                                        <td>{{ $usuario->name.' '.$usuario->surname }}</td>
                                        <td>por primera vez {{ $cliente->created_at->diffForHumans() }}<br>{{ ($cliente->created_at == $cliente->updated_at) ? ('') : ('renovado '.$cliente->updated_at->diffForHumans()) }}</td>
                                        <td></td>
                                        <td> {!! ($cliente->available == 0) ? ('<button class="btn btn-xs btn-info">Habilitar</button>') : ('<button class="btn btn-xs btn-danger">Deshabilitar</button>') !!}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-10 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end #content -->

        <!-- Modal -->
        <div id="enableUserModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Habilitar Cliente acceso WebMaster</h4>
              </div>
              <div class="modal-body">
                <div class="input-group">
                    <input id="search_string" type="text" class="form-control" required autofocus/>
                    <div class="input-group-btn">
                        <button  id="user_search_btn" type="button" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                </div>
                <hr>
                <div class="well">
                    <ul id="search_results" class="list-group">
                        
                    </ul>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              </div>
            </div>

          </div>
        </div>


        <!-- Modal -->
        <div id="confirmEnableUserModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Habilitar Cliente acceso WebMaster</h4>
              </div>
              <div class="modal-body">
                <div id="enablingConfirmation" class="m-t-20 m-b-20"></div>
              </div>
              <div class="modal-footer">
              </div>
            </div>

          </div>
        </div>
@endsection
    

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ asset('/js/admin_webmaster.js') }}"></script>
    <script src="{{ asset('/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('/js/jszip.min.js') }}"></script>
    <script src="{{ asset('/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/js/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/js/table-manage-buttons.demo.min.js') }}"></script>
    <script src="{{ asset('/js/admin_apps.min.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    
    <script>
        $(document).ready(function() {
            App.init();
            TableManageButtons.init();
        });
    </script>
@endsection