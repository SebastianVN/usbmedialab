$(document).ready(function(){
  $.ajaxSetup({
  	      headers: {
  	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
  	      }
  	  });
  $('#deleteNotification').click(function(){
    var id_note = $(this).val();
    var formData = new FormData();
    formData.append("id",id_note);
    console.log(id_note+'hola')
    var my_url = '/Mr_Administrator/sudo/delete_notification';
    var type = "POST";

    $.ajax({

      type: type,
      url: my_url,
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: 'post',
      success: function(data){
        $('#confirmAlertModal').modal('show');
        $('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz Eliminado La notificación sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
        $('.modal-title').text('Notificación Eliminada');
        setTimeout(function(){
              $('#confirmAlertModal').modal('hide');
          },5000);
      },
      error: function(data){
        var errors = data.responseJSON;
        console.log(errors);
        $('#error_noti').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
      }
    });
  });
  $('#notifications').on('click','.delete_notification',function(){
    var id = $(this).val();
    var formData = new FormData();
    formData.append("id",id);
    var type = "POST";
    var my_url = '/Mr_Administrator/sudo/delete_note';

    $.ajax({

      type: type,
      url: my_url,
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: 'post',
      success: function(data){
        $('#notification_'+id).remove();
        $('#confirmAlertModal').modal('show');
        $('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz Eliminado La notificación sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
        $('.modal-title').text('Notificación Eliminada');
        setTimeout(function(){
              $('#confirmAlertModal').modal('hide');
          },5000);
      },
      error: function(data){
        var errors = data.responseJSON;
        console.log(errors);
        $('#error_noti').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
      }
    });
  });
  $('#add_b').on('click','.blockUser',function () {
    var id_user = $(this).val();
    var formData = new FormData();
    formData.append("id",id_user);
    var my_url = '/Mr_Administrator/sudo/blocked_user';
    var type = "POST";

    $.ajax({

      type: type,
      url: my_url,
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: 'post',
      success: function(data){
        $('#b_user').text('blocked');
        $('#add_b').html('<button id="unBlockUser" class="btn btn-primary btn-block" value="'+data.user.id+'" type="button">Desbloquear Usuario</button><br>')
        $('#blockUser').hide();
        $('#confirmAlertModal').modal('show');
        $('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz Bloqueado al usuario sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
        $('.modal-title').text('Usuario Bloqueado');
        setTimeout(function(){
              $('#confirmAlertModal').modal('hide');
          },5000);
      },
      error: function(data){
        var errors = data.responseJSON;
        console.log(errors);
        $('#error_noti').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
      }
    });
  });
  $('#add_b').on('click','.unBlockUser',function(){
    var id_user = $(this).val();
    var formData = new FormData();
    formData.append("id",id_user);
    var my_url = '/Mr_Administrator/sudo/unBlocked_user';
    var type = "POST";

    $.ajax({

      type: type,
      url: my_url,
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: 'post',
      success: function(data){
        $('#b_user').text('active');
        $('#add_b').html('<button id="BlockUser" class="btn btn-warning btn-block" value="'+data.user.id+'" type="button">Bloquear Usuario</button><br>')
        $('#unBlockUser').hide();
        $('#confirmAlertModal').modal('show');
        $('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz desbloqueado al usuario sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
        $('.modal-title').text('Usuario desbloqueado');
        setTimeout(function(){
              $('#confirmAlertModal').modal('hide');
          },5000);
      },
      error: function(data){
        var errors = data.responseJSON;
        console.log(errors);
        $('#error_noti').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
      }
    });
  });
  $('#deleteUser').click(function(){
    var id_user = $(this).val();
    var formData = new FormData();
    formData.append("id",id_user);
    var my_url = '/Mr_Administrator/sudo/delete_user';
    var type = "POST";

    $.ajax({

      type: type,
      url: my_url,
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: 'post',
      success: function(data){
        $('#add_b').hide();
        $('#deleteUser').hide();
        $('#user_out').html('<h3>Usuario no asociado</h3>');
        $('#confirmAlertModal').modal('show');
        $('#alertConfirmation').html('<div class="alert alert-dismissible alert-success text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><h1 class="text-success"><i class="fa fa-check" aria-hidden="true"></i></h1><br>Haz eliminado al usuario sin inconvenientes. </strong><br><br><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>');
        $('.modal-title').text('Usuario Eliminado');
        setTimeout(function(){
              $('#confirmAlertModal').modal('hide');
          },5000);
      },
      error: function(data){
        var errors = data.responseJSON;
        console.log(errors);
        $('#error_noti').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
      }
    });
  });
});
