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
			<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')" >
				<div class="modal-body modal_body">
   					<input type="hidden" name="id" id="id_{{$prefix}}" >
					<input type="hidden" name="idpersona_solicita" value=" {{auth()->user()->persona->dni}}" id="idpersona_solicita_{{$prefix}}" >
   					<div class="form-group form-row">
						<div class="col-md-4">
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

						<div class="col-md-4">
   							<div class="select2-idcargo_responsable_{{$prefix}} div-select2 input-group mt-10px">
								<select class="form-control select2-show-search" id="idcargo_responsable_{{$prefix}}" name="idcargo_responsable" data-placeholder="Selecciona el Responsable del Proceso*" style="width:100%;" >
									<option label="Selecciona el Responsable del Proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idcargo_responsable_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-4">
   							<div class="select2-idtipo_proceso_{{$prefix}} div-select2 input-group mt-10px">
								<select class="form-control select2-show-search" id="idtipo_proceso_{{$prefix}}" name="idtipo_proceso" data-placeholder="Selecciona el Tipo de Proceso*" style="width:100%;" >
									<option label="Selecciona el Tipo de Proceso"></option>
									@foreach($tipo_proceso as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idtipo_proceso_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-2">
							<div class="wrap-input100 mrginput100 validate-input">
                                    <input type="text" class="input100" id="codigo_{{$prefix}}" name="codigo" placeholder="Código*">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
                                    </span>
                                    <span class="codigo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>

						<div class="col-md-6">
							<div class="wrap-input100 mrginput100 validate-input">
                                    <input type="text" class="input100" id="descripcion_{{$prefix}}" name="descripcion" placeholder="Nombre del Proceso*">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
                                    </span>
                                    <span class="descripcion_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>

						<div class="col-md-12">
							<div class="wrap-input100 mrginput100 validate-input">
									<textarea class="input100" id="objetivo_{{$prefix}}" name="objetivo" placeholder="Describe el Objetivo del Proceso*" cols="30" rows="5"></textarea>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-align-justify" aria-hidden="true"></i>
                                    </span>
                                    <span class="objetivo_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>

						<div class="col-md-12">
							<div class="wrap-input100 mrginput100 validate-input">
								<textarea name="alcance" class="input100" id="alcance_{{$prefix}}" name="alcance" placeholder="Describe el Alcance del Proceso*" cols="30" rows="5"></textarea>
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-align-justify" aria-hidden="true"></i>
                                </span>
                                <span class="alcance_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>
							<div class="col-md-12 row">
								<div class="col-md-12 text-center">
									<span><b>DESCRIPCIÓN DEL PROCESO</b></span>
								</div>
								<div class="col-md-6">
									<div class="wrap-input100 mrginput100 validate-input">
										<span><b>PROVEEDORES</b></span>
										<textarea name="proveedor" class="input100" id="proveedor_{{$prefix}}" name="proveedor" placeholder="¿Quién provee las entradas? Pueden ser internos o externos" cols="30" rows="5"></textarea>
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="fa fa-align-justify" aria-hidden="true"></i>
										</span>
										<span class="proveedor_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="wrap-input100 mrginput100 validate-input">
										<span><b>ENTRADAS</b></span>
										<textarea name="entradas" class="input100" id="entradas_{{$prefix}}" name="entradas" placeholder="¿Qué insumos se necesitan para realizar el proceso nivel 1?" cols="30" rows="5"></textarea>
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="fa fa-align-justify" aria-hidden="true"></i>
										</span>
										<span class="entradas_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
								</div>
								<div class="col-md-3">
									<div class="wrap-input100 mrginput100 validate-input">
										<span><b>CÓDIGO</b></span>
										<input type="text" class="input100" id="codigo_cero_{{$prefix}}" name="codigo_cero" placeholder="Código*">
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
										</span>
										<span class="codigo_cero_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
								</div>

								<div class="col-md-9">
									<div class="wrap-input100 mrginput100 validate-input">
										<span><b>PROCESOS NIVEL 1</b></span>
										<input type="text" class="input100" id="descripcion_cero_{{$prefix}}" name="descripcion_cero" placeholder="Nombre del Proceso*">
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
										</span>
										<span class="descripcion_cero_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="wrap-input100 mrginput100 validate-input">
										<span><b>SALIDAS</b></span>
										<textarea name="salidas" class="input100" id="salidas_{{$prefix}}" name="salidas" placeholder="¿Qué bienes y servicios genera el proceso nivel 1?" cols="30" rows="5"></textarea>
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="fa fa-align-justify" aria-hidden="true"></i>
										</span>
										<span class="salidas_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="wrap-input100 mrginput100 validate-input">
										<span><b>CLIENTES</b></span>
										<textarea name="clientes" class="input100" id="clientes_{{$prefix}}" name="clientes" placeholder="¿Quién o quienes reciben los bienes y servicios generados por el proceso? Pueden ser internos o externos" cols="30" rows="5"></textarea>
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="fa fa-align-justify" aria-hidden="true"></i>
										</span>
										<span class="clientes_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
								</div>
							</div>
						<!--<div class="col-md-12">
							<div class="wrap-input100 mrginput100 validate-input">
								<span>Diagrama del Proceso</span>
                                    <input type="file" class="input100" id="diagrama_{{$prefix}}" name="diagrama" placeholder="Diagrama del Proceso*">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
                                    </span>
                                    <span class="diagrama_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
                            </div>
                        </div>-->

						<div class="col-md-4">
   							<div class="select2-idcargo_elaborado_{{$prefix}} div-select2 input-group mt-10px">
							   <span><b>ELABORADO</b></span>
								<select class="form-control select2-show-search" id="idcargo_elaborado_{{$prefix}}" name="idcargo_elaborado" data-placeholder="Selecciona el que elaboró el proceso*" style="width:100%;" >
									<option label="Selecciona el que elaboró el proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idcargo_elaborado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-4">
   							<div class="select2-idcargo_revisado_{{$prefix}} div-select2 input-group mt-10px">
								<span><b>REVISADO</b></span>
								<select class="form-control select2-show-search" id="idcargo_revisado_{{$prefix}}" name="idcargo_revisado" data-placeholder="Selecciona el que revisó el proceso*" style="width:100%;" >
									<option label="Selecciona el que revisó el proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idcargo_revisado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
							</div>
                        </div>

						<div class="col-md-4">
   							<div class="select2-idcargo_aprobado_{{$prefix}} div-select2 input-group mt-10px">
							   <span><b>APROBADO</b></span>
								<select class="form-control select2-show-search" id="idcargo_aprobado_{{$prefix}}" name="idcargo_aprobado" data-placeholder="Selecciona el que aprobó el proceso*" style="width:100%;" >
									<option label="Selecciona el que aprobó el proceso"></option>
									@foreach($entidades as $value)
		                            	<option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        	@endforeach
								</select>
								<span class="idcargo_aprobado_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
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
</script>
<script type="text/javascript">
$(document).ready(function () {
	$('#idtipo_proceso_').change(function(e){
		let tipo_proceso = @json($proceso_cero);
		tipo_proceso.map((e) => {
			if(e.id == $(this).val()){
				$('#codigo_').val(e.codigo);
			}
		});
	});
});
</script>

<script src='{{asset("js/form/$pathController/script.js")}}'></script>
<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>


