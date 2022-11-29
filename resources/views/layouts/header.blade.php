<head>
        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>

        <!-- FAVICON -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo_fisi.jpeg')}}" />

        <!-- TITLE -->
        <title>{{$title}}</title>

        <!-- BOOTSTRAP CSS -->
        <link href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

        <!-- STYLE CSS -->
        <link href="{{asset('css/style.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/skin-modes.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/dark-style.css')}}" rel="stylesheet"/>

        <!--C3 CHARTS CSS -->
        <link href="{{asset('plugins/charts-c3/c3-chart.css')}}" rel="stylesheet"/>

        <!-- P-scroll bar css-->
        <link href="{{asset('plugins/p-scroll/perfect-scrollbar.css')}}" rel="stylesheet" />

        <!--- FONT-ICONS CSS -->
        <link href="{{asset('plugins/icons/icons.css')}}" rel="stylesheet"/>

        <link href="{{asset('plugins/morris/morris.css')}}" rel="stylesheet">

        <!-- SIDE-MENU CSS -->
        <link href="{{asset('css/sidemenu.css')}}" rel="stylesheet"/>

        <!-- SIDEBAR CSS -->
        <link href="{{asset('plugins/sidebar/sidebar.css')}}" rel="stylesheet"/>

        <!-- COLOR SKIN CSS -->
        <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{asset('colors/color1.css')}}" />

        <!-- SWITCHER SKIN CSS -->
        <link href="{{asset('plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
        <link href="{{asset('switcher/css/switcher.css')}}" rel="stylesheet">

        <!-- DATATABLE -->
        <link href="{{asset('plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

        <!-- MY CSS -->
        <link href="{{asset('css/mycss.css')}}" rel="stylesheet"/>

        <!-- Efectos Input -->
        <link href="{{asset('plugins/single-page/css/main.css')}}" rel="stylesheet">

        <!-- NOTIFICATIONS -->
        <link href="{{asset('plugins/notify/css/jquery.growl.css')}}" rel="stylesheet">

        <!-- Alertas -->
        <link href="{{asset('plugins/css/toastr/toastr.min.css')}}" rel="stylesheet">

        <!-- Select2 -->
        <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/multipleselect/multiple-select.css')}}" rel="stylesheet">

        <!-- Esqueletor -->
        <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">

        <!-- Jstree -->
        <link rel="stylesheet" href="{{asset('plugins/jstree/themes/default/style.css')}}">

        <!-- file -->
        <link href="{{asset('plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />

        <!-- autocomplete -->
        <link rel="stylesheet" href="{{asset('plugins/autocompletejs_2.3/style.css')}}">
</head>
@routes