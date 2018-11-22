var nombre_busqueda;
var apellido_busqueda;
var id_busqueda;
var estado_previo;
var green = '#0D888B';
var greenLight = '#00ACAC';
var blue = '#3273B1';
var blueLight = '#348FE2';
var blackTransparent = 'rgba(0,0,0,0.6)';
var whiteTransparent = 'rgba(255,255,255,0.4)';
var handleFormWysihtml5 = function() {
    "use strict";
    $("#wysihtml5").wysihtml5()
    $("#cat_wysihtml5").wysihtml5()
};
var FormWysihtml5 = function() {
    "use strict";
    return {
        init: function() {
            handleFormWysihtml5()
        }
    }
}();



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

var d = new Date();
d.setMonth(d.getMonth() - 1);
var formData = {
    type: 'general',
    start_period: d.toJSON().slice(0,10),
}

var type = "POST";
var my_url = '/Mr_Administrator/BlogMan/get_blog_views';

//console.log(formData);

$.ajax({

    type: type,
    url: my_url,
    data: formData,
    success: function (data) {
        console.log(data);
        console.log(JSON.parse(data));
        Morris.Line({
            element: 'visitors-line-chart',
            data: JSON.parse(data),
            xkey: 'x',
            ykeys: ['y'],
            labels: ['Blog Views'],
            lineColors: [green],
            pointFillColors: [greenLight],
            lineWidth: '2px',
            pointStrokeColors: [blackTransparent],
            resize: true,
            gridTextFamily: 'Open Sans',
            gridTextColor: whiteTransparent,
            gridTextWeight: 'normal',
            gridTextSize: '11px',
            gridLineColor: 'rgba(0,0,0,0.5)',
            hideHover: 'auto',
        });
    },
    error: function (data) {
        var errors = data.responseJSON;
        $('#errors').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Se presento un error en la solicitud.</p>');
    }
});


$(document).ready(function() {
  $('#titulo').keyup(function() {
      var filtrado = $('#titulo').val();
      filtrado = filtrado.replace(/[^a-zA-Z0-9-_]/g, '_');
      $('#identificador').val(filtrado);
  });
  $('#cat_titulo').keyup(function() {
      var filtrado = $('#cat_titulo').val();
      filtrado = filtrado.replace(/[^a-zA-Z0-9-_]/g, '_');
      $('#cat_identificador').val(filtrado);
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
  var tabla = $("#posts_table").DataTable( {
      dom:"Bfrtip", buttons:[ {
          extend: "copy", className: "btn-sm"
      }
      , {
          extend: "csv", className: "btn-sm"
      }
      , {
          extend: "excel", className: "btn-sm"
      }
      , {
          extend: "pdf", className: "btn-sm"
      }
      , {
          extend: "print", className: "btn-sm"
      }
      ], responsive:!0
  }
  );

  $( "#newCat" ).click(function(){
      console.log("baby cat on its way");
      $('#newCatModal').modal('show');
  });

  $('#create_cat').click(function(){
    var cat_id = parseInt($(this).val());
    var file_data = $("#cat_main_image").prop("files")[0];   // Getting the properties of file from file field
      if(cat_id != -1){
        $('#cat_'+cat_id).remove();
      }
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      var formData = new FormData();
      if(document.getElementById("cat_main_image").value != "") {
          formData.append("file", file_data);
      }
      formData.append("id", cat_id);
      formData.append("cat_titulo", $('#cat_titulo').val());
      formData.append("cat_identificador", $('#cat_identificador').val());
      var cat_descripcion = $('#cat_descripcion').val();
      if(cat_descripcion.length > 0){
        formData.append("cat_descripcion", cat_descripcion);
      }
      formData.append("cat_content", $('#cat_content').val());
      var type = "POST";
      var my_url = '/Mr_Administrator/BlogMan/SaveCat';


      $.ajax({

          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,                         // Setting the data attribute of ajax with file_data
          type: 'post',
          beforeSend: function() {
            $('.error_display').html('');
          },
          success: function (data) {
            var newCat = '<li class="media media-sm">\
                  <a class="media-left" href="javascript:;">\
                  '+data.catDisplay+'\
                  </a>\
                  <div class="media-body">\
                      <h4 class="media-heading"><a href="/Mr_Administrator/BlogMan/'+data.category.name_identifier+'">'+data.category.name+'</a></h4>\
                      <p>'+data.category.description+'<br>\
                      Posts: 0<br></p>\
                  </div>\
              </li>';
            $("#category_list").append(newCat);
            $('#newCatModal').modal('hide');
          },
          error: function (data) {
            console.log(data);
            var errors =  JSON.parse(data.responseText);
            console.log(errors);
            for (var prop in errors) {
              if(!errors.hasOwnProperty(prop)) continue;
              console.log(prop + " = " + errors[prop]);
              $('#'+prop+'_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+errors[prop]+'</p>');
            }
          }
      });
  });
  $('#newPost').click(function(){
      $('#postEditorModal').modal('show');
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });

      var type = "POST";
      var my_url = '/Mr_Administrator/BlogMan/GetCats';
      var blog_cats = $('#blog_cats');
      blog_cats.empty();

      $.ajax({

          type: type,
          url: my_url,
          success: function (data) {
              for(var i = 0; i < data.cats.length; i++) {
                  var obj = data.cats[i];
                  blog_cats.append($("<option />").val(obj.id).text(obj.name));
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
  });
  $('.save_post').click(function(){
    console.log("uepa");
    var post_id = parseInt($(this).val());
    var file_data = $("#main_image").prop("files")[0];   // Getting the properties of file from file field
      if(post_id != -1){
        $('#post_'+post_id).remove();
      }
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
      formData.append("contenido", $('#wysihtml5').val());
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
             
            tabla
             .row.add([
             '<a href="'+data.post_link+'">'+data.saved_post.name+'</a>',
             data.blogger.name,
             data.saved_post.description,
             '<button class="btn btn-warning btn-xs approve_post value="'+data.saved_post.id+'">Aprobar</button> <button class="btn btn-info btn-xs destacar_post" value="'+data.saved_post.id+'">Agregar a destacados</button> <a class="btn btn-success btn-xs edit_post" href="/Mr_Administrator/BlogMan/post_editor/'+data.saved_post.name_identifier+'">Editar</a> <button class="btn btn-danger btn-xs delete_post" value="'+data.saved_post.id+'">Eliminar</button>' ,
             ])
             .draw();

              $('#postEditorModal').modal('hide');
          },
          error: function (data) {
            console.log(data);
            var errors =  JSON.parse(data.responseText);
            console.log(errors);
            for (var prop in errors) {
              if(!errors.hasOwnProperty(prop)) continue;
              console.log(prop + " = " + errors[prop]);
              $('#'+prop+'_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+errors[prop]+'</p>');
            }
          }
      });
  });

  $('#enableUser').click(function(){
    $('#search_results').html('no hay resultados');
      $('#enableUserModal').modal('show');
  });

  $('#user_search_btn').click(function(){
      var search_string = $('#search_string').val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });

      var formData = {
          search_str: search_string,
      }

      var type = "POST";
      var my_url = '/Mr_Administrator/search_user';

      //console.log(formData);

      $.ajax({

          type: type,
          url: my_url,
          data: formData,
          beforeSend:function(){
                  $('#search_results').html('<i class="fa fa-refresh fa-spin lead"></i>');
              },
          success: function (data) {
            if(data == -1){
              $('#search_results').html('no hay resultados');
            }else{
              $('#search_results').html('');
              for(var i = 0; i < data.search_results.length; i++) {
                var obj = data.search_results[i];
                  $("#search_results").append('<li id="search_result_'+obj.id+'" class="search_result_item list-group-item"><a href="#">'+obj.name+' '+obj.surname+' <small>('+obj.email+')</small></a></li>');
              }
            }
          },
          error: function (data) {
              var errors = data.responseJSON;
              $('#search_results').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Se presento un error en la solicitud.</p>');
          }
      });
  });

  $('#search_results').on('click', '.search_result_item', function(){
    var id = parseInt($(this).attr('id').substr(14));
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var formData = {
        id: id,
    }

    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/enableBlogger';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        success: function (data) {
            $('#enableUserModal').modal('hide');
            $('#confirmEnableUserModal').modal('show');
              estado_previo = data.estado;
              id_busqueda = data.usuario.id;
              nombre_busqueda = data.usuario.name;
              apellido_busqueda = data.usuario.surname;
            if(data.estado == "habilitado"){
              $("#enablingConfirmation").html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'+nombre_busqueda+' '+apellido_busqueda+' ya está habilitado como Blogger,</strong><br>¿Lo quieres deshabilitar?<br><br><br><button value="enable" class="btn btn-danger enable_action">Deshabilitar</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button></div>');
            }else if(data.estado == "deshabilitado"){
                  $("#enablingConfirmation").html('<div class="alert alert-dismissible alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'+nombre_busqueda+' '+apellido_busqueda+' aún no está habilitado como Blogger,</strong><br>¿Lo quieres habilitar?<br><br><br><button value="disable" class="btn btn-success enable_action">Habilitar</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button></div>');
            }

        },
        error: function (data) {
            var errors = data.responseJSON;
            $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudieron guardar los cambios :/ quizas fue el email?</p>');
        }
    });
  });

  $('#posts_table').on('click', '.approve_post', function(){
    var id = parseInt($(this).val());
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var formData = {
        id: id,
    }

    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/approvePost';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        success: function (data) {
            $('#post_'+id).remove();
            $('#posts_table tbody').append(data);
        },
        error: function (data) {
            var errors = data.responseJSON;
            console.log(errors);
            $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
        }
    });
  });


  $('#posts_table').on('click', '.disable_post', function(){
    var id = parseInt($(this).val());
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var formData = {
        id: id,
    }

    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/disablePost';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        success: function (data) {
            $('#post_'+id).remove();
            $('#posts_table tbody').append(data);
        },
        error: function (data) {
            var errors = data.responseJSON;
            console.log(errors);
            $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
        }
    });
  });


  $('#posts_table').on('click', '.enable_post', function(){
    var id = parseInt($(this).val());
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var formData = {
        id: id,
    }

    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/enablePost';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        success: function (data) {
            $('#post_'+id).remove();
            $('#posts_table tbody').append(data);
        },
        error: function (data) {
            var errors = data.responseJSON;
            console.log(errors);
            $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
        }
    });
  });


  $('#posts_table').on('click', '.destacar_post', function(){
    var id = parseInt($(this).val());
    var position = parseInt(prompt("Destacado #:", "1"));
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var formData = {
        id: id,
        position: position,
    }

    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/destacarPost';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        success: function (data) {
            $('#post_'+id).remove();
            $('#posts_table tbody').append(data.post);
            $('#destacados_group').html(data.destacados);
        },
        error: function (data) {
            var errors = data.responseJSON;
            console.log(errors);
            $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
        }
    });
  });

  $('#posts_table').on('click', '.desdestacar_post', function(){
    var id = parseInt($(this).val());
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var formData = {
        id: id,
    }

    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/desdestacarPost';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        success: function (data) {
            $('#post_'+id).remove();
            $('#posts_table tbody').append(data.post);
            $('#destacados_group').html(data.destacados);
        },
        error: function (data) {
            var errors = data.responseJSON;
            console.log(errors);
            $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
        }
    });
  });

  $('#posts_table').on('click', '.delete_post', function(){
    var id = parseInt($(this).val());
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var formData = {
        id: id,
    }

    var type = "POST";
    var my_url = '/Mr_Administrator/BlogMan/deletePost';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        success: function (data) {
          tabla
                 .row( $('#post_'+id) )
                 .remove()
                 .draw();
            $('#destacados_group').html(data.destacados);
        },
        error: function (data) {
            var errors = data.responseJSON;
            console.log(errors);
            $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
        }
    });
  });

  $('#enablingConfirmation').on('click', '.enable_action', function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });

      var formData = {
          id: id_busqueda,
      }

      var type = "POST";
      var my_url = '/Mr_Administrator/BlogMan/changeEnableBlogger';

      //console.log(formData);

      $.ajax({

          type: type,
          url: my_url,
          data: formData,
          success: function (data) {
              $("#enablingConfirmation").html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz ' + data + ' a '+nombre_busqueda+' '+apellido_busqueda+' como Blogger,</strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
              setTimeout(function(){
                  $('#confirmEnableUserModal').modal('hide');
              },3000);
          },
          error: function (data) {
              var errors = data.responseJSON;
              $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudieron guardar los cambios :/ quizas fue el email?</p>');
          }
      });
  });
});