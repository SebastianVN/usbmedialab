<?php
use App\NotificationSubscription;
use App\ContactMessage;
use Carbon\Carbon;
Carbon::setLocale('es');
$messages = ContactMessage::orderBy('created_at', 'desc')->get();
$subscriptions = NotificationSubscription::all();
function subs_info($subscription){
  Log::debug($subscription);
  $res =  '<h6 class="list-group-item-heading">'. $subscription->email .'</h6>';
  $res .= '<p class="list-group-item-text">Reportes: ';
  switch ($subscription->level) {
    case 1:
      $res.= 'Mensajes Nuevos';
      break;
    case 2:
      $res.= 'Mensajes + Reportes';
      break;
    case 4:
      $res.= 'Técnicos';
      break;
    default:
      return null;
  }
  $res .= '<br>'.$subscription->notifications_sent.' enviadas.<br></p>';
  $res .= '<br><button class="del_sub btn btn-xs btn-danger" value="'. $subscription->id .'"><i class="fa fa-trash"></i></button>';
  Log::debug($res);
  return $res;
}
?>
@extends('layouts.admin.master')

@section('head')
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/buttons.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
                <li class="active">Mensajes</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Site Messages <small>42nd Studio</small></h1>
            <!-- end page-header -->
            <div id="errorDisplay"></div>
            <div class="row">
                <!-- begin col-3 -->
                <div class="col-md-3">
                    <button id="delete_all" class="btn btn-danger btn-block">Eliminar Todos Los Mensajes</button>
                    <hr>
                    <h3>Subscriptores</h3>
                    <div class="list-group" id="subscription_list">
                      @if($subscriptions->count() == 0)
                      <p class="text-center text-warning">No hay Subscriptores Registrados.</p>
                      @else
                      @foreach($subscriptions as $subscription)
                      <div class="list-group-item" id="sub_{{ $subscription->id }}">
                        {!! subs_info($subscription) !!}
                      </div>
                      @endforeach
                      @endif
                    </div>
                    <button id="new_sub" class="btn btn-info btn-block">Agregar Subscriptor</button>
                    <p class="text-muted">Los subscriptores reciben notificaciones del sitio web en el email registrado.</p>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Mensajes</h4>
                        </div>
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Recibido</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                    <tr id="message_{{ $message->id }}" class="odd gradeX {{ ($message->read == 0) ? 'warning':'' }}">
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->phone }}</td>
                                        <td>{{ $message->created_at . ' (' . $message->created_at->diffForHumans() . ')' }}</td>
                                        <td>
                                            <button class="view_message btn btn-inverse btn-xs" value="{{ $message->id }}"><i class="fa fa-search" aria-hidden="true"></i> Ver</button>
                                            <button class="delete_message btn btn-inverse btn-xs" value="{{ $message->id }}"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end #content -->

        <!-- Modal -->
        <div id="messageModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mensaje de <span class="msg_from"></span></h4>
                <p>Recibido <span id="msg_time"></span></p>
              </div>
              <div class="modal-body">
                <div id="errorDisplay"></div>
                <h5>Nombre: </h5>
                <p class="msg_from"></p>
                <h5>Teléfono: </h5>
                <p id="msg_phone"></p>
                <h5>Email: </h5>
                <p id="msg_email"> (<small id="msg_ip"></small>)</p>
                <h5>Mensaje: </h5>
                <p id="msg_msg"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="unreadMessage" type="button" class="unread_message btn btn-warning" data-dismiss="modal" value="-1">Marcar como no leído</button>
                <button id="delete_msg" class="delete_message btn btn-danger" value="-1">Eliminar</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Modal -->
        <div id="sub_modal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Subscriptor</h4>
              </div>
              <div class="modal-body">
                <div class="form-horizontal" id="sub_modal_form">
                  <fieldset>
                    <div class="form-group">
                      <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" id="sub_email" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="select" class="col-lg-2 control-label">Reporte</label>
                      <div class="col-lg-10">
                        <select class="form-control" id="sub_level">
                          <option value="1">Mensajes Nuevos</option>
                          <option value="2">Mensajes + Reportes</option>
                          <option value="4">Técnicos</option>
                        </select>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="save_sub" class="btn btn-success" value="-1">Guardar</button>
              </div>
            </div>

          </div>
        </div>
@endsection


@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
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
	<script src="{{ asset('/js/admin_messages.js') }}"></script>
	<script src="{{ asset('/js/admin_apps.min.js') }}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
@endsection
