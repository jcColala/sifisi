

form.register(_path_controller_modulo, {
	_form: "#form-"+_path_controller_modulo,

    nuevo: function() {
        alert('nuevo')
        dialog.open(this._form);
    },
    cancelar: function() {
		dialog.close(this._form);
	},
    editar: function(id) {
		var $self = this;
        alert('editar')
    },
    eliminar: function(id) {
        var $self = this;
        
    },
    guardar: function(){
		var $self = this;

		
    },
    callback: function(data) {
		
	},
    reset: function() {

        $(":input", this._form).val("");
        $(arr_check).each(function(k, v){
			$("#"+v, this._form).prop("checked", false);
		});
        $("#activo", this._form).prop("checked", true);
        $("#tabla_detalle tbody").html(_table_bt);
    }
});