<?php
use App\User;
use App\GalleryContent;
use App\GalleryCategory;
use Carbon\Carbon;

Carbon::setLocale('es');
$categories = GalleryCategory::all();
?>
@extends('layouts.admin.master')

@section('head')

@endsection

@section('content')
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="{{ url('Mr_Administrator')}}">Principal</a></li>
                <li class="active">Galería</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Gallery Administrator Panel <small>42nd Studio</small></h1>
            <!-- end page-header -->
            <div class="alert alert-dismissible alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Para disminuir los tiempos de carga recomendamos comprimir las imágenes utilizando herramientas como</strong> <a href="http://compressjpeg.com/" target="none" class="alert-link">CompressJPEG</a> o <a href="https://tinyjpg.com/" target="none" class="alert-link">TinyJPG</a>
            </div>
            <h3>Fotos por Categoría <button id="add_widget" class="btn btn-inverse pull-right"><i class="fa fa-youtube" aria-hidden="true" style="margin-left: 10px;"></i> Agregar Video Widget</button><button id="new_img" class="btn btn-inverse pull-right"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Subir Imágen/Video</button></h3>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
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
                            <div class="list-group">
                              <a href="{{ url('Mr_Administrator/gallery') }}" class="list-group-item {{ (isset($selected_cat))?'':'active' }}">
                                <h4 class="list-group-item-heading"><i class="fa fa-star" aria-hidden="true"></i> Destacados</h4>
                              </a>
                              @foreach($categories as $category)
                              <a href="{{ url('Mr_Administrator/gallery/'.$category->identifier) }}" class="list-group-item {{ (isset($selected_cat) && $selected_cat->id == $category->id)?'active':'' }}">
                                <h4 class="list-group-item-heading">{{ $category->name }}</h4>
                                <p class="list-group-item-text"  style="width: 100%!important; word-wrap: break-word!important;">{{ url('gallery/'.$category->identifier) }}</p>
                              </a>
                              @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Fotos en {{ (isset($selected_cat))?$selected_cat->name:'Destacados' }}</h4>
                        </div>
                        <div class="panel-body" id="image_group">
                            @if(isset($selected_cat))
                            <div class="pull-right">
                                <button id="edit_category" value="{{ $selected_cat->id }}" class="btn btn-sm btn-inverse"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Categoría</button>
                                <button id="pre_delete_cat" value="{{ $selected_cat->id }}" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar Categoría</button>
                            </div>
                            <br><br>
                            @endif
                            <?php 
                            if(isset($selected_cat)){
                                $pictures = GalleryContent::where('category_id', $selected_cat->id)->get();
                            }else{
                                $pictures = GalleryContent::where('featured', 1)->get();
                            }
                            ?>
                            @foreach($pictures as $picture)
                            @if($picture->type == "photo")
                            <div id="container_{{ $picture->id }}" class="gallery_product_cont">
                                <p class="pic_title lead">{{ $picture->title }}</p>
                                <img src="/gallery_contents/{{ $picture->file_name }}" class="center-block gallery_product">
                                <p class="pic_caption">{{ $picture->caption }}</p>
                                <button class="btn btn-inverse edit_img" value="{{ $picture->id }}">Editar</button>
                                <button class="btn btn-danger delete_img" value="{{ $picture->id }}">Eliminar</button>
                                <button class="btn btn-info feature_img" id="feature_{{ $picture->id }}" value="{{ $picture->id }}">{!! ($picture->featured == 1)?'<i class="fa fa-star" aria-hidden="true"></i>':'<i class="fa fa-star-o" aria-hidden="true"></i>' !!}</button>
                                <span class="cat_id" style="display: none">{{ $picture->category_id }}</span>
                            </div>
                            @elseif($picture->type == "video")
                            <div id="container_{{ $picture->id }}" class="gallery_product_cont">
                                <p class="pic_title lead">{{ $picture->title }}</p>
                                <a href="/gallery/video/{{$picture->file_name}}" target="blank"><img src="/images/play.png" class="center-block gallery_product"></a>
                                <p class="pic_caption">{{ $picture->caption }}</p>
                                <button class="btn btn-inverse edit_img" value="{{ $picture->id }}">Editar</button>
                                <button class="btn btn-danger delete_img" value="{{ $picture->id }}">Eliminar</button>
                                <button class="btn btn-info feature_img" id="feature_{{ $picture->id }}" value="{{ $picture->id }}">{!! ($picture->featured == 1)?'<i class="fa fa-star" aria-hidden="true"></i>':'<i class="fa fa-star-o" aria-hidden="true"></i>' !!}</button>
                                <span class="cat_id" style="display: none">{{ $picture->category_id }}</span>
                            </div>
                            @else
                            <div id="container_{{ $picture->id }}" class="gallery_product_cont">
                                <input type="hidden" id="widget_{{ $picture->id }}" value="{{ $picture->file_name }}">
                                <p class="pic_title lead">{{ $picture->title }}</p>
                                <a href="/gallery/widget/{{$picture->id}}" target="blank"><img src="/images/play.png" class="center-block gallery_product"></a>
                                <p class="pic_caption">{{ $picture->caption }}</p>
                                <button class="btn btn-inverse edit_widget" value="{{ $picture->id }}">Editar</button>
                                <button class="btn btn-danger delete_img" value="{{ $picture->id }}">Eliminar</button>
                                <button class="btn btn-info feature_img" id="feature_{{ $picture->id }}" value="{{ $picture->id }}">{!! ($picture->featured == 1)?'<i class="fa fa-star" aria-hidden="true"></i>':'<i class="fa fa-star-o" aria-hidden="true"></i>' !!}</button>
                                <span class="cat_id" style="display: none">{{ $picture->category_id }}</span>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end #content -->

        <!-- Modal -->
        <div id="editImageModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Gallery Editor</h4>
              </div>
              <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Título</label>
                        <div>
                            <input id="img_title" type="text" class="form-control" placeholder="Título" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Categoría</label>
                        <select class="form-control" id="img_cat">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            <option value="-1">Otra</option>
                        </select>
                    </div>
                    <div class="form-group" id="other_cat_group" style="display: none;">
                        <label class="control-label">Nueva Categoría</label>
                        <input id="other_category" type="text" class="form-control" placeholder="Nueva Categoría" />
                    </div>
                    <div class="form-group" id="image_content">
                        <div id="image_holder"></div>
                        <label class="control-label">Archivo</label>
                        <input id="content_file" type="file" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Leyenda</label>
                        <textarea class="form-control" rows="3" id="img_caption"></textarea>
                    </div>
              </div>
              <div class="modal-footer">
                <legend>Extensiones Validas: JPEG, JPG, PNG, GIF, MP4, OGG</legend>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                <button id="save_image" class="btn btn-sm btn-success save_post" value="-1">Guardar Cambios</button>
              </div>
            </div>

          </div>
        </div>
        <div id="add_widget_modal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Gallery Widget</h4>
              </div>
              <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Título</label>
                        <div>
                            <input id="widget_title" type="text" class="form-control" placeholder="Título" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Categoría</label>
                        <select class="form-control" id="widget_cat">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            <option value="-1">Otra</option>
                        </select>
                    </div>
                    <div class="form-group" id="widget_cat_group" style="display: none;">
                        <label class="control-label">Nueva Categoría</label>
                        <input id="widget_category" type="text" class="form-control" placeholder="Nueva Categoría" />
                    </div>
                    <div class="form-group" id="widget_content">
                        <div id="widget_holder"></div>
                        <label class="control-label">Código de Inserción</label>
                        <textarea class="form-control" rows="3" id="widget_code"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Leyenda</label>
                        <textarea class="form-control" rows="3" id="widget_caption"></textarea>
                    </div>
              </div>
              <div class="modal-footer">
                <legend>Inserta Widgets como <a href="http://es.wikihow.com/insertar-un-video-de-YouTube" target="blank"> videos de Youtube</a></legend>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                <button id="save_widget" class="btn btn-sm btn-success save_post" value="-1">Guardar Cambios</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Modal -->
        <div id="kill_cat_modal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmar Acción</h4>
              </div>
              <div class="modal-body">
                    <div class="alert alert-danger" id="warning_alert">
                      <strong>Atención!</strong> Estás a punto de eliminar una categoría de la galería, incluyendo a todas las imágenes que esten asociada a esta. 
                    </div>
                    <div class="alert alert-info" id="success_alert" style="display: none">
                      <strong>Categoría e Imagenes asociadas eliminadas!</strong>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal">Cancelar</button>
                <button id="kill_cat" class="btn btn-sm btn-danger" value="-1">Eliminar Categoría e Imágenes Asociadas</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Modal -->
        <div id="edit_cat_modal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Category Editor</h4>
              </div>
              <div class="modal-body">
                <div id="cat_errorDisplay"></div>
                    <div class="form-group">
                        <label class="control-label">Título</label>
                        <div>
                            <input id="cat_title" type="text" class="form-control" value="{{ (isset($selected_cat)) ? $selected_cat->name : '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Identificador</label>
                        <div>
                            <input id="cat_identifier" type="text" class="form-control" value="{{ (isset($selected_cat)) ? $selected_cat->identifier : '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Descripción</label>
                        <textarea class="form-control" rows="3" id="cat_description">{{ (isset($selected_cat)) ? $selected_cat->description : '' }}</textarea>
                    </div>
              </div>
              <div class="modal-footer">
                <p><small>La descripción (opcional) se muestra al público en la página de Galería</small></p>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                <button id="save_cat" class="btn btn-sm btn-success" value="-1">Guardar Cambios</button>
              </div>
            </div>

          </div>
        </div>
@endsection
    

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <meta name="_token" content="{!! csrf_token() !!}" />W
    <script src="{{ asset('/js/admin_apps.min.js') }}"></script>
    <script src="{{ asset('/js/admin_gallery.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
@endsection