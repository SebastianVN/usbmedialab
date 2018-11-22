var nombre_busqueda;
var apellido_busqueda;
var id_busqueda;
var estado_previo;

var handleFormWysihtml5 = function() {
    "use strict";
    $("#wysihtml5").wysihtml5()
};
var FormWysihtml5 = function() {
    "use strict";
    return {
        init: function() {
            handleFormWysihtml5()
        }
    }
}()

$(document).ready(function() {
  $('#titulo').keyup(function() {
      var filtrado = $('#titulo').val();
      filtrado = filtrado.replace(/[^a-zA-Z0-9-_]/g, '_');
      $('#identificador').val(filtrado);
  });

  $('.edit_cat').click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });

      var type = "POST";
      var my_url = '/Mr_Administrator/BlogMan/GetCat';
      var id = $(this).val();

      var formData = {
          id: id,
      }

      $.ajax({

          type: type,
          url: my_url,
          data: formData,
          success: function (data) {
              $('#titulo').val(data.category.name);
              $('#identificador').val(data.category.name_identifier);
              $('#descripcion').val(data.category.description);
              $('iframe').contents().find('.wysihtml5-editor').html(data.category.content);
              $('#catEditorModal').modal('show');
          },
          error: function (data) {
            errors = "";
            data.foreach(function(element){
              errors = errors + element[0];
            })
            $('#catErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
            $('#catEditorModal').modal('show');
          }
      });
  });

  $('.delete_cat').click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });

      var type = "POST";
      var my_url = '/Mr_Administrator/BlogMan/DeleteCat';
      var id = $(this).val();

      var formData = {
          id: id,
      }

      $.ajax({

          type: type,
          url: my_url,
          data: formData,
          success: function (data) {
              alert("Categoria Eliminada");
              window.location.replace("/Mr_Administrator/BlogMan");
          },
          error: function (data) {
            errors = "";
            data.foreach(function(element){
              errors = errors + element[0];
            })
            $('#catErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
            $('#catEditorModal').modal('show');
          }
      });
  });

  $('.save_cat').click(function(){
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
      formData.append("file", file_data);
      formData.append("id", post_id);
      formData.append("cat_titulo", $('#titulo').val());
      formData.append("cat_identificador", $('#identificador').val());
      formData.append("cat_descripcion", $('#descripcion').val());
      formData.append("cat_contenido", $('#wysihtml5').val());
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
            $('#catErrorDisplay').html('');
          },
          success: function (data) {
              $('#catEditorModal').modal('hide');
              $(".category_name").text(data.cat.name);
              $(".category_identifier").text(data.cat.name_identifier);
              $(".category_description").text(data.cat.description);
              $(".category_content").text(data.cat.name_content);
          },
          error: function (data) {
              $('#catErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p></div>');
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
});