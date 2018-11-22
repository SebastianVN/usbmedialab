<?php
use App\User;
use App\StaticPage;
use App\StaticContent;
use App\SocialMedia;
use App\SystemNotification;
use Carbon\Carbon;
Carbon::setLocale('es');
$pages = StaticPage::all();
$socials = SocialMedia::all();
$usuarios = User::orderBy('id', 'desc')->get();
$notification = SystemNotification::orderBy('updated_at','desc')->take(20)->get();
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
                <li class="active">Sudo Panel</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">SUDO Panel <small>42nd Studio</small></h1>
            <!-- end page-header -->

            <div class="row">
                <!-- begin col-3 -->
                <div class="col-md-3">
                <button id="new_page" class="btn btn-inverse btn-block" value="-1" type="button">Crear Pagina</button><br>
                <button id="search_user" class="btn btn-inverse btn-block" value="-1" type="button">Habilitar Usuario</button><br>
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Usuarios</h4>
                        </div>
                        <div class="panel-body">
                          <div id="Display"></div>
                            <div class="list-group" id="userList">
                              @foreach($usuarios as $usuario)
                              @if($usuario->level >= 8)
                              <div class="list-group-item" id="user_{{ $usuario->id }}">
                                <button class="btn btn-danger btn-xs disableUser pull-right" value="{{ $usuario->id }}">Deshabilitar</button>
                                <h5 class="list-group-item-heading">{{ $usuario->name }} ({{ $usuario->level }})</h5>
                                <p class="list-group-item-text">{{ $usuario->email }} </p>
                              </div>
                              @endif
                              @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <div class="col-md-9">
                    <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Registros de contenido</h4>
                    </div>
                    <div class="panel-body">
                    <div id="error_display"></div>
                        <table id="page_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Identificador</th>
                                    <th>Descripcion</th>
                                    <th>URL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pages as $page)
                                <tr id="page_{{$page->id}}">
                                	<td>
                                		<a href="{{ url('Mr_Administrator/sudo/site/'.$page->identifier) }}">{{ $page->identifier }}</a>
                                    @if($page->bilingual == 1)
                                    <span class="label label-primary pull-right">Bilingue</span>
                                    @endif
                                	</td>
                                    <td>
                                        {{ $page->es_description }}
                                    </td>
                                    <td>
                                        {{ $page->url }}
                                    </td>
                                	<td>
                                    <button  class="edit_page btn-circle btn-icon btn-success pull-left" value="{{ $page->id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                		<button class="deletePage btn-danger btn-circle btn-icon pull-right" value="{{ $page->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                	</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Registros de contenido</h4>
                </div>
                <div class="panel-body">
                <div id="error_display"></div>
                <div class="list-group">
                  @foreach($notification as $note)
                  <a href="{{ url('/Mr_Administrator/sudo/system_notification/'.$note->id) }}" class="list-group-item">
                    <h4 class="list-group-item-heading">{!! parse_notification_title($note->type) !!}</h4>
                    <p class="list-group-item-text">({{ $note->ip }}) <small class="pull-rigth">{{ $note->updated_at .' ('.$note->updated_at->diffForHumans(). ') '}}</small></p>
                  </a>
                  @endforeach
                  </div>
                </div>
            </div>
                </div>
            </div>
        </div>
        <!-- end #content -->
    <!-- Modal -->
    <div id="newPage" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nueva Pagina</h4>
          </div>
          <div class="modal-body">
            <div id="errorDisplay"></div>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Identificador</label>
                    <div class="col-md-9">
                        <input id="page_identifier" type="text" class="form-control" placeholder="Identificador" required autofocus/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Titulo</label>
                    <div class="col-md-9">
                        <input id="page_titulo_es" type="text" class="form-control" placeholder="Titulo" required autofocus/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Descripción</label>
                    <div class="col-md-9">
                        <input id="page_description" type="text" class="form-control" placeholder="Descripción" required autofocus/>
                    </div>
                </div>
                <div id="es_keywords" class="form-group">
                    <label class="col-md-3 control-label">Palabras Claves</label>
                    <div class="col-md-9">
                        <input id="Page_keywords_es" type="text" class="form-control" placeholder="Palabras Claves" required autofocus/>
                    </div>
                </div>
                <div class="form-group">
      				<label class="col-md-3 control-label">Lenguajes</label>
      					<div class="col-md-9">
        					 <div id="lang_en" class="checkbox" value="-1">
      						<label>
           			 			<input type="checkbox"> Pagina Bilingüe
          					</label>
        				</div>
     				 </div>
   				 </div>
                 <div id="en_title" class="form-group" style="display: none;">
                    <label class="col-md-3 control-label">English Title</label>
                    <div class="col-md-9">
                        <input id="page_title_en" type="text" class="form-control" placeholder="Titulo en Ingles" required autofocus/>
                    </div>
                </div>
                <div id="en_keywords" class="form-group" style="display: none;">
                    <label class="col-md-3 control-label">Keywords</label>
                    <div class="col-md-9">
                        <input id="Page_keywords" type="text" class="form-control" placeholder="Keyword" required autofocus/>
                    </div>
                </div>
                <div id="en_description" class="form-group" style="display: none;">
                    <label class="col-md-3 control-label">Description</label>
                    <div class="col-md-9">
                        <input id="page_description_en" type="text" class="form-control" placeholder="Description" required autofocus/>
                    </div>
                </div>
   				 <div class="form-group">
                    <label class="col-md-3 control-label">URL</label>
                    <div class="col-md-9">
                        <input id="page_url" type="text" class="form-control" placeholder="www.example.com/example" required autofocus/>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button id="create_page" class="btn btn-sm btn-success" value="-1">Guardar Cambios</button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>

      </div>
    </div>
    <!-- Modal -->
        <div id="enableUserModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Habilitar Usuario</h4>
              </div>
              <div class="modal-body">
                <div id="searchUser" class="input-group">
                    <input id="search_string" type="text" class="form-control" required autofocus/>
                    <div class="input-group-btn">
                        <button  id="user_search_btn" type="button" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    </div>
                <hr id="hidehr">
                <div id="user_list" class="well">
                    <ul id="search_results" class="list-group">

                    </ul>
                </div>
                <div id="confirmUser" style="display: none">
                  <h6>Habilitar Usuario a: </h6>
                      <div class="row">
                          <div id="errorDisplay"></div>
                            <div class="col-md-3 control-label">
                            	<h5 id="nameUser"></h5>
                            </div>
                          <div class="col-md-9 pull-right">
                            <h6>Como:</h6>
                            	<select id="selectUser" class="form-control">
      									          <option id="select_webmaster" value="16"> Webmaster (16)</option>
      									          <option id="select_sudo" value="32"> Super User (32)</option>
								              </select>
						                  <br>
                              <button id="cancel_user" class="btn btn-sm btn-danger">Cancelar</button>
                              <button id="save_user" class="btn btn-sm btn-success">Guardar</button>
                              <br>
                              </div>
                            </div>
                        </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              </div>
            </div>

          </div>
        </div>
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

    <!-- Modal -->
    <div id="editPage" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Pagina</h4>
          </div>
          <div class="modal-body">
            <div id="errorDisplay"></div>
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Identificador</label>
                    <div class="col-md-9">
                        <input id="edit_identifier" type="text" class="form-control" placeholder="Identificador" required autofocus/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Titulo</label>
                    <div class="col-md-9">
                        <input id="edit_titulo_es" type="text" class="form-control" placeholder="Titulo" required autofocus/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Descripcion</label>
                    <div class="col-md-9">
                        <input id="edit_description" type="text" class="form-control" placeholder="Descripcion" required autofocus/>
                    </div>
                </div>
                <div id="es_keywords" class="form-group">
                    <label class="col-md-3 control-label">Palabras Claves</label>
                    <div class="col-md-9">
                        <input id="edit_keywords_es" type="text" class="form-control" placeholder="Palabras Claves" required autofocus/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Lenguajes</label>
                        <div class="col-md-9">
                             <div class="checkbox" >
                            <label>
                                <input id="lang_edit" type="checkbox" value="0"> Pagina Bilingüe
                            </label>
                        </div>
                     </div>
                 </div>
                 <div id="en_title_edit" class="form-group" style="display: none;">
                    <label class="col-md-3 control-label">English Title</label>
                    <div class="col-md-9">
                        <input id="edit_title_en" type="text" class="form-control" placeholder="Titulo en Ingles" required autofocus/>
                    </div>
                </div>
                <div id="en_keywords_edit" class="form-group" style="display: none;">
                    <label class="col-md-3 control-label">Keywords</label>
                    <div class="col-md-9">
                        <input id="edit_keywords" type="text" class="form-control" placeholder="Keyword" required autofocus/>
                    </div>
                </div>
                <div id="en_description_edit" class="form-group" style="display: none;">
                    <label class="col-md-3 control-label">Description</label>
                    <div class="col-md-9">
                        <input id="edit_description_en" type="text" class="form-control" placeholder="Description" required autofocus/>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-md-3 control-label">URL</label>
                    <div class="col-md-9">
                        <input id="edit_url" type="text" class="form-control" placeholder="www.example.com/example" required autofocus/>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button id="edit_page" class="btn btn-sm btn-success" value="-1">Guardar Cambios</button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div id="confirmdeleteUserModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Deshabilitar usuario</h4>
          </div>
            <div class="modal-body">
                <div id="deleteUserConfirmation" class="m-t-20 m-b-20"></div>
            </div>
          <div class="modal-footer">
            <div id="errorDisplay"></div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <a href="{{ url('Mr_Administrator/sudo') }}" id="DeleteUser" class="btn btn-sm btn-success" value="-1">Confirmar</a>
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
    <script src="{{ asset('/js/admin_apps.min.js') }}"></script>
    <script src="{{ asset('/js/admin_site_dashboard.js') }}"></script>
    <script src="{{ asset('/js/admin_sudo.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
@endsection
