//------------------------------------------------------------- Variables globales
let selected = ''

//------------------------------------------------------------- Cambiar tema
$(".cambiar_tema").on("click", function(e) {
    let actual = ($("#body").attr("data-tema") == 1)? 2:1 
    $.ajax({
            url:route('tema',actual),
            type:'GET',
            beforeSend: function() {
                
            },
            success: function(response) {
                $("#body").removeClass("dark-mode")
                $("#body").attr("data-tema",actual)
                if(actual == 2)
                    $("#body").addClass("dark-mode")
            },
            complete: function () {
                
            },
            error: function() {
                if(e.status==419){
                    console.log("La sesión ya expiró, por favor cierre sesión y vuelva a ingresar");
                }else if(e.status==500){
                    console.log((e.responseJSON.message)??'Hubo problemas internos, por favor comunicate de inmediato con SOPORTE');
                }
            }
        });
})
//------------------------------------------------------------- Select tr
$(".databale").on('click', 'tr', function() {
    selected = table.row(this).data();

    if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
    } else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
});
//------------------------------------------------------------- Alertas
var alertas = function() {

    function warning(titulo='',texto='Seleccione un registro.',tipo='warning',texto_bnt='Entendido') {
        swal({
            title: titulo,
            text: texto,
            type: tipo,
            confirmButtonText: texto_bnt
        })
    }
    return { warning: warning };

}();

//------------------------------------------------------------- Grilla
var grilla = function() {

    function _get_real_id(idobject) {
        if ($("table[realid='" + idobject + "']").length == 1) {
            var table = "dt-" + idobject;

            var realId = "#" + table;

            if ($.fn.DataTable.isDataTable(realId)) {
                return table;
            } else {
                console.log(idobject + " podria no ser una instancia de DataTables");
            }
        } else {
            console.log("El objeto DOM no existe o existe mas de una instancia para " + idobject);
        }

        return false;
    }

    function get_data(idobject, iRow) {
        var table = _get_real_id(idobject);

        if (table !== false) {
            var api = $("#" + table).DataTable();

            if (iRow === undefined) {
                //console.log(api);
                if (api.$("tr.selected").length) {
                    iRow = api.$("tr.selected");
                } else if (api.$("tr.DTTT_selected[role='row']").length) {
                    iRow = api.$("tr.DTTT_selected[role='row']");
                }
            }

            if (iRow !== undefined) {
                return api.row(iRow).id() || null;
            }
        }
        return null;
    }

    function get_id(idobject, iRow) {
        var row = get_data(idobject, iRow);

        if (row != null) {
            return row;
        }
        return null;
    }

    return { get_id: get_id, get_data: get_data };

}();

//------------------------------------------------------------- Modal
var form = function() {
    var aControllers = [];

    function clearfix(keyvar) {
        keyvar = $.trim(keyvar);
        keyvar = keyvar.replace(/\W+/g, "");
        keyvar = keyvar.replace(/\s+/g, "");
        return keyvar;
    }

    function register(key, val, replace) {
        key = clearfix(key);

        if (typeof replace != "boolean")
            replace = false;

        if (key != "") {
            if (replace === true) { // nueva asignacion
                aControllers[key] = val;
            } else if (!(key in aControllers)) { // no existe el registro
                aControllers[key] = val;
            } else if (!$.isPlainObject(val)) { // no es un objeto
                aControllers[key] = val;
            } else if ($.isEmptyObject(val)) { // objeto esta vacio
                aControllers[key] = val;
            } else { // extendemos nomas
                var object = $.extend({}, get(key), val);
                aControllers[key] = object;
            }
        }
    }

    function get(key) {
        key = clearfix(key);
        if (!(key in aControllers)) {
            console.log("key " + key + " not found");
            return {};
        }

        return aControllers[key];
    }

    return { register: register, get: get }
}();


