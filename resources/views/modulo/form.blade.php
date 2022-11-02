<div class="modal fade" id="md-modulo" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Registrar Modulo</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obrigatorios </span>
				<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body modal_body">
				<form id="form-modulo">
   					<input type="hidden" name="id" id="id" >
   					<div class="form-group form-row">
						<div class="col-md-6">
							<div class="wrap-input100 mrginput100 validate-input">
                                    <input type="text" class="input100" id="descripcion" name="descripcion" placeholder="Descripción*">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
                                    </span>
                                    <span class="descripcion zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="wrap-input100 mrginput100 validate-input">
                                    <input type="text" class="input100" id="abreviatura" name="abreviatura" placeholder="Abreviatura*">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-file-text" aria-hidden="true"></i>
                                    </span>
                                    <span class="abreviatura zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>
						<div class="col-md-4">
							<div class="wrap-input100 mrginput100 validate-input">
                                    <input type="text" class="input100" id="url" name="url" placeholder="Url">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-link" aria-hidden="true"></i>
                                    </span>
                                    <span class="url zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                        	<div class="input-group mt-10px">
								<div class="input-group-text mticono_form">
									<i id="form-icono-modulo"></i>
								</div>
								<input type="text" class="form-control pull-right" id="icono" name="icono" placeholder="Icono*" onkeyup="text_icono(event,this,'icono','modulo')">
								<div class="input-group-append">
									<button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle borderrad_tb"> Buscar</button>
									<div class="dropdown-menu dropdown-menu-right search_icono">
										@include('extras.iconos',['idicono' => 'icono'])
									</div>
								</div>
								<span class="icono zmdi zmdi-close-circle msj_error d-none riht_extra" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>
                        <div class="col-md-3">
							<div class="wrap-input100 mrginput100 validate-input">
                                    <input type="text" class="input100" id="orden" name="orden" placeholder="Orden*">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-arrow-merge" aria-hidden="true"></i>
                                    </span>
                                    <span class="orden zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>
					</div>
   				</form>
			</div>
			<div class="modal-footer border-0">
				<button type="button" onclick="md_guardar(event,this)" class="btn btn-primary" data-acciones="guardar-modulo">Guardar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	data_form = @json($data);
</script>
<script src='{{asset("js/form/modulo/script.js")}}'></script>
<script src="{{asset('js/custom.js')}}"></script>