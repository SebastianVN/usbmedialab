/*----Eliminado un usuario----*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    var tabla = $("#data-table").DataTable({
        dom: "Bfrtip", buttons: [{
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
        ], responsive: !0
    }
    );
    //Creac un nuevo proyecto
    $('#crearProyecto').on('click', function () {
        $('#crear_proyecto').modal('show');
    });
    $('#create_project').click(function () {
        var clicked_btn = $(this);
        var org_text = clicked_btn.text();
        var nombre = $('#nombre_proyecto').val();
        var lider = $('#lider_proyecto').val();
        var objetivo = $('#objetivo_proyecto').val();
        var mision = $('#mision_proyecto').val();
        var vision = $('#vision_proyecto').val();
        var formData = new FormData();
        formData.append("nombre", nombre);
        formData.append("lider", lider);
        formData.append("objetivo", objetivo);
        formData.append("mision", mision);
        formData.append("vision", vision);
        var type = "POST";
        var my_url = '/Mr_Administrator/crear_proyecto';

        $.ajax({

            type: type,
            url: my_url,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            beforeSend: function () {
                clicked_btn.html('<i class="fa fa-refresh fa-spin lead"></i>');
            },
            success: function (data) {
                clicked_btn.text(org_text);
                $('#crear_proyecto').modal('hide');
                
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
    //Eliminar proyecto
    $('#data-table').on('click', '.deleteProject', function () {
        var id = $(this).val();
        var formData = {
            id: id,
        }
        var type = "POST";
        var my_url = '/Mr_Administrator/deleteProject';

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            success: function (data) {
                tabla
                    .row($('#proyecto_' + id))
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
    //Editar proyecto
    var id_project = 0;
    $('#data-table').on('click', '.editProject', function () {
        var btn = $(this);
        var org_text = btn.html();
        var id = btn.val();
        var formData = new FormData();
        formData.append("id", id);
        var type = "POST";
        var my_url = '/Mr_Administrator/get_project';
        $.ajax({

            type: type,
            url: my_url,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: "post",
            beforeSend: function () {
                btn.html('<i class="fa fa-refresh fa-spin lead"></i>');
            },
            success: function (data) {
                btn.html(org_text);
                $('#nombre_editar').val(data.project.nombre);
                $('#lider_editar').val(data.project.lider);
                $('#objetivo_editar').val(data.project.objetivo);
                $('#mision_editar').val(data.project.mision);
                $('#vision_editar').val(data.project.vision);
                $('#editar_proyecto').modal('show');
                $('#editar_proyecto').on('hidden.bs.modal', function () {
                    $(this).find("input,select").text('').end();
                });
            },
            error: function (data) {
                btn.html(org_text);
                var errors = data.responseJSON;
                console.log(errors);
                $('#error_display').html('<p class="text-danger text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se pudo procesar la solicitud</p>');
            }
        });
        id_project = id;
        console.log('este es el id' + id_project);
    });
    $('#edit_project').click(function () {
        var clicked_btn = $(this);
        var org_text = clicked_btn.text();
        var nombre = $('#nombre_editar').val();
        var lider = $('#lider_editar').val();
        var objetivo = $('#objetivo_editar').val();
        var mision = $('#mision_editar').val();
        var vision = $('#vision_editar').val();
        var formData = new FormData();
        formData.append("id",id_project);
        formData.append("nombre", nombre);
        formData.append("lider", lider);
        formData.append("objetivo", objetivo);
        formData.append("mision", mision);
        formData.append("vision", vision);
        var type = "POST";
        var my_url = '/Mr_Administrator/editar_proyecto';

        $.ajax({

            type: type,
            url: my_url,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            beforeSend: function () {
                clicked_btn.html('<i class="fa fa-refresh fa-spin lead"></i>');
            },
            success: function (data) {
                clicked_btn.text(org_text);
                $('#editar_proyecto').modal('hide');
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