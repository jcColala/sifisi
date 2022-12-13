<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ver Ficha de Indicador</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
					<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')">
				<input type="hidden" name="idpersona_solicita" value=" {{auth()->user()->persona->dni}}" id="idpersona_solicita_{{$prefix}}">
				<div class="modal-body modal_body">
					<input type="hidden" name="id" id="id_{{$prefix}}">
					<div class="form-group form-row">
						<div class="col-md-3">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="codigo_{{$prefix}}" name="codigo" placeholder="Código*" disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="codigo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-7">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Nombre del Indicador*" disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-2">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="version_ficha_{{$prefix}}" name="version_ficha" placeholder="Version*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="version_ficha_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-4">
   							<div class="select2-idresponsable_{{$prefix}} div-select2 input-group mt-10px">
							    <span><b>RESPONSABLE:</b></span>
								<select class="form-control select2-show-search" id="idresponsable_{{$prefix}}" name="idresponsable" data-placeholder="Selecciona el que elaboró el proceso*" style="width:100%;" 
								disabled>
									<option label="Selecciona el que elaboró el proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idresponsable_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-12">

							<div class="wrap-input100 mrginput100 validate-input">
								<textarea class="input100" id="objetivo_{{$prefix}}" name="objetivo" placeholder="Describe el Objetivo del Indicador*" cols="30" rows="5"
								disabled></textarea>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-align-justify" aria-hidden="true"></i>
								</span>
								<span class="objetivo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-12">
							<div class="wrap-input100 mrginput100 validate-input">
								<textarea name="variables" class="input100" id="variables_{{$prefix}}" name="variables" placeholder="Describe el variables del Indicador*" cols="30" rows="5"
								disabled></textarea>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-align-justify" aria-hidden="true"></i>
								</span>
								<span class="variables_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-12">
							<div class="wrap-input100 mrginput100 validate-input">
								<textarea name="calculo" class="input100" id="calculo_{{$prefix}}" name="calculo" placeholder="Describe el calculo del Indicador*" cols="30" rows="5"
								disabled></textarea>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-align-justify" aria-hidden="true"></i>
								</span>
								<span class="calculo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						
						<div class="col-md-4">
							<div class="wrap-input100 mrginput100 validate-input">
									<span><b>FECHA DE APROBACIÓN:</b></span>
                                    <input type="date" class="input100" id="fecha_aprobacion_{{$prefix}}" name="fecha_aprobacion" placeholder="Fecha de Aprobación*" 
									disabled>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                    </span>
                                    <span class="fecha_aprobacion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>

						<div class="col-md-4">
   							<div class="select2-idperiodicidad_{{$prefix}} div-select2 input-group mt-10px">
							    <span><b>PERIODICIDAD:</b></span>
								<select class="form-control select2-show-search" id="idperiodicidad_{{$prefix}}" name="idperiodicidad" data-placeholder="¨Periodicidad del Indicador*" style="width:100%;" 
								disabled>
									<option label="Periodicidad"></option>
									@foreach($periodicidad as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idperiodicidad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-4">
							<div class="wrap-input100 mrginput100 validate-input">

								<span><b>PORCENTAJE:</b></span>
								<input type="text" class="input100" id="porcentaje_{{$prefix}}" name="porcentaje" placeholder="Porcentaje del Indicador*"
								disabled>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									
								</span>
								<span class="porcentaje_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-12 mt-3 mp-3 ">
							<button type="button" class="btn btn-outline-primary" id="add-documentos" >
								Agregar Documento
							</button>
						</div>

						<div class="col-md-12 documentos" id="documentos" >
							@foreach($informacion as $value)
							<div class="fila-documento row">
							<div class="col-md-10">
								<div class="wrap-input100 mrginput100 validate-input">
									<input type="hidden" name="iddocumento[]" value="{{$value->iddocumento}}"
									>
									<input type="text" class="input100" id="descripcion_documentos_{{$prefix}}" name="descripcion_documentos" placeholder="Nombre del Documento*" 
									value="{{$value->documento->descripcion}}"
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
							@endforeach
						</div>

						<div class="col-md-4">
   							<div class="select2-idelaborado_{{$prefix}} div-select2 input-group mt-10px">
							    <span><b>ELABORADO POR:</b></span>
								<select class="form-control select2-show-search" id="idelaborado_{{$prefix}}" name="idelaborado" data-placeholder="Selecciona el que elaboró el proceso*" style="width:100%;" 
								disabled>
									<option label="Selecciona el que elaboró el proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idelaborado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-4">
   							<div class="select2-idrevisado_{{$prefix}} div-select2 input-group mt-10px">
								<span><b>REVISADO POR:</b></span>
								<select class="form-control select2-show-search" id="idrevisado_{{$prefix}}" name="idrevisado" data-placeholder="Selecciona el que revisó el proceso*" style="width:100%;" 
								disabled>
									<option label="Selecciona el que revisó el proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idrevisado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-4">
   							<div class="select2-idaprobado_{{$prefix}} div-select2 input-group mt-10px">
							   <span><b>APROBADO POR:</b></span>
								<select class="form-control select2-show-search" id="idaprobado_{{$prefix}}" name="idaprobado" data-placeholder="Selecciona el que aprobó el proceso*" style="width:100%;" 
								disabled>
									<option label="Selecciona el que aprobó el proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idaprobado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
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
<script>
	$(document).ready(function () {
		$("#add-documentos").click(function () {
		let html = '<div class="fila-documento row"><div class="col-md-10"><div class="select2-iddocumento_{{$prefix}} div-select2 input-group mt-10px"><select class="select2 form-control select2-show-search" id="iddocumento_{{$prefix}}" name="iddocumento[]" data-placeholder="Selecciona el que elaboró el proceso*" style="width:100%;" ><option label="Selecciona el que elaboró el proceso"></option>@foreach($documentos as $value)<option value="{{$value->id}}">{{$value->descripcion}}</option>@endforeach</select><span class="iddocumento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-documentos" >Eliminar</button></div></div></div>';
		$('.documentos').append(html);

	});

	 $('#documentos').on('click', '#del-documentos', function(){
		$(this).parent().parent().parent().remove();
	 });

	 $(".select2").select2();
	});
</script>
<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>