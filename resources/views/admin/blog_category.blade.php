<?php
use App\User;
use Carbon\Carbon;
use App\Blogger;
use App\BlogPost;
use App\BlogStatus;
use App\BlogCategory;
use App\BlogDestacado;
$destacados = BlogDestacado::all();
$array_destacados = array();
foreach ($destacados as $destacado)
{
    $array_destacados[] = $destacado->post_id;
}
$posts = BlogPost::where('category_id', $show_category->id)->get();
$categories = BlogCategory::where('id', '!=', $show_category->id)->get();
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
<link href="{{ asset('css/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection

@section('content')
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
                <li><a href="{{ url('Mr_Administrator/BlogMan')}}">Blog</a></li>
                <li class="active"><span class="category_name">{{ $show_category->name }}</span></li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Blog | Categoría <span class="category_name">{{ $show_category->name }}</span> <small>42nd Studio</small></h1>
            <!-- end page-header -->
            
            <!-- begin row -->
            <div class="row">
                <!-- begin col-5 -->
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-sm-12"> 
                            <p style="word-break: break-all;">
                                <strong>Descripción: </strong><br>
                                <span class="category_description">{{ $show_category->description }}</span><br>
                                <strong>URL Pública: </strong><br>
                                <a href="{{ url('blog/'.$show_category->name_identifier) }}">{{ url('blog/'.$show_category->name_identifier) }}</a><hr>
                                <strong>Posts: </strong>{{ $show_category->total_posts }}<br>
                                <strong>Comments: </strong>{{ $show_category->total_comments }}<br>
                                <strong>Ranking Categoría: </strong><br>
                                <strong>&nbsp;&nbsp;&nbsp; Total: </strong> 0 <br>
                                <strong>&nbsp;&nbsp;&nbsp; Mes: </strong> 0 <br>
                                <strong>&nbsp;&nbsp;&nbsp; Semana: </strong> 0 <br>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <button value="{{ $show_category->id }}" class="btn btn-block btn-default edit_cat">Editar Categoría</button>
                        </div>
                        <div class="col-sm-6">
                            <button value="{{ $show_category->id }}" class="btn btn-block btn-danger delete_cat">Eliminar Categoría</button>
                        </div>
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
                            <h4 class="panel-title">Posts en Categoría</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="media-list media-list-with-divider">
                                @if(isset($posts))
                                @foreach($posts as $post)
                                <?php
                                $category = BlogCategory::find($post->category_id);
                                $post_link =  url('Mr_Administrator/BlogMan/loner_post/'.$post->name_identifier);
                                if(isset($category)){
                                    $post_link =  url('Mr_Administrator/BlogMan/'.$category->name_identifier.'/'.$post->name_identifier);
                                }
                                ?>
                                <li class="media media-sm">
                                    <a class="media-left" href="javascript:;">
                                        @if(isset($post->main_image))
                                            <img src="/blog42_content/uploads/{{ $post->main_image }}" class="media-object rounded-corner">
                                        @else
                                            <i class="fa fa-file-text big-icon" aria-hidden="true"></i>
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="{{ $post_link }}" target="blank">{{ $post->name }}</a></h4>
                                        <p>{{ $post->description }}<br>
                                        Posts: {{ $post->total_posts }}<br></p>
                                    </div>
                                </li>
                                @endforeach
                                @endif
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
                            <h4 class="panel-title">Otras Categorías</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="media-list media-list-with-divider">
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
                <!-- end col-5 -->
                <!-- begin col-7 -->
                <div class="col-md-7">
                    @if(isset($show_category->main_image))
                      <div class="text-center">
                        <img src="/blog42_content/uploads/{{ $show_category->main_image }}" class="img-responsive" style="max-height:240px; display:block; margin:auto;">
                      </div>
                    @endif
                      <h2 class="text-center"><span class="category_name">{{ $show_category->name }}</span></h2>
                      <div>
                          <span class="category_content">{!! $show_category->content !!}</span>
                      </div>
                </div>
                <!-- end col-7 -->
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
                <h4 class="modal-title">Habilitar Blogger</h4>
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
    <div id="catEditorModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editor Categoría</h4>
          </div>
          <div class="modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Título</label>
                    <div class="col-md-9">
                        <input id="titulo" type="text" class="form-control" placeholder="Título" />
                        <div id="cat_titulo_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Identificador Único</label>
                    <div class="col-md-9">
                        <input id="identificador" type="text" class="form-control" placeholder="Identificador Único" />
                        <div id="cat_identificador_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Descripción</label>
                    <div class="col-md-9">
                        <textarea id="descripcion" class="form-control" placeholder="Descripción del Post" rows="5"></textarea>
                        <div id="cat_descripcion_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Foto Principal</label>
                    <div class="col-md-9">
                        <input id="main_image" type="file" name="main_image" />
                        <div id="cat_main_image_error" class="error_display"></div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="textarea form-control" id="wysihtml5" placeholder="Redactemos algo genial!" rows="12"></textarea>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success save_cat" value="{{ $show_category->id }}">Guardar Cambios</button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div id="catErrorDisplay"></div>
          </div>
        </div>

      </div>
    </div>
@endsection
    

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ asset('/js/admin_blog_cat.js') }}"></script>
    <script src="{{ asset('/js/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('/js/admin_apps.min.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    
    <script>
        $(document).ready(function() {
            App.init();
            FormWysihtml5.init();
        });
    </script>
@endsection