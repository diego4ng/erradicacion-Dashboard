@extends("theme.$theme.layout")
@section("titulo")
Menús - Roles
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/menu-rol/index.js")}}" type="text/javascript"></script>
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
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Menús - Roles</h3>
            </div>
            <div class="box-body">
                @csrf
                <table id="example" class="table table-bordered example table-nondownload" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th><center>Menús <i class="fa fa-arrow-down" aria-hidden="true"></i>  - Roles <i class="fa fa-arrow-right" aria-hidden="true"></i></center></th>
                            @foreach ($rols as $id => $nombre)
                            <th class="text-center">{{$nombre}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $key => $menu)
                            @if ($menu["menu_id"] != 0)
                                @break
                            @endif
                            <tr>
                                <td class="font-weight-bold table-dark"><i class="fa fa-arrows-alt"></i> {{$menu["nombre"]}}</td>
                                @foreach($rols as $id => $nombre)
                                    <td class="text-center">
                                       <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="checkbox" class="menu_rol custom-control-input" id="customSwitch{{$id.$menu["id"]}}"
                                                    name="menu_rol[]" data-menuid={{$menu["id"]}} value="{{$id}}"
                                                    {{in_array($id, array_column($menusRols[$menu["id"]], "id"))? "checked" : ""}}>
                                                <label class="custom-control-label" for="customSwitch{{$id.$menu["id"]}}"></label>
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            @foreach($menu["submenu"] as $key => $hijo)
                                <tr>
                                    <td class="pl-20 table-dark"><i class="fa fa-arrow-right"></i> {{ $hijo["nombre"] }}</td>
                                    @foreach($rols as $id => $nombre)
                                        <td class="text-center">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input
                                                    type="checkbox"
                                                    class="menu_rol custom-control-input"
                                                    id="customSwitch{{$id.$hijo["id"]}}"
                                                    name="menu_rol[]"
                                                    data-menuid={{$hijo["id"]}}
                                                    value="{{$id}}" {{in_array($id, array_column($menusRols[$hijo["id"]], "id"))? "checked" : ""}}>
                                                    <label class="custom-control-label" for="customSwitch{{$id.$hijo["id"]}}"></label>
                                                </div>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($hijo["submenu"] as $key => $hijo2)
                                    <tr>
                                        <td class="pl-30"><i class="fa fa-arrow-right"></i> {{$hijo2["nombre"]}}</td>
                                        @foreach($rols as $id => $nombre)
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input
                                                        type="checkbox"
                                                        class="menu_rol custom-control-input"
                                                        id="customSwitch{{$id.$hijo2["id"]}}"
                                                        name="menu_rol[]"
                                                        data-menuid={{$hijo2["id"]}}
                                                        value="{{$id}}" {{in_array($id, array_column($menusRols[$hijo2["id"]], "id"))? "checked" : ""}}>
                                                        <label class="custom-control-label" for="customSwitch{{$id.$hijo2["id"]}}"></label>
                                                    </div>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @foreach ($hijo2["submenu"] as $key => $hijo3)
                                        <tr>
                                            <td class="pl-40"><i class="fa fa-arrow-right"></i> {{$hijo3["nombre"]}}</td>
                                            @foreach($rols as $id => $nombre)
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input
                                                        type="checkbox"
                                                        class="menu_rol custom-control-input"
                                                        id="customSwitch{{$id.$hijo3["id"]}}"
                                                        name="menu_rol[]"
                                                        data-menuid={{$hijo3["id"]}}
                                                        value="{{$id}}" {{in_array($id, array_column($menusRols[$hijo3["id"]], "id"))? "checked" : ""}}>
                                                        <label class="custom-control-label" for="customSwitch{{$id.$hijo3["id"]}}"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
