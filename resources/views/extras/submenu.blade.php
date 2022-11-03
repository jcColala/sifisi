<ul class="slide-menu">
    @foreach($submenu as $key => $modulo)
        @if(count($modulo['submenu']) == 0)
        <li>
            <a class="slide-item" @if($modulo['url']) href="{{route($modulo['url'].'.index')}}" @else href="#" @endif>
                <span>{{$modulo['text']}}</span>
            </a>
        </li>
        @else
            <li class="sub-slide">
                <a class="sub-side-menu__item" data-toggle="sub-slide" href="#">
                    <span class="sub-side-menu__label">{{$modulo['text']}}</span>
                    <i class="sub-angle fa fa-angle-right"></i>
                </a>
                @include('extras.submenu',['submenu'=>$modulo['submenu'], "cont"=>($key+1)])
            </li>
        @endif
    @endforeach
</ul>