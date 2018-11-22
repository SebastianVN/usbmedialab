/*----Eliminado un usuario----*/
$(document).ready(function() {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});
	var tabla = $("#data-table").DataTable( {
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
	$('#data-table').on('click','.deleteUser', function(){
		var user_id = $(this).val();
		var formData = {
			id: user_id,
		}
		var type = "POST";
		var my_url = '/Mr_Administrator/deleteUser';

		$.ajax({

			type: type,
			url: my_url,
			data: formData,
			success: function (data) {
				tabla
						.row( $('#user_'+user_id) )
						.remove()
						.draw();
			},
			error: function (data) {
				var errors = data.responseJSON;
				console.log(errors);
				$('#error_display').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
			}
		});
	});
});
/*----Creacion de Usuario----*/
