@extends("theme.$theme.layout")
@section("titulo")
Inicio
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.mensaje')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Inicio</h3>
            </div>
            <div class="box-body">
                <h2>Bienvenido {{ session()->get('user_name') ?? 'Invitado'}}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
