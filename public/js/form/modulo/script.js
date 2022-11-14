//------------------------------------------------------------- Variables globales
var acceso_directo_ = "N"

//------------------------------------------------------------- Focus
$("#form-" + _path_controller_modulo + " input").on("focus", function(e) {
    $("#form-" + _path_controller_modulo + " .msj_error_exist").first().popover('hide')
})

$(".div-select2").on("click", function(e) {
    $("#form-" + _path_controller_modulo + " .msj_error_exist").first().popover('hide')
})

//------------------------------------------------------------- Acceso directo
$("#acceso_directo_" + _prefix_modulo).on("change", function(e) {
    e.preventDefault();
    acceso_directo_ = acceso_directo_=="N"?"S":"N"
})

//------------------------------------------------------------- modulos padre
$("#idmodulo_padre_" + _prefix_modulo).on("change", function(e) {
    e.preventDefault();
    get_modulos($(this).val())
})

function get_modulos(idmodulo_padre) {
    $.ajax({
        url: route(_path_controller_modulo + '.get_modulos'),
        type: 'GET',
        data: { idmodulo_padre: idmodulo_padre, id: $("#id_" + _prefix_modulo).val() },
        dataType: 'json',
        beforeSend: function() {
            //loading();
        },
        success: function(response) {
            let list = []
            var seleccion__ = -1
            list  = "<option label='Selecciona el padre'></option>";
            list += "<option value=' '>Selecciona el padre</option>";

            if (data_form != [])
                seleccion__ = data_form["idpadre"]

            $(response).each(function(key, val) {
                let selected__ = ""
                if(val["id"] == seleccion__)
                    selected__ = "selected"
                list += "<option value='" + val["id"] + "' "+selected__+" >" + val["modulo"] + "</option>";
            });
            $("#idpadre_" + _prefix_modulo).html(list);
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
}

function init() {
    if($("#acceso_directo_"+_prefix_modulo).val() == "S")
        $("#foracceso_directo_"+_prefix_modulo).click()
    
    let idmodulo_padre = $("#idmodulo_padre_" + _prefix_modulo).val()
    if (idmodulo_padre)
        get_modulos(idmodulo_padre)
}
