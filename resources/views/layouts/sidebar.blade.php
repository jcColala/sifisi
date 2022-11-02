<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{ route('home') }}">
            <img src="{{asset('images/brand/logo.png')}}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{asset('images/brand/logo-1.png')}}"  class="header-brand-img toggle-logo" alt="logo">
            <img src="{{asset('images/brand/logo-2.png')}}" class="header-brand-img light-logo" alt="logo">
            <img src="{{asset('images/brand/logo-3.png')}}" class="header-brand-img light-logo1" alt="logo">
        </a>
        <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="{{ route('home') }}"></a>
    </div>
    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="user-pic">
                <img src="{{ (auth()->user()->avatar == null or auth()->user()->avatar == '')? asset('images/users/anonimo.png'): asset('images/users/'.auth()->user()->avatar) }}" alt="user-img" class="avatar-xl rounded-circle">
            </div>
            <div class="user-info">
                <h6 class=" mb-0 text-dark">{{auth()->user()->persona->nombres}}</h6>
                <span class="text-muted app-sidebar__user-name text-sm">{{auth()->user()->perfil->perfil}}</span>
            </div>
        </div>
    </div>
    <!--<div class="sidebar-navs">
        <ul class="nav  nav-pills-circle justify-content-center">
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Settings">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-settings"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Followers">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-user"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Logout">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-power"></i>
                </a>
            </li>
        </ul>
    </div>-->
    <ul class="side-menu">

        <li><h3>Modulos</h3></li>

        <li class="slide">
            <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-lock"></i><span class="side-menu__label">Seguridad</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('modulo_padre.index') }}"><span>Modulo padre</span></a></li>
            </ul>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('modulo.index') }}"><span>Modulo</span></a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-lock"></i><span class="side-menu__label">Gestión de Calidad</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('proceso_cero.index') }}"><span>Procesos Nivel Cero</span></a></li>
            </ul>
        </li>

        <li><h3>Extras</h3></li>

        <li>
            <a class="side-menu__item" href="{{ route('404') }}"><i class="side-menu__icon ti-info-alt"></i><span class="side-menu__label">Error 404</span></a>
        </li>
    </ul>
</aside>