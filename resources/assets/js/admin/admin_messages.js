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
      ], responsive:!0,
      "order": [[ 4, "desc" ]]
  }
  );
  function subs_info(subscription){
    console.log(subscription);
    var res =  '<h6 class="list-group-item-heading">'+ subscription.email +'</h6>';
    res += '<p class="list-group-item-text">Reportes: ';
    switch (subscription.level) {
      case '1':
        res += 'Mensajes Nuevos';
        break;
       case '2':
        res += 'Mensajes + Reportes';
        break;
      case '4':
        res += 'Técnicos';
        break;
      default:
        return null;
    }
    if(subscription.notifications_sent){
      res += '<br>'+subscription.notifications_sent+' enviadas.<br></p>';
    }else{
      res += '<br>0 enviadas.<br></p>';
    }
    res += '<br><button class="del_sub btn btn-xs btn-danger" value="' + subscription.id +'"><i class="fa fa-trash"></i></button>';
    console.log(res);
    return(res);
  }
  $('#data-table').on('click', '.view_message', function(){
    var message_id = $(this).val();
    var formData = new FormData();
    formData.append("id", message_id);
    var type = "POST";
    var my_url = '/Mr_Administrator/messages/view';

    $.ajax({

        type: type,
        url: my_url,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        success: function (data) {
            console.log(data);
            $('.msg_from').text(data.message.name);
            $('#msg_phone').text(data.message.phone);
            $('#msg_email').text(data.message.email);
            $('#msg_msg').text(data.message.message);
            $('#msg_ip').text(data.message.ip);
            $('#msg_time').text(data.diff+' ('+data.message.created_at+')');
            $('#message_'+message_id).removeClass('warning');
            $('#messageModal').modal('show');
            $('#delete_msg').val(message_id);
            $('#unreadMessage').val(message_id);
        },
        error: function (data) {
          errors = "";
          data.foreach(function(element){
            errors = errors + element[0];
          })
          $('#errorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
        }
    });
  });

  $('#subscription_list').on('click', '.del_sub', function(){
    var sub_id = $(this).val();
    var formData = new FormData();
    formData.append("id", sub_id);
    var type = "POST";
    var my_url = '/Mr_Administrator/messages/subscription/delete';
    $.ajax({
        type: type,
        url: my_url,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        success: function () {
          $('#sub_' + sub_id).remove();
        },
        error: function (data) {
          errors = "";
          data.foreach(function(element){
            errors = errors + element[0];
          })
          $('#errorDisplay').html('<div class="alert alert-danger m-b-0"><h4><i class="fa fa-info-circle"></i> Woops</h4><p>No se pudo procesar tu solicitud</p>'+errors+'</div>');
        }
    });
  });

  /*---Eliminando Mensaje*/
  $('#data-table').on('click', '.delete_message', function(){
    var message_id = $(this).val();
    var formData = {
      id: message_id,
    }
    var type = "POST";
    var my_url = '/Mr_Administrator/messages/delete';

    $.ajax({

        type: type,
        url: my_url,
        data: formData,

        success: function(data){
          console.log(data);
          tabla
                  .row( $('#message_'+message_id) )
                  .remove()
                  .draw();

         },

        error: function(data){
          var errors = data.responseJSON;
          conosole.log(errors);
          $('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
        }
    });
  });
  /*----Elminando mensaje desde el lector----*/
  $('#messageModal').on('click', '.delete_message',function(){
    var message_id = $(this).val();
    var formData = {
      id: message_id,
    }
    var type = "POST";
    var my_url = '/Mr_Administrator/messages/delete';

    $.ajax({
        type:type,
        url: my_url,
        data: formData,

        success: function(data){
          console.log(data);
          tabla
                .row( $('#message_'+message_id) )
                .remove()
                .draw();
                $('#messageModal').modal('hide');
        },
        error: function(data){
          var errors = data.responseJSON;
          console.log(errors);
          $('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');

        }
    });
  });
  $('#messageModal').on('click','.unread_message', function(){
    var message_id = $(this).val();
    var  formData = {
      id: message_id,
    }
    var type = "POST";
    var my_url ='/Mr_Administrator/messages/unread';

    $.ajax({
       type: type,
       url: my_url,
       data: formData,

       success: function(data){
        $('#message_'+message_id).addClass('warning');
        $('#messageModal').modal('hide');
       },
       error: function(data){
        var errors = data.responseJSON;
        console.log(errors);
        $('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
       }
    });
  });

  $('#new_sub').click(function(){
    $('#save_sub').val(-1);
    $('#sub_modal').modal('show');
    $('#sub_modal_form input').val('');
  });

  $('#save_sub').click(function(){
    var sub_id = $(this).val();
    var  formData = {
      id: sub_id,
      email: $('#sub_email').val(),
      level: $('#sub_level').val(),
    }
    var type = "POST";
    var my_url ='/Mr_Administrator/messages/subscription';

    $.ajax({
       type: type,
       url: my_url,
       data: formData,

       success: function(data){
        console.log(data.subscription);
        var res = '<div class="list-group-item" id="'+data.subscription.id+'">' + subs_info(data.subscription) + '</div>';
        console.log(res);
        $('#subscription_list').append(res);
        $('#sub_modal').modal('hide');
       },
       error: function(data){
        var errors = data.responseJSON;
        console.log(errors);
        $('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
       }
    });
  });

  /*----Eliminando Todos Los mensajes----*/
  $('#delete_all').click(function(){
    var type = "POST";
    var my_url = '/Mr_Administrator/messages/delete_all';

    $.ajax({

        type: type,
        url: my_url,

        success: function(data){
          console.log(data);
          tabla
              .clear()
              .draw();
         },

        error: function(data){
          var errors = data.responseJSON;
          conosole.log(errors);
          $('#errorDisplay').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
        }
    });
  });
});
