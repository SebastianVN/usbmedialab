<?php
use App\SystemNotification;
use App\User;
use Carbon\Carbon;

Carbon::setLocale('es');
$show_notification = SystemNotification::where('id',$id)->first();
$user = User::where('id',$show_notification->asociated_id)->first();
$notis = SystemNotification::where('id','!=',$show_notification->id)->where('ip',$show_notification->ip)->orderBy('id','desc')->take(5)->get();
?>
@extends('layouts.admin.master')

@section('head')
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="{{ asset('css/buttons.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection

@section('content')
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
          <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
          <li><a href="{{ url('Mr_Administrator/sudo')}}">Sudo Panel</a></li>
          <li class="active">Notificación {{ $show_notification->type }}</li>
      </ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Notificacion del Sistema <small>42nd Studio</small></h1>
			<!-- end page-header -->
			<div id="error_noti"></div>
      <div class="row">
        <div class="col-md-8">
          @if($show_notification->type == 'fail_login')
          <h3>{!! parse_notification_title($show_notification->type) !!}</h3>
          @if(isset($user))
					<div id="user_out">
          <h3>Usuario asociado</h3>

						<h4>{{ $user->name }} {{ $user->surname }}</h4>
						<h4>Estado: <strong id="b_user">{{ $user->status }}</strong> </h4>
						</div>
          @else
          <h3>Usuario no asociado</h3>

          @endif
          <h4>IP: <strong>{{ $show_notification->ip }}</strong></h4>
					<h4>Fecha: <strong>{{ $show_notification->created_at .' ('.$show_notification->created_at->diffForHumans(). ') ' }}</strong></h4>
					@if($show_notification->updated_at != $show_notification->created_at)
					<h4>Actualizado: <strong>{{ $show_notification->updated_at .' ('.$show_notification->updated_at->diffForHumans(). ') ' }}</strong></h4>
					@endif
					<h4>N° de intentos: <strong>{{ $show_notification->valor }}</strong></h4>
          <h3>Mensaje:</h3>
          <pre style="white-space: pre-wrap;white-space: -moz-pre-wrap; background-color: transparent; word-wrap: break-word; white-space: -o-pre-wrap; white-space: -pre-wrap; font-family: inherit"><h4>{{ $show_notification->content }}</h4></pre>
          @endif
        </div>
        <div class="col-md-4">
          <button id="deleteNotification" class="btn btn-danger btn-block" value="{{ $show_notification->id }}" type="button">Eliminar Notificación</button><br>

					@if(isset($user))
					<div id="add_b">
					@if($user->status == 'active')
					<button class="blockUser btn btn-warning btn-block" value="{{ $user->id }}" type="button">Bloquear Usuario</button><br>
					@endif
					@if($user->status == 'blocked')
					<button class="unBlockUser btn btn-primary btn-block" value="{{ $user->id }}" type="button">Desbloquear Usuario</button><br>
					@endif
					</div>
					<button id="deleteUser" class="btn btn-danger btn-block" value="{{ $user->id }}" type="button">Eliminar Usuario</button><br>
					@endif

          <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
              <div class="panel-heading">
                  <div class="panel-heading-btn">
                      <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                      <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                      <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                      <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                  </div>
                  <h4 class="panel-title">Notificaciones relacionadas recientes</h4>
              </div>
              <div class="panel-body">
                  <div class="list-group" id="notifications">
                    @foreach($notis as $not)
										<?php $usuario = User::find($not->asociated_id); ?>
                    <div id="notification_{{ $not->id }}" class="list-group-item">
                      <span class="pull-right">
                        <button class="delete_notification btn-danger btn-circle btn-icon" value="{{ $not->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      </span>
                      <a href="{{ url('/Mr_Administrator/sudo/system_notification/'.$not->id) }}" class="btn btn-succes"><h5 class="list-group-item-heading">{{ $not->ip }} <small>{{ $not->created_at->diffForHumans() }}</small></h5></a>
                      <br>
                      @if(isset($not->asociated_id))
                      @if(isset($usuario))
                      <span>{{ $usuario->email }}</span>
                      @else
                      <span>Usuario asociado</span>
                      @endif
                      @else
                      <span>Usuario no asociado</span>
                      @endif
                    </div>
                    @endforeach
                  </div>
              </div>
          </div>
        </div>
      </div>
		</div>
		<!-- end #content -->
		<!-- Modal -->
		<div id="confirmAlertModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Pagina Creada</h4>
					</div>
						<div class="modal-body">
								<div id="alertConfirmation" class="m-t-20 m-b-20"></div>
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
	<script src="{{ asset('/js/admin_apps.min.js') }}"></script>
	<script src="{{ asset('/js/admin_system_notification.js') }}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
@endsection
