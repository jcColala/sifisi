//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable();
});

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_proceso_cero).DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        destroy: true,
        responsive: true,
        autoWidth: false,
        ordering: true,
        rowId: "id",
        bJQueryUI: true,
        ajax: route(_path_controller_proceso_cero + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: true,
                searchable: false,
                className: "text-center"
            },
            {
                data: 'descripcion',
                searchable: true
            },
            {
                data: 'activo',
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
    $('#dt-' + _path_controller_proceso_cero).on('error.dt', function(e, settings, techNote, message) {
        console.log('error ajax: ', message);
    }).DataTable();
}

//------------------------------------------------------------- Nuevo
$("#btn-new").on("click", function(e) {
    e.preventDefault();
    form.get(_path_controller_proceso_cero).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_proceso_cero);

    if (id != null) {
        form.get(_path_controller_proceso_cero).editar(id);
    } else {
        alertas.warning("Ups..!");
    }
});

$("#form-Proceso_cero").on("submit", function(e){
    e.preventDefault();
    alert('A la mrda');
});

//------------------------------------------------------------- Eliminar
$("#btn-delete_restore").on("click", function(e) {
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_proceso_cero);
    if (id != null) {
        form.get(_path_controller_proceso_cero).eliminar_restaurar(id, this);
    } else {
        alertas.warning("Ups..!");
    }
});
