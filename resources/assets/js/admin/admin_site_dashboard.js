$(document).ready(function() {
	$.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	      }
	  });

	var current_icon = "none";
	$('#edit_social_media').click(function(){
		console.log("wtf sevin!");
	  $('#social_media_modal').modal('show');
	});

	$('#edit_footer').click(function(){
	  $('#edit_footer_modal').modal('show');
	});

	$('#edit_schedule').click(function(){
	  $('#schedule_editor_modal').modal('show');
	});

	$('#add_social').click(function(){
	  $('#add_social').hide(420);
	  $('#symbol_pool').show(420);
	});

	$('#footer_cancel').click(function(){
	  $('#footer_editor_form').hide(420);
	  $('#footer_editor').show(420);
	});

	$('#footer_save').click(function(){
      var identifier = $(this).val();
      var value = $('#footer_editor_input').val();
	  var type = "post";
	  var my_url = '/Mr_Administrator/save_footer';
	  var formData = new FormData();
	  formData.append("identifier", identifier);
	  formData.append("value", value);

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
	      	$('#footer_editor_form').hide(420);
	      	$('#footer_editor').show(420);
	      	$('#footer_'+identifier).html(value);
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

	$('#save_schedule').click(function(){
      var value = $('#schedule').val();
	  var type = "post";
	  var my_url = '/Mr_Administrator/save_footer';
	  var formData = new FormData();
	  formData.append("value", value);
	  formData.append("identifier", "schedule");
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
	      	$('#schedule_editor_modal').modal('hide');
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

	$('#footer_editor').on('click', '.footer_item', function(){
	  var identifier = $(this).val();
	  $('#footer_editor').hide(420);
	  $('#footer_editor_form').show(420);
	  var current_value = $('#footer_'+identifier).html();
	  console.log(current_value);
	  current_descripton = $('#footer_'+identifier).data('description');
	  $('#footer_editor_input').val(current_value);
	  $('#footer_save').val(identifier);
	  $('#footer_editor_display').text(current_descripton);
	});

	$('#symbol_pool').on('click', '.symbol_btn', function(){
	  var icon = $(this).val();
	  var icon_html = '<i class="fa fa-'+icon+'" aria-hidden="true"></i>';
	  $('#icon_preview').html(icon_html);
	  current_icon = icon;
	  $('#symbol_pool').hide(420);
	  $('#naming_box').show(420);
	});

	$('#cancel_social').click(function(){
	  $('#social_title').val('');
	  $('#social_identifier').val('');
	  $('#naming_box').hide(420);
	  $('#add_social').show(420);
	});

	$('#social_title').keyup(function() {
	    var filtrado = $('#social_title').val();
	    filtrado = filtrado.replace(/[^a-zA-Z0-9-_]/g, '_');
	    $('#social_identifier').val(filtrado);
	});

	$('#save_social').click(function(){
	  var type = "post";
	  var my_url = '/Mr_Administrator/save_social';
	  icon = current_icon;
	  console.log(icon);
	  var title = $('#social_title').val();
	  console.log(title);
	  var identifier = $('#social_identifier').val();
	  console.log(identifier);
	  var original_url = $('#social_url').val();
	  var social_url = encodeURIComponent(original_url);
	  console.log(social_url);

	  var formData = new FormData();
	  formData.append("icon", icon);
	  formData.append("name", title);
	  formData.append("identifier", identifier);
	  formData.append("url", social_url);

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
	      	$('#social_title').val('');
	      	$('#social_identifier').val('');
	      	$('#naming_box').hide(420);
	      	$('#add_social').show(420);
	      	new_item = '<li id="social_'+data.social.id+'"class="list-group-item"><a href="'+original_url+'"><i class="fa fa-'+icon+'" aria-hidden="true"></i> '+title+'</a><button class="btn btn-xs btn-danger pull-right delete_social" value="'+data.social.id+'"><i class="fa fa-trash" aria-hidden="true"></i></button></li>';
	      	$('#social_group').append(new_item);
	      	$('#naming_box').hide(420);
	      	$('#add_social').show(420);
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

	$('#social_group').on('click', '.delete_social', function(){
		var id = $(this).val();
		var type = "post";
		var my_url = '/Mr_Administrator/delete_social';
		var formData = new FormData();
		formData.append("id", id);

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
		    	$('#social_'+id).remove();
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
});
