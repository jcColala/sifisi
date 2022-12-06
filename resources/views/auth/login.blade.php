@include('layouts.header',['title'=>'Login'])
<script src='https://www.google.com/recaptcha/api.js'></script>

<body class="login-img img_logo_o_o">
        <div class="img_logo_color_o_o">

            <div id="global-loader">
                <img src="{{asset('images/loader.svg')}}" class="loader-img" alt="Loader">
            </div>

            <div class="logo_universidad">
                <a href="https://unsm.edu.pe" target="_blank">
                    <img src="{{asset('images/logo_unsm.png')}}">
                </a>
            </div>

            <div class="page h-100 justify-content-unset">
                <div class="h-100">
                    <div class="container-login100">
                        <div class="wrap-login100 pd_login h-100">
                            <form class="login100-form validate-form" id="login" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="col col-login mx-auto mt-1">
                                    <div class="text-center">
                                        <img src="{{asset('images/logo_fisi.jpeg')}}" class="header-brand-img h_3em mg_no" alt="">
                                    </div>
                                </div>
                                <span class="login100-form-title login_title mt-3">
                                    <h3 class="page-title">SIFISI</h3>
                                    <p>Sistema Integrado de la Facultad de Ingenier&iacute;a de Sistemas e Inform&aacute;tica</p>
                                </span>
                                <div class="progress progress-md login_progress">
                                    <div class="progress-bar progress-bar-indeterminate bg-purple-1"></div>
                                </div>
                                <div class="wrap-input100 validate-input">
                                    <input type="text" class="input100 @error('usuario') is-invalid @enderror" id="usuario" name="usuario" value="{{ old('usuario') }}" autofocus placeholder="Usuario">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                @if ($errors->has('usuario') AND $errors->first('usuario') != "Lo sentimos, las credenciales ingresadas no coinciden con ninguno de nuestros registros.")
                                    <span class="text-danger login_mjs_error">{{ $errors->first('usuario') }}</span>
                                @enderror

                                <div class="wrap-input100 validate-input">
                                    <input type="password" class="input100 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Contrase&ntilde;a">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="text-danger login_mjs_error">{{ $errors->first('password') }}</span>
                                @enderror

                                <div class="wrap-input100 validate-input mgb_none">
                                    <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}" ></div>
                                </div>
                                @error('g-recaptcha-response')
                                    <span class="text-danger login_mjs_error">{{ $errors->first('g-recaptcha-response') }}</span>
                                @enderror

                                <!--<div class="text-right pt-1">
                                    <p class="mb-0"><a href="{{ route('password.request') }}" class="text-primary ml-1">¿Has olvidado tu contrase&ntilde;a?</a></p>
                                </div>-->

                                @if ($errors->has('usuario') AND $errors->first('usuario') == "Lo sentimos, las credenciales ingresadas no coinciden con ninguno de nuestros registros.")
                                    <div class="alert alert-danger login_error">
                                        <i class="fas fa-frown fa-2x"></i>
                                        <p>{{ $errors->first('usuario') }}<p>
                                    </div>
                                @enderror
                                
                                <div class="container-login100-form-btn pt-0">
                                    <button type="submit" class="login100-form-btn btn-primary">
                                        Ingresar
                                    </button>
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.script')
        <script src='{{asset("js/form/login.js")}}'></script>
    </body>
</html>