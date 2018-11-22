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
        <li class="active">Generalidades</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Blog | Editar Generalidades <small>42nd Studio</small></h1>
    <!-- end page-header -->
    
    <!-- begin row -->
    <div class="row">
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="ui-media-object-4">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Barra Lateral</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                          <div class="form-horizontal">
                              <div class="form-group">
                                  <label class="col-md-3 control-label">Encabezado</label>
                                  <div class="col-md-9">
                                      <input id="titulo" type="text" class="form-control" placeholder="Título" value="{{ (isset($post) ? $post->name : "") }}" />
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-3 control-label">Cuerpo</label>
                                  <div class="col-md-9">
                                      <textarea id="descripcion" class="form-control" placeholder="Descripción del Post" rows="5">{{ (isset($post) ? $post->description : "") }}</textarea>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-3 control-label">Imágen</label>
                                  <div class="col-md-9">
                                      <input id="main_image" type="file" name="main_image" />
                                  </div>
                              </div>
                              <div class="text-center">
                                  <button class="btn btn-success">Guardar Cambios</button>
                              </div>
                          </div>  
                        </div>
                        <div class="col-md-4 text-center">
                          <div class="my-pic"><img src="{{ url('/blog42_content/blog_logo.png') }}" alt="" style="width: 70%; padding-top: 5px;"></div>
                          <div class="my-details">
                              <h5>{{ $sidebar_title }}</h5>
                              <p>{!! $sidebar_message !!}</p>
                              @include('site.social_media')
                          </div>
                          <br>
                          ...
                          <br>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->
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