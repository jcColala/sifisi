<ul  @if($id) class="sub-slide-menu" @else class="slide-menu" @endif >
    @foreach($submenu as $key => $modulo)
        @if(count($modulo["submenu"]) == 0)
            @if($id)
               <li>
                    <a class="sub-slide-item" @if($modulo["url"]) href="{{route($modulo["url"].'.index')}}" @else href="#" @endif>
                        <span>{{$modulo["text"]}}</span>
                    </a>
                </li>
            @else
                <li>
                    <a class="slide-item" @if($modulo["url"]) href="{{route($modulo["url"].'.index')}}" @else href="#" @endif>
                        <span>{{$modulo["text"]}}</span>
                    </a>
                </li>
            @endif
        @else
            <li class="sub-slide">
                <a class="sub-side-menu__item" data-toggle="sub-slide" href="#">
                    <span class="sub-side-menu__label">{{$modulo["text"]}}</span>
                    <i class="sub-angle fa fa-angle-right"></i>
                </a>
                @include("extras.submenu",["submenu"=>$modulo["submenu"], "id"=>($key+1)])
            </li>
        @endif
    @endforeach
</ul>