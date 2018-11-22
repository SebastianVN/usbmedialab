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
Carbon::setLocale('es');
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
                @if(isset($in_cat))
                    <li><a href="{{ url('Mr_Administrator/BlogMan'.$in_cat->name_identifier)}}">{{ $in_cat->name }}</a></li>
                @else
                    <li><a href="{{ url('Mr_Administrator/BlogMan/loner_post')}}">Sin Categoría</a></li>
                @endif
                <li><a class="active"><span class="post_name">{{ $post->name }}</span></a></li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Blog | Post <span class="post_name">{{ $post->name }}</span> <small>42nd Studio</small></h1>
            <!-- end page-header -->
            
            <!-- begin row -->
            <div class="row">
                <!-- begin col-5 -->
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-sm-12"> 
                            <p style="word-break: break-all;">
                                <strong>Descripción: </strong><br>
                                <span class="post_description">{{ $post->description }}</span><br>
                                <strong>URL Pública: </strong><br>
                                <a href="{{ $post_link  }}" target="blank">{{ $post_link  }}</a><hr>
                                <strong>Posts: </strong>{{ $post->total_posts }}<br>
                                <strong>Comments: </strong>{{ $post->total_comments }}<br>
                                <strong>Ranking Categoría: </strong><br>
                                <strong>&nbsp;&nbsp;&nbsp; Total: </strong> 0 <br>
                                <strong>&nbsp;&nbsp;&nbsp; Mes: </strong> 0 <br>
                                <strong>&nbsp;&nbsp;&nbsp; Semana: </strong> 0 <br>
                            </p>
                            <br>
                            <button value="{{ $post->id }}" class="btn btn-block btn-default edit_post">Editor Rápido</button>
                            <a href="{{ url('Mr_Administrator/BlogMan/post_editor/'.$post->name_identifier) }}" class="btn btn-block btn-default edit_post">Editor Completo</a>
                            <button value="{{ $post->id }}" class="btn btn-block btn-danger delete_post">Eliminar Post</button>
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
                            <h4 class="panel-title">Otros Posts en Categoría</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="media-list media-list-with-divider">
                                @if(isset($other_posts))
                                @foreach($other_posts as $other)
                                <?php
                                $other_category = BlogCategory::find($other->category_id);
                                if(isset($other_category)){
                                    $other_link = url('Mr_Administrator/BlogMan/'.$other_category->name_identifier.'/'.$other->name_identifier);
                                }else{
                                    $other_link = url('Mr_Administrator/BlogMan/loner_post/'.$other->name_identifier);
                                }
                                ?>
                                <li class="media media-sm">
                                    <a class="media-left" href="javascript:;">
                                        <img src="assets/img/user-6.jpg" alt="" class="media-object rounded-corner" />
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="{{ $other_link }}">{{ $other->name }}</a></h4>
                                        <p>{{ $other->description }}<br>
                                        Posts: {{ $other->total_posts }}<br></p>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-5 -->
                <!-- begin col-7 -->
                <div class="col-md-7">
                    @if(isset($post->main_image))
                      <div class="text-center">
                        <img src="/blog42_content/uploads/{{ $post->main_image }}" class="img-responsive" style="max-height:240px; display:block; margin:auto;">
                      </div>
                    @endif
                      <h2 class="text-center"><span class="post_name">{{ $post->name }}</span></h2>
                      <div id="post_content">
                          {!! $post->content !!}
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
    <div id="postEditorModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Post Editor</h4>
          </div>
          <div class="modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Título</label>
                    <div class="col-md-9">
                        <input id="titulo" type="text" class="form-control" placeholder="Título" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Identificador Único</label>
                    <div class="col-md-9">
                        <input id="identificador" type="text" class="form-control" placeholder="Identificador Único" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Categoría</label>
                    <div class="col-md-9">
                        <select class="form-control" id="blog_cats">

                        </select>
                    </div>
                </div>
                <div class="form-group" id="other_cat_group" style="display: none;">
                    <label class="col-md-3 control-label">Nueva Categoría</label>
                    <div class="col-md-9">
                        <input id="other_category" type="text" class="form-control" placeholder="Nueva Categoría" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Descripción</label>
                    <div class="col-md-9">
                        <textarea id="descripcion" class="form-control" placeholder="Descripción del Post" rows="5"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Foto Principal</label>
                    <div class="col-md-9">
                        <input id="main_image" type="file" name="main_image" />
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="textarea form-control" id="wysihtml5" placeholder="Redactemos algo genial!" rows="12"></textarea>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success save_post" value="{{ $post->id }}">Guardar Cambios</button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div id="postErrorDisplay"></div>
          </div>
        </div>

      </div>
    </div>
@endsection
    

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ asset('/js/admin_blog_post.js') }}"></script>
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