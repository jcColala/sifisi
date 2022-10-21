@include('layouts.header',['title'=>'SIFISI'])
<link href="{{asset('plugins/single-page/css/main.css')}}" rel="stylesheet">
<body class="login-img">
        <div class="login-img">

            <div id="global-loader">
                <img src="{{asset('images/loader.svg')}}" class="loader-img" alt="Loader">
            </div>

            <div class="page">
            <div class="page-content error-page">
                <div class="container text-center">
                    <div class="error-template">
                        <h1 class="display-1 text-white mb-2">500<span class="text-transparent fs-20">error</span></h1>
                        <h5 class="error-details text-white">
                            Lo sentimos, se ha producido un error, ¡ página solicitada no encontrada !
                        </h5>
                        <div class="text-center">
                            <a class="btn btn-secondary mt-5 mb-5" href="{{ route('web') }}"> <i class="fa fa-long-arrow-left"></i> Regresar a la página principal </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @include('layouts.script')
    </body>
</html>