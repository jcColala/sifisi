<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Proceso Nivel 0</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
					<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')" >
				<input type="hidden" name="idpersona_solicita" value=" {{auth()->user()->persona->id}}" id="idpersona_solicita_{{$prefix}}">
				<div class="modal-body modal_body">
					<input type="hidden" name="id" id="id_{{$prefix}}">
					<div class="form-group form-row">
						
								<div class="col-md-6"> 
		   							<div class="select2-idtipo_proceso_{{$prefix}} div-select2 mrginput100_form input-group mt-10px">
										<select class="form-control select2-show-search" id="idtipo_proceso_{{$prefix}}" name="idtipo_proceso" data-placeholder="Selecciona el tipo de proceso*" style="width:100%;" required >
											<option label="Selecciona el tipo de proceso"></option>
											@foreach($tipo_proceso as $value)
				                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
				                        	@endforeach
										</select>
                                    	<span class="focus-input100">Tipo de Proceso*</span>
										<span class="idtipo_proceso_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
		                        </div>

						<div class="col-md-6">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="hidden" id="codigo_hidde_{{$prefix}}" name="codigo_hidde">
								<input type="text" class="input100 mrginput100 validate-input" id="codigo_{{$prefix}}" name="codigo" placeholder="Código*"
								disabled>
								<span class="focus-input100">Código*</span>
								<span class="symbol-input100">
								</span>
								<span class="codigo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-12">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100 mrginput100 validate-input" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Nombre del Proceso de Nivel 0*">
								<span class="focus-input100">Nombre del Proceso de Nivel 0</span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="submit" id="btn-save" onclick="md_guardar(event,'btn-save')" class="btn btn-primary" data-acciones="guardar-{{$pathController}}">Guardar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	data_form = @json($data);
	$('#idtipo_proceso_').val(data_form.idtipo_proceso);
	$('#codigo_').val(data_form.codigo);
	$('#codigo_hidde_').val(data_form.codigo);
</script>
<script type="text/javascript">
	$(document).ready(function() {

		$('#idtipo_proceso_').change(function(e) {
			let tipo_proceso = @json($tipo_proceso);
			let data = @json($data);
			tipo_proceso.map((e) => {
				if (e.id == $(this).val()) {
					let codigo = e.codigo;
					let numero = parseInt(e.procesos_cero.length+1);
					if(e.id != data.idtipo_proceso){
						$('#codigo_').val(codigo+'.0'+numero);
						$('#codigo_hidde_').val(codigo+'.0'+numero);
					}else{
						$('#codigo_').val(data.codigo);
						$('#codigo_hidde_').val(data.codigo);
					}
					
				}
			});
		});
	});
</script>

<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>