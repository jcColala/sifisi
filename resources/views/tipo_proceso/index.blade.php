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
				<h3 class="card-title">Lista de {{"$modulo"}}</h3>
				<div class="card-options card_options">
					<div class="btn-list">
						<!-- START Botones-->
						@include('extras.botones',['path_controller' => "$pathController"])
						<!-- END Botones-->
					</div>
				</div>
			</div>
			<div class="card-body pdd_card_body">
				<div class="table-responsive">
					<table id="dt-{{$pathController}}" realid="{{$pathController}}" class="table table-striped databale table-bordered text-nowrap w-100">
						<thead>
							<tr>
								<th width="05%">#</th>
								<th width="40%">Tipo de Proceso</th>
								<th width="30%">Código</th>
								<th width="20%">Estado</th>
								<th width="05%">Activo</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="div_md-{{$pathController}}"></div>
@section('script')
<script type="text/javascript">
	let _name_tabla_{{$table_name}}         = "{{$table_name}}"
    let _path_controller_{{$table_name}}    = "{{$pathController}}"
    let _name_module_{{$table_name}}        = "{{$modulo}}"
    let _prefix_{{$table_name}}        		= "{{$prefix}}"
    let table 								= ""
</script>

<script src='{{asset("js/form/$pathController/index.js")}}'></script>
<script src='{{asset("js/form/$pathController/form.js")}}'></script>
@endsection
@endsection

