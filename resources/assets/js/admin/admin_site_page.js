$(document).ready(function() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });
  var current_type = "none";

  editor = CKEDITOR.replace( 'editor_content',
      {
          height : '500',
      });

  $('#create_master').click(function(){
    $('#save_master').val(-1);
    $('#editMasterModal').modal('show');
  });

  $('#save_page').click(function(){
      var id = $(this).val();
      console.log("Saving page");
      var formData = new FormData();
      formData.append("id", id);
      formData.append("es_title", $('#es_title').val());
      formData.append("en_title", $('#en_title').val());
      var page_description = $('#page_description').val();
      if(page_description.length > 0){
        formData.append("page_description", page_description);
      }
      var page_keywords = $('#page_keywords').val();
      if(page_keywords.length > 0){
        formData.append("page_keywords", page_keywords);
      }
      var type = "POST";
      var my_url = '/Mr_Administrator/site/save_page';


      $.ajax({

          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'post',
          beforeSend: function() {
              $('#pageErrorDisplay').html('');
          },
          success: function (data) {
              console.log("Success");
              $('#pageErrorDisplay').html('<p class="text-success text-center"><i class="fa fa-check" aria-hidden="true"></i> Cambios Guardados</p>');
              setTimeout(function(){
                $('#pageErrorDisplay').fadeOut();
              }, 2000);
          },
          error: function (data) {
            errors = "";
            data.foreach(function(element){
              errors = errors + element[0];
            })
            $('#pageErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
          }
      });
  });

  $('#content_boxes').on('click','.show_contents',function(){
		var content_id = $(this).val();
		console.log(content_id);
		$('#save-box').val(content_id);
		var formData = new FormData();
		formData.append("id",content_id);
		var type = "POST";
		var my_url = '/Mr_Administrator/site/get_content_box';

		$.ajax({

			type: type,
 			url: my_url,
 			cache: false,
 			contentType: false,
 			processData: false,
 			data: formData,
 			type: 'post',
			beforeSend:function(){
				  $('#error_display').html('<p class="text-info text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span> Cargando</p>');
			},
			success: function(data){
        $('#contentBoxEn').empty();
        $('#contentBoxEs').empty();
        $('#contentBoxImg').empty();
        $('#contentBoxW').empty();
				$('#error_display').html('');
				$('#alias').text(data.alias);
				$('.box_alias').val(data.alias)
				$('.box_alias').css('display', 'block !important');
				$('.box_alias').show();
        data.contents.forEach(function(content){
          var new_line = '<div id="content_' + content.id + '" class="list-group-item contenido">\
                            <h4 class="list-group-item-heading">' + content.descripcion + '</h4>\
                          </div>';
          switch (content.lang) {
            case 'es':
              $('#contentBoxEs').append(new_line);
              break;
            case 'en':
              $('#contentBoxEn').append(new_line);
              break;
            case 'img':
              $('#contentBoxImg').append(new_line);
              break;
            case 'code':
              $('#contentBoxW').append(new_line);
              break;
            default:
          }

        });
				$('#contentBoxContent').modal('show');
				$('#contentBoxContent').on('hidden.bs.modal', function () {
			    $(this).find("div.list-group").text('').end();
				});
			},
			error:function(data){
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
		 });
	});

  $('#contenidos').on('click', '.contenido', function(){
    var content_id = $(this).attr('id');
    console.log(content_id);
    content_id = parseInt(content_id.slice(8));
    console.log(content_id);
    $('#save-changes-btn').val(content_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    var formData = new FormData();
    formData.append("id", content_id);
    var type = "POST";
    var my_url = '/Mr_Administrator/site/get_content';

    $.ajax({

        type: type,
        url: my_url,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        beforeSend: function() {
            $('#editor_holder').hide();
            $('#large_content').hide();
            $('#short_content').hide();
            $('#image_content').hide();
            $('#contentErrorDisplay').html('<p class="text-info text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span> Cargando</p>');
        },
        success: function (data) {
            $('#contentErrorDisplay').html('');
            switch(data.contentType){
              case "formatted_text":
                current_type = "formatted_text";
                editor.setData(data.content);
                $('#editor_holder').css('display', 'block !important');
                $('#editor_holder').show();
                break;
              case "long_text":
                current_type = "long_text";
                $('#large_content').val(data.content)
                $('#large_content').css('display', 'block !important');
                $('#large_content').show();
                break;
              case "short_text":
                current_type = "short_text";
                $('#short_content').val(data.content)
                $('#short_content').css('display', 'block !important');
                $('#short_content').show();
                break;
              case "image":
                current_type = "image";
                var image_element = '<img src="/page_content/'+data.content+'" height="300">';
                $('#image_holder').html(image_element)
                $('#image_content').css('display', 'block !important');
                $('#image_content').show();
                break;
            }
            console.log("Success");
            $('#contentBoxContent').modal('hide');
            $('#contentEditorModal').modal('show');
        },
        error: function (data) {
          errors = "";
          data.foreach(function(element){
            errors = errors + element[0];
          })
          $('#contentErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
        }
    });
  });
  $('#save-box').click(function(){
		var box_id = $(this).val();
		var clicked_btn = $(this);
    var org_text = clicked_btn.text();
		console.log(box_id);
		var alias = $('#box_alias').val();
		var formData = new FormData();
		formData.append("id",box_id);
		formData.append("alias",alias);
		var type = "POST";
		var my_url = '/Mr_Administrator/site/save_box';
		$.ajax({
			type: type,
			url: my_url,
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			type: 'post',
			beforeSend: function() {
				clicked_btn.html('<i class="fa fa-refresh fa-spin lead"></i>');
			},
			success: function(data){
				clicked_btn.text(org_text);
        $('#box_'+box_id+' .list-group-item-heading').text(alias);
        $('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz modificado la caja de contenido. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
				$('#confirmAlertModal').modal('show');
				$('.modal-title').text('Caja de contenido modificada');
				setTimeout(function(){
							$('#confirmAlertModal').modal('hide');
					},3000);
			},
			error: function(data){
				clicked_btn.text(org_text);
        console.log(data);
				var errors = data.responseJSON;
				console.log(errors);
				$('#modal_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
		});
	});
  $('#save-changes-btn').click(function(){
    console.log("saving changes");
    var original_text = $('#save-changes-btn').text();
    $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
    var content_id = parseInt($(this).val());
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      var formData = new FormData();
      formData.append("id", content_id);
      switch(current_type){
        case "formatted_text":
          formData.append("contenido", editor.getData());
          break;
        case "long_text":
          formData.append("contenido", $('#large_content').val());
          break;
        case "short_text":
          formData.append("contenido", $('#short_content').val());
          break;
        case "image":
          current_type = "image";
          formData.append("contenido", 'imagen');
          var file_data = $("#content_file").prop("files")[0];   // Getting the properties of file from file field
          formData.append("file", file_data);
          break;
      }
      var type = "POST";
      var my_url = '/Mr_Administrator/site/save_content';


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
              $('#save-changes-btn').text(original_text);
              $('#contentEditorModal').modal('hide');
              if(current_type == "image"){
                location.reload();
              }
          },
          error: function (data) {
            $('#postErrorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p></div>');
            $('#save-changes-btn').text(original_text);
          }
      });
  });
});
