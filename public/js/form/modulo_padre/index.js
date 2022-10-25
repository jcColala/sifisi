//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable();
});

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_modulo_padre).DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        destroy: true,
        responsive: true,
        autoWidth: false,
        ordering: true,
        rowId: "id" + _name_tabla_modulo_padre,
        bJQueryUI: true,
        ajax: route(_path_controller_modulo_padre + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {
                data: 'descripcion',
                orderable: false,
                searchable: false
            },
            {
                data: 'abreviatura',
                orderable: false,
                searchable: false
            },
            { data: 'url', name: 'url' },
            {
                data: 'icono',
                className: 'icono',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            { data: 'orden', name: 'orden', className: "text-center" },
            {
                data: 'activo',
                className: 'activo',
                orderable: false,
                searchable: false,
                className: "text-center"
            },

        ],
        order: [
            [0, 'ASC'],
            [3, 'ASC']
        ]
    });

    //-------------------------------------------------------- Horrores Datatable
    $('#dt-' + _path_controller_modulo_padre).on('error.dt', function(e, settings, techNote, message) {
        console.log('error ajax: ', message);
    }).DataTable();
}

//------------------------------------------------------------- Nuevo
$("#btn-new").on("click", function(e) {
    e.preventDefault();
    form.get(_path_controller_modulo_padre).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_modulo_padre);

    if (id != null) {
        form.get(_path_controller_modulo_padre).editar(id);
    } else {
        alertas.warning("Ups..!");
    }
});

//------------------------------------------------------------- Eliminar
$("#btn-delete").on("click", function(e) {
    e.preventDefault();
    var id = grilla.get_id(_name_tabla_modulo_padre);
    if (id != null) {
        form.get(_path_controller_modulo_padre).eliminar(id);
    } else {
        alertas.warning("Ups..!");
    }
});
