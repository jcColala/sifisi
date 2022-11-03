const text_icono = (e, obj, _key, _paht) => {
    let valor = $('input:text[name=icono]').val()
    set_icono(_key, valor, _paht)
}

form.register(_path_controller_modulo, {
    nuevo: function() {
        get_modal(_path_controller_modulo,_prefix_modulo) 
    },
    editar: function(id) {
        get_modal(_path_controller_modulo, _prefix_modulo, "edit", id)
    },
    eliminar_restaurar: function(id, obj) {
        var $self = this
        let accion__ = obj.getAttribute('data-action')
        let textaccion__ = (accion__.substring(0, 7)) + 'ado'

        swal({ title: "Confirmar", text: "¿Desea " + accion__ + " el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

            $.ajax({
                url: route(_path_controller_modulo + '.destroy', 'delete'),
                data: { id: id, accion: accion__ },
                type: 'DELETE',
                beforeSend: function() {
                    //loading();
                },
                success: function(response) {
                    //return console.log(response)
                    toastr.success('Registro ' + textaccion__ + ' correctamente', 'Notificación modulo padre')
                    $self.callback(response)
                    init_btndelete()
                },
                complete: function() {
                    //loading("complete");
                },
                error: function(e) {
                    if (e.status == 419) {
                        console.log(msj_sesion);
                    } else if (e.status == 500) {
                        console.log((e.responseJSON.message) ? msj_soporte : ' ');
                    }
                }
            })
        })

    },
    guardar: function() {
        var $self = this;
        let _form = "#form-" + _path_controller_modulo
        let post_data = $(_form).serialize()
        post_data += "&acceso_directo="+acceso_directo_
        
        $.ajax({
            url: route(_path_controller_modulo + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            processData: false,
            beforeSend: function() {
                //loading();
            },
            success: function(response) {
                toastr.success('Datos grabados correctamente', 'Notificación modulo padre')
                $self.callback(response)
                close_modal(_path_controller_modulo)
            },
            complete: function() {
                //loading("complete");
            },
            error: function(e) {

                if (e.status == 422) { //Errores de Validacion
                    limpieza(_path_controller_modulo);
                    $.each(e.responseJSON.errors, function(i, item) {
                        $('#' + i+"_"+_prefix_modulo).addClass('is_invalid');
                        $('.select2-' + i+"_"+_prefix_modulo).addClass('select2-is_invalid');
                        $('.' + i+"_"+_prefix_modulo).removeClass('d-none');
                        $('.' + i+"_"+_prefix_modulo).attr('data-content', item);
                        $('.' + i+"_"+_prefix_modulo).addClass('msj_error_exist');

                    });
                    $("#form-" + _path_controller_modulo + " .msj_error_exist").first().popover('show');


                } else if (e.status == 419) {
                    console.log(msj_sesion);
                } else if (e.status == 500) {
                    console.log((e.responseJSON.message) ? msj_soporte : ' ');
                }
            }
        })

    },
    callback: function(data) {
        grilla.reload(_path_controller_modulo);
    }
});
