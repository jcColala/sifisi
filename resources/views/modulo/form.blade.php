<div class="modal fade" id="md-{{$pathController}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Registrar {{$modulo}}</h5>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
				<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')">
				<div class="modal-body modal_body">
   					<input type="hidden" name="id" id="id_{{$prefix}}" >
   					<div class="row">
   						<div class="col-md-8">
   							<div class="form-group form-row">
		   						<div class="col-md-6"> 
		   							<div class="select2-idmodulo_padre_{{$prefix}} div-select2 mrginput100_form input-group mt-10px">
										<select class="form-control select2-show-search" id="idmodulo_padre_{{$prefix}}" name="idmodulo_padre" data-placeholder="Selecciona el modulo padre*" style="width:100%;" required >
											<option label="Selecciona el modulo padre"></option>
											@foreach($modulo_padre as $value)
				                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
				                        	@endforeach
										</select>
                                    	<span class="focus-input100">Selecciona el modulo padre*</span>
										<span class="idmodulo_padre_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
		                        </div>
		                        <div class="col-md-6">
		   							<div class="div-select2 mrginput100_form input-group mt-10px">
										<select class="form-control select2-show-search" id="idpadre_{{$prefix}}" name="idpadre" data-placeholder="Selecciona el padre" style="width:100%;" required>
											<option label="Selecciona el padre"></option>
										</select>
                                    	<span class="focus-input100">Selecciona el padre</span>
									</div>
		                        </div>
								<div class="col-md-6">
									<div class="wrap-input100 mrginput100 validate-input">
		                                    <input type="text" class="input100" id="modulo_{{$prefix}}" name="modulo" placeholder="Modulo*">
		                                    <span class="focus-input100">Modulo*</span>
		                                    <span class="symbol-input100">
		                                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
		                                    </span>
		                                    <span class="modulo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
		                            </div>
		                        </div>
								<div class="col-md-6">
		                            <div class="wrap-input100 mrginput100 validate-input">
		                                    <input type="text" class="input100" id="abreviatura_{{$prefix}}" name="abreviatura" placeholder="Abreviatura">
		                                    <span class="focus-input100">Abreviatura</span>
		                                    <span class="symbol-input100">
		                                        <i class="zmdi zmdi-file-text" aria-hidden="true"></i>
		                                    </span>
		                                    <span class="abreviatura_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
		                            </div>
		                        </div>
								<div class="col-md-6">
									<div class="wrap-input100 mrginput100 validate-input">
		                                    <input type="text" class="input100" id="url_{{$prefix}}" name="url" placeholder="Url">
		                                    <span class="focus-input100">Url</span>
		                                    <span class="symbol-input100">
		                                        <i class="zmdi zmdi-link" aria-hidden="true"></i>
		                                    </span>
		                                    <span class="url_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
		                            </div>
		                        </div>
		                        <div class="col-md-6">
		                        	<div class="input-group mrginput100_form mt-10px">
										<div class="input-group-text mticono_form">
											<i id="form-icono-{{$pathController}}"></i>
										</div>
										<input type="text" class="form-control pull-right" id="icono_{{$prefix}}" name="icono" placeholder="Icono" onkeyup="text_icono(event,this,'icono','{{$pathController}}')">
                                		<span class="focus-input100">Icono</span>
										<div class="input-group-append">
											<button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle borderrad_tb"> Buscar</button>
											<div class="dropdown-menu dropdown-menu-right search_icono">
												@include('extras.iconos',['idicono' => 'icono', 'modulo' => $pathController, 'prefix' => $prefix])
											</div>
										</div>
										<span class="icono_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extra" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
		                        </div>
		                        <div class="col-md-4">
									<div class="wrap-input100 mrginput100 validate-input">
		                                    <input type="text" class="input100" id="orden_{{$prefix}}" name="orden" placeholder="Orden*">
		                                    <span class="focus-input100">Orden*</span>
		                                    <span class="symbol-input100">
		                                        <i class="zmdi zmdi-arrow-merge" aria-hidden="true"></i>
		                                    </span>
		                                    <span class="orden_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
		                            </div>
		                        </div>
		                        <div class="col-md-4">
		                        	<div class="input-group mt-10px">
		                        		<label class="custom-switch mt-10px pl-2px">
											<input type="checkbox" class="custom-switch-input" id="acceso_directo_{{$prefix}}">
											<span id="foracceso_directo_{{$prefix}}" class="custom-switch-indicator">si</span>
											<span class="custom-switch-description"> ¿Acceso Directo?</span>
										</label>
		                        	</div>
		                    	</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group form-row">
		   						<div class="col-md-12">
		   							<div class="div-select2 mrginput100_form input-group mt-10px">
										<select class="form-control select2-show-search" id="idfuncion_{{$prefix}}" name="idfuncion" onchange="select_funcion(event,this)" data-placeholder="Agreagar función" style="width:100%;" required>
											<option label="Agreagar función"></option>
											@foreach($funcion as $value)
				                            	<option value="{{$value->id}}" data-nombre="{{$value->nombre}}"  data-icono="{{$value->icono}}" >{{$value->nombre}}</option>
				                        	@endforeach 
										</select>
                                    	<span class="focus-input100">Agreagar función</span>
									</div>
		                        </div>
		                        <div class="col-md-12">
		                        	<div class="mt-10px">
										<div class="grid-margin">
											<div class="">
												<!-- Template funcion ---->
                                                <template id="template_funcion">
                                                	<tr>
														<td class="nro_funcion text-center">1</td>
														<td class="nombre_funcion text-center font-weight-600">
															<i></i>
															<span></span>
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
																<th width="70%" class="text-center text-white">Funci&oacute;n</th>
																<th width="25%" class="text-center text-white"></th>
															</tr>
														</thead>
														<tbody id="table_funcion">
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
	var funcion_modulo = @json($funcion_modulo);
</script>
<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>



