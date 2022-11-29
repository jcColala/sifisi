@foreach ($funcion as $key => $row)
	@can($row["funcion"].'-'.$path_controller)
		<a href="#" id="btn-{{$row["funcion"]}}" data-controller="{{$path_controller}}" @if($row["clase"] == null) class="btn btn-outline-default" @else class="{{$row["clase"]}}" @endif >
			<i @if($row["icono"] == null) class="fe fe-code bt_grilla text-primary-shadow" @else  class="{{$row["icono"]}} bt_grilla text-primary-shadow" @endif></i> {{$row["nombre"]}}</a>
	@endcan
@endforeach