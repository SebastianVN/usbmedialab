var nombre_busqueda;
var apellido_busqueda;
var id_busqueda;
var estado_previo;

$('#enableSeller').click(function(){
	$('#search_results').html('no hay resultados');
    $('#enableSellerModal').modal('show');
});

$('.check_project').click(function(){
    var id = parseInt($(this).val());
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var type = "GET";
    var my_url = '/SalesTeam/Proyectos/check/'+id;

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        beforeSend:function(){
                $('#search_results').html('<i class="fa fa-refresh fa-spin lead"></i>');
            },
        success: function (data) {
            if(data == -1){
                $('#project_details').html('Error Ubicando Proyecto');
            }else{
                $('#project_info_name').text(data.project_name);
                $('#project_details').html(data.response);
            }
            $('#infoProjectModal').modal('show');
        },
        error: function (data) {
            var errors = data.responseJSON;
            console.log(errors);
            $('#project_details').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Error Procesando Solicitud.</p>');
        }
    });
});

$('#project_details').on('click', '.take_project', function(){
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
    var my_url = '/SalesTeam/Proyectos/take';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        beforeSend: function(){
            $( "#project_details" ).fadeOut( "slow", function() {});
            $( "#project_details" ).html();
        },
        success: function (data) {
            if(data == "success"){
                $("#project_details").html('<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Felicidades</strong><br>El proyecto es tuyo<br><br><button type="button" class="btn btn-default" data-dismiss="modal">Terminar</button></div>');
            }else if(data == "taken"){
                $("#project_details").html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Casi!</strong><br>Casi lo coges, pero alguien mas te ganó<br><br><button type="button" class="btn btn-default" data-dismiss="modal">Terminar</button></div>');
            }
            $( "#project_details" ).fadeIn( "slow", function() {});
        },
        error: function (data) {
            var errors = data.responseJSON;
            $("#project_details").html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Error Procesando Solicitud<br></div>');
            $( "#project_details" ).fadeIn( "slow", function() {});
        }
    });
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
	var my_url = '/Mr_Administrator/sales/enable';

	//console.log(formData);

	$.ajax({

	    type: type,
	    url: my_url,
	    data: formData,
	    success: function (data) {
	        $('#enableSellerModal').modal('hide');
	        $('#confirmEnableSellerModal').modal('show');
            estado_previo = data.estado;
            id_busqueda = data.usuario.id;
            nombre_busqueda = data.usuario.name;
            apellido_busqueda = data.usuario.surname;
	        if(data.estado == "habilitado"){
	        	$("#enablingConfirmation").html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'+nombre_busqueda+' '+apellido_busqueda+' ya es parte del Sales Team,</strong><br>¿Lo quieres deshabilitar?<br><br><br><button value="enable" class="btn btn-danger enable_action">Deshabilitar</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button></div>');
	        }else if(data.estado == "deshabilitado"){
                $("#enablingConfirmation").html('<div class="alert alert-dismissible alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'+nombre_busqueda+' '+apellido_busqueda+' aún no hace parte del Sales Team,</strong><br>¿Lo quieres habilitar?<br><br><br><button value="disable" class="btn btn-success enable_action">Habilitar</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button></div>');
	        }

	    },
	    error: function (data) {
	        var errors = data.responseJSON;
	        $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudieron guardar los cambios :/ quizas fue el email?</p>');
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
    var my_url = '/Mr_Administrator/sales/change';

    //console.log(formData);

    $.ajax({

        type: type,
        url: my_url,
        data: formData,
        success: function (data) {
            $("#enablingConfirmation").html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz ' + data + ' a '+nombre_busqueda+' '+apellido_busqueda+' como miembro del Sales Team,</strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
            setTimeout(function(){
                $('#confirmEnableSellerModal').modal('hide');
            },3000);
        },
        error: function (data) {
            var errors = data.responseJSON;
            $('#info-error').html('<p class="tex-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudieron guardar los cambios :/ quizas fue el email?</p>');
        }
    });
});