@extends("theme.$theme.layout")
@section('titulo')
Dispositivo
@endsection

@section("scripts")
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}" type="text/javascript"></script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.form-error')
        @include('includes.mensaje')
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Dispositivo</h3>
                <div class="box-tools pull-right">
                    <a href="{{route('dispositives')}}" class="btn btn-block btn-info btn-sm">
                        <i class="fa fa-fw fa-reply-all"></i> Volver al listado
                    </a>
                </div>
            </div>
            <form action="{{route('update_dispositive', ['id' => $data->id])}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                @csrf @method("put")
                <div class="box-body">
                    @include('admin.dispositive.form')
                </div>
                <div class="box-footer">
                    <div class="col-lg-12 center box-footer text-center">
                        @include('includes.boton-form-editar')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#entidad_id').ready(function(){
        $('#entidad_id').trigger("change");
        setTimeout(function() {
            $('#municipio_id option[value= <?= $data->municipio_id ?>]').prop('selected', 'selected').change();
            $('.selectpicker').selectpicker('refresh');
            setTimeout(function() {
                $('#localidad_id option[value= <?= $data->localidad_id ?>]').prop('selected', 'selected').change();
                $('.selectpicker').selectpicker('refresh');
            }, 2000);
        }, 2000);
    });
</script>

@endsection
