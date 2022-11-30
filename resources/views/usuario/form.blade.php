@extends('layouts.app')
@section('content')
<div class="page-header">
	<!-- START NAVBAR Header -->
	@include('layouts.navbar',['title'=>"$modulo",'modulo'=>"$modulo",'paht'=>'Index'])
	<!-- END NAVBAR Header -->
</div>
<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Registrar {{"$modulo"}}</h3>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
				<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
			</div>
			<div class="card-body pdd_card_body">
				<form id="form-{{$pathController}}" onsubmit="md_guardar(event,'btn-save')" autocomplete="off">
   					<input type="hidden" name="id" id="id_{{$prefix}}" >
   					<div class="row">
   						<div class="col-md-7">
		   					<div class="form-group form-row">
								<div class="col-md-12">
									<div class="wrap-input100 mrginput100 validate-input">
											<input type="hidden" id="idpersona_{{$prefix}}" name="idpersona">
											<div id="autocomplete" class="autocomplete">
												<input type="text" class="input100" id="persona_nombres_{{$prefix}}" name="persona_nombres" placeholder="Buscar persona*">
			                                    <span class="focus-input100"></span>
			                                    <span class="symbol-input100">
			                                        <i class="mdi mdi-account-search" aria-hidden="true"></i>
			                                    </span>
											  	<ul class="autocomplete-result-list"></ul>
											</div>
		                                    <span class="idpersona_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
		                            </div>
		                        </div>
		                        <div class="col-md-6"> 
			   						<div class="select2-idperfil_{{$prefix}} div-select2 input-group mt-10px">
										<select class="form-control select2-show-search" id="idperfil_{{$prefix}}" name="idperfil" data-placeholder="Selecciona el perfil*" style="width:100%;" >
											<option label="Selecciona el perfil"></option>
											@foreach($perfil as $value)
					                            <option value="{{$value->id}}">{{$value->perfil}}</option>
					                        @endforeach
										</select>
										<span class="idperfil_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
			                    </div>
			                    <div class="col-md-6"> 
			   						<div class="select2-rol_{{$prefix}} div-select2 input-group mt-10px">
										<select class="form-control select2-show-search" id="rol_{{$prefix}}" name="rol" data-placeholder="Selecciona el rol*" style="width:100%;" >
											<option label="Selecciona el rol"></option>
											@foreach($role as $value)
					                            <option value="{{$value->id}}">{{$value->name}}</option>
					                        @endforeach
										</select>
										<span class="rol_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
									</div>
			                    </div>
		                        <div class="col-md-12">
		                            <div class="wrap-input100 mrginput100 validate-input">
		                                    <input type="text" class="input100" id="usuario_{{$prefix}}" name="usuario" placeholder="Usuario*">
		                                    <span class="focus-input100"></span>
		                                    <span class="symbol-input100">
		                                        <i class="fa fa-user" aria-hidden="true"></i>
		                                    </span>
		                                    <span class="usuario_{{$prefix}} zmdi zmdi-close-circle msj_error d-none" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
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
						<div class="col-md-5">
		   					<div class="form-group form-row">
								<div class="col-md-12">
									<div class="card shadow">
										<div class="card-header">
											<h3 class="mb-0 card-title">Subir imagen</h3>
											<span class="col-auto align-self-center"> | <span class="text_requiere">Formatos aceptados </span>
											<span class="avatar_{{$prefix}} form-help msj_error_exist" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Solo se acepta formatos tipo (*.jpg, *.png, *.jpeg, *.svg)" data-original-title="" title="">?</span>
											</span>
										</div>
										<div class="card-body">
											<input type="hidden" id="avatar_nombre_{{$prefix}}" name="avatar_nombre">
											<input type="file" class="dropify" id="avatar_{{$prefix}}" name="avatar" data-height="200" >
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				<div class="modal-footer border-0 pl-0 pr-0">
					<button type="submit" id="btn-save" onclick="md_guardar(event,'btn-save')" class="btn btn-primary" data-acciones="guardar-{{$pathController}}">Guardar</button>
					<button type="button" id="cancelar_{{$prefix}}" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
   			</form>
			</div>
		</div>
	</div>
</div>
@section('script')
<script type="text/javascript">
	let _name_tabla_{{$table_name}}         = "{{$table_name}}"
    let _path_controller_{{$table_name}}    = "{{$pathController}}"
    let _name_module_{{$table_name}}        = "{{$modulo}}"
    let _prefix_{{$table_name}}        		= "{{$prefix}}"
	data_form 								= @json($data);

</script>
<script src='{{asset("js/form/$pathController/form.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>
@endsection
@endsection