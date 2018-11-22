<?php
use App\User;
use Carbon\Carbon;
use App\Blogger;
use App\BlogPost;
use App\BlogStatus;
use App\BlogCategory;
use App\BlogDestacado;
$destacados = BlogDestacado::all();
$bloggers = Blogger::all();
$posts = BlogPost::all();
$categories = BlogCategory::all();
$total_posts = BlogStatus::where('name_identifier', 'total_posts')->first()->int_content;
$array_destacados = array();
foreach ($destacados as $destacado)
{
    $array_destacados[] = $destacado->post_id;
}
Carbon::setLocale('es');

function post_status_class($status){
    switch ($status) {
        case 'waiting_approval':
            return("warning");

        case 'approved_unavailable':
            return("danger");

        case 'approved_available':
            return("");

        case 'not_approved':
            return("danger");

        case 'needs_revision':
            return("info");

        default:
            # code...
            break;
    }
}

?>
@extends('layouts.admin.master')

@section('head')
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/buttons.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/morris.css') }}" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection

@section('content')
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
                <li class="active">Blog</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Blog Administrator Panel <small>42nd Studio</small></h1>
            <!-- end page-header -->
            
            <!-- begin row -->
            <div class="row">
                <!-- begin col-4 -->
                <div class="col-md-4">
                    <h5>
                        Opciones:
                    </h5>
                    <div class="text-center">
                        <button id="newPost" class="btn btn-block btn-default">Post Rápido</button>
                        <a href="{{ url('Mr_Administrator/BlogMan/post_editor') }}" class="btn btn-block btn-default">Nuevo Post</a>
                        <button id="newCat" class="btn btn-block btn-default">Nueva Categoría</button>
                        <button id="enableUser" class="btn btn-block btn-default">Habilitar Blogger</button>
                    </div>
                    <br>
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="ui-media-object-4">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Bloggers</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="media-list media-list-with-divider">
                                @foreach($bloggers as $blogger)
                                <li class="media media-sm">
                                    <a class="media-left" href="javascript:;">
                                        @if(isset($blogger->main_image))
                                        <img src="/blog_content/{{ $blogger->main_image }}" alt="" class="media-object rounded-corner" />
                                        @else
                                        <i class="fa fa-pencil big-icon" aria-hidden="true"></i>
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ $blogger->name }}</h4>
                                        <p>
                                        Posts: {{ $blogger->total_posts }}<br>
                                        Blogger {{ $blogger->created_at->diffForHumans() }}<br>
                                        </p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- end panel -->
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="ui-media-object-4">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Categorías</h4>
                        </div>
                        <div class="panel-body">
                            <ul id="category_list" class="media-list media-list-with-divider">
                                @foreach($categories as $category)
                                <li class="media media-sm">
                                    <a class="media-left" href="javascript:;">
                                        @if(isset($category->main_image))
                                            <img src="/blog42_content/uploads/{{ $category->main_image }}" class="media-object rounded-corner">
                                        @else
                                            <i class="fa fa-th-list big-icon" aria-hidden="true"></i>
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="{{ url('Mr_Administrator/BlogMan/'.$category->name_identifier) }}">{{ $category->name }}</a></h4>
                                        <p>{{ $category->description }}<br>
                                        Posts: {{ $category->total_posts }}<br></p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-4 -->
                <!-- begin col-8 -->
                <div class="col-md-8">
                    <div class="widget-chart-content">
                        <h4 class="chart-title">
                            Blog Views
                            <small>Visitas a posts en el mes actual</small>
                        </h4>
                        <div class="widget-chart bg-black">
                            <div id="visitors-line-chart" class="morris-inverse" style="height: 260px;"></div>
                        </div>
                    </div>
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Entradas | Posts</h4>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group btn-group-justified" id="destacados_group">
                            @foreach($destacados as $destacado)
                            <?php
                            $post_destacado = BlogPost::find($destacado->post_id);
                            ?>
                                <a href="/Mr_Administrator/BlogMan/post_editor/{{ $post_destacado->name_identifier }}" class="btn btn-default">
                                <i class="fa fa-star" aria-hidden="true"></i><br>{{ $post_destacado->name }}</a>
                            @endforeach
                            </div>
                            <hr>
                            <table id="posts_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Autor</th>
                                        <th>Descripción</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                    <?php 
                                    $blogger = Blogger::find($post->blogger_id);
                                    $post_link = url('Mr_Administrator/BlogMan/loner_post/'.$post->name_identifier);
                                    if(isset($post->category_id)){
                                        $category = BlogCategory::find($post->category_id);
                                        if(isset($category)){
                                            $post_link = url('blog/'.$category->name_identifier.'/'.$post->name_identifier);
                                        }
                                    }?>
                                    <tr class="{{ post_status_class($post->status) }}" id="post_{{ $post->id }}">
                                        <td><a href="{{ $post_link }}">{{ $post->name }}</a></td>
                                        <td>{{ $blogger->name }}</td>
                                        <td>{{ $post->description }}</td>
                                        <td>
                                            @if($post->status == 'waiting_approval' || $post->status == 'not_approved')
                                            <button class="btn btn-warning btn-xs approve_post" value="{{ $post->id }}">Aprobar</button>
                                            @elseif($post->status == 'approved_unavailable')
                                            <button class="btn btn-warning btn-xs enable_post" value="{{ $post->id }}">Habilitar</button>
                                            @else
                                            <button class="btn btn-warning btn-xs disable_post" value="{{ $post->id }}">Deshabilitar</button>
                                            @endif
                                            @if(in_array($post->id, $array_destacados))
                                            <button class="btn btn-warning btn-xs desdestacar_post" value="{{ $post->id }}">Remover Destacado</button>
                                            @else
                                            <button class="btn btn-info btn-xs destacar_post" value="{{ $post->id }}">Agregar a Destacados</button>
                                            @endif
                                            <a class="btn btn-success btn-xs edit_post" href="/Mr_Administrator/BlogMan/post_editor/{{ $post->name_identifier }}">Editar</a>
                                            <button class="btn btn-danger btn-xs delete_post" value="{{ $post->id }}">Eliminar</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-8 -->
            </div>
            <!-- end row -->
            <div class="row">
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
                <h4 class="modal-title">(Des)Habilitar Blogger</h4>
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
                <h4 class="modal-title">Habilitar Blogger</h4>
              </div>
              <div class="modal-body">
                <div id="enablingConfirmation" class="m-t-20 m-b-20"></div>
              </div>
              <div class="modal-footer">
              </div>
            </div>

          </div>
        </div>

    <!-- Modal -->
    <div id="postEditorModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editor Post</h4>
          </div>
          <div class="modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Título</label>
                    <div class="col-md-9">
                        <input id="titulo" type="text" class="form-control" placeholder="Título" />
                        <div id="titulo_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Identificador Único</label>
                    <div class="col-md-9">
                        <input id="identificador" type="text" class="form-control" placeholder="Identificador Único" />
                        <div id="identificador_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Categoría</label>
                    <div class="col-md-9">
                        <select class="form-control" id="blog_cats">

                        </select>
                        <div id="category_id_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group" id="other_cat_group" style="display: none;">
                    <label class="col-md-3 control-label">Nueva Categoría</label>
                    <div class="col-md-9">
                        <input id="other_category" type="text" class="form-control" placeholder="Nueva Categoría" />
                        <div id="other_category_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Descripción</label>
                    <div class="col-md-9">
                        <textarea id="descripcion" class="form-control" placeholder="Descripción del Post" rows="5"></textarea>
                        <div id="descripcion_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Foto Principal</label>
                    <div class="col-md-9">
                        <input id="main_image" type="file" name="main_image" />
                        <div id="main_image_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="textarea form-control" id="wysihtml5" placeholder="Redactemos algo genial!" rows="12"></textarea>
                    <div id="contenido_error" class="error_display"></div>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success save_post" value="-1">Guardar Cambios</button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div id="postErrorDisplay"></div>
          </div>
        </div>

      </div>
    </div>
    <!-- Modal -->
    <div id="newCatModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nueva Categoría</h4>
          </div>
          <div class="modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Nombre</label>
                    <div class="col-md-9">
                        <input id="cat_titulo" type="text" class="form-control" placeholder="Nombre" />
                        <div id="cat_titulo_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Identificador Único</label>
                    <div class="col-md-9">
                        <input id="cat_identificador" type="text" class="form-control" placeholder="Identificador Único" />
                        <div id="cat_identificador_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Descripción</label>
                    <div class="col-md-9">
                        <textarea id="cat_descripcion" class="form-control" placeholder="Descripción del Post" rows="5"></textarea>
                        <div id="cat_descripcion_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Foto Principal</label>
                    <div class="col-md-9">
                        <input id="cat_main_image" type="file" name="main_image" />
                        <div id="cat_main_image_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="textarea form-control" id="cat_content" placeholder="Redactemos algo genial!" rows="12"></textarea>
                    <div id="cat_content_error" class="error_display"></div>
                </div>
                <div class="form-group text-center">
                    <button id="create_cat" class="btn btn-sm btn-success" value="-1">Guardar Cambios</button>
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
    <!--Modal-->
    <div id="Modal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Advertencia</h4>
              </div>
              <div class="modal-body">
                <div id="errorDisplay"></div>
                <p></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="unreadMessage" type="button" class="unread_message btn btn-warning" data-dismiss="modal" value="-1">Marcar como no leído</button>
                <button id="delete_msg" class="delete_message btn btn-danger" value="-1">Eliminar</button>
              </div>
            </div>

          </div>
        </div>
@endsection
    

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ asset('js/raphael.min.js') }}"></script>
    <script src="{{ asset('js/morris.js') }}"></script>
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
    <script src="{{ asset('/js/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('/js/admin_apps.min.js') }}"></script>
    <script src="{{ asset('/js/admin_blogger.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    
    <script>
        $(document).ready(function() {
            App.init();
            FormWysihtml5.init();
        });
    </script>
@endsection