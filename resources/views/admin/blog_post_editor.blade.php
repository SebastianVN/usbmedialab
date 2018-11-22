@extends('layouts.admin.master')

@section('head')
    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="{{ asset('/css/isotope.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/lightbox.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/jquery.tagit.css')}}" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{ asset('/js/pace.min.js') }}"></script>
    <!-- ================== END BASE JS ================== -->
    <script src="//cdn.ckeditor.com/4.7.0/full/ckeditor.js"></script>
@endsection

@section('content')
<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
        <li><a href="{{ url('Mr_Administrator/BlogMan')}}">Blog</a></li>
        <li class="active">Nuevo Post</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Blog | Post Editor <small>42nd Studio</small></h1>
    <!-- end page-header -->
    <div class="panel-group" id="accordion">
        <div class="panel panel-inverse overflow-hidden">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i class="fa fa-plus-circle pull-right"></i> 
                        Generalidades
                    </a>
                </h3>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Título</label>
                            <div class="col-md-9">
                                <input id="titulo" type="text" class="form-control" placeholder="Título" value="{{ (isset($post) ? $post->name : "") }}" />
                                <div id="titulo_error" class="error_display"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Identificador Único</label>
                            <div class="col-md-9">
                                <input id="identificador" type="text" class="form-control" placeholder="Identificador Único" value="{{ (isset($post) ? $post->name_identifier : "") }}" />
                                <div id="identificador_error" class="error_display"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Categoría</label>
                            <input type="hidden" id="post_cat_id" value="{{ (isset($post) ? $post->category_id : -1) }}">
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
                                <textarea id="descripcion" class="form-control" placeholder="Descripción del Post" rows="5">{{ (isset($post) ? $post->description : "") }}</textarea>
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
                            <label class="col-md-3 control-label">Encabezado</label>
                            <div class="col-md-9">
                                <select class="form-control" id="header_type">
                                    <option @if(isset($post)) {{ ($post->header_type == "image") ? 'selected':''}} @endif value="image">Foto Principal</option>
                                    <option @if(isset($post)) {{ ($post->header_type == "widget") ? 'selected':''}} @endif value="widget">HTML Widget</option>
                                    <option @if(isset($post)) {{ ($post->header_type == "quote") ? 'selected':''}} @endif value="quote">Big Quote</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="header_data_group" @if(isset($post))  {!! ($post->header_type == "image" ? 'style="display: none"' : '') !!} @else style="display: none" @endif >
                            <label class="col-md-3 control-label" id="header_data_label">Header Data</label>
                            <div class="col-md-9">
                                <textarea id="header_data" class="form-control" rows="5">{{ (isset($post) ? $post->header_data : "") }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="control-label col-md-3">Etiquetas</label>
                        <div class="col-md-9">
                            <ul id="blog_tags" class="inverse">
                            @if(isset($tags))
                            @foreach($tags as $tag)
                                <li>{{ $tag }}</li>
                            @endforeach
                            @endif
                            </ul>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-inverse overflow-hidden" id="gallery-accordion">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" id="blog_gallery">
                        <i id="gallery-icon" class="fa fa-plus-circle pull-right"></i> 
                        Blog Gallery
                    </a>
                </h3>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div id="options" class="m-b-10">
                            <span class="gallery-option-set" id="filter" data-option-key="filter">
                                <button id="upload-image" class="btn btn-default btn-xs active">
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i> Subir Imagen
                                </button>
                                <a href="#show-all" class="btn btn-default btn-xs active" data-option-value="*">
                                    Show All
                                </a>
                            </span>
                        </div>
                        <div id="gallery" class="gallery">
                            @foreach($images as $image)
                            <div class="image">
                                <div class="image-inner">
                                    <a href="/blog42_content/uploads/{{ $image->file_name }}" data-lightbox="gallery-group-1">
                                        <img src="/blog42_content/uploads/{{ $image->file_name }}" alt="{{ $image->alt }}" class="gallery-img" />
                                    </a>
                                    <p class="image-caption">
                                        <button class="btn btn-xs btn-success insert-image" value="{{ $image->id }}"><span><i class="fa fa-plus-circle" aria-hidden="true"></i></span></button>
                                        <button class="btn btn-xs btn-danger delete-image" value="{{ $image->id }}"><span><i class="fa fa-minus-circle" aria-hidden="true"></i></span></button>
                                    </p>
                                </div>
                                <div class="image-info">
                                    <h5 class="title">{{ $image->alt }}</h5>
                                    <div class="pull-right">
                                        
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($images->count() == 8)
                            <input type="hidden" id="pepe" value="0">
                            <div id="btns_space" class="text-center">
                                <button id="btn_more" class="btn btn-info load-more" value="1"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div id="postErrorDisplay">
        <ul class="list-group">
          
        </ul>
    </div>
    <textarea id="post_content" name="editor1">{{ (isset($post) ? $post->content : "") }}</textarea>
    <div id="contenido_error" class="error_display"></div>
    <br>
    <div class="text-center"><button id="save-changes-btn" class="btn btn-sm btn-success save_post" value="{{ (isset($post) ? $post->id : -1) }}">Guardar Cambios</button>
    </div>

</div>
<!-- Modal -->
<div id="uploadImageModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Subir Imagen a Galeria</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-md-3 control-label">Foto Principal</label>
                <div class="col-md-9">
                    <input id="uploaded-image" type="file" name="main_image" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Alt Text</label>
                <div class="col-md-9">
                    <input id="alt" type="text" class="form-control" placeholder="Alt Text" />
                </div>
            </div>
            <div class="form-group text-center">
                <button id="submit-image" class="btn btn-sm btn-success" value="-1">Subir Imagen</button>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div id="imageErrorDisplay"></div>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->
<div id="success_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Post Guardado</h4>
      </div>
      <div class="modal-body">
        <i class="fa fa-check fa-5x"></i>
      </div>
    </div>

  </div>
</div>
@endsection
    

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="{{ asset('/js/jquery.isotope.min.js') }}"></script>
    <script src="{{ asset('/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('/js/tag-it.min.js') }}"></script>
    <script src="{{ asset('/js/admin_apps.min.js') }}"></script>
    <script src="{{ asset('/js/admin_blog_post_editor.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
@endsection