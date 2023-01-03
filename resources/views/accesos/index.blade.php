@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jstree-bootstrap-theme@1.0.1/dist/themes/proton/style.min.css">
@section('content')
<div class="page-header">
	<!-- START NAVBAR Header -->
	@include('layouts.navbar',['title'=>"$modulo",'modulo'=>"$modulo",'paht'=>'Index'])
	<!-- END NAVBAR Header -->
</div>
<div class="row">
	<div class="col-md-12 col-lg-5">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Filtrar</h3>
				<span class="col-auto align-self-center"> | <span class="text_requiere">campos obligatorios </span>
				<span class="form-help" data-toggle="popover" data-placement="top" data-content="Los campos que contengan un ' * ' son obligatorios y es necesario que se ingrese la información correspondiente." data-original-title="" title="">?</span>
				</span>
			</div>
			<form id="form-{{$pathController}}" onsubmit="guardar_accesos(event)">
			<div class="card-body">
				<div class="form-group form-row">
   					<div class="col-md-12">
   						<div class="select2-idmodulo_padre_{{$prefix}} div-select2 mrginput100_form input-group mt-10px">
							<select class="form-control select2-show-search" id="idmodulo_padre_{{$prefix}}" name="idmodulo_padre" data-placeholder="Selecciona el modulo padre*" style="width:100%;" onchange="armar_jstree(event)" required >
								<option label="Selecciona el modulo padre"></option>
								@foreach($modulo_padre as $value)
		                            <option value="{{$value->id}}">{{$value->descripcion}}</option>
		                        @endforeach
							</select>
                            <span class="focus-input100">Selecciona el modulo padre*</span>
							<span class="idmodulo_padre_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
						</div>
                	</div>

                	<div class="col-md-12">
   						<div class="select2-idrol_{{$prefix}} div-select2 mrginput100_form input-group mt-10px">
							<select class="form-control select2-show-search" id="idrol_{{$prefix}}" name="idrol" data-placeholder="Selecciona el rol*" style="width:100%;" onchange="armar_jstree(event)" required>
								<option label="Selecciona el rol"></option>
								@foreach($role as $value)
		                            <option value="{{$value->id}}">{{$value->name}}</option>
		                        @endforeach
							</select>
                            <span class="focus-input100">Selecciona el rol*</span>
							<span class="idrol_{{$prefix}} zmdi zmdi-close-circle msj_error d-none riht_extraselect2" data-toggle="popover" data-trigger="hover" data-class="popover_error" data-placement="top"></span>
						</div>
                	</div>

               	</div>					
			</div>
			<div class="card-footer border-0 pt-0">
				<button type="submit" id="btn-save" onclick="guardar_accesos(event)" class="btn btn-primary w-100" data-acciones="guardar-{{$pathController}}">Guardar</button>
			</div>
			</form>
		</div>
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-7">
		<div class="card overflow-hidden bg-white work-progress">
			<div class="card-header">
				<h3 class="card-title">Lista de {{$modulo}} y Permisos</h3>
			</div>
			<div class="card-body ml-6 mr-6">
				<div id="jstree_{{$pathController}}"></div>				
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
    let table 								= ""
</script>
<script src='{{asset("js/form/$pathController/index.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>
@endsection
@endsection