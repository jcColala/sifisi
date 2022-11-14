//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable();
});

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_funcion).DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        destroy: true,
        responsive: true,
        autoWidth: false,
        ordering: true,
        rowId: "id",
        bJQueryUI: true,
        ajax: route(_path_controller_funcion + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            { data: 'nombre' },
            { data: 'funcion' },
            { data: 'orden' },
            {
                data: 'estado',
                orderable: false,
                searchable: false,
                className: "text-center"
            },

        ],
        order: [
            [3, 'ASC']
        ]
    });

    //-------------------------------------------------------- Horrores Datatable
    $('#dt-' + _path_controller_funcion).on('error.dt', function(e, settings, techNote, message) {
        console.log('error ajax: ', message);
    }).DataTable();
}

//------------------------------------------------------------- Nuevo
$("#btn-new").on("click", function(e) {
    e.preventDefault();
    form.get(_path_controller_funcion).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_funcion);

    if (id != null) {
        form.get(_path_controller_funcion).editar(id);
    } else {
        alertas.warning("Ups..!");
    }
});

//------------------------------------------------------------- Eliminar
$("#btn-delete_restore").on("click", function(e) {
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_funcion);
    if (id != null) {
        form.get(_path_controller_funcion).eliminar_restaurar(id, this);
    } else {
        alertas.warning("Ups..!");
    }
});
