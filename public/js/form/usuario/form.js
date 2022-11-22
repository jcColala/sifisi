//------------------------------------------------------------- Datos editar
if (data_form.length != 0) {
    init()
}

//------------------------------------------------------------- Focus
$("#form-" + _path_controller_usuario + " input").on("focus", function(e) {
    $("#form-" + _path_controller_usuario + " .msj_error_exist").first().popover('hide')
    $("#form-" + _path_controller_usuario + " .avatar_" + _prefix_usuario).first().popover('hide')
})

$(".div-select2").on("click", function(e) {
    $("#form-" + _path_controller_usuario + " .msj_error_exist").first().popover('hide')
})

//------------------------------------------------------------- Init
function init() {
    $.each(data_form, function(key, val) {
        if (key == 'avatar') {
            if (val != null) {
                $(".div_avatar_" + _prefix_usuario).html('<input type="file" class="dropify" id="avatar_' + _prefix_usuario + '" name="avatar" data-default-file="' + data_form.path_file + val + '" data-height="200" />')
                $("#" + key + "_" + _prefix_usuario, "#form-" + _path_controller_usuario).dropify()
            }
        } else {
            $("#" + key + "_" + _prefix_usuario, "#form-" + _path_controller_usuario).val(val)
        }
    })
    $("#password_" + _prefix_usuario, "#form-" + _path_controller_usuario).val("******")
    $("#password_confirmation_" + _prefix_usuario, "#form-" + _path_controller_usuario).val("******")
    $("#password_" + _prefix_usuario, "#form-" + _path_controller_usuario).attr("disabled", true)
    $("#password_confirmation_" + _prefix_usuario, "#form-" + _path_controller_usuario).attr("disabled", true)
    console.log(data_form);
}

//------------------------------------------------------------- Cancelar
$(document).on("click", "#cancelar_" + _prefix_usuario, function(e) {
    e.preventDefault();
    window.location.href = route(_path_controller_usuario + ".index");
});


form.register(_path_controller_usuario, {
    nuevo: function() {
        get_modal(_path_controller_usuario, _prefix_usuario)
    },
    editar: function(id) {
        get_modal(_path_controller_usuario, _prefix_usuario, "edit", id)
    },
    eliminar_restaurar: function(id, obj) {
        var $self = this
        let accion__ = obj.getAttribute('data-action')
        let textaccion__ = (accion__.substring(0, 7)) + 'ado'

        swal({ title: "Confirmar", text: "¿Desea " + accion__ + " el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

            $.ajax({
                url: route(_path_controller_usuario + '.destroy', 'delete'),
                data: { id: id, accion: accion__ },
                type: 'DELETE',
                beforeSend: function() {
                    //loading();
                },
                success: function(response) {
                    //return console.log(response)
                    toastr.success('Registro ' + textaccion__ + ' correctamente', 'Notificación módulo ' + _path_controller_usuario)
                    $self.callback(response)
                    init_btndelete()
                },
                complete: function() {
                    //loading("complete");
                },
                error: function(e) {
                    mostrar_errores_externos(e)
                }
            })
        })

    },
    guardar: function() {
        var $self = this;
        let _form = "#form-" + _path_controller_usuario
        let post_data = new FormData($(_form)[0]);

        $.ajax({
            url: route(_path_controller_usuario + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                //loading();
            },
            success: function(response) {
                localStorage.usuario = "Datos grabados correctamente."
                $("#cancelar_" + _prefix_usuario).trigger("click");
            },
            complete: function() {
                //loading("complete");
            },
            error: function(e) {

                //Msj($("#descripcion"), "Ingrese Descripcion ","","above",false)
                if (e.status == 422) { //Errores de Validacion
                    limpieza(_path_controller_usuario);
                    $(".avatar_" + _prefix_usuario).removeClass("bg-danger text-white")
                    $.each(e.responseJSON.errors, function(i, item) {
                        if (i == 'invalide_img') {
                            toastr.error(item, 'Notificación módulo ' + _path_controller_usuario)
                            $(".avatar_" + _prefix_usuario).addClass("bg-danger text-white")
                            $(".avatar_" + _prefix_usuario).first().popover('show');

                        }
                        $('#' + i + "_" + _prefix_usuario).addClass('is_invalid');
                        $('.select2-' + i + "_" + _prefix_usuario).addClass('select2-is_invalid');
                        $('.' + i + "_" + _prefix_usuario).removeClass('d-none');
                        $('.' + i + "_" + _prefix_usuario).attr('data-content', item);
                        $('.' + i + "_" + _prefix_usuario).addClass('msj_error_exist');

                    });
                    $("#form-" + _path_controller_usuario + " .msj_error_exist").first().popover('show');


                } else {
                    mostrar_errores_externos(e)
                }

            }
        })

    },
    callback: function(data) {
        grilla.reload(_path_controller_usuario);
    }
});