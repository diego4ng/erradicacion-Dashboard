@extends("theme.$theme.layout")
@section("titulo")
Administrador
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.mensaje')
        <div class="box">

            <div class="box-body">

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Bienvenido {{ session()->get('user_name') ?? ''}}</h1>
                    <p class="lead">Seleccione una opción del menú lateral.</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
