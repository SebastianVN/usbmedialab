$(document).ready(function() {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$('#delete_single').click(function(){
		var id = $(this).val();
	    var formData = {
	        id: id,
	    }
	    var type = "POST";
	    var my_url = '/Mr_Administrator/messages/sent/delete';
	    $.ajax({
	        type: type,
	        url: my_url,
	        data: formData,
	        beforeSend:function(){
	            $('#delete_single').html('<i class="fa fa-refresh fa-spin lead"></i>');
	        },
	        success: function (data) {
	        	window.location = "/Mr_Administrator/messages/sent";
	        },
	        error: function (data) {
	            var errors = data.responseText;
	            $('#display').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Se presento un error en la solicitud.<br>'+errors+'</p>');
	            $('#delete_single').text('Eliminar');
	        }
	    });
	});

	$('#delete_all').click(function(){
		var id = -21;
	    var formData = {
	        id: id,
	    }
	    var type = "POST";
	    var my_url = '/Mr_Administrator/messages/sent/delete';
	    $.ajax({
	        type: type,
	        url: my_url,
	        data: formData,
	        beforeSend:function(){
	            $('#delete_all').html('<i class="fa fa-refresh fa-spin lead"></i>');
	        },
	        success: function (data) {
	        	$('#delete_all').text('Eliminar Todos');
	        	$('#message_list').empty();
	        },
	        error: function (data) {
	            var errors = data.responseText;
	            $('#display').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Se presento un error en la solicitud.<br>'+errors+'</p>');
	            $('#delete_all').text('Eliminar Todos');
	        }
	    });
	});
});