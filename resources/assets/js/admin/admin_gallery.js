$(document).ready(function() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });
  $('#new_img').click(function(){
    $('#save_image').val(-1);
    $('#editImageModal').modal('show');
  });
  $('#add_widget').click(function(){
    $('#save_widget').val(-1);
    $('#add_widget_modal').modal('show');
  });
  if($('#img_cat').val() == -1){
      $("#other_category").val('');
      $("#other_cat_group").show();
      $('#img_cat').val(1);
  }else{
      $("#other_category").val('');
      $("#other_cat_group").hide();
  }
  $( "#img_cat" ).change(function() {
    if($('#img_cat').val() == -1){
        $("#other_category").val('');
        $("#other_cat_group").show();
    }else{
        $("#other_category").val('');
        $("#other_cat_group").hide();
    }
  });

  $('#save_image').click(function(){
      var original_text = $('#save_image').text();
      $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
      var id = $(this).val();
      console.log("Saving page");
      var formData = new FormData();
      formData.append("id", id);
      var cat = parseInt($('#img_cat').val());
      if(cat == -1){
        formData.append("new_category", $('#other_category').val());
      }else{
        formData.append("category", cat);
      }
      var img_title = $('#img_title').val();
      if(img_title.length > 0){
        formData.append("img_title", img_title);
      }
      var img_caption = $('#img_caption').val();
      if(img_caption.length > 0){
        formData.append("img_caption", img_caption);
      }
      var file_data = $("#content_file").prop("files")[0];   // Getting the properties of file from file field
      formData.append("file", file_data);
      var type = "POST";
      var my_url = '/Mr_Administrator/gallery/save_image';
      $.ajax({
          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'post',
          beforeSend: function() {
              $('#imageErrorDisplay').html('');
          },
          success: function (data) {
              console.log("Success");
              $('#save_image').text(original_text);
              location.reload();
          },
          error: function (data) {
            errors = "";
            data.foreach(function(element){
              errors = errors + element[0];
            })
            $('#imageErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
            $('#save_image').text(original_text);
          }
      });
  });

  $('#save_widget').click(function(){
      var original_text = $('#save_widget').text();
      $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
      var id = $(this).val();
      console.log("Saving widget");
      var formData = new FormData();
      formData.append("id", id);
      formData.append("widget_code", $('#widget_code').val());
      var cat = parseInt($('#widget_cat').val());
      if(cat == -1){
        formData.append("new_category", $('#other_category').val());
      }else{
        formData.append("category", cat);
      }
      var widget_title = $('#widget_title').val();
      if(widget_title.length > 0){
        formData.append("widget_title", widget_title);
      }
      var widget_caption = $('#widget_caption').val();
      if(widget_caption.length > 0){
        formData.append("widget_caption", widget_caption);
      }
      var type = "POST";
      var my_url = '/Mr_Administrator/gallery/save_widget';
      $.ajax({
          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'post',
          beforeSend: function() {
              $('#widgetErrorDisplay').html('');
          },
          success: function (data) {
              console.log("Success");
              $('#save_widget').text(original_text);
              location.reload();
          },
          error: function (data) {
            errors = data.responseText;
            data.forEach(function(element){
              errors = errors + element[0];
            })
            $('#widgetErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
            $(this).text(original_text);
          }
      });
  });

  $('#image_group').on('click', '.edit_img', function(){
      var id = $(this).val();
      $('#save_image').val(id);
      var title = $('#container_'+id).find('.pic_title').text();
      var caption = $('#container_'+id).find('.pic_caption').text();
      var cat = $('#container_'+id).find('.cat_id').text();
      var filename = $('#container_'+id).find('img').attr("src");
      var image_element = '<img src="'+filename+'" style="width:100%;">';
      $('#image_holder').html(image_element);
      $('#img_title').val(title);
      $('#img_caption').val(caption);
      $("option:selected").prop("selected", false);
      console.log(''+cat+'');
      $("#img_cat").val(cat);
      $('#editImageModal').modal('show');
  });

  $('#image_group').on('click', '.edit_widget', function(){
      var id = $(this).val();
      $('#save_widget').val(id);
      var title = $('#container_'+id).find('.pic_title').text();
      var caption = $('#container_'+id).find('.pic_caption').text();
      var cat = $('#container_'+id).find('.cat_id').text();
      var widget_code = $('#widget_'+id).val();
      $('#widget_title').val(title);
      $('#widget_caption').val(caption);
      $('#widget_code').val(widget_code);
      $("option:selected").prop("selected", false);
      console.log(''+cat+'');
      $("#widget_cat").val(cat);
      $('#add_widget_modal').modal('show');
  });

  $('#image_group').on('click', '.delete_img', function(){
      var id = $(this).val();
      var formData = new FormData();
      formData.append("id", id);
      var type = "POST";
      var my_url = '/Mr_Administrator/gallery/delete_image';
      $.ajax({
          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'post',
          beforeSend: function() {
              $('#imageErrorDisplay').html('');
          },
          success: function (data) {
              console.log("Success");
              $('#container_'+id).remove();
          },
          error: function (data) {
            errors = "";
            data.foreach(function(element){
              errors = errors + element[0];
            })
            $('#imageErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
          }
      });
  });

  $('#image_group').on('click', '.feature_img', function(){
      var id = $(this).val();
      var formData = new FormData();
      formData.append("id", id);
      var type = "POST";
      var my_url = '/Mr_Administrator/gallery/feature_image';
      $.ajax({
          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'post',
          beforeSend: function() {
              $('#imageErrorDisplay').html('');
          },
          success: function (data) {
              console.log(data.featured);
              if(data.featured == 1){
                console.log("destacado");
                $('#feature_'+id).html('<i class="fa fa-star" aria-hidden="true"></i>');
              }else{
                $('#feature_'+id).html('<i class="fa fa-star-o" aria-hidden="true"></i>');
              }
          },
          error: function (data) {
            errors = "";
            data.foreach(function(element){
              errors = errors + element[0];
            })
            $('#imageErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
          }
      });
  });

  $('#image_group').on('click', '#pre_delete_cat', function(){
      var id = $(this).val();
      $('#kill_cat').val(id);
      $('#kill_cat_modal').modal('show');
  });

  $('#image_group').on('click', '#edit_category', function(){
      var id = $(this).val();
      $('#save_cat').val(id);
      $('#edit_cat_modal').modal('show');
  });

  $('#kill_cat').click(function(){
      var id = $(this).val();
      var formData = new FormData();
      formData.append("id", id);
      var type = "POST";
      var my_url = '/Mr_Administrator/gallery/delete_category';
      $.ajax({
          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'post',
          beforeSend: function() {
              $('#imageErrorDisplay').html('');
          },
          success: function (data) {
              console.log("Category and Images Deleted");
              $('#warning_alert').hide(400);
              $('#success_alert').show(400);
              setTimeout(function(){window.location = '/Mr_Administrator/gallery';} , 3000);   
          },
          error: function (data) {
            errors = "";
            data.foreach(function(element){
              errors = errors + element[0];
            })
            $('#imageErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
          }
      });
  });

  $('#save_cat').click(function(){
      var id = $(this).val();
      var formData = new FormData();
      formData.append("id", id);
      formData.append("cat_title", $('#cat_title').val());
      formData.append("cat_identifier", $('#cat_identifier').val());
      var cat_description = $('#cat_description').val();
      if(cat_description.length > 0){
        formData.append("cat_description", cat_description);
      }
      var type = "POST";
      var my_url = '/Mr_Administrator/gallery/save_category';
      $.ajax({
          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'post',
          beforeSend: function() {
              $('#cat_errorDisplay').html('');
          },
          success: function (data) {
              console.log("Category Saved");
              $('#edit_cat_modal').modal('hide');
          },
          error: function (data) {
            errors = "";
            data.foreach(function(element){
              errors = errors + element[0];
            })
            $('#cat_errorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
          }
      });
  });
});