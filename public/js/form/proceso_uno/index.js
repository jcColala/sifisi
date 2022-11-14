//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable();
});

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_proceso_uno).DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        destroy: true,
        responsive: true,
        autoWidth: false,
        ordering: true,
        rowId: "id",
        bJQueryUI: true,
        ajax: route(_path_controller_proceso_uno + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {
                data: 'descripcion',
                orderable: false,
                searchable: true
            },
            {
                data: 'codigo',
                orderable: false,
                searchable: true
            },
            {
                data: 'estado',
                orderable: false,
                searchable: true,
                className: "text-center"
            },

        ],
        order: [
            [1, 'ASC']
        ]
    });

    //-------------------------------------------------------- Horrores Datatable
    $('#dt-' + _path_controller_proceso_uno).on('error.dt', function(e, settings, techNote, message) {
        console.log('error ajax: ', message);
    }).DataTable();
}

//------------------------------------------------------------- IR
$("#btn-ir").on("click", function(e){
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_proceso_uno);
    if (id != null) {
        window.location.href ='proceso_uno_detalle/'+id;
    } else {
        alertas.warning("Ups..!");
    }
});

//------------------------------------------------------------- Nuevo
$("#btn-new").on("click", function(e) {
    e.preventDefault();
    form.get(_path_controller_proceso_uno).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_proceso_uno);

    if (id != null) {
        form.get(_path_controller_proceso_uno).editar(id);
    } else {
        alertas.warning("Ups..!");
    }
});

$("#form-Proceso_uno").on("submit", function(e){
    e.preventDefault();
    alert('A la mrda');
});

//------------------------------------------------------------- Eliminar
$("#btn-delete_restore").on("click", function(e) {
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_proceso_uno);
    if (id != null) {
        form.get(_path_controller_proceso_uno).eliminar_restaurar(id, this);
    } else {
        alertas.warning("Ups..!");
    }
});
