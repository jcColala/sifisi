<ul @if($id) @if($id > 1) class="sub-slide-menu2" @else class="sub-slide-menu" @endif @else class="slide-menu" @endif>
    @foreach($submenu as $key => $modulo)
        @if(count($modulo["submenu"]) == 0)
            @if($id)
                <li>
                    <a @if($id > 1) class="sub-slide-item2" @else class="sub-slide-item" @endif @if($modulo["url"] AND $modulo["url"] !="#") href="{{route($modulo["url"].'.index')}}" @else href="#" @endif>
                        <span>{{$modulo["text"]}}</span>
                    </a>
                </li>
            @else
                <li>
                    <a class="slide-item" @if($modulo["url"] AND $modulo["url"] !="#") href="{{route($modulo["url"].'.index')}}" @else href="#" @endif>
                        <span>{{$modulo["text"]}}</span>
                    </a>
                </li>
            @endif
        @else
            <li @if($id==1) class="sub-slide2" @else class="sub-slide" @endif>
                <a class="sub-side-menu__item" @if($id==1) data-toggle="sub-slide2" @else data-toggle="sub-slide" @endif href="#">
                    <span @if($id==1) class="sub-side-menu__label2" @else class="sub-side-menu__label" @endif>{{$modulo["text"]}}</span>
                    <i @if($id==1) class="sub-angle2 fa fa-angle-right" @else class="sub-angle fa fa-angle-right" @endif ></i>
                </a>
                @include("extras.submenu",["submenu"=>$modulo["submenu"], "id"=>($id+1)])
            </li>
        @endif
    @endforeach
</ul>