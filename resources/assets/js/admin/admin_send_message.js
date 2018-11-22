$(document).ready(function() {
  var to_array = new Array();

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });

  var editor = CKEDITOR.replace( 'editor1',
          {
              height : '500',
          });    

    $('#search_user').click(function(){
        $('#search_results').html('no hay resultados');
        $('#enableUserModal').modal('show');
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
                    $("#search_results").append('<li id="search_result_'+obj.id+'" class="list-group-item">'+obj.name+' '+obj.surname+' <small>('+obj.email+')</small><button class="add_user_list btn btn-warning pull-right btn-xs" value="'+obj.id+'" data-name="'+obj.name+'" data-surname="'+obj.surname+'" data-email="'+obj.email+'">Agregar a la Lista</button></li>');
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
    
    $('#search_results').on('click','.add_user_list', function(){
        var send_id = $(this).val();
        if(to_array.indexOf(send_id) == -1){
          var email = $(this).attr('data-email');
          var nombre = $(this).attr('data-name') + ' ' + $(this).attr('data-surname');
          var elemento = '<div id="to_'+send_id+'" data-id="'+send_id+'" class="list-group-item"><h4 class="list-group-item-heading">'+ nombre +'<button class="btn btn-xs btn-danger pull-right remove_to" value="' + send_id + '"><i class="fa fa-trash" aria-hidden="true"></i></button></h4><p class="list-group-item-text">'+ email +'</p></div>';
          $('#sending_to').append(elemento);
          to_array.push(send_id);
          $(this).prop('disabled', true);
          $(this).removeClass('btn-warning');
          $(this).addClass('btn-default');
          $(this).text("Agregado")
        }else{
          alert("Ya incluiste este usuario en la lista");
        }
    });

    $('#sending_to').on('click','.remove_to', function(){
        var delete_id = parseInt($(this).val());
        var del_position = to_array.indexOf(delete_id);
        to_array.splice(del_position, 1);
        $('#to_'+delete_id).remove();
    });

    $('#to_all').click(function(){
        var org_btn = $(this).text();
        var type = "POST";
        var my_url = '/Mr_Administrator/messages/add_all';
        $.ajax({
            type: type,
            url: my_url,
            beforeSend:function(){
                  $(this).html('<i class="fa fa-refresh fa-spin lead"></i>');
                },
            success: function (data) {
              $('#contenido_error').html('<p class="text-success text-center"><i class="fa fa-check" aria-hidden="true"></i> Mensaje Enviado.</p>');
              $('#to_all').html(org_btn);
              data.users.forEach(function(user){
                if(to_array.indexOf(user.id) == -1){
                  var elemento = '<div id="to_'+user.id+'" data-id="'+user.id+'" class="list-group-item"><h4 class="list-group-item-heading">'+ user.name + ' ' +  user.surname + '<button class="btn btn-xs btn-danger pull-right remove_to" value="' + user.id + '"><i class="fa fa-trash" aria-hidden="true"></i></button></h4><p class="list-group-item-text">'+ user.email +'</p></div>';
                  $('#sending_to').append(elemento);
                  to_array.push(user.id);
                }                
              })
            },
            error: function (data) {
                $('#contenido_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Se presento un error en la solicitud.</p>');
                var errors =  JSON.parse(data.responseText);
                console.log(errors);
                for (var prop in errors) {
                  if(!errors.hasOwnProperty(prop)) continue;
                  console.log(prop + " = " + errors[prop]);
                  $('#'+prop+'_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+errors[prop]+'</p>');
                }
                $(this).html(org_btn);
            }
        });
    });

    $('#send_message').click(function(){
        var org_btn = $('#send_message').text();
        var from = $('#from').val();
        var subject = $('#subject').val();
        var message = editor.getData();
        var formData = {
            from: from,
            subject: subject,
            to_array: to_array,
            message: message,
        }
        var type = "POST";
        var my_url = '/Mr_Administrator/messages/send_message';
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            beforeSend:function(){
                  $('#send_message').html('<i class="fa fa-refresh fa-spin lead"></i>');
                },
            success: function (data) {
              $('#contenido_error').html('<p class="text-success text-center"><i class="fa fa-check" aria-hidden="true"></i> Mensaje Enviado.</p>');
              $('#send_message').html(org_btn);
              $('#display').html('\
                <div class="alert alert-dismissible alert-success text-center">\
                  <button type="button" class="close" data-dismiss="alert">&times;</button>\
                  <h4>Email enviado</h4>\
                  <a href="/Mr_Administrator/messages/sent" class="btn btn-sm btn-info">Ver Correos Enviados</a>\
                </div>\
                ');

            },
            error: function (data) {
                $('#contenido_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Se presento un error en la solicitud.</p>');
                var errors =  JSON.parse(data.responseText);
                console.log(errors);
                for (var prop in errors) {
                  if(!errors.hasOwnProperty(prop)) continue;
                  console.log(prop + " = " + errors[prop]);
                  $('#'+prop+'_error').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+errors[prop]+'</p>');
                }
                $('#send_message').html(org_btn);
            }
        });
    });
});