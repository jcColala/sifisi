<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Resolución</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios.* </span>
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

						<div class="col-md-8">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Resolucion*">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
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

									<div class="col-md-8">
											<div class="wrap-input100 mrginput100 validate-input">
												
												<input type="file" class="input100" id="documentoo_{{$prefix}}" name="documento" placeholder="Documento del Proceso*">
												<span class="focus-input100"></span>
												<span class="symbol-input100">
													<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
												</span>
												<span class="documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
											</div>
										</div>
						
						<div class="col-md-12 mt-3 mp-3 ">
										<button type="button" class="btn btn-outline-primary" id="add-documento">Agregar Documento
										</button>
									</div>
						<div class="col-md-12  documentos" id="documentos" >
						<div class="fila-documentos row">
						<div class="col-md-4">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="codigo_documento_{{$prefix}}" name="codigo_documento" placeholder="Código*">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="codigo_documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>

						<div class="col-md-8">
							<div class="wrap-input100 mrginput100 validate-input">
								<input type="text" class="input100" id="descripcion_documento_{{$prefix}}" name="descripcion_documento" placeholder="Nombre del Documento*">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
								</span>
								<span class="descripcion_documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
						</div>
	
									<div class="col-md-3">
										<div class="wrap-input100 mrginput100 validate-input">
											<input type="text" class="input100" id="version_documento_{{$prefix}}" name="version_documento" placeholder="Version*">
											<span class="focus-input100">Version*</span>
											<span class="symbol-input100">
												<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
											</span>
											<span class="version_documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
										</div>
									</div>
									<div class="col-md-5">
											<div class="wrap-input100 mrginput100 validate-input">
												
												<input type="file" class="input100" id="documentoo_{{$prefix}}" name="archivo_documento" placeholder="Documento del Proceso*">
												<span class="focus-input100"></span>
												<span class="symbol-input100">
													<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
												</span>
												<span class="documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
											</div>
										</div>
						</div><br>
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
			$("#add-documento").click(function() {
			let html = '<div class="fila-documentos row"><div class="col-md-4"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100" id="codigo_documento_{{$prefix}}" name="codigo_documento" placeholder="Código*"><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="codigo_documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-8"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100" id="descripcion_documento_{{$prefix}}" name="descripcion_documento" placeholder="Nombre del Documento*"><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="descripcion_documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-3"><div class="wrap-input100 mrginput100 validate-input"><input type="text" class="input100" id="version_documento_{{$prefix}}" name="version_documento" placeholder="Version*"><span class="focus-input100">Version*</span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="version_documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div><div class="col-md-5"><div class="wrap-input100 mrginput100 validate-input"><input type="file" class="input100" id="documentoo_{{$prefix}}" name="archivo_documento" placeholder="Documento del Proceso*"><span class="focus-input100"></span><span class="symbol-input100"><i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i></span><span class="documento_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span></div></div></div><br>';
			$('.documentos').append(html);

		});

		$('#documentos').on('click', '#del-documento', function() {
			$(this).parent().parent().parent().remove();
		});
</script>

<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>