@include('layouts.header',['title'=>'SIFISI'])
<link href="{{asset('plugins/single-page/css/main.css')}}" rel="stylesheet">
<body class="login_errors">
        <div class="login-img">

            <div id="global-loader">
                <img src="{{asset('images/loader.svg')}}" class="loader-img" alt="Loader">
            </div>

            <div class="page">
            <div class="page-content error-page">
                <div class="container text-center">
                    <div class="error-template">
                        <h1 class="display-1 text-primary mb-2">404 <span class="text-transparent_primary fs-20">Ooops error !</span></h1>
                        <h5 class="error-details text-primary">
                            Lo sentimos, se ha producido un error, ¡ página solicitada no encontrada !
                        </h5>
                        <div class="text-center">
                            <a class="btn btn-secondary mt-5 mb-5" href="javascript:history.back()"> <i class="fa fa-long-arrow-left"></i> Regresar a la p&aacute;gina anterior </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @include('layouts.script')
    </body>
</html>