<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ficha de Indicador</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
					<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')">
				<input type="hidden" name="idpersona_solicita" value="{{auth()->user()->persona->id}}" id="idpersona_solicita_{{$prefix}}">
				<div class="modal-body modal_body">
					<input type="hidden" name="id" id="id_{{$prefix}}">
					<div class="form-group form-row">

						<div class="col-md-6">
							<div class="select2-idindicador_uno_{{$prefix}} div-select2 mrginput100_form input-group mt-10px">
								<select class="form-control select2-show-search" id="idindicador_uno_{{$prefix}}" name="idindicador_uno" data-placeholder="Selecciona el tipo de proceso*" style="width:100%;" required>
									<option label="Selecciona el tipo de proceso"></option>
									@foreach($indicadores as $value)
									<option value="{{$value->id}}">{{$value->codigo}} - {{$value->descripcion}}</option>
									@endforeach
								</select>
								<span class="focus-input100">Indicadores Nivel 1*</span>
								<span class="idindicador_uno_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-2">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100 mrginput100 validate-input" id="version_{{$prefix}}" name="version" placeholder="Version*">
								<span class="focus-input100">Versión*</span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="version_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-4">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100 fc-datepicker" id="fecha_aprobado_{{$prefix}}" name="fecha_aprobado" placeholder="Fecha de Aprobación*">
								<span class="focus-input100">Fecha de Aprobación*</span>
								<span class="symbol-input100">
								</span>
								<span class="fecha_aprobado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-6">
							<div class="select2-idperiodicidad_{{$prefix}} div-select2 mrginput100_form input-group mt-10px">
								<select class="form-control select2-show-search" id="idperiodicidad_{{$prefix}}" name="idperiodicidad" data-placeholder="Selecciona la periodicidad" style="width:100%;" required>
									<option label="Selecciona la periodicidad"></option>
									@foreach($periodicidad as $value)
									<option value="{{$value->id}}">{{$value->descripcion}}</option>
									@endforeach
								</select>
								<span class="focus-input100">Periodicidad de Evaluación</span>
								<span class="idperiodicidad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						

						<!--<div class="col-md-12 mt-3 mp-3 ">
							<button type="button" class="btn btn-outline-primary" id="add-documentos" >
								Agregar Documento
							</button>
						</div>-->

						<div class="col-md-12 documentos" id="documentos">
						<div class="col-md-6">
												<div class="wrap-input100 mrginput100 validate-input">
													<span>Documento</span>
													<input type="file" class="input100" id="documento_{{$prefix}}" name="documentoo" placeholder="Documento del Proceso*">
													<span class="focus-input100"></span>
													<span class="symbol-input100">
														<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
													</span>
													<span class="documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
												</div>
											</div>
							<!--foreach($informacion as $value)
							<div class="fila-documento row">
							<div class="col-md-10">
								<div class="wrap-input100 mrginput100 validate-input">
									<input type="hidden" name="iddocumento[]" value="{{-- $value->iddocumento --}}">
									<input type="text" class="input100" id="descripcion_documentos_{{$prefix}}" name="descripcion_documentos" placeholder="Nombre del Documento*" 
									value="{{-- $value->documento->descripcion --}}"
									disabled>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
									</span>
									<span class="descripcion_documentos_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="wrap-input100 mrginput100 validate-input">
									<button type="button" class="btn btn-outline-danger" id="del-documentos" >Eliminar
									</button>
								</div>
							</div>
							</div>
							endforeach-->
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
</script>
<script>
	$(document).ready(function() {
		$("#add-documentos").click(function() {
			let html = '<div class="fila-documento row"><div class="col-md-10"><div class="select2-iddocumento_{{$prefix}} div-select2 input-group mt-10px"><select class="select2 form-control select2-show-search" id="iddocumento_{{$prefix}}" name="iddocumento[]" data-placeholder="Selecciona el que elaboró el proceso*" style="width:100%;" ><option label="Selecciona el que elaboró el proceso"></option>@foreach($documentos as $value)<option value="{{$value->id}}">{{$value->descripcion}}</option>@endforeach</select><span class="iddocumento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-documentos" >Eliminar</button></div></div></div>';
			$('.documentos').append(html);

		});

		$('#documentos').on('click', '#del-documentos', function() {
			$(this).parent().parent().parent().remove();
		});

		$(".select2").select2();
	});
</script>
<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>