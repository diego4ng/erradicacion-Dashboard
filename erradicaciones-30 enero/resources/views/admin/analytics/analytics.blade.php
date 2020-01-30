@extends("theme.$theme.layout")
@section('titulo')
Analytics
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/core.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/charts.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/themes/animated.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/themes/material.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/data-graficas.js")}}" type="text/javascript"></script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.mensaje')
        <div class="box">

            <div class="box-body">

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Bienvenido a Analyticas</h1>
                    
            
<iframe src="http://www.google.com.mx" width="100%" height="300"></iframe>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
