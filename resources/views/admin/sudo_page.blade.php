<?php
use App\User;
use App\StaticPage;
use App\StaticContent;
use App\SocialMedia;
use App\ContentBox;
use Carbon\Carbon;

Carbon::setLocale('es');

$socials = SocialMedia::all();
$contents = StaticContent::all();
$show_page = StaticPage::where('identifier', $identifier)->first();
$pages = StaticPage::where('id', '!=', $show_page->id)->get();
$all_pages = StaticPage::all();
$content_boxes = ContentBox::all();
$content_box = ContentBox::where('page_id',$show_page->id)->orderBy('page_order')->get();

?>
@extends('layouts.admin.master')
@section('head')
<script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/buttons.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection

@section('content')
<div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
                <li><a href="{{ url('Mr_Administrator/sudo')}}">Sudo Panel</a></li>
                <li class="active">Pagina {{ $show_page->identifier }}</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">SUDO Crear Registros y Caja de Contenidos<small>42nd Studio</small></h1>
            <!-- end page-header -->
            <div class="row">
            	<div class="col-md-4">
              <div id="display_error"></div>
              <button id="new_registry" class="btn btn-inverse btn-block" value="-1" type="button">Crear Registro</button><br>
              <button id="new_content_box" class="btn btn-success btn-block" value="{{ $show_page->id}}" type="button">Crear Content box</button><br>
            	<button id="new_composer" class="btn btn-inverse btn-block" value="-1" type="button">Generar Composer</button><br>
              <button id="delete_all_page" class="btn btn-danger btn-block" value="{{ $show_page->id }}" type="button">Eliminar esta Pagina</button><br>
              <button id="order_content_box" class="btn btn-warning btn-block" value="{{ $show_page->id }}" type="button">Ordenar Cajas de contenidos</button><br>
              <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                  <div class="panel-heading">
                      <div class="panel-heading-btn">
                          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                      </div>
                      <h4 class="panel-title">Paginas</h4>
                  </div>
                  <div class="panel-body">
                      <div class="list-group">
                        @foreach($pages as $page)
                        <a href="{{ url('Mr_Administrator/sudo/site/'.$page->identifier) }}" class="list-group-item">
                          <h5 class="list-group-item-heading">{{ $page->identifier }}</h5>
                          <p class="list-group-item-text">{{ $page->descripcion}} </p>
                        </a>
                        @endforeach
                      </div>
                  </div>
              </div>
            	</div>
            	<div class="col-md-8">
            		<div>
                  <div class="panel panel-inverse">
                      <div class="panel-heading">
                          <div class="panel-heading-btn">
                              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                          </div>
                          <h4 class="panel-title">Caja de contenidos</h4>
                      </div>
                      <div class="panel-body">
                      <div id="error_display"></div>
                      <div class="list-group" id="content_boxes">
                        @foreach($content_box as $boxes)
                        <div id="box_{{ $boxes->id }}" class="list-group-item">
                          <span class="pull-right">
                            <button class="show_contents btn-circle btn-icon btn-success" value="{{ $boxes->id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button class="up_box btn-info btn-circle btn-icon" value="{{ $boxes->id }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
                            <button class="down_box btn-info btn-circle btn-icon" value="{{ $boxes->id }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></button>
                            <button class="delete_content_box btn-danger btn-circle btn-icon" value="{{ $boxes->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        	</span>
                          <h4 class="list-group-item-heading">{{ $boxes->alias }}</h4>
                        </div>
                        @endforeach
                      </div>
                      </div>
                  </div>
            		</div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="newRegistry" class="modal fade" role="dialog">
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
                    <label class="col-md-3 control-label">Caja de Contenido</label>
                    <div class="col-md-9">
                        <select class="form-control" id="selectBox">
                          @foreach($content_box as $boxs)
                          <option value="{{ $boxs->id }}">{{ $boxs->alias }}</option>
                          @endforeach
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

      </div>
    </div>
    <!-- Modal -->
    <div id="newContentBox" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nueva Caja de Contenido</h4>
          </div>
          <div class="modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Alias</label>
                    <div class="col-md-9">
                        <input id="content_box_alias" type="text" class="form-control" placeholder="Alias" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Seleccione la pagina</label>
                    <div class="col-md-9">
                        <select class="form-control" id="select_page">
                          @foreach($all_pages as $page)
                            <option value="{{ $page->id }}" @if($page->id == $show_page->id) selected="selected" @endif >{{ $page->identifier }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button id="create_content_box" class="btn btn-sm btn-success" value="-1">Guardar Cambios</button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div id="errorDisplay"></div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div id="contentBoxContent" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div id="modal_error"></div>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Contenidos de la caja <div id="alias"></div></h4>
          </div>
          <div class="modal-body">
            <div id="loadContent"></div>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Generealidades</h4>
                </div>
                <div class="panel-body">
                <div class="form">
                    <div class="form-group">
                      <label class="control-label" for="alias">Alias</label>
                      <input class="form-control box_alias" id="box_alias" type="text" style="display:none">
                    </div>
                  </div>
                  <button id="save-changes-btn" class="btn btn-sm btn-success save_post" value="{{ (isset($post) ? $post->id : -1) }}">Guardar Cambios</button>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Contenido en Español</h4>
                    </div>
                    <div class="panel-body">
                      <div class="list-group" id="contentBoxEs">

                      </div>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                @if($show_page->bilingual == 1)
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Contenido en ingles</h4>
                    </div>
                    <div class="panel-body">
                      <div class="list-group" id="contentBoxEn">
                      </div>
                    </div>
                </div>
                @endif
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
                    <h4 class="panel-title">Contenido de imagenes</h4>
                </div>
                <div class="panel-body">
                  <div class="list-group" id="contentBoxImg">
                  </div>
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
                    <h4 class="panel-title">Contenido de widgets</h4>
                </div>
                <div class="panel-body">
                  <div class="list-group" id="contentBoxW">
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div id="errorDisplay"></div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div id="confirmdeleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Eliminar esta pagina</h4>
          </div>
            <div class="modal-body">
                <div id="deleteConfirmation" class="m-t-20 m-b-20"></div>
            </div>
          <div class="modal-footer">
            <div id="errorDisplay"></div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button href="{{ url('Mr_Administrator/sudo') }}" id="deleteAllPage" class="btn btn-sm btn-success" value="{{ $show_page->id }}">Confirmar</button>
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
        <h4 class="modal-title"></h4>
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
<div id="contentEditorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar variable</h4>
      </div>
      <div class="modal-body">
        <div id="error"></div>
          <div class="form-horizontal">
              <div class="form-group">
                  <label class="col-md-3 control-label">Identificador</label>
                  <div class="col-md-9">
                      <input id="edit_identificador" type="text" class="form-control" placeholder="Identificador" />
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-3 control-label">lang</label>
                  <div class="col-md-9">
                      <select class="form-control" id="edit_lang">
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
                      <input id="edit_descripcion" type="text" class="form-control" placeholder="Descripcion"/>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-3 control-label">Tipo de contenido</label>
                  <div class="col-md-9">
                      <select class="form-control" id="editType">
                        <option value="formatted_text">Texto formatted</option>
                        <option value="short_text">Texto corto</option>
                        <option value="long_text">Texto largo</option>
                        <option value="image">Imagen</option>
                      </select>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-3 control-label">Caja de Contenido</label>
                  <div class="col-md-9">
                      <select class="form-control" id="editBox">
                        @foreach($content_box as $boxs)
                        <option value="{{ $boxs->id }}">{{ $boxs->alias }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="form-group">
              <label class="col-md-3 control-label">Contenido</label>
                <div class="col-md-9">
                  <textarea class="textarea form-control" rows="3" id="edit_content" placeholder="Contenido" rows="12"></textarea>
                </div>
              </div>
              <div class="form-group text-center">
                  <button id="save-content_changes" class="btn btn-sm btn-success save_post" value="{{ (isset($post) ? $post->id : -1) }}">Guardar Cambios</button>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ asset('/js/admin_apps.min.js') }}"></script>
    <script src="{{ asset('/js/admin_sudo_page.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
@endsection
