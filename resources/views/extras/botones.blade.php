@foreach ($funcion as $key => $row)
	@can($row["funcion"].'-'.$path_controller)
		<a href="#" id="btn-{{$row["funcion"]}}" data-controller="{{$path_controller}}" class="{{$row["clase"]}}" >
			<i class="{{$row["icono"]}} bt_grilla text-primary-shadow"></i> {{$row["nombre"]}}</a>
	@endcan
@endforeach