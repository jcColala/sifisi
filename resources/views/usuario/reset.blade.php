<div class="modal fade" id="md-{{$pathController}}_reset" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
				<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')" >
				<div class="modal-body modal_body">
   					<input type="hidden" name="id" id="id_{{$prefix}}" >
   					<div class="form-group form-row">
						<div class="col-md-6">
							<div class="wrap-input100 mrginput100 validate-input mt-0">
									<strong class="form_strong">Nombre completo</strong>
                                    <input type="text" class="input100 pdd_0" id="persona_nombres_{{$prefix}}" name="persona_nombres" disabled="true">
                          
                            </div>
                        </div>
                        <div class="col-md-6">
							<div class="wrap-input100 mrginput100 validate-input mt-0">
									<strong class="form_strong">Usuario</strong>
                                    <input type="text" class="input100 pdd_0" id="usuario_{{$prefix}}" name="usuario" disabled="true">
                          
                            </div>
                        </div>
                        <div class="col-md-6">
		                            <div class="wrap-input100 mrginput100 validate-input">
		                                    <input type="password" class="input100" id="password_{{$prefix}}" name="password" placeholder="Contraseña*" autocomplete="new-password">
		                                    <span class="focus-input100"></span>
		                                    <span class="symbol-input100">
		                                        <i class="zmdi zmdi-key" aria-hidden="true"></i>
		                                    </span>
		                                    <span class="password_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
		                            </div>
		                        </div>
		                        <div class="col-md-6">
		                            <div class="wrap-input100 mrginput100 validate-input">
		                                    <input type="password" class="input100" id="password_confirmation_{{$prefix}}" name="password_confirmation" placeholder="Confirmar contraseña*">
		                                    <span class="focus-input100"></span>
		                                    <span class="symbol-input100">
		                                        <i class="zmdi zmdi-key" aria-hidden="true"></i>
		                                    </span>
		                            </div>
		                        </div>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="submit" id="btn-save" onclick="md_guardar(event,'btn-save')" class="btn btn-primary" data-acciones="guardar_reset-{{$pathController}}">Guardar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
   			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	reset_true = true
	data_form  = @json($data);
</script>
<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>


