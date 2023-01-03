<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ver Entidad</h5>
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
					<input type="hidden" name="idpersona_solicita" value="{{auth()->user()->persona->id}}" id="idpersona_solicita_{{$prefix}}" >
   					<div class="form-group form-row">
						<div class="col-md-8">
							<div class="wrap-input100 mrginput100 validate-input">
                                    <input type="text" class="input100" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Descripción*"
									disabled>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
                                    </span>
                                    <span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>
						<div class="col-md-4">
							<div class="wrap-input100 mrginput100 validate-input">
                                    <input type="text" class="input100" id="idpersona_responsable_{{$prefix}}" name="idpersona_responsable" placeholder="Cantidad Integrantes*"
									disabled>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
                                    </span>
                                    <span class="idpersona_responsable_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
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


