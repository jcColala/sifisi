<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Proceso Nivel 1</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios</span>
					<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')">
				<div class="modal-body modal_body">

					<!--<div class="col-md-12 mt-3 mp-3 ">
							<button type="button" class="btn btn-outline-primary" id="add-responsable">Agregar Responsable
							</button>
						</div>-->
					<!--
						<div class="col-md-12 responsables" id="responsables">
						{{--count($responsables) === 0--}}
						<div class="fila-responsable row">
							<div class="col-md-6">
								<div class="select2-idcomision_responsable_{{$prefix}} div-select2 input-group mt-10px">
									<select class="form-control select2-show-search" id="idcomision_responsable_{{$prefix}}" name="idcomision_responsable" data-placeholder="Selecciona el puesto responsable del proceso*" style="width:100%;">
										<option label="Selecciona el puesto responsable del proceso"></option>
										{{-- -foreach($entidades as $value)-}}
										<option value="{{$value->id}}">{{--$value->descripcion--}}</option>
										{{--endforeach--}
										{{--foreach($comisiones as $value)--}}
										<option value="{{--$value->id--}}">{{--$value->descripcion--}}</option>
										{{--endforeach--}}
									</select>
									<span class="idcomision_responsable_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
								</div>
							</div>
						</div>
						{{--endif--}}
						</div>-->


					<div class="col-12">

						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Proceso Nivel 1</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Procedimientos</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Indicadores</button>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

								<div class="form-group form-row">
									<input type="hidden" name="id" id="id_{{$prefix}}">
									<input type="hidden" name="idpersona_solicita" value=" {{auth()->user()->persona->id}}" id="idpersona_solicita_{{$prefix}}">

									<div class="col-md-3">
										<div class="select2-idproceso_cero_{{$prefix}} div-select2 mrginput100_form input-group mt-10px">
											<select class="form-control select2-show-search" id="idproceso_cero_{{$prefix}}" name="idproceso_cero" data-placeholder="Selecciona el Proceso de Nivel 0.*" style="width:100%;">
												<option label="Selecciona el Responsable del Proceso"></option>
												@foreach($proceso_cero as $value)
												<option value="{{$value->id}}">{{$value->descripcion}}</option>
												@endforeach
											</select>
											<span class="focus-input100">Proceso Nivel 0*</span>
											<span class="idproceso_cero_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
										</div>
									</div>

									<div class="col-md-3">
										<div class="wrap-input100 mrginput100 validate-input">
											<input type="hidden" class="input100" id="codigo_hidde_{{$prefix}}" name="codigo_hidde">
											<input type="text" class="input100 mrginput100 validate-input" id="codigo_{{$prefix}}" name="codigo" placeholder="Código*" disabled>
											<span class="focus-input100">Código*</span>
											<span class="symbol-input100">
												<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
											</span>
											<span class="codigo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
										</div>
									</div>

									<div class="col-md-6">
										<div class="wrap-input100 mrginput100 validate-input">
											<input type="text" class="input100 mrginput100 validate-input" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Nombre del Proceso Nivel 1*">
											<span class="focus-input100">Nombre del Proceso</span>
											<span class="symbol-input100">
												<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
											</span>
											<span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
										</div>
									</div>

									<div class="col-md-2">
										<div class="wrap-input100 mrginput100 validate-input">
											<input type="text" class="input100" id="version_{{$prefix}}" name="version" placeholder="Version*">
											<span class="focus-input100">Version*</span>
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
												<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
											</span>
											<span class="fecha_aprobado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
										</div>
									</div>
									<div class="col-12 row">
										<div class="col-md-6">
											<div class="wrap-input100 mrginput100 validate-input">
												<span>Diagrama</span>
												<input type="file" class="input100" id="diagramaa_{{$prefix}}" name="diagrama" placeholder="Diagrama del Proceso*">
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
												<input type="file" class="input100" id="documentoo_{{$prefix}}" name="documento" placeholder="Documento del Proceso*">
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
										<button type="button" class="btn btn-outline-primary" id="add-procedimiento">Agregar Procedimiento
										</button>
									</div>
									<div class="col-md-12 procedimientos" id="procedimientos">
										@if(count($procedimientos) === 0)
										<div class="fila-procedimiento row">
											<div class="col-md-3">
												<div class="wrap-input100 mrginput100 validate-input">
													<input type="hidden" name="id_procedimiento" value="0">
													<input type="text" class="input100" id="codigo_procedimiento_{{$prefix}}" name="codigo_procedimiento" placeholder="Código*">
													<span class="focus-input100">Código</span>
													<span class="symbol-input100">
														<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
													</span>
													<span class="codigo_procedimiento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
												</div>
											</div>

											<div class="col-md-7">
												<div class="wrap-input100 mrginput100 validate-input">
													<input type="text" class="input100 mrginput100 validate-input" id="descripcion_procedimiento_{{$prefix}}" name="descripcion_procedimiento" placeholder="Nombre del procedimiento*">
													<span class="focus-input100">Nombre del Procedimiento</span>
													<span class="symbol-input100">
														<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
													</span>
													<span class="descripcion_procedimiento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
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
													<input type="hidden" name="id_indicador" value="0">
													<input type="text" class="input100 mrginput100 validate-input" id="codigo_indicador_{{$prefix}}" name="codigo_indicador" placeholder="Código*">
													<span class="focus-input100">Código</span>
													<span class="symbol-input100">
														<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
													</span>
													<span class="codigo_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
												</div>
											</div>

											<div class="col-md-7">
												<div class="wrap-input100 mrginput100 validate-input">
													<input type="text" class="input100 mrginput100 validate-input" id="descripcion_indicador_{{$prefix}}" name="descripcion_indicador" placeholder="Nombre del Indicador*">
													<span class="focus-input100">Nombre del Indicador</span>
													<span class="symbol-input100">
														<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
													</span>
													<span class="descripcion_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
												</div>
											</div>
										</div>
										@endif

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
	$('#proceso_cero').val(data_form.proceso_cero);
	$('#codigo_').val(data_form.codigo);
	$('#codigo_hidde_').val(data_form.codigo);
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myTab button').on('click', function(event) {
			event.preventDefault()
			$(this).tab('show')
		})
		/**--------------------INDICADORES--------------- */
		let html_indicador = '';
		let indicadores = @json($indicadores);
		indicadores.forEach(e => {
			html_indicador += '<div class="fila-indicador row"><div class="col-md-3"><div class="wrap-input100 mrginput100 validate-input"><input type="hidden" name="id_indicador" value="' + e.id + '"><input type="text" class="input100 mrginput100 validate-input" id="codigo_indicador_{{$prefix}}" name="codigo_indicador" placeholder="Código*" value="' + e.codigo + '" ><span class="focus-input100">Código</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="codigo_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-7"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100 mrginput100 validate-input" id="descripcion_indicador_{{$prefix}}" name="descripcion_indicador" placeholder="Nombre del Indicador*" value="' + e.descripcion + '"><span class="focus-input100">Nombre del Indicador*</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-indicador" >Eliminar</button></div></div></div>';
		});
		$('.indicadores').append(html_indicador);



		$("#add-indicador").click(function() {
			let html = '<div class="fila-indicador row"><div class="col-md-3"><div class="wrap-input100 mrginput100 validate-input"><input type="hidden" name="id_indicador" value="0"><input type="text" class="input100 mrginput100 validate-input" id="codigo_indicador_{{$prefix}}" name="codigo_indicador" placeholder="Código*"><span class="focus-input100">Código*</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="codigo_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-7"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100 mrginput100 validate-input" id="descripcion_indicador_{{$prefix}}" name="descripcion_indicador" placeholder="Nombre del Indicador*"><span class="focus-input100">Nombre del Indicador*</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_indicador_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-indicador" >Eliminar</button></div></div></div>';
			$('.indicadores').append(html);

		});

		$('#indicadores').on('click', '#del-indicador', function() {
			$(this).parent().parent().parent().remove();
		});
		/**---------------------------END INDICADORES---------- */


		/**--------------------PROCEDIMIENTOS--------------- */
		let html_procedimiento = '';
		let procedimientos = @json($procedimientos);
		procedimientos.forEach(e => {
			html_procedimiento += '<div class="fila-procedimiento row"><div class="col-md-3"><div class="wrap-input100 mrginput100 validate-input"><input type="hidden" name="id_procedimiento" value="' + e.id + '"><input type="text" class="input100 mrginput100 validate-input" id="codigo_procedimiento_{{$prefix}}" name="codigo_procedimiento" placeholder="Código*" value="' + e.codigo + '" ><span class="focus-input100">Código</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="codigo_procedimiento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-7"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100 mrginput100 validate-input" id="descripcion_procedimiento_{{$prefix}}" name="descripcion_procedimiento" placeholder="Nombre del procedimiento*" value="' + e.descripcion + '"><span class="focus-input100">Nombre del Procedimiento*</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_procedimiento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-procedimiento" >Eliminar</button></div></div></div>';
		});
		$('.procedimientos').append(html_procedimiento);



		$("#add-procedimiento").click(function() {
			let html = '<div class="fila-procedimiento row"><div class="col-md-3"><div class="wrap-input100 mrginput100 validate-input"><input type="hidden" name="id_procedimiento" value="0"><input type="text" class="input100 mrginput100 validate-input" id="codigo_procedimiento_{{$prefix}}" name="codigo_procedimiento" placeholder="Código*"><span class="focus-input100">Código*</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="codigo_procedimiento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-7"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100 mrginput100 validate-input" id="descripcion_procedimiento_{{$prefix}}" name="descripcion_procedimiento" placeholder="Nombre del procedimiento*"><span class="focus-input100">Nombre del Procedimiento*</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_procedimiento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-procedimiento" >Eliminar</button></div></div></div>';
			$('.procedimientos').append(html);

		});

		$('#procedimientos').on('click', '#del-procedimiento', function() {
			$(this).parent().parent().parent().remove();
		});
		/**---------------------------END PROCEDIMIENTOS---------- */




		/**--------------------RESPONSABLES ---------------- */
		/*
		let html_responsable = '';
		let responsables = {{--json($responsables)--}};
		responsables.forEach(e => {
			html_responsable += '<div class="fila-responsable row"><div class="col-md-6"><div class="select2-idcomision_responsable_{{$prefix}} div-select2 input-group mt-10px"><input type="hidden" value="' + e.id + '" name="id_responsable_hidde" ><input type="hidden" value="' + e.idcomision_responsable + '" name="idcomision_responsable" ><input type="text" value="' + e.responsable.descripcion + '" disabled class="form-control" ><span class="idcomision_responsable_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-responsable" >Eliminar</button></div></div></div>';
		});
		$('.responsables').append(html_responsable);

		$("#add-responsable").click(function() {
			let html = '<div class="fila-responsable row"><div class="col-md-6"><div class="select2-idcomision_responsable_{{$prefix}} div-select2 input-group mt-10px"><select class="form-control select2-show-search" id="idcomision_responsable_{{$prefix}}" name="idcomision_responsable" data-placeholder="Selecciona el puesto responsable del proceso*" style="width:100%;"><option label="Selecciona el puesto responsable del proceso"></option>{{--foreach($comisiones as $value)--}}<option value="{{$value->id}}">{{--$value->descripcion--}}</option>{{--endforeach--}}</select><span class="idcomision_responsable_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-2"><div class="wrap-input100 mrginput100 validate-input"><button type="button" class="btn btn-outline-danger" id="del-responsable" >Eliminar</button></div></div></div>';
			$('.responsables').append(html);

		});

		$('#responsables').on('click', '#del-responsable', function() {
			$(this).parent().parent().parent().remove();
		});*/
		/**----------------------END RESPONSABLES----------- */

		$('#idproceso_cero_').change(function(e) {
			let proceso_cero = @json($proceso_cero);
			proceso_cero.map((e) => {
				if (e.id == $(this).val()) {
					$('#codigo_').val(e.codigo + '.');
				}
			});
		});


		//! PONE EL CÓDIGO 
		$('#idproceso_cero_').change(function(e) {
			let proceso_cero = @json($proceso_cero);
			let data = @json($data);
			proceso_cero.map((e) => {
				if (e.id == $(this).val()) {
					let codigo = e.codigo;
					let numero = parseInt(e.procesos_uno.length + 1);
					if (e.id != data.idproceso_uno) {
						$('#codigo_').val(codigo + '.0' + numero);
						$('#codigo_hidde_').val(codigo + '.0' + numero);
					} else {
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