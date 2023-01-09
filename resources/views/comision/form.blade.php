<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document"> 
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> Registrar Comisi&oacute;n</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
				<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')" autocomplete="off">
				<div class="modal-body modal_body modal_bodytabs">
   					<input type="hidden" name="id" id="id_{{$prefix}}" >
					<input type="hidden" name="idcreador" id="idcreador_{{$prefix}}" value="{{auth()->user()->persona->id}}">
					<div class="panel panel-primary">
						<div class="tab-menu-heading">
							<div class="tabs-menu">
								<ul class="nav panel-tabs">
									<li ><a href="#tab1" class="active" data-toggle="tab">Datos b&aacute;sicos</a></li>
									<li><a href="#tab2" data-toggle="tab">Responsables</a></li>
								</ul>
							</div>
						</div>
						<div class="panel-body tabs-menu-body">
							<div class="tab-content">
								<div class="tab-pane active " id="tab1">
									<div class="form-group form-row">
										<div class="col-md-12">
											<div class="wrap-input100 mrginput100 validate-input">
				                                    <input type="text" class="input100" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Descripci&oacute;n*">
				                                    <span class="focus-input100">Descripci&oacute;n*</span>
				                                    <span class="symbol-input100">
				                                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
				                                    </span>
				                                    <span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
				                            </div>
				                        </div>
										<div class="col-md-7">
				                            <div class="wrap-input100 mrginput100 validate-input">
				                                    <input type="text" class="input100" id="abreviatura_{{$prefix}}" name="abreviatura" placeholder="Abreviatura*">
				                                    <span class="focus-input100">Abreviatura*</span>
				                                    <span class="symbol-input100">
				                                        <i class="zmdi zmdi-file-text" aria-hidden="true"></i>
				                                    </span>
				                                    <span class="abreviatura_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
				                            </div>
				                        </div>
				                        <div class="col-md-5">
				                            <div class="wrap-input100 mrginput100 validate-input">
				                                    <input type="text" class="input100" id="resolucion_{{$prefix}}" name="resolucion" placeholder="Resoluci&oacute;n*">
				                                    <span class="focus-input100">Resoluci&oacute;n*</span>
				                                    <span class="symbol-input100">
				                                        <i class="zmdi zmdi-file-text" aria-hidden="true"></i>
				                                    </span>
				                                    <span class="resolucion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
				                            </div>
				                        </div>
				                        <div class="col-md-4">
				                            <div class="wrap-input100 mrginput100 validate-input">
				                                    <input type="text" class="input100 fc-datepicker" id="fecha_inicio_{{$prefix}}" name="fecha_inicio" placeholder="Fecha inicio*">
				                                    <span class="focus-input100">Fecha inicio*</span>
				                                    <span class="symbol-input100">
				                                        <i class="zmdi zmdi-calendar" aria-hidden="true"></i>
				                                    </span>
				                                    <span class="fecha_inicio_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
				                            </div>
				                        </div>
				                        <div class="col-md-4">
				                            <div class="wrap-input100 mrginput100 validate-input">
				                                    <input type="text" class="input100 fc-datepicker" id="fecha_fin_{{$prefix}}" name="fecha_fin" placeholder="Fecha fin*">
				                                    <span class="focus-input100">Fecha fin*</span>
				                                    <span class="symbol-input100">
				                                        <i class="zmdi zmdi-calendar" aria-hidden="true"></i>
				                                    </span>
				                                    <span class="fecha_fin_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
				                            </div>
				                        </div>
				                        <div class="col-md-4">
				                        	<div class="input-group mt-10px">
				                        		<label class="custom-switch mt-10px pl-2px">
													<input type="checkbox" class="custom-switch-input" id="especiales_{{$prefix}}">
													<span id="forespeciales_{{$prefix}}" class="custom-switch-indicator">si</span>
													<span class="custom-switch-description"> Comisi&oacute;n Especial?</span>
												</label>
				                        	</div>
				                    	</div>
									</div>
								</div>
								<div class="tab-pane " id="tab2">
									<div class="form-group form-row">
										<div class="col-md-12">
											<div class="wrap-input100 mrginput100 validate-input">
													<input type="hidden" id="idresponsable_{{$prefix}}" name="idresponsable">
													<div id="autocomplete" class="autocomplete">
														<input type="text" class="input100" id="persona_nombres_{{$prefix}}" name="persona_nombres" placeholder="Buscar responsable*">
					                                    <span class="focus-input100">Buscar responsable*</span>
					                                    <span class="symbol-input100">
					                                        <i class="mdi mdi-account-search" aria-hidden="true"></i>
					                                    </span>
													  	<ul class="autocomplete-result-list"></ul>
													</div>
				                                    <span class="idresponsable_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
				                            </div>
				                        </div>
				                        <div class="col-md-12">
				                        	<div class="mt-10px">
												<div class="grid-margin">
													<div class="">
														<!-- Template responsable ---->
		                                                <template id="template_responsable">
		                                                	<tr>
																<td class="nro_responsable text-center">1</td>
																<td class="nrodocumento_responsable"></td>
																<td class="nombres_responsable"></td>
																<td class="presidente_responsable text-center">
																	<label class="custom-control custom-radio table_checkbox">
																		<input type="radio" class="custom-control-input" name="presidente" id="presidente">
																		<span class="custom-control-label">Seleccionar</span>
																	</label>
																</td>
																<td class="text-center">
																	<button type="button" class="btn_eliminar btn btn-icon  btn-danger mw-2em btn_ptb"><i class="fe fe-trash"></i></button>
																</td>
															</tr>
		                                                </template>
														<div class="table-responsive">
															<table class="table card-table table-vcenter text-nowrap table-writhe align-items-center mb-0">
																<thead class="bg-primary text-white">
																	<tr>
																		<th width="05%" class="text-center text-white">#</th>
																		<th width="20%" class="text-white">Nro. Documento</th>
																		<th width="50%" class="text-white">Responsable</th>
																		<th width="20%" class="text-center text-white">Presidente</th>
																		<th width="05%" class="text-center text-white"></th>
																	</tr>
																</thead>
																<tbody id="table_responsable">
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
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
	var data_responsable = @json($data_responsable);

</script>
<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>


