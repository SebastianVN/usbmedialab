<?php
use App\User;
use App\ContentBox;
use App\StaticPage;
use App\StaticContent;
use Carbon\Carbon;

Carbon::setLocale('es');
$show_page = StaticPage::where('identifier', $identifier)->first();
Log::debug($show_page);
$pages = StaticPage::where('id', '!=', $show_page->id)->get();
$all_pages = StaticPage::all();
$content_boxes = ContentBox::where('page_id', $show_page->id)->orderBy('page_order')->get();
?>
@extends('layouts.admin.master')

@section('head')
<script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
@endsection

@section('content')
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
                <li><a href="{{ url('Mr_Administrator/site')}}">Páginas</a></li>
                <li class="active">{{ $show_page->identifier }}</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Site Administrator Panel <small>42nd Studio</small></h1>
            <!-- end page-header -->

            <div class="row">
            <!-- begin col-3 -->
            <div class="col-md-3">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Páginas</h4>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                          @foreach($pages as $page)
                          <a href="{{ url('Mr_Administrator/site/'.$page->identifier) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $page->identifier }}</h4>
                            <p class="list-group-item-text">{{ $page->descripcion }}</p>
                          </a>
                          @endforeach
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <div class="col-md-9">
                <h1>Página {{ $show_page->identifier }} <a href="{{ url($show_page->url) }}" class="btn btn-inverse pull-right" target="blank"><i class="fa fa-external-link-square" aria-hidden="true"></i> Ver Página</a></h1>
                <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Generalidades</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form">
                            <div class="form-group">
                              <label class="control-label" for="es_title">Titulo</label>
                              <input class="form-control" id="es_title" type="text" value="{{ $show_page->es_title }}">
                            </div>
                            @if($show_page->bilingual == 1)
                            <div class="form-group">
                              <label class="control-label" for="en_title">Titulo Inglés</label>
                              <input class="form-control" id="en_title" type="text" value="{{ $show_page->en_title }}">
                            </div>
                            @endif
                            <div class="form-group">
                              <label class="control-label" for="es_description">Descripción</label>
                              <textarea class="form-control" rows="3" id="es_description">{{ $show_page->es_description }}</textarea>
                            </div>
                            @if($show_page->bilingual == 1)
                            <div class="form-group">
                              <label class="control-label" for="en_description">Descripción Inglés</label>
                              <textarea class="form-control" rows="3" id="es_description">{{ $show_page->en_description }}</textarea>
                            </div>
                            @endif
                            <div class="form-group">
                              <label class="control-label" for="es_keywords">Palabras Clave</label>
                              <textarea class="form-control" rows="3" id="es_keywords">{{ $show_page->es_keywords }}</textarea>
                            </div>
                            @if($show_page->bilingual == 1)
                            <div class="form-group">
                              <label class="control-label" for="en_keywords">Palabras Clave Inglés</label>
                              <textarea class="form-control" rows="3" id="en_keywords">{{ $show_page->en_keywords }}</textarea>
                            </div>
                            @endif
                            <div id="pageErrorDisplay"></div>
                            <div class="form-group">
                                <button id="save_page" class="btn btn-inverse pull-right" value="{{ $show_page->id }}">Guardar Cambios</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                        <h4 class="panel-title">Cajas de Contenidos</h4>
                    </div>
                    <div class="panel-body">
                    <div id="error_display"></div>
                    <div class="list-group" id="content_boxes">
                      @foreach($content_boxes as $boxes)
                      <div id="box_{{ $boxes->id }}" class="list-group-item">
                        <span class="pull-right">
                          <button class="show_contents btn-circle btn-icon btn-success" value="{{ $boxes->id }}"><i class="fa fa-search-plus fa-fw fa-lg" aria-hidden="true"></i></button>
                        </span>
                        <h3 class="list-group-item-heading">{{ $boxes->alias }}</h3>
                      </div>
                      @endforeach
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
                          <option value="link">link</option>
                          <option value="img">Imagen ( img )</option>
                          <option value="widget">widget</option>
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
                          <option value="formatted_text">Texto formatiado</option>
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
                          @foreach($content_boxes as $boxs)
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
                            <option value="{{ $page->id }}" @if($page->id == $show_page->id) selected="selected" @endif >{{ $page->es_title }}</option>
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
          <div class="modal-body" id="contenidos">
            <div id="loadContent"></div>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Generalidades</h4>
                </div>
                <div class="panel-body">
                  <div class="form">
                    <div class="form-group">
                      <label class="control-label" for="alias">Alias</label>
                      <input class="form-control box_alias" id="box_alias" type="text" style="display:none">
                    </div>
                  </div>
                  <button id="save-box" class="btn btn-sm btn-success" value="{{ (isset($post) ? $post->id : -1) }}">Guardar Cambios</button>
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
<div id="contentEditorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar contenido</h4>
      </div>
      <div class="modal-body">
        <div id="editor_holder" style="display: none;">
            <textarea id="editor_content"></textarea>
        </div>
        <input type="text" class="form-control" id="short_content" style="display: none;">
        <textarea class="form-control" rows="3" id="large_content" style="display: none;"></textarea>
        <div id="image_content" style="display: none">
            <div id="image_holder"></div>
          <input id="content_file" type="file" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="save-changes-btn" class="btn btn-sm btn-success save_post" value="{{ (isset($post) ? $post->id : -1) }}">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />W
    <script src="{{ asset('/js/admin_apps.min.js') }}"></script>
    <script src="{{ asset('/js/admin_site_page.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
@endsection
