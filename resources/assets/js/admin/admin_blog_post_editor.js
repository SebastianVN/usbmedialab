function calculateDivider() {
    var e = 4;
    if ($(this).width() <= 480) {
        e = 1
    } else if ($(this).width() <= 767) {
        e = 2
    } else if ($(this).width() <= 980) {
        e = 3
    }
    return e
}
var handleIsotopesGallery = function() {
    "use strict";
    $(window).load(function() {
        var e = $("#gallery");
        var t = calculateDivider();
        var n = $(e).width() - 20;
        var r = n / t;
        $(e).isotope({
            resizable: false,
            masonry: {
                columnWidth: r
            }
        });
        $(window).smartresize(function() {
            var t = calculateDivider();
            var n = $(e).width() - 20;
            var r = n / t;
            $(e).isotope({
                masonry: {
                    columnWidth: r
                }
            })
        });
        var i = $("#options .gallery-option-set"),
            s = i.find("a");
        s.click(function() {
            var t = $(this);
            if (t.hasClass("active")) {
                return false
            }
            var n = t.parents(".gallery-option-set");
            n.find(".active").removeClass("active");
            t.addClass("active");
            var r = {};
            var i = n.attr("data-option-key");
            var s = t.attr("data-option-value");
            s = s === "false" ? false : s;
            r[i] = s;
            $(e).isotope(r);
            return false
        })
    })
};
var Gallery = function() {
    "use strict";
    return {
        init: function() {
            handleIsotopesGallery()
        }
    }
}()

    var editor = CKEDITOR.replace( 'editor1',
        {
            height : '500',
        });    
    App.init();
    Gallery.init();


$('#upload-image').click(function(){
	$('#uploadImageModal').modal('show');
});

$('#blog_gallery').click(function(){
	$(window).trigger('resize');
});

$('#submit-image').click(function(){
    var original_text = $('#submit-image').text();
    console.log(original_text);
    $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
	var file_data = $("#uploaded-image").prop("files")[0];   // Getting the properties of file from file field
	  $.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	      }
	  });
	  var formData = new FormData();
	  formData.append("file", file_data);
      var altText = $('#alt').val();
      if(altText.length > 0){
	   formData.append("alt", altText);
      }
	  var type = "POST";
	  var my_url = '/Mr_Administrator/BlogMan/UploadImage';


	  $.ajax({

	      type: type,
	      url: my_url,
	      cache: false,
	      contentType: false,
	      processData: false,
	      data: formData,                         // Setting the data attribute of ajax with file_data
	      type: 'post',
	      beforeSend: function() {
	        $('#imageErrorDisplay').html('');
	      },
	      success: function (data) {
              $('#uploaded-image').text(original_text);
	      	  content = '<img src="'+data.img_link+'" style="height:330px;" />';
              final_html = 'mediaembedInsertData|---' + escape(content) + '---|mediaembedInsertData';
              editor.insertHtml(final_html);
              updated_editor_data = editor.getData();
              clean_editor_data = updated_editor_data.replace(final_html,content);
              editor.setData(clean_editor_data);
	          $('#uploadImageModal').modal('hide');
              if(data.num_images > 8){
                $('#gallery div.image').last().remove();
              }
	          var $newItems = $('<div class="image">\
                                <div class="image-inner">\
                                    <a href="'+data.img_link+'" data-lightbox="gallery-group-1">\
                                        <img src="'+data.img_link+'" alt="" class="gallery-img" />\
                                    </a>\
                                    <p class="image-caption">\
                                        <button class="btn btn-xs btn-success insert-image" value="'+data.img_id+'"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>\
                                        <button class="btn btn-xs btn-danger delete-image" value="'+data.img_id+'"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>\
                                    </p>\
                                </div>\
                                <div class="image-info">\
                                    <h5 class="title">'+data.img_alt+'</h5>\
                                    <div class="pull-right">\
                                        \
                                    </div>\
                                </div>\
                            </div>');
	          $('#gallery').prepend( $newItems)
	            .isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });
              var elem  = $('#accordion').find('.panel-collapse');
                elem.removeClass("in");
                elem.attr("style","height: 0px;");
                elem.attr("aria-expanded",false);
	      },
	      error: function (data) {
	        $('#imageErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p></div>');
	      }
	  });
});

$('#titulo').keyup(function() {
    var filtrado = $('#titulo').val();
    filtrado = filtrado.replace(/[^a-zA-Z0-9-_]/g, '_');
    $('#identificador').val(filtrado);
});
$( "#blog_cats" ).change(function() {
  if($('#blog_cats').val() == 'Otra'){
      $("#other_category").val('');
      $("#other_cat_group").show();
  }else{
      $("#other_category").val('');
      $("#other_cat_group").hide();
  }
});
$( "#header_type" ).change(function() {
  $("#header_data").val('');
  var typeval = $('#header_type').val();
  if(typeval == 'image'){
      $("#header_data_group").hide();
  }else if(typeval == 'quote'){
      $("#header_data_group").show();
      $("#header_data_label").text("Frase");
  }else if(typeval == "widget"){
      $("#header_data_group").show();
      $("#header_data_label").text("Código Widget");
  }
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

var type = "POST";
var my_url = '/Mr_Administrator/BlogMan/GetCats';
var blog_cats = $('#blog_cats');
var cat_id = $('#post_cat_id').val();
console.log(cat_id);
blog_cats.empty();

$.ajax({

    type: type,
    url: my_url,
    success: function (data) {
        for(var i = 0; i < data.cats.length; i++) {
            var obj = data.cats[i];
            if(obj.id == cat_id){
                blog_cats.append($("<option selected/>").val(obj.id).text(obj.name));
            }else{
                blog_cats.append($("<option />").val(obj.id).text(obj.name));
            }
        }
        blog_cats.append($("<option id='other_cat' />").text("Otra"));
        if(data.cats.length > 0){
          $('#other_cat_group').hide();
        }else{
          $('#other_cat_group').show();
        }
    },
    error: function (data) {

    }
});

var type = "POST";
var my_url = '/Mr_Administrator/BlogMan/GetTags';
var blog_tags = $('#blog_tags');
var tag_array = [];

$.ajax({

    type: type,
    url: my_url,
    success: function (data) {
        for(var i = 0; i < data.tags.length; i++) {
            var obj = data.tags[i];
            tag_array[i] = obj.name;
        }
    },
    error: function (data) {

    }
});
$('#save-changes-btn').click(function(){
  var original_text = $('#save-changes-btn').text();
  $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
  var post_id = parseInt($(this).val());
  var file_data = $("#main_image").prop("files")[0];   // Getting the properties of file from file field
  var keywords = $('#blog_tags').tagit("assignedTags");;
  console.log(keywords);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    var formData = new FormData();
    if(document.getElementById("main_image").value != "") {
        formData.append("file", file_data);
    }
    formData.append("id", post_id);
    formData.append("titulo", $('#titulo').val());
    formData.append("identificador", $('#identificador').val());
    formData.append("category", $('#blog_cats').val());
    formData.append("other_category", $('#other_category').val());
    var descripcion = $('#descripcion').val();
      if(descripcion.length > 0){
       formData.append("descripcion", descripcion);
      }
    formData.append("contenido", editor.getData());
    formData.append("header_type", $('#header_type').val());
    formData.append("header_data", $('#header_data').val());
    formData.append("tags", keywords);
    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/SavePost';


    $.ajax({

        type: type,
        url: my_url,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,                         // Setting the data attribute of ajax with file_data
        type: 'post',
        beforeSend: function() {
          $('#postErrorDisplay').html('');
          $('.error_display').html('');
        },
        success: function (data) {
            $('#save-changes-btn').text(original_text);
            $('#save-changes-btn').val(data.post_id);
            window.location.replace("/Mr_Administrator/BlogMan");
        },
        error: function (data) {
          var errors =  JSON.parse(data.responseText);
          console.log(errors);
          for (var prop in errors) {
            if(!errors.hasOwnProperty(prop)) continue;
            console.log(prop + " = " + errors[prop]);
            $('#'+prop+'_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+errors[prop]+'</p>');
          }
          $('#postErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p></div>');
          $('#save-changes-btn').text(original_text);
        }
    });
});

$('#gallery').on('click', '.insert-image', function() {
    console.log('inserting image');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    var id = $(this).val();
    var comment = $('#blog_comment').val();
    var formData = {
        id: id,
    }
    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/insert_image';

    var prev_content = '';
    $.ajax({
        type: type,
        url: my_url,
        data: formData,                         // Setting the data attribute of ajax with file_data
        beforeSend: function() {
            console.log("jueputa");
            var elem  = $('#accordion').find('.panel-collapse');
                elem.removeClass("in");
                elem.attr("style","height: 0px;");
                elem.attr("aria-expanded",false);
        },
        success: function (data) {
            content = '<img id="gallery_'+data.img_id+'" src="'+data.img_link+'" alt="'+data.img_alt+'" style="height:330px;" />';
            final_html = 'mediaembedInsertData|---' + escape(content) + '---|mediaembedInsertData';
            editor.insertHtml(final_html);
            updated_editor_data = editor.getData();
            clean_editor_data = updated_editor_data.replace(final_html,content);
            editor.setData(clean_editor_data);
        },
    }); 
});

$('#collapseTwo').on('click', '.load-more', function() {
    console.log('loading more...');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    var tipo = $(this).val();
    var lot = $('#pepe').val();
    var formData = {
        lot: lot,
        type: tipo,
    }
    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/load_more_images';
    var prev_content = '';
    $.ajax({
        type: type,
        url: my_url,
        data: formData,                         // Setting the data attribute of ajax with file_data
        beforeSend: function() {
            console.log("bueno ahi va el request");
        },
        success: function (data) {
            data.images.forEach(function(element){
                $('#gallery div.image').first().remove();
                var $newItems = $('<div class="image">\
                                <div class="image-inner">\
                                    <a href="/blog42_content/uploads/'+element.file_name+'" data-lightbox="gallery-group-1">\
                                        <img src="/blog42_content/uploads/'+element.file_name+'" alt="" class="gallery-img" />\
                                    </a>\
                                    <p class="image-caption">\
                                        <button class="btn btn-xs btn-success insert-image" value="'+element.id+'"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>\
                                        <button class="btn btn-xs btn-danger delete-image" value="'+element.id+'"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>\
                                    </p>\
                                </div>\
                                <div class="image-info">\
                                    <h5 class="title">'+element.alt+'</h5>\
                                    <div class="pull-right">\
                                        \
                                    </div>\
                                </div>\
                            </div>');
                $('#gallery').append($newItems)
                .isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });
            });
            if(data.more_available == false){
                $( "#btn_more" ).remove();
            }else{
                if ( $( "#btn_more" ).length ) { }else{
                    $('#btns_space').append('<button id="btn_more" class="btn btn-info load-more" value="1"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>');
                }
            }
            if(data.less_available == false){
                $( "#btn_less" ).remove();
            }else{
                if ( $( "#btn_less" ).length ) { }else{
                    $('#btns_space').prepend('<button id="btn_less" class="btn btn-info load-more" value="-1"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>');
                }
            }
            $('#pepe').val(parseInt(data.current_lot));
        },
    }); 
});
$(document).ready(function() {
    App.init();
    Gallery.init();

    $('#blog_tags').tagit({
        availableTags: tag_array
    });
});