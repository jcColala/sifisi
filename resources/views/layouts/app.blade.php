<!DOCTYPE html>
<html lang="en" dir="ltr">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    @include('layouts.header',['title'=>'SIFISI'])

    <body class="app sidebar-mini">

        <!-- START SWITCHER -->
        <!-- END SWITCHER -->

        <!-- START GLOBAL-LOADER -->
        <div id="global-loader">
            <img src="{{asset('images/loader.svg')}}" class="loader-img" alt="Loader">
        </div>
        <!-- END GLOBAL-LOADER -->

        <div class="page">
            <div class="page-main">

                <!-- START APP-SIDEBAR-->
                @include('layouts.sidebar')
                <!-- END APP-SIDEBAR-->

                <!-- START Mobile Header -->
                @include('layouts.mobile')
                <!-- END Mobile Header -->

                <div class="app-content">
                    <div class="side-app">
                        <div class="page-header">
                            <!-- START NAVBAR Header -->
                            @include('layouts.navbar')
                            <!-- END NAVBAR Header -->
                        </div>

                        <!-- START CONTAINER -->
                        @yield('content')
                        <!-- END CONTAINER -->

                    </div>
                </div>
            </div>

            <!-- START FOOTER -->
            <footer class="footer">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-md-12 col-sm-12 text-center">
                            SIFISI © 2022 <a href="#">FISI</a>. Todo los derechos reservados.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- END FOOTER -->
        </div>
        <!-- START SCRIPT -->
        @include('layouts.script')
        <!-- END SCRIPT -->
    </body>
</html>
