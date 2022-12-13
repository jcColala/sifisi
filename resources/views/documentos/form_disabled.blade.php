<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ver Documento</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
					<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')">
				<input type="hidden" name="idpersona_solicita" value=" {{auth()->user()->persona->id}}" id="idpersona_solicita_{{$prefix}}">
				<div class="modal-body modal_body">
					<input type="hidden" name="id" id="id_{{$prefix}}">
					<div class="form-group form-row">
						<div class="col-md-4">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="codigo_{{$prefix}}" name="codigo" placeholder="Código*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="codigo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-8">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Nombre del Proceso*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-2">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="version_{{$prefix}}" name="version" placeholder="Version*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="version_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-3">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="date" class="input100" id="fecha_emision_{{$prefix}}" name="fecha_emision" placeholder="Fecha de Emisión*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="fecha_emision_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-3">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="date" class="input100" id="fecha_aprobacion_{{$prefix}}" name="fecha_aprobacion" placeholder="Fecha de Aprobación*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="fecha_aprobacion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-4">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="ubicacion_fisica_{{$prefix}}" name="ubicacion_fisica" placeholder="Ubicación Física*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="ubicacion_fisica_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="file" class="input100" id="archivo_{{$prefix}}" name="archivo[]" 
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
								</span>
								<span class="archivo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>
						<div class="col-md-4">
   							<div class="select2-idtipo_documento_{{$prefix}} div-select2 input-group mt-10px">
							    <span><b>Tipo de Documento</b></span>
								<select class="form-control select2-show-search" id="idtipo_documento_{{$prefix}}" name="idtipo_documento" data-placeholder="Selecciona el que elaboró el proceso*" style="width:100%;"
								disabled >
									<option label="Selecciona el que elaboró el proceso"></option>
									@foreach($tipo_documentos as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idtipo_documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-4">
   							<div class="select2-identidad_{{$prefix}} div-select2 input-group mt-10px">
							    <span><b>Elaborado por:</b></span>
								<select class="form-control select2-show-search" id="identidad_{{$prefix}}" name="identidad" data-placeholder="Selecciona el que elaboró el proceso*" style="width:100%;" disabled>
									<option label="Selecciona el que elaboró el proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="identidad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-4">
   							<div class="select2-idresolucion_{{$prefix}} div-select2 input-group mt-10px">
							    <span><b>Resolución</b></span>
								<select class="form-control select2-show-search" id="idresolucion_{{$prefix}}" name="idresolucion" data-placeholder="Selecciona el que elaboró el proceso*" style="width:100%;" 
								disabled>
									<option label="Selecciona el que elaboró el proceso"></option>
									@foreach($resoluciones as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idresolucion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>
						<div class="col-md-2">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="porcentaje_{{$prefix}}" name="porcentaje" placeholder="100%*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="porcentaje_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	data_form = @json($data);
</script>

<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>