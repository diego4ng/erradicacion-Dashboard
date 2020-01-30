<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{asset("assets/img/logo.png")}}" type="image/x-icon">

    <title>@yield('titulo', 'Erradicación MEXW34') | Erradicación MEXW34</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("assets/css/all.css")}}" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="{{asset("assets/css/font-awesome.min.css")}}" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"/>
    <!-- Ionicons -->
    <link type="text/css" rel="stylesheet" href="{{asset("assets/css/ionicons.min.css")}}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
    <link type="text/css" rel="stylesheet" href="{{asset("assets/css/googlefont.css")}}" /

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{asset("assets/js/html5shiv.min.js")}}"></script>
    <script src="{{asset("assets/js/respond.min.js")}}"></script>
    <![endif]-->

    <style>
        body {
            background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#000000)) fixed;
        }

        img#background {
            height: auto;
            left: 0;
            min-height: 100%;
            position: fixed;
            width: 100%;
            z-index: -1;
            opacity: 0.2;
            /*height: 100%;*/
        }
    </style>
</head>

<body class="hold-transition text-center">

    <img src="{{asset('assets/img/background.png')}}" id="background">

    <div class="login-box">

        <div class="card">
            <div class="card-body login-card-body">
                    <div class="col-lg-12">
                        @include('includes.mensaje')
                        @include('includes.mensaje-error')
                    </div>
              <div class="clearfix text-center">
                <div>
                    <a href="{{route('login')}}" style="font-weight:500; font-size: 30px; text-align: center; margin-bottom: 5px;color: black; margin-top: 5px">Erradicación MEXW34 </a>
                </div>
                <img src="{{asset('assets/img/logo.png')}}" style="width: 150px; margin: 15px">
              </div>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <div class="alert-text">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form action="{{route('login_post')}}" method="POST" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="E-mail">
                        <div class="input-group-append input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña">
                        <div class="input-group-append input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6"></div>
                        <!-- /.col -->
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- jquery -->
    <script src="{{asset("assets/$theme/plugins/jquery/jquery.min.js")}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset("assets/$theme/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
    <script src="{{asset("assets/$theme/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>


</body>

</html>
