@include('layouts.header',['title'=>'SIFISI'])
<link href="{{asset('plugins/countdown/jquerysctipttop.css')}}" rel="stylesheet">
<link href="{{asset('plugins/jquery-countdown/jquery.countdown.css')}}" rel="stylesheet">
<link href="{{asset('plugins/single-page/css/main.css')}}" rel="stylesheet">
<body class="login-img">
        <div class="login-img">
            <div id="global-loader">
                <img src="{{asset('images/loader.svg')}}" class="loader-img" alt="Loader">
            </div>

            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block logueo_acceso">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="page">
                <div class="">
                    <!-- CONTAINER OPEN -->
                    <div class="container">
                        <div class="row text-center mx-auto">
                            <div class="col-lg-8 col-sm-12 center-block align-items-center construction  ">
                                <div class="text-white">
                                    <div class="card-body">
                                        <h1 class="display-2 mb-0 font-weight-semibold">Próximamente SIFISI</h1>
                                        <div id="launch_date"></div>
                                        <h4><strong>Se viene algo muy bueno.</h4>
                                        <!--<div class="mt-5">
                                            <button class="btn btn-icon" type="button">
                                                <span class="btn-inner--icon"><i class="fa fa-facebook-f"></i></span>
                                            </button>
                                            <button class="btn btn-icon" type="button">
                                                <span class="btn-inner--icon"><i class="fa fa-google"></i></span>
                                            </button>
                                            <button class="btn btn-icon" type="button">
                                                <span class="btn-inner--icon"><i class="fa fa-twitter"></i></span>
                                            </button>
                                            <button class="btn btn-icon" type="button">
                                                <span class="btn-inner--icon"><i class="fa fa-pinterest-p"></i></span>
                                            </button>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CONTAINER CLOSED -->
                </div>
            </div>
        </div>
    @include('layouts.script')
    <script src="{{asset('plugins/jquery-countdown/jquery.plugin.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-countdown/jquery.countdown.js')}}"></script>
    <script src="{{asset('plugins/jquery-countdown/countdown.js')}}"></script>
    </body>
</html>