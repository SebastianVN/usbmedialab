<?php
use App\User;
use App\StaticPage;
use App\StaticContent;
use App\SocialMedia;
use Carbon\Carbon;

Carbon::setLocale('es');
$pages = StaticPage::all();
$socials = SocialMedia::all();
$footers = array();
$pre_foot = StaticContent::where('lang', 'foot')->orderBy('box_order', 'asc')->get();
foreach ($pre_foot as $footie) {
    array_push($footers, $footie->content);
}
?>
@extends('layouts.admin.master')

@section('head')
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="http://localhost/usbmedialab/resources/assets/css/admin/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="http://localhost/usbmedialab/resources/assets/css/admin/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="http://localhost/usbmedialab/resources/assets/css/admin/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="http://localhost/usbmedialab/resources/assets/css/admin/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
<link href="http://localhost/usbmedialab/resources/assets/css/admin/morris.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection

@section('content')
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
        <li class="active">Administrator de sitios</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Panel Administrator de sitios <small>42nd Studio</small></h1>
    <!-- end page-header -->

    <div class="row">
        <!-- begin col-3 -->
        <div class="col-md-4">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Aspectos Generales</h4>
                </div>
                <div class="panel-body">
                    <button id="edit_social_media" class="btn btn-inverse"><i class="fa fa-share-square-o" aria-hidden="true"></i> Redes Sociales</button>
                </div>
            </div>
            <!-- end panel -->
            <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Resumen de Visitas</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                    </div>
                </div>
            </div>
            <!-- end panel -->

        </div>
        <div class="col-md-8">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr id="page_{{$page->id}}">
                          <td>
                            <a href="{{ url('Mr_Administrator/site/'.$page->identifier) }}">{{ $page->identifier }}</a>
                            @if($page->bilingual == 1)
                            <span class="label label-primary pull-right">Bilingue</span>
                            @endif
                          </td>
                            <td>
                                {{ $page->es_description }}
                            </td>
                            <td>
                                {{ url('') }}/{{ $page->url }}
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

<!-- Modal -->
<div id="social_media_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Redes Sociales</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-8">
              <ul id="social_group" class="list-group">
                @foreach($socials as $social)
                <li id="social_{{ $social->id }}" class="list-group-item">
                  <a href="{{ urldecode($social->url) }}"><i class="fa fa-{{ $social->icon }}" aria-hidden="true"></i>
                  {{ $social->name }}</a>
                  <button class="btn btn-xs btn-danger pull-right delete_social" value="{{ $social->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="col-sm-4">
                <button id="add_social" class="btn btn-success btn-block"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                <div id="symbol_pool" class="text-center" style="display: none">
                    <p>Selecciona un Ícono</p>
                    <button class="symbol_btn btn" value="facebook">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </button>
                    <button class="symbol_btn btn" value="facebook-square">
                        <i class="fa fa-facebook-square" aria-hidden="true"></i>
                    </button>
                    <button class="symbol_btn btn" value="instagram">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </button>
                    <button class="symbol_btn btn" value="twitter">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </button>
                    <button class="symbol_btn btn" value="twitter-square">
                        <i class="fa fa-twitter-square" aria-hidden="true"></i>
                    </button>
                    <button class="symbol_btn btn" value="youtube">
                        <i class="fa fa-youtube" aria-hidden="true"></i>
                    </button>
                    <button class="symbol_btn btn" value="youtube-play">
                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                    </button>
                    <button class="symbol_btn btn" value="youtube-square">
                        <i class="fa fa-youtube-square" aria-hidden="true"></i>
                    </button>
                </div>
                <div id="naming_box" class="text-center" style="display: none">
                    <div id="icon_preview" class="text-center" style="font-size: 42px"></div>
                    <input id="social_title" name="social_title" type="text" class="form-control" placeholder="Título" />
                    <div id="name_error" class="error_display"></div>
                    <input id="social_identifier" name="social_identifier" type="text" class="form-control" placeholder="Identificador Único" />
                    <div id="identifier_error" class="error_display"></div>
                    <input id="social_url" type="text" class="form-control" placeholder="URL" />
                    <div id="url_error" class="error_display"></div>
                    <br>
                    <button id="cancel_social" class="btn btn-sm btn-danger">Cancelar</button>
                    <button id="save_social" class="btn btn-sm btn-success">Guardar</button>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
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
@endsection

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="http://localhost/usbmedialab/resources/assets/js/admin/raphael.min.js"></script>
    <script src="http://localhost/usbmedialab/resources/assets/js/admin/morris.js"></script>
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
    <script src="http://localhost/usbmedialab/resources/assets/js/admin/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="http://localhost/usbmedialab/resources/assets/js/admin/admin_apps.min.js"></script>
    <script src="http://localhost/usbmedialab/resources/assets/js/admin/admin_site_dashboard.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
@endsection
