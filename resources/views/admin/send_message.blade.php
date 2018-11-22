@extends('layouts.admin.master')

@section('head')
<script src="//cdn.ckeditor.com/4.7.0/full/ckeditor.js"></script>
@endsection
<!-- begin #content -->
@section('content')
<div id="content" class="content">
	<!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
                <li><a href="{{ url('Mr_Administrator/messages')}}">Mensajes</a></li>
                <li class="active">Enviar Mensajes</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Enviar Mensajes <small>42nd Studio</small></h1>
            <!-- end page-header -->

            <!-- begin row -->
            <div class="row">
            	<!-- begin col-4 -->
                <div class="col-md-4">
                <h5>
                	Opciones:
                </h5>
                <div class="text-center">
                	<button id="search_user" class="btn btn-block btn-inverse">Agregar Usuario</button>
                	<button id="to_all" class="btn btn-block btn-inverse">Enviar a Todos</button>
                	<br>
                	<!-- User List // Users selected -->
                	<h5>
                		Se Enviara a:
                	</h5>
					<ul id="sending_to" class="list-group">
						
					</ul>
                </div>
                </div>
                <br>
                <div class="col-md-8">
                <div id="display"></div>
            	<div class="panel-group" id="accordion">
        		<div class="panel panel-inverse overflow-hidden">
            		<div class="panel-heading">
                		<h3 class="panel-title">
                       		 Mensaje
                		</h3>
            		</div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Nombre Remitente</label>
                                    <div class="col-md-10">
                                        <input id="from" type="text" class="form-control" placeholder="Nombre Remitente" value="{{ env('APP_NAME', 'Tu Nombre') }}" />
                                        <div id="from_error" class="error_display"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Asunto</label>
                                    <div class="col-md-10">
                                        <input id="subject" type="text" class="form-control" placeholder="Asunto" />
                                        <div id="subject_error" class="error_display"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="postErrorDisplay">
               					 <ul class="list-group">
                  
            					</ul>
            				</div>
            				<textarea id="post_content" name="editor1"></textarea>
            				<div id="message_error" class="error_display"></div>
            				<br>
            				<div class="text-center"><button id="send_message" class="btn btn-lg btn-success">Enviar Mensaje</button>
            				</div>
            			</div>
                    </div>
                </div>
            </div>
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
	<script src="{{ asset('/js/admin_send_message.js') }}"></script>
	<script src="{{ asset('/js/admin_apps.min.js') }}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>

@endsection