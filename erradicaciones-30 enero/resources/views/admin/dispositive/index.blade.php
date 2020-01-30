@extends("theme.$theme.layout")
@section('titulo')
Dispositivos
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
                    <h3 class="box-title">Dispositivos</h3>
                    <!--div class="box-tools pull-right">
                        <a href="{{route('create_dispositive')}}" class="btn btn-block btn-success btn-sm">
                            <i class="fa fa-fw fa-plus-circle"></i> Nuevo registro
                        </a>
                    </div-->
                </div>
                <div class="box-body">
                    <div class="table-responsive scrollId">
                        <table id="tabla-data" class=" fontErradicacion table table-sm table-bordered table-hover example {{ request()->session()->get('role_name') != "invitado" ? "" : "table-nondownload" }} " style="width:100%">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th class="align-middle">id</th>
                                    <th class="align-middle">IMEI</th>
                                    <th class="align-middle">PSN</th>
                                    <th class="align-middle">Dependencia</th>
                                    <th class="align-middle">Asignación Interna</th>
                                    <th class="align-middle">Estado</th>
                                    <th class="align-middle">Municipio</th>
                                    <th class="align-middle">Localidad</th>
                                    <th class="align-middle">Total eventos</th>
                                    <th class="align-middle">Observaciones</th>
                                    <th class="align-middle">Útima fecha de registro</th>
                                    <th class="align-middle">Útima coordenada punto medio (Longitud, Latitud, Altitud)</th>
                                    <th class="align-middle tableexport-ignore">Localización última coordenada</th>
                                    <th class="align-middle tableexport-ignore fa-2x"><i class="fa fa-arrow-right tooltipsC" title="Ver más detalles de dispositivo y sus eventos registrados" aria-hidden="true"></i></th>
                                    <th class="align-middle tableexport-ignore">Editar</th>
                                    <th class="align-middle tableexport-ignore">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($datas as $data)

                                <tr>
                                    <td class="align-middle">{{$data->id}}</td>
                                    <td class="align-middle">{{$data->imei}}</td>
                                    <td class="align-middle">{{$data->psn}}</td>
                                    <td class="align-middle">{{$data['dependencia']['d_v_dependencia']}}</td>
                                    <td class="align-middle">{{$data['asignacion']['descripcion']}}</td>
                                    <td class="align-middle">{{$data['entidad']['NOMBRE']}}</td>
                                    <td class="align-middle">{{$data['municipio']['NOMBRE']}}</td>
                                    <td class="align-middle">{{$data['localidad']['NOMBRE']}}</td>
                                    <td class="align-middle">{{count($data['eventos'])}}</td>
                                    <td class="align-middle">{{$data->observaciones}}</td>

                                        <?php
                                            $events = Array();
                                        ?>

                                        @foreach ($data['eventos'] as $evento)
                                            <?php $events[] = $evento; ?>
                                        @endforeach

                                        <?php $coordenadas = 0; ?>
                                        @if (count($data['eventos'])>0)

                                            <?php
                                                $ultimo = end($events);
                                                $coordenadas = explode(",", $ultimo->{'d_v_medio'});
                                            ?>
                                            <td class="align-middle">
                                                {{ $ultimo->{'f_t_registro'} }}
                                            </td>

                                            <td class="align-middle">
                                                {{ '('.$ultimo->{'d_v_medio'} .')' }}
                                            </td>

                                        @else
                                            <td></td><td></td>
                                        @endif

                                    <td class="text-center tableexport-ignore" onclick = "this.style.background = '#38d91280'">
                                        <?php if($coordenadas<>0){ ?>
                                            <a href="#" class="btn tooltipsC" title="Ver última posición registrada en mapa" onclick="graficar(<?= $coordenadas[0] ?>,<?= $coordenadas[1] ?>);">
                                                <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center tableexport-ignore" onclick = "this.style.background = '#38d91280'">
                                        <a href="{{route('show_dispositive', ['id' => $data->id])}}" class="btn btn-accion-tabla tooltipsC" title="Ver más detalles de dispositivo y sus eventos registrados" style="padding-top: 10px;">
                                            <i class="fa fa-arrow-right fa-2x" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td class="text-center  tableexport-ignore" onclick = "this.style.background = '#38d91280'">
                                        <a href="{{route('edit_dispositive', ['id' => $data->id])}}" class="btn btn-accion-tabla tooltipsC" title="Editar este registro" style="padding-top: 10px;">
                                            <i class="fa fa-pencil fa-2x"  aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td class="text-center tableexport-ignore" onclick = "this.style.background = '#38d91280'">
                                        <form action="{{route('destroy_dispositive', ['id' => $data->id])}}" class="d-inline form-eliminar" method="POST">
                                            @csrf @method("delete")
                                            <button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro" style="padding-top: 10px;">
                                                <i class="fa fa-fw fa-trash text-danger fa-2x"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function graficar(lon, lat){
            $("#exampleModal").modal();
            $("#exampleModalLabel").text('Posición registrada: ' + lon + ',' + lat);
            $("#contentMap").empty();
            $("#contentMap").append('<div id="test" class="gmap3"></div>');
            var center = [lon,lat];
            var map = new google.maps.Map(document.getElementById('test'), {
                center: {lat: lat, lng: lon},
                mapTypeId: 'hybrid',
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
            });

            var geocoder = new google.maps.Geocoder;
            var infowindow = new google.maps.InfoWindow;
            geocodeLatLng(geocoder, map, infowindow,lat, lon);
        }

        function geocodeLatLng(geocoder, map, infowindow,lat, lng) {
            var latlng = {lat: lng, lng: lat};
            console.log('lat2: '+lat);
            console.log('lon2: '+lng);
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                    map.setZoom(17);
                    map.setCenter(latlng);
                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                    });
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                    } else {
                    window.alert('Sin resultados para las coordenadas');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }
    </script>

    <!-- Modal Map -->
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header thead-dark">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contentMap">
                <div id="test" class="gmap3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

@endsection
