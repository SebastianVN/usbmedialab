<?php
use App\SentMail;
use App\User;
use Carbon\Carbon;
Carbon::setLocale('es');
$messages = SentMail::orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
if(isset($identifier)){
    $message = SentMail::find($identifier);
    if(!isset($message)){abort(404);}
    $sent_to_array = explode(', ', $message->to_array);
}
?>
@extends('layouts.admin.master')

@section('content')
<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
        <li><a href="{{ url('Mr_Administrator/messages')}}">Mensajes</a></li>
        <li class="active">Mensajes Enviados</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Mensajes Enviados <small>42nd Studio</small></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-4 -->
        <div class="col-md-4">
        <h5>
            Opciones:
        </h5>
        <div class="text-center">
            @if(isset($identifier))
            <a href="/Mr_Administrator/messages/sent" class="btn btn-block btn-inverse">Volver a Enviados</a>
            <button id="delete_single" class="btn btn-block btn-danger" value="{{ $message->id }}">Eliminar</button>
            @else
            <button id="delete_all" class="btn btn-block btn-danger">Eliminar Todos</button>
            @endif
        </div>
        </div>
        <br>
        <div class="col-md-8">
            <div id="display"></div>
            @if(isset($identifier))
            <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Mensaje Enviado</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            Enviado a 
                            <div class="list-group">
                              @foreach($sent_to_array as $key)
                              <?php $user = User::find($key); ?>
                              @if(isset($user))
                              <div class="list-group-item">
                                <h4 class="list-group-item-heading">{{ $user->name.' '.$user->surname }}</h4>
                                <p class="list-group-item-text">{{ $user->email }}</p>
                              </div>
                              @endif
                              @endforeach
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h4>Asunto: <span class="pull-right small">Enviado {{ $message->created_at->diffForHumans() }}<br>{{ $message->created_at }} UTC</span></h4>
                            <p>{{ $message->subject }}</p>
                            <h4>Nombre a Mostrar: </h4>
                            <p>{{ $message->from }}</p>
                            <h4>Mensaje</h4>
                            <div class="well"><p>{!! $message->message !!}</p></div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Mensajes Enviados</h4>
                </div>
                <div class="panel-body">
                    <div class="list-group" id="message_list">
                      @foreach($messages as $message)
                      <a href="{{ url('Mr_Administrator/messages/sent/'.$message->id) }}" class="list-group-item">
                        <h4 class="list-group-item-heading">{{ $message->subject }}<span></span></h4>
                        <h5 class="pull-right">Enviado {{ $message->created_at->diffForHumans() }} ({{ $message->created_at }})</h5>
                        <p class="list-group-item-text">de: {{ $message->from }}</p>
                      </a>
                      @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        <br>
    </div>  
</div>

<!-- Modal -->
        <div id="enableUserModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Busqueda de Usuarios</h4>
              </div>
              <div class="modal-body">
                <div class="input-group">
                    <input id="search_string" type="text" class="form-control" required autofocus/>
                    <div class="input-group-btn">
                        <button  id="user_search_btn" type="button" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i>Buscar</button>
                    </div>
                </div>
                <hr>
                <div class="well">
                    <ul id="search_results" class="list-group">
                        
                    </ul>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>

          </div>
        </div>
@endsection

@section('scripts')
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
	<script src="{{ asset('/js/admin_sent_messages.js') }}"></script>
	<script src="{{ asset('/js/admin_apps.min.js') }}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>

@endsection