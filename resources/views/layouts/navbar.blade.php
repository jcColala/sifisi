<!-- START PAGE-HEADER -->
<div>
    <h1 class="page-title">{{$title}}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">{{$modulo}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$paht}}</li>
    </ol>
</div>
<!-- END PAGE-HEADER --> 

<!-- START NAVBAR -->
<div class="d-flex  ml-auto header-right-icons header-search-icon">
    <!--<div class="dropdown d-sm-flex">
        <a href="#" class="nav-link icon" data-toggle="dropdown">
            <i class="fe fe-search"></i>
        </a>
        <div class="dropdown-menu header-search dropdown-menu-left">
            <div class="input-group w-100 p-2">
                <input type="text" class="form-control " placeholder="Search....">
                <div class="input-group-append ">
                    <button type="button" class="btn btn-primary ">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>-->
    <div class="dropdown d-md-flex">
        <a class="nav-link icon full-screen-link nav-link-bg">
            <i class="fe fe-maximize fullscreen-button"></i>
        </a>
    </div>
    <div class="dropdown d-md-flex">
        <a class="nav-link icon nav-link-bg">
            <i class="fe fe-moon cambiar_tema"></i>
        </a>
    </div>
    <!--<div class="dropdown d-md-flex message">
        <a class="nav-link icon text-center" data-toggle="dropdown">
            <i class="fe fe-mail"></i>
            <span class="nav-unread badge badge-success badge-pill">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <div class="message-menu">
                <a class="dropdown-item d-flex pb-3" href="#">
                    <span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="{{asset('images/users/1.jpg')}}"></span>
                    <div>
                        <strong>Madeleine</strong> Hey! there I' am available....
                        <div class="small text-muted">
                            3 hours ago
                        </div>
                    </div>
                </a>
                <a class="dropdown-item d-flex pb-3" href="#">
                    <span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="{{asset('images/users/12.jpg')}}"></span>
                    <div>
                        <strong>Anthony</strong> New product Launching...
                        <div class="small text-muted">
                            5 hour ago
                        </div>
                    </div>
                </a>
                <a class="dropdown-item d-flex pb-3" href="#">
                    <span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="{{asset('images/users/4.jpg')}}"></span>
                    <div>
                        <strong>Olivia</strong> New Schedule Realease......
                        <div class="small text-muted">
                            45 mintues ago
                        </div>
                    </div>
                </a>
            </div>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item text-center">See all Messages</a>
        </div>
    </div>-->
    <div class="dropdown profile-1">
        <a href="#" data-toggle="dropdown" class="nav-link pr-2 leading-none d-flex">
            <span>
                <img src="{{ (auth()->user()->avatar == null or auth()->user()->avatar == '')? asset('images/users/anonimo.png'): asset('images/users/'.auth()->user()->avatar) }}" alt="profile-user" class="avatar  profile-user brround cover-image">
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <div class="drop-heading">
                <div class="text-center">
                    <h5 class="text-dark mb-0">{{auth()->user()->persona->nombres}}</h5>
                    <small class="text-muted">{{auth()->user()->perfil->perfil}}</small>
                </div>
            </div>
            <div class="dropdown-divider m-0"></div>
            <!--<a class="dropdown-item" href="#">
                <i class="dropdown-icon mdi mdi-account-outline"></i> Profile
            </a>
            <a class="dropdown-item" href="#">
                <i class="dropdown-icon  mdi mdi-settings"></i> Settings
            </a>-->

            <a class="dropdown-item text-center" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();" role="button" >
                <i class="dropdown-icon ti-power-off"></i> Cerrar Session
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
<!-- END NAVBAR -->
