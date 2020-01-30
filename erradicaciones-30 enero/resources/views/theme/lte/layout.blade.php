<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{asset("assets/img/logo.png")}}" type="image/x-icon">

    <title>@yield('titulo', 'Erradicación MEXW34') | Erradicación MEXW34</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("assets/css/all.css")}}" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="{{asset("assets/css/font-awesome.min.css")}}" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
    <!-- Mensajes administrador de roles -->
    <link type="text/css" rel="stylesheet" href="{{asset("assets/css/toastr.min.css")}}" />
    <!-- Plugin Scrollbars CSS -->
    <link type="text/css" rel="stylesheet" href="{{asset("assets/css/OverlayScrollbars.min.css")}}" />
    <!-- jQuery -->
    <script src="{{asset("assets/js/jquery-3.4.1.min.js")}}" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- Plugin Scrollbars JS -->
    <script src="{{asset("assets/js/OverlayScrollbars.min.js")}}"></script>

    @yield("styles")

    <!-- Datepicker -->
    <script src="{{asset("assets/js/gijgo.min.js")}}"></script>
    <link type="text/css" rel="stylesheet" href="{{asset("assets/css/gijgo.min.css")}}" />
    <script src="{{asset("assets/js/messages.es-es.js")}}"></script>

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
    <!-- Bootstrap 4 -->
    <script src="{{asset("assets/$theme/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>

</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed" >

    <div class="wrapper">

        @include("theme/$theme/navbar")

        @include("theme/$theme/sidebar")

        <div class="content-wrapper" id="contentId">

            <section class="content">
                @yield('contenido')
            </section>

        </div>

        @include("theme/$theme/footer")

        @include("theme/$theme/filtro")

        <!-- FastClick -->
        <script src="{{asset("assets/$theme/plugins/fastclick/fastclick.js")}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset("assets/$theme/dist/js/adminlte.min.js")}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{asset("assets/$theme/dist/js/demo.js")}}"></script>

        @yield("scriptsPlugins")
        <script src="{{asset("assets/js/jquery-validation/jquery.validate.min.js")}}"></script>
        <script src="{{asset("assets/js/jquery-validation/localization/messages_es.min.js")}}"></script>
        <script src="{{asset("assets/js/sweetalert.min.js")}}"></script>
        <script src="{{asset("assets/js/toastr.min.js")}}"></script>

        <!-- CSS Datatables bootstrap4-->
        <link type="text/css" rel="stylesheet"href="{{asset("assets/css/bootstrap.css")}}" />
        <link type="text/css" rel="stylesheet"href="{{asset("assets/css/dataTables.bootstrap4.min.css")}}" />

        <!-- JS Datatables bootstrap4-->
        <script src="{{asset("assets/js/dataTables/jquery.dataTables.min.js")}}"></script>
        <script src="{{asset("assets/js/dataTables/dataTables.bootstrap4.min.js")}}"></script>

        <!-- CSS JSSelect -->
        <link type="text/css" rel="stylesheet"href="{{asset("assets/css/bootstrap-select.css")}}" />
        <script src="{{asset("assets/js/bootstrap-select.min.js")}}"></script>

        <!-- JS MAPS -->
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCJnj2nWoM86eU8Bq2G4lSNz3udIkZT4YY&libraries=visualization&sensor=false&libraries=drawing,geometry"></script>
        <link type="text/css" rel="stylesheet"href="{{asset("assets/css/style.css")}}" />
        <script type="text/javascript" src="{{asset("assets/js/gmap3.js")}}"></script>

        <!-- FUNCIONES INDEPENDIENTES -->
        @if ((Route::current()->getName()!='register_filter') && (Route::current()->getName()!='registros') && (Route::current()->getName()!='registers_map') && (Route::current()->getName()!='registers_map_filter') && (Route::current()->getName()!='validation') && (Route::current()->getName()!='images') && (Route::current()->getName()!='images_filter') && (Route::current()->getName()!='validation') && (Route::current()->getName()!='validation_filter'))
            <script src="{{asset("assets/js/scripts.js")}}"></script>
        @endif
        <script src="{{asset("assets/js/funciones.js")}}"></script>
        <link rel="stylesheet" href="{{asset("assets/css/custom.css")}}">
        @yield("scripts")

</body>

</html>
