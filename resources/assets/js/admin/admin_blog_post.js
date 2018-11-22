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

  $( "#blog_cats" ).change(function() {
    if($('#blog_cats').val() == 'Otra'){
        $("#other_category").val('');
        $("#other_cat_group").show();
    }else{
        $("#other_category").val('');
        $("#other_cat_group").hide();
    }
  });
  $('.delete_post').click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });

      var type = "POST";
      var my_url = '/Mr_Administrator/BlogMan/deletePost';
      var id = $(this).val();

      var formData = {
          id: id,
      }

      $.ajax({
          type: type,
          url: my_url,
          data: formData,
          success: function (data) {
            window.location.replace("/Mr_Administrator/BlogMan");
          },
          error: function (data) {
            console.log("error");
          }
      });
  });
  $('.edit_post').click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });

      var type = "POST";
      var my_url = '/Mr_Administrator/BlogMan/GetPost';
      var id = $(this).val();
      var blog_cats = $('#blog_cats');

      var formData = {
          id: id,
      }

      $.ajax({
          type: type,
          url: my_url,
          data: formData,
          success: function (data) {
              for(var i = 0; i < data.cats.length; i++) {
                  var obj = data.cats[i];
                  if(obj.id == data.post.category_id){
                    blog_cats.append($("<option selected />").val(obj.id).text(obj.name));
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
              $('#titulo').val(data.post.name);
              $('#identificador').val(data.post.name_identifier);
              $('#descripcion').val(data.post.description);
              $('iframe').contents().find('.wysihtml5-editor').html(data.post.content);
              $('#postEditorModal').modal('show');
          },
          error: function (data) {
            $('#postErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p></div>');
            $('#postEditorModal').modal('show');
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
      formData.append("descripcion", $('#descripcion').val());
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
          },
          success: function (data) {
              console.log(data);
              $(".post_name").text(data.saved_post.name);
              $(".post_identifier").text(data.saved_post.name_identifier);
              $(".post_description").text(data.saved_post.description);
              $("#post_content").html(data.saved_post.content);
              $('#postEditorModal').modal('hide');
          },
          error: function (data) {
            $('#postErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p></div>');
          }
      });
    
  });
});