$(document).ready(function(){
	  var to_array = new Array();
$.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	      }
	  });
var current_name = "none";
var current_surname = "none";
var current_email = "none";
var current_id = "none";
var id_now ="none";

var tabla = $("#page_table").DataTable( {
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
$('#new_page').click(function(){
	  $('#newPage').modal('show');
	});
	 $('#search_user').click(function(){
        $('#search_results').html('no hay resultados');
        $('#enableUserModal').modal('show');
    });
		$('#userList').on('click','.disableUser',function(){
	    var user_id = $(this).val();
	    var formData = new FormData();
			formData.append("id",user_id);
	    var type = "POST";
	    var my_url = '/Mr_Administrator/disableUser';

	    $.ajax({

				type: type,
	 			url: my_url,
	 			cache: false,
	 			contentType: false,
	 			processData: false,
	 			data: formData,
	 			type: 'post',
	      success: function (data) {
	            $('#user_'+user_id).remove();
	      },
	      error: function (data) {
	        var errors = data.responseJSON;
	        console.log(errors);
	        $('#Display').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
	      }
	    });
	  });
    $('#user_search_btn').click(function(){
        var search_string = $('#search_string').val();
        var formData = {
            search_str: search_string,
        }
        var type = "POST";
        var my_url = '/Mr_Administrator/search_user';
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
                  if(to_array.indexOf(obj.id) == -1){
                    $("#search_results").append('<li id="search_result_'+obj.id+'" class="list-group-item">'+obj.name+' '+obj.surname+' <small>('+obj.email+')</small><button id="userList" class="confirm_user btn btn-warning pull-right btn-xs" value="'+obj.id+'" data-name="'+obj.name+'" data-surname="'+obj.surname+'" data-email="'+obj.email+'">Agregar a la Lista</button></li>');
                  }else{
                    $("#search_results").append('<li id="search_result_'+obj.id+'" class="list-group-item">'+obj.name+' '+obj.surname+' <small>('+obj.email+')</small><button class="btn btn-default pull-right btn-xs" disabled="true">Agregado</button></li>');
                  }
                }
              }
            },
            error: function (data) {
                var errors = data.responseJSON;
                $('#search_results').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Se presento un error en la solicitud.</p>');
            }
        });
    });

    $('#search_results').on('click', '.confirm_user', function(){
    var id = $(this).val();
    var name = $(this).attr('data-name');
    var surname =$(this).attr('data-surname');
    var email = $(this).attr('data-email');
    console.log("id tomado "+id);
    current_id = id;
    console.log("id actual "+current_id);
    $('#nameUser').text(name +'  '+ surname);
    $('#user_list').hide(420);
    $('#searchUser').hide(420);
    $('#hidehr').hide(420);
    $('#confirmUser').show(420);
  });
    $('#cancel_user').click(function(){
    $('#confirmUser').hide();
    $('#user_list').show();
		$('#searchUser').show();
  });

  $('#save_user').click(function(){
    var clicked_btn = $(this);
		var body = $('.modal-body1').html();
    var org_text = clicked_btn.text();
    var type = "post";
    var my_url = '/Mr_Administrator/enable_user';
    console.log("Este es el id "+current_id);
    var level = $('#selectUser').val();
    console.log("Este es el nivel  "+level);
    var formData =  {
      id:current_id,
      level:level,
    }
    $.ajax({
        type: type,
        url: my_url,
        data: formData,                         // Setting the data attribute of ajax with file_data
        beforeSend: function() {
          clicked_btn.html('<i class="fa fa-refresh fa-spin lead"></i>');
        },
        success: function (data) {
          clicked_btn.text(org_text);
          $('#enableUserModal').modal('hide');
					$('#userList').append('<div class="list-group-item" id="user_'+data.id+'"><button class="btn btn-danger btn-xs disableUser pull-right" value="'+data.id+'">Deshabilitar</button><h5 class="list-group-item-heading">'+data.name+' ('+data.level+')</h5><p class="list-group-item-text">'+data.email+' </p></div>');
					$('#confirmUser').hide();
					$('#user_list').show();
					$('#hidehr').show();
					$('#searchUser').show();
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
        if($('#lang_en').val() == 1){
          $("#page_title_en").val('');
          $("#en_title").show();
          $('#Page_keywords').val('');
          $('#en_keywords').show();
          $('#page_description_en').val('');
          $('#en_description').show();
          $('#lang_en').val(-1);
        }else{
          $("#page_title_en").val('');
          $("#en_title").hide();
          $('#Page_keywords').val('');
          $('#en_keywords').hide();
          $('#page_description_en').val('');
          $('#en_description').hide();
          $('#lang_en').val(0);
        }
  $( "#lang_en" ).change(function() {
    if($('#lang_en').val() == 0){
        $("#page_title_en").val('');
        $("#en_title").show();
        $('#Page_keywords').val('');
        $('#en_keywords').show();
        $('#page_description_en').val('');
          $('#en_description').show();
        $('#lang_en').val(1);
        console.log($('#lang_en').val());
    }else{
        $("#page_title_en").val('');
        $("#en_title").hide();
        $('#Page_keywords').val('');
        $('#en_keywords').hide();
        $('#page_description_en').val('');
        $('#en_description').hide();
        $('#lang_en').val(0);
        console.log($('#lang_en').val());
    }
  });

  $('#create_page').click(function(){
  	var clicked_btn = $(this);
  	var org_text = clicked_btn.text();
  	var identifier = $('#page_identifier').val();
  	var title = $('#page_titulo_es').val();
  	var description = $('#page_description').val();
  	var url = $('#page_url').val();
    var keywords_es = $('#Page_keywords_es').val();
    var title_en = $('#page_title_en').val();
    var description_en = $('#page_description_en').val();
    var keywords = $('#Page_keywords').val();
    var bilingual = $('#lang_en').val();
    console.log('es bilingue '+bilingual);
    console.log(''+title_en);
    console.log(''+description_en);
    console.log(''+keywords);

  	var formData = new FormData();
    formData.append("identifier",identifier);
    formData.append("title",title);
    formData.append("description",description);
    formData.append("url",url);
    formData.append("keywords_es",keywords_es);
    formData.append("bilingual",bilingual);
    if(title_en.length > 0){
      formData.append("title_en",title_en);
    }
    if(description_en.length > 0){
      formData.append("description_en",description_en);
    }
    if(keywords.length > 0){
      formData.append("keywords",keywords);
    }

    var type = "POST";
    var my_url = '/Mr_Administrator/create_page';
    	$.ajax({

  		type:type,
  		url:my_url,
      cache: false,
      contentType: false,
      processData: false,
  		data:formData,
      type:"post",
  		beforeSend: function() {
          clicked_btn.html('<i class="fa fa-refresh fa-spin lead"></i>');
        },
        success: function (data) {
        	clicked_btn.text(org_text);
        	$('#newPage').modal('hide');
        	$('#confirmAlertModal').modal('show')
        	$('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz creado una nueva pagina</strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
					var bilingue = "";
					if(bilingual == 1){
						bilingue = '<span class="label label-primary pull-right">Bilingue</span>';
					}
					tabla
            .row.add([
             '<a href="/Mr_Administrator/sudo/site/'+data.identifier+'">'+data.identifier+'</a>'+bilingue,
 						data.descripcion,
 						data.url,
 						'<button class="edit_page btn-circle btn-icon btn-success pull-left" value="'+ data.id +'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="deletePage btn-danger btn-circle btn-icon pull-right" value="'+ data.id +'"><i class="fa fa-trash" aria-hidden="true"></i></button>'
             ])
            .draw();
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
  $('#page_table').on('click','.deletePage', function(){
    var page_id = $(this).val();
    var formData = {
      id: page_id,
    }
    var type = "POST";
    var my_url = '/Mr_Administrator/deletePage';

    $.ajax({

      type: type,
      url: my_url,
      data: formData,
      success: function (data) {
        tabla
            .row( $('#page_'+page_id) )
            .remove()
            .draw();
            $('#confirmAlertModal').modal('show')
            $('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz Eliminado La pagina sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
            $('.modal-title').text('Pagina Eliminada');
            setTimeout(function(){
                  $('#confirmAlertModal').modal('hide');
              },3000);

      },
      error: function (data) {
        var errors = data.responseJSON;
        console.log(errors);
        $('#error_display').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
      }
    });
  });
  $('#page_table').on('click', '.edit_page', function() {
		var btn = $(this);
		var org_text = btn.html();
    var id = btn.val();
		var formData = new FormData();
		formData.append("id",id);
		var type = "POST";
		var my_url = '/Mr_Administrator/sudo/get_page';
		$.ajax({

			type:type,
      url:my_url,
      cache: false,
      contentType: false,
      processData: false,
      data:formData,
      type:"post",
				beforeSend: function(){
					btn.html('<i class="fa fa-refresh fa-spin lead"></i>');
				},
				success: function(data){
					btn.html(org_text);
					$('#edit_identifier').val(data.page.identifier);
					$('#edit_titulo_es').val(data.page.es_title);
					$('#edit_description').val(data.page.es_description);
					$('#edit_keywords_es').val(data.page.es_keywords);
					$('#lang_edit').val(data.page.bilingual);
					$('#edit_url').val(data.page.url);
					if(data.page.bilingual == 1){
						$('#lang_edit').val(data.page.bilingual)
						$('#edit_title_en').val(data.page.en_title);
						$('#edit_title_en').css('display', 'block !important');
						$('#en_title_edit').show();
						$('#edit_keywords').val(data.page.en_keywords);
						$('#edit_keywords').css('display', 'block !important');
						$('#en_keywords_edit').show();
						$('#edit_description_en').val(data.page.en_description);
						$('#edit_description_en').css('display', 'block !important');
						$('#en_description_edit').show();
					}
					$('#editPage').modal('show');
					$('#editPage').on('hidden.bs.modal', function () {
				    $(this).find("input,select").text('').end();
					});
				},
				error: function(data){
					btn.html(org_text);
					var errors = data.responseJSON;
	        console.log(errors);
	        $('#error_display').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
				}
		});
		id_now = id;
    console.log('este es el id'+id_now);
  });
  if($('#lang_edit').val() == 1){
          $("#edit_title_en").val('');
          $("#en_title_edit").show();
          $('#edit_keywords').val('');
          $('#en_keywords_edit').show();
          $('#edit_description_en').val('');
          $('#en_description_edit').show();
          $('#lang_edit').val(1);
        }else if($('#lang_edit').val() == 0){
          $("#edit_title_en").val('');
          $("#en_title_edit").hide();
          $('#edit_keywords').val('');
          $('#en_keywords_edit').hide();
          $('#edit_description_en').val('');
          $('#en_description_edit').hide();
          $('#lang_edit').val(0);
        }
  $( "#lang_edit" ).change(function() {
    if($('#lang_edit').val() == 0){
        $("#edit_title_en").val('');
        $("#en_title_edit").show();
        $('#edit_keywords').val('');
        $('#en_keywords_edit').show();
        $('#edit_description_en').val('');
        $('#en_description_edit').show();
        $('#lang_edit').val(1);
        console.log($('#lang_edit').val());
    }else{
        $("#edit_title_en").val('');
        $("#en_title_edit").hide();
        $('#edit_keywords').val('');
        $('#en_keywords_edit').hide();
        $('#edit_description_en').val('');
        $('#en_description_edit').hide();
        $('#lang_edit').val(0);
        console.log($('#lang_edit').val());
    }
  });

  $('#edit_page').click(function(){
    var clicked_btn = $(this);
    var org_text = clicked_btn.text();
    var identifier = $('#edit_identifier').val();
    var title = $('#edit_titulo_es').val();
    var description = $('#edit_description').val();
    var url = $('#edit_url').val();
    var keywords_es = $('#edit_keywords_es').val();
    var title_en = $('#edit_title_en').val();
    var description_en = $('#edit_description_en').val();
    var keywords = $('#edit_keywords').val();
    var bilingual = $('#lang_edit').val();
    console.log('es bilingue '+bilingual);
    console.log(''+title_en);
    console.log(''+description_en);
    console.log(''+keywords);

    var formData = new FormData();
    formData.append("id",id_now);
    formData.append("identifier",identifier);
    formData.append("title",title);
    formData.append("description",description);
    formData.append("url",url);
    formData.append("keywords_es",keywords_es);
    formData.append("bilingual",bilingual);
    if(title_en.length > 0){
      formData.append("title_en",title_en);
    }
    if(description_en.length > 0){
      formData.append("description_en",description_en);
    }
    if(keywords.length > 0){
      formData.append("keywords",keywords);
    }
    var type = "POST";
    var my_url = '/Mr_Administrator/edit_page';
      $.ajax({

      type:type,
      url:my_url,
      cache: false,
      contentType: false,
      processData: false,
      data:formData,
      type:"post",
      beforeSend: function() {
          clicked_btn.html('<i class="fa fa-refresh fa-spin lead"></i>');
        },
        success: function (data) {
          clicked_btn.text(org_text);
          $('#editPage').modal('hide');
          $('#confirmAlertModal').modal('show');
					$('.modal-title').text('Pagina Editada');
          $('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz editado la pagina '+data.identifier+' satisfactoriamente. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
          setTimeout(function(){
                  $('#confirmAlertModal').modal('hide');
              },3000);
							/**var bilingue = "";
							if(bilingual == 1){
								bilingue = '<span class="label label-primary pull-right">Bilingue</span>';
								tabla
			            .row(2)
									.data('<a href="/Mr_Administrator/sudo/site/'+data.page.identifier+'">'+data.page.identifier+'</a>'+bilingue,
		  						data.page.descripcion,
		  						data.page.url)
			            .draw();
							}else{
								tabla
			            .row(id_now)
									.data('<a href="/Mr_Administrator/sudo/site/'+data.page.identifier+'">'+data.page.identifier+'</a>'+bilingue,
		  						data.page.descripcion,
		  						data.page.url)
			            .draw();
							}*/
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
});
