$(document).ready(function(){
$.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	      }
	  });

		/*editor = CKEDITOR.replace( 'editor_content',
	      {
	          height : '500',
	      });*/

	$('#new_registry').click(function(){
	  $('#newRegistry').modal('show');
	});
	$('#new_content_box').click(function(){
		$('#newContentBox').modal('show');
	});


	$('#content_boxes').on('click','.show_contents',function(){
		var content_id = $(this).val();
		console.log(content_id);
		$('#save-changes-btn').val(content_id);
		 var formData = new FormData();
		 formData.append("id",content_id);
		 var type = "POST";
		 var my_url = '/Mr_Administrator/sudo/get_content';

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
				$('#error_display').html('');
				$('#alias').text(data.alias);
				$('.box_alias').val(data.alias)
				$('.box_alias').css('display', 'block !important');
				$('.box_alias').show();
				for(var i=0 ; i < data.contents.length ; i++){
					var obj = data.contents[i];
					if(obj.lang == "en" && obj.box_id == content_id){
						$('#contentBoxEn').append('<div id="content_'+obj.id+'" class="list-group-item"><span class="pull-right"><button class="edit_content btn-circle btn-icon btn-success btn-xs" value="'+obj.id+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="up_content btn-info btn-circle btn-icon btn-xs" value="'+obj.id+'"><i class="fa fa-arrow-up" aria-hidden="true"></i></button><button class="down_content btn-info btn-circle btn-icon btn-xs" value="'+obj.id+'" data-box="'+data.box_id+'"><i class="fa fa-arrow-down" aria-hidden="true"></i></button><button class="deleteContent btn-danger btn-circle btn-icon btn-xs" value="'+obj.id+'"><i class="fa fa-trash" aria-hidden="true"></i></button></span><h4 class="list-group-item-heading">'+obj.identifier+'</h4></div>');
					}if(obj.lang == "es" && obj.box_id == content_id || obj.lang == "link"){
						$('#contentBoxEs').append('<div id="content_'+obj.id+'" class="list-group-item"><span class="pull-right"><button class="edit_content btn-circle btn-icon btn-success btn-xs" value="'+obj.id+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="up_content btn-info btn-circle btn-icon btn-xs" value="'+obj.id+'"><i class="fa fa-arrow-up" aria-hidden="true"></i></button><button class="down_content btn-info btn-circle btn-icon btn-xs" value="'+obj.id+'" data-box="'+data.box_id+'"><i class="fa fa-arrow-down" aria-hidden="true"></i></button><button class="deleteContent btn-danger btn-circle btn-icon btn-xs" value="'+obj.id+'"><i class="fa fa-trash" aria-hidden="true"></i></button></span><h4 class="list-group-item-heading">'+obj.identifier+'</h4></div>');
					}if(obj.lang == "img" && obj.box_id == content_id){
						$('#contentBoxImg').append('<div id="content_'+obj.id+'" class="list-group-item"><span class="pull-right"><button class="edit_content btn-circle btn-icon btn-success btn-xs" value="'+obj.id+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="up_content btn-info btn-circle btn-icon btn-xs" value="'+obj.id+'"><i class="fa fa-arrow-up" aria-hidden="true"></i></button><button class="down_content btn-info btn-circle btn-icon btn-xs" value="'+obj.id+'" data-box="'+data.box_id+'"><i class="fa fa-arrow-down" aria-hidden="true"></i></button><button class="deleteContent btn-danger btn-circle btn-icon btn-xs" value="'+obj.id+'"><i class="fa fa-trash" aria-hidden="true"></i></button></span><h4 class="list-group-item-heading">'+obj.identifier+'</h4></div>');
					}if(obj.lang == "widget" && obj.box_id == content_id){
						$('#contentBoxW').append('<div id="content_'+obj.id+'" class="list-group-item"><span class="pull-right"><button class="edit_content btn-circle btn-icon btn-success btn-xs" value="'+obj.id+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="up_content btn-info btn-circle btn-icon btn-xs" value="'+obj.id+'"><i class="fa fa-arrow-up" aria-hidden="true"></i></button><button class="down_content btn-info btn-circle btn-icon btn-xs" value="'+obj.id+'" data-box="'+data.box_id+'"><i class="fa fa-arrow-down" aria-hidden="true"></i></button><button class="deleteContent btn-danger btn-circle btn-icon btn-xs" value="'+obj.id+'"><i class="fa fa-trash" aria-hidden="true"></i></button></span><h4 class="list-group-item-heading">'+obj.identifier+'</h4></div>');
					}
				}
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
	$('#content_boxes').on('click','.up_box',function(){
		var box_id = $(this).val();
		var formData = new FormData();
		formData.append("box_id",box_id);
		var type = "POST";
		var my_url = '/Mr_Administrator/up_box';

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
			success:function(data){
				$('#error_display').html('');
				var up = $("#box_"+data.box_id);
				// move up:
				up.prev().insertAfter(up);
			},
			error: function(){
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
			});
		});
	$('#content_boxes').on('click','.down_box',function(){
		var box_id = $(this).val();
		var formData = new FormData();
		formData.append("box_id",box_id);
		var type = "POST";
		var my_url = '/Mr_Administrator/down_box';

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
			success:function(data){
			$('#error_display').html('');
				var down = $("#box_"+data.box_id);
				// move up:
				down.next().insertBefore(down);
			},
			error: function(){
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
		});
	});
	$('#create_content_box').click(function(){
		var alias = $('#content_box_alias').val();
		var page_select = $('#select_page').val();
		var clicked_btn = $(this);
    var org_text = clicked_btn.text();
		var formData = new FormData();
		formData.append("alias",alias);
		formData.append("page_select",page_select);
		var type = "POST";
		var my_url = '/Mr_Administrator/create_content_box';

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
			success: function (data) {
				clicked_btn.text(org_text);
				$('#newContentBox').modal('hide');
				$('#content_boxes').append('<div id="box_'+data.box.id+'" class="list-group-item"><span class="pull-right"><button class="show_contents btn-circle btn-icon btn-success" value="'+data.box.id+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button class="up_box btn-info btn-circle btn-icon" value="'+data.box.id+'"><i class="fa fa-arrow-up" aria-hidden="true"></i></button> <button class="down_box btn-info btn-circle btn-icon" value="'+data.box.id+'"><i class="fa fa-arrow-down" aria-hidden="true"></i></button> <button class="delete_content_box btn-danger btn-circle btn-icon" value="'+data.box.id+'"><i class="fa fa-trash" aria-hidden="true"></i></button> </span><h4 class="list-group-item-heading">'+data.box.alias+'</h4></div>');
			},
			error: function (data) {
				clicked_btn.text(org_text);
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
				}
		});
	});
	$('#select_lang').click(function(){
		if($('#select_lang').val() == 'img' ){
			$('#selectType').val('image');
		}
		if($('#select_lang').val() == 'code'){
			$('#selectType').val('long_text');
		}
		if($('#select_lang').val() == 'es'){
			$('#selectType').val('long_text');
		}
		if($('#select_lang').val() == 'en'){
			$('#selectType').val('long_text');
		}
		if($('#select_lang'.val() == 'link')){
			$('#selectType').val('long_text');
		}
	});
	$('#create_registry').click(function(){
		var clicked_btn = $(this);
    var org_text = clicked_btn.text();
		var identifier = $('#registry_identificador').val();
		var lang = $('#select_lang').val();
		var descripcion = $('#registry_descripcion').val();
		var content_type = $('#selectType').val();
		var content = $('#registry_content').val();
		var box = $('#selectBox').val();
		var formData = new FormData();
		formData.append("identifier",identifier);
		formData.append("lang",lang);
		formData.append("descripcion",descripcion);
		formData.append("content_type",content_type);
		formData.append("content",content);
		formData.append("box",box);
		var type = "POST";
		var my_url = '/Mr_Administrator/create_registry';

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
			success: function (data) {
				clicked_btn.text(org_text);
				$('#newRegistry').modal('hide');
			},
			error: function (data) {
				clicked_btn.text(org_text);
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
				}
		});
	});
	$('#delete_all_page').click(function(){
		$('#confirmdeleteModal').modal('show');
		$('#deleteConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>¿Estas seguro de eliminar la pagina?. </strong><br><br></div>');
	});
	$('#deleteAllPage').click(function(){
		var clicked_btn = $(this);
    var org_text = clicked_btn.text();
		var page_id = $(this).val();
		var formData = new FormData();
		formData.append("id",page_id);
		var type = "POST";
		var my_url = '/Mr_Administrator/delete_all_page';

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
			success: function (data) {
				clicked_btn.text(org_text);
				$('#confirmAlertModal').modal('show')
				$('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz Eliminado La pagina sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
				$('.modal-title').text('Pagina Eliminada');
				setTimeout(function(){
							$('#confirmAlertModal').modal('hide');
					},3000);
			},
			error: function (data) {
				clicked_btn.text(org_text);
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
				}
		});
	});
	$('#content_boxes').on('click','.delete_content_box',function(){
		var box_id = $(this).val();
		var formData = new FormData();
		formData.append("id",box_id);
		var type = "POST";
		var my_url = '/Mr_Administrator/delete_content_box';
		$.ajax({

			type: type,
 			url: my_url,
 			cache: false,
 			contentType: false,
 			processData: false,
 			data: formData,
 			type: 'post',

			success: function (data) {
				$('#box_'+box_id).remove();
				$('#confirmAlertModal').modal('show')
				$('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz Eliminado la caja de contenidos sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
				$('.modal-title').text('Caja de Contenido Eliminada');
				setTimeout(function(){
							$('#confirmAlertModal').modal('hide');
					},3000);
			},
			error: function (data) {
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
				}
		});
	});
	$('#contentBoxContent').on('click','.up_content',function(){
		var content_id = $(this).val();
		var formData = new FormData();
		formData.append("content_id",content_id);
		var type = "POST";
		var my_url = '/Mr_Administrator/up_content';

		$.ajax({
			type: type,
 			url: my_url,
 			cache: false,
 			contentType: false,
 			processData: false,
 			data: formData,
 			type: 'post',
			beforeSend:function(){
				  $('#loadContent').html('<p class="text-info text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span> Cargando</p>');
			},
			success:function(data){
				$('#loadContent').html('');
				var up = $("#content_"+data.content_id);
				// move up:
				up.prev().insertAfter(up);
			},
			error: function(){
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#loadContent').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
			});
		});
	$('#contentBoxContent').on('click','.down_content',function(){
		var content_id = $(this).val();
		var box_id = $(this).attr('data-box');
		console.log(box_id);
		var formData = new FormData();
		formData.append("content_id",content_id);
		formData.append("box_id",box_id);
		var type = "POST";
		var my_url = '/Mr_Administrator/down_content';

		$.ajax({
			type: type,
 			url: my_url,
 			cache: false,
 			contentType: false,
 			processData: false,
 			data: formData,
 			type: 'post',
			beforeSend:function(){
				  $('#loadContent').html('<p class="text-info text-center">Cargando</p>');
			},
			success:function(data){
			$('#loadContent').html('');
				var down = $("#content_"+data.content_id);
				// move up:
				down.next().insertBefore(down);
			},
			error: function(){
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#loadContent').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
		});
	});
	$('#contentBoxContent').on('click','.deleteContent',function(){
		var content_id = $(this).val();
		var formData = new FormData();
		formData.append("content_id",content_id);
		var type = "POST";
		var my_url = '/Mr_Administrator/delete_content';
		$.ajax({
			type: type,
 			url: my_url,
 			cache: false,
 			contentType: false,
 			processData: false,
 			data: formData,
 			type: 'post',
			beforeSend:function(){
				  $('#loadContent').html('<p class="text-info text-center">Cargando</p>');
			},
			success: function(data){
				$('#content_'+content_id).remove();
				$('#contentBoxContent').modal('hide');
				$('#confirmAlertModal').modal('show');
				$('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz Eliminado el Contenido sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
				$('.modal-title').text('Contenido Eliminado');
				setTimeout(function(){
							$('#confirmAlertModal').modal('hide');
					},3000);
			},
			error: function(data){
				console.log(data);
				var errors = data.responseJSON;
					console.log(errors);
					$('#loadContent').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
		});
	});
	$('#contentBoxContent').on('click','.edit_content',function(){
		var content_id = $(this).val();
    console.log(content_id);
    $('#save-content_changes').val(content_id);
		var formData = new FormData();
    formData.append("id", content_id);
    var type = "POST";
    var my_url = '/Mr_Administrator/sudo/get_identifier_sudo';

    $.ajax({

        type: type,
        url: my_url,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        beforeSend: function() {
            $('#short_content').hide();
            $('#contentErrorDisplay').html('<p class="text-info text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span> Cargando</p>');
        },
        success: function (data) {
            $('#contentErrorDisplay').html('');
								$('#edit_identificador').val(data.content.identifier);
                $('#edit_content').val(data.content.content);
								$('#editBox').val(data.content.box_id);
								$('#edit_lang').val(data.content.lang);
								$('#edit_descripcion').val(data.content.descripcion);
								$('#editType').val(data.content.content_type);
								$('#contentBoxContent').modal('hide');
            console.log("Success");
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
	$('#edit_lang').click(function(){
		if($('#edit_lang').val() == 'img' ){
			$('#editType').val('image');
		}
		if($('#edit_lang').val() == 'code'){
			$('#editType').val('long_text');
		}
		if($('#edit_lang').val() == 'es'){
			$('#editType').val('long_text');
		}
		if($('#edit_lang').val() == 'en'){
			$('#editType').val('long_text');
		}
		if($('#edit_lang'.val() == 'link')){
			$('#editType').val('long_text');
		}
	});
	$('#save-content_changes').click(function(){
    var original_text = $('#save-content_changes').text();
    $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
    var content_id = parseInt($(this).val());
		var identifier = $('#edit_identificador').val();
		var lang = $('#edit_lang').val();
		var descripcion = $('#edit_descripcion').val();
		var content_type = $('#editType').val();
		var content_box = $('#editBox').val();
		console.log(content_box);
		var content = $('#edit_content').val();
      var formData = new FormData();
      formData.append("id", content_id);
			formData.append("identifier",identifier);
			formData.append("lang",lang);
			formData.append("descripcion",descripcion);
			formData.append("content_type",content_type);
			formData.append("content_box",content_box);
			formData.append("content",content);
      var type = "POST";
      var my_url = '/Mr_Administrator/sudo/save_identifier';


      $.ajax({

          type: type,
          url: my_url,
          cache: false,
          contentType: false,
          processData: false,
          data: formData,                         // Setting the data attribute of ajax with file_data
          type: 'post',
          beforeSend: function() {
						  $('#save-content_changes').html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
          },
          success: function (data) {
              $('#save-content_changes').text(original_text);
              $('#contentEditorModal').modal('hide');
							$('#confirmAlertModal').modal('show');
							$('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz editado los valores de la variable, sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
							$('.modal-title').text('Variable editada');
							setTimeout(function(){
										$('#confirmAlertModal').modal('hide');
								},3000);
          },
          error: function (data) {
						console.log(data);
						var errors = data.responseJSON;
							console.log(errors);
            $('#error').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p></div>');
            $('#save-content_changes').text(original_text);
          }
      });
  });
	$('#order_content_box').click(function(){
		var id_page = $(this).val();
		var clicked_btn = $(this);
    var org_text = clicked_btn.text();
		var formData = new FormData();
		formData.append("id",id_page);
		var type = "POST";
		var my_url = '/Mr_Administrator/sudo/order_content_box';

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
				$('#confirmAlertModal').modal('show');
				$('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz ordenado la integridad de las caja de contenido. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
				$('.modal-title').text('Cajas ordenadas');
				setTimeout(function(){
							$('#confirmAlertModal').modal('hide');
					},3000);
			},
			error: function(data){
				console.log(data);
				clicked_btn.text(org_text);
				var errors = data.responseJSON;
					console.log(errors);
					$('#display_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
		});
	});
	$('#save-changes-btn').click(function(){
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
				$('#contentBoxContent').modal('hide');
				$('#confirmAlertModal').modal('show');
				$('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz modificado la caja de contenido. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
				$('.modal-title').text('Caja de contenido modificada');
				setTimeout(function(){
							$('#confirmAlertModal').modal('hide');
					},3000);
			},
			error: function(data){
				console.log(data);
				clicked_btn.text(org_text);
				var errors = data.responseJSON;
					console.log(errors);
					$('#modal_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
		});
	});
});
