@extends("theme.$theme.layout")
@section('titulo')
Roles
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/excel-export/FileSaver.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/excel-export/Blob.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/excel-export/xls.core.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/excel-export/tableexport.js")}}" type="text/javascript"></script>
@endsection

@section('styles')
<link href="{{ asset("assets/css/tableexport.css") }}" rel="stylesheet" type="text/css">
@endsection

@section('contenido')

<div class="row">
    <div class="col-lg-12">
        @include('includes.mensaje')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Usuarios</h3>
                <div class="box-tools pull-right">
                    <a href="{{route('create_user')}}" class="btn btn-block btn-success btn-sm">
                        <i class="fa fa-fw fa-plus-circle"></i> Nuevo registro
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table id="tabla-data" class="table table-bordered table-hover example {{ request()->session()->get('role_name') != "invitado" ? "" : "table-nondownload" }} " style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Usuario</th>
                            <th>Correo (Acceso)</th>
                            <th>Fecha de creación</th>
                            <th>Fecha de modificación</th>
                            <th class=" text-center" >Editar</th>
                            <th class=" text-center" >Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <th class="text-center">
                                <a href="{{route('edit_user', ['id' => $data->id])}}" class="btn-accion-tabla tooltipsC" title="Editar este registro">
                                    <i class="fa fa-pencil fa-2x"></i>
                                </a>
                            </th>
                            <th class="text-center">
                                <form action="{{route('destroy_user', ['id' => $data->id])}}" class="d-inline form-eliminar" method="POST">
                                    @csrf @method("delete")
                                    <button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro">
                                        <i class="fa fa-fw fa-trash text-danger fa-2x"></i>
                                    </button>
                                </form>
                            </th>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
