//------------------------------------------------------------- Variables globales
var mostrar_ = "N"

$("#form-" + _path_controller_funcion + " input").on("focus", function(e) {
    $("#form-" + _path_controller_funcion + " .msj_error_exist").first().popover('hide')
})

//------------------------------------------------------------- Mostrar
$("#mostrar_" + _prefix_funcion).on("change", function(e) {
    e.preventDefault();
    mostrar_ = mostrar_ == "N" ? "S" : "N"
})


function init() {
    if ($("#mostrar_" + _prefix_funcion).val() == "S")
        $("#formostrar_" + _prefix_funcion).click()
}
