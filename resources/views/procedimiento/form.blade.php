<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Procedimiento</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios</span>
					<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')">
				<div class="modal-body modal_body">
					<input type="hidden" name="id" id="id_{{$prefix}}">
					<input type="hidden" name="idpersona_solicita" value=" {{auth()->user()->persona->id}}" id="idpersona_solicita_{{$prefix}}">
					<div class="form-group form-row">
						<div class="col-12">
							<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Procedimiento</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Actividades</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Indicadores</button>
								</li>
							</ul>
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
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

										<div class="col-md-9">
											<div class="wrap-input100 mrginput100 validate-input">
												<input type="text" class="input100" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Nombre del Procedimiento*" disabled>
												<span class="focus-input100"></span>
												<span class="symbol-input100">
													<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
												</span>
												<span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
											</div>
										</div>
										<div class="col-md-2">
											<div class="wrap-input100 mrginput100 validate-input">
												<input type="text" class="input100" id="version_{{$prefix}}" name="version" placeholder="Version*">
												<span class="focus-input100"></span>
												<span class="symbol-input100">
													<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
												</span>
												<span class="version_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
											</div>
										</div>

										<div class="col-md-4">
											<div class="wrap-input100 mrginput100 validate-input">
												<input type="date" class="input100" id="fecha_aprobado_{{$prefix}}" name="fecha_aprobado" placeholder="Fecha de Aprobación*">
												<span class="focus-input100"></span>
												<span class="symbol-input100">
													<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
												</span>
												<span class="fecha_aprobado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
											</div>
										</div>

										<div class="col-12 row">
											<div class="col-md-6">
												<div class="wrap-input100 mrginput100 validate-input">
													<span>Diagrama</span>
													<input type="file" class="input100" id="diagrama_{{$prefix}}" name="diagramaa" placeholder="Diagrama del Proceso*">
													<span class="focus-input100"></span>
													<span class="symbol-input100">
														<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
													</span>
													<span class="diagrama_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
												</div>
											</div>

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
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
									<div class="form-group form-row">
										<div class="col-md-12 mt-3 mp-3 ">
											<button type="button" class="btn btn-outline-primary" id="add-actividad">Agregar Actividad
											</button>
										</div>

										<div class="col-md-12 actividades" id="actividades">
											@if(count($actividades) == 0)
											<div class="fila-actividad row">
												<div class="col-md-6">
													<div class="wrap-input100 mrginput100 validate-input">
														<input type="hidden" name="id_actividad">
														<input type="text" class="input100" id="descripcion_actividad_{{$prefix}}" name="descripcion_actividad" placeholder="Nombre del actividad*">
														<span class="focus-input100"></span>
														<span class="symbol-input100">
															<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
														</span>
														<span class="descripcion_actividad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="select2-idresponsable_actividad_{{$prefix}} div-select2 input-group mt-10px">
														<select class="form-control select2-show-search" id="idresponsable_actividad_{{$prefix}}" name="idresponsable_actividad" data-placeholder="Selecciona el puesto responsable del procedimiento*" style="width:100%;">
															<option label="Selecciona el puesto responsable del procedimiento"></option>
															@foreach($comisiones as $value)
															<option value="{{$value->id}}">{{$value->descripcion}}</option>
															@endforeach
														</select>
														<span class="idresponsable_actividad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
													</div>

												</div>
											</div>
											@endif
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
									<div class="form-group form-row">
										<div class="col-md-12 mt-3 mp-3 ">
											<button type="button" class="btn btn-outline-primary" id="add-indicador">Agregar Indicador
											</button>
										</div>

										<div class="col-md-12 indicadores" id="indicadores">
											@if(count($indicadores) === 0)
											<div class="fila-indicador row">
												<div class="col-md-3">
													<div class="wrap-input100 mrginput100 validate-input">
														<input type="text" class="input100" id="codigo_indicador_{{$prefix}}" name="codigo_indicador" placeholder="Código*">
														<span class="focus-input100"></span>
														<span class="symbol-input100">
															<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
														</span>
														<span class="codigo_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
													</div>
												</div>

												<div class="col-md-7">
													<div class="wrap-input100 mrginput100 validate-input">
														<input type="text" class="input100" id="descripcion_indicador_{{$prefix}}" name="descripcion_indicador" placeholder="Nombre del Indicador*">
														<span class="focus-input100"></span>
														<span class="symbol-input100">
															<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
														</span>
														<span class="descripcion_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
													</div>
												</div>

												<!--<div class="col-md-2">
										<div class="wrap-input100 mrginput100 validate-input">
											<button type="button" class="btn btn-outline-danger" id="del-indicador" >Eliminar
											</button>
										</div>
									</div>-->
											</div>
											@endif

										</div>
									</div>
								</div>
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
	$('#proceso_uno').val(data_form.proceso_uno);
	$('#codigo_').val(data_form.codigo);
	$('#codigo_hidde_').val(data_form.codigo);
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myTab button').on('click', function(event) {
			event.preventDefault()
			$(this).tab('show')
		})

		/* -- PINTAR INDICADORES EN CASO DE EDITAR */
		let html_indicador = '';
		let indicadores = @json($indicadores);
		indicadores.forEach(e => {
			html_indicador += '<div class="fila-indicador row"><div class="col-md-3"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100" id="codigo_indicador_{{$prefix}}" name="codigo_indicador" placeholder="Código*" value="' + e.codigo + '" ><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="codigo_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-7"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100" id="descripcion_indicador_{{$prefix}}" name="descripcion_indicador" placeholder="Nombre del Indicador*" value="' + e.descripcion + '"><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-indicador" >Eliminar</button></div></div></div>';
		});
		$('.indicadores').append(html_indicador);
		/*---------------END---------------*/
		let html_actividad = '';
		let actividades = @json($actividades);
		actividades.forEach(e => {
			html_actividad += '<div class="fila-actividad row"><div class="col-md-6"><div class="wrap-input100 mrginput100 validate-input"><input type="hidden" name="id_actividad" value="' + e.id + '"><input type="text" class="input100" id="descripcion_actividad_{{$prefix}}" name="descripcion_actividad" placeholder="Nombre del actividad*" value="' + e.descripcion + '"><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_actividad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-4"><div class="select2-idresponsable_actividad_{{$prefix}} div-select2 input-group mt-10px"><select class="form-control select2-show-search" id="idresponsable_actividad_{{$prefix}}" name="idresponsable_actividad" data-placeholder="Selecciona el puesto responsable del proceso*" style="width:100%;"><option label="Selecciona el puesto responsable del proceso"></option>@foreach($comisiones as $value)<option value="{{$value->id}}">{{$value->descripcion}}</option>@endforeach</select><span class="idresponsable_actividad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-10"><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-actividad" >Eliminar</button></div></div></div>';
		});
		$('.actividades').append(html_actividad);
		/**--PINTAR ACTIVIDADES EN CASO DE EDITAR */

		/**END */
		$("#add-indicador").click(function() {
			let html = '<div class="fila-indicador row"><div class="col-md-3"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100" id="codigo_indicador_{{$prefix}}" name="codigo_indicador" placeholder="Código*"><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="codigo_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-7"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100" id="descripcion_indicador_{{$prefix}}" name="descripcion_indicador" placeholder="Nombre del Indicador*"><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-indicador" >Eliminar</button></div></div></div>';
			$('.indicadores').append(html);

		});

		$('#indicadores').on('click', '#del-indicador', function() {
			$(this).parent().parent().parent().remove();
		});


		$("#add-actividad").click(function() {
			let html = '<div class="fila-actividad row"><div class="col-md-6"><div class="wrap-input100 mrginput100 validate-input"><input type="hidden" name="id_actividad"><input type="text" class="input100" id="descripcion_actividad_{{$prefix}}" name="descripcion_actividad" placeholder="Nombre del actividad*"><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_actividad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-4"><div class="select2-idresponsable_actividad_{{$prefix}} div-select2 input-group mt-10px"><select class="form-control select2-show-search" id="idresponsable_actividad_{{$prefix}}" name="idresponsable_actividad" data-placeholder="Selecciona el puesto responsable del proceso*" style="width:100%;"><option label="Selecciona el puesto responsable del proceso"></option>@foreach($comisiones as $value)<option value="{{$value->id}}">{{$value->descripcion}}</option>@endforeach</select><span class="idresponsable_actividad_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-1"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-actividad" >Eliminar</button></div></div></div>';
			$('.actividades').append(html);

		});

		$('#actividades').on('click', '#del-actividad', function() {
			$(this).parent().parent().parent().remove();
		});

	});
</script>

<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>