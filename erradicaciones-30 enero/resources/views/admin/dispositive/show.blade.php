@extends("theme.$theme.layout")
@section('titulo')
Detalles de dispositivo
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

    <div class="box col-md-12">

        @include('includes.mensaje')

        <div class="text-center" style="padding-top: 15px;">
                <h4 class="box-title">Detalles de dispositivo y registros realizados</h4>
        </div>
        <p>
            <strong>IMEI: </strong>{{$data['imei']}}
            <strong>  Observaciones: </strong>{{ $data['observaciones'] != "" ? $data['observaciones'] : 'Sin observaciones' }}
            <a href="{{route('edit_dispositive', ['id' => $data['id']])}}" class="btn btn-accion-tabla tooltipsC" title="Editar datos de dispositivo"><i class="fa fa-pencil fa-2x"  aria-hidden="true"></i></a>
        </p>


        <p><strong>PSN:</strong> {{$data['psn']}} <strong>Dependencia:</strong> {{$data['dependencia']['d_v_dependencia']}} <strong>Asignación Interna:</strong> {{ $data['asignacion']['descripcion'] != "" ? $data['asignacion']['descripcion'] : 'Sin asignación' }}</p>

        <p>
        <strong>Estado: </strong>{{ $data['entidad']['NOMBRE'] != "" ? $data['entidad']['NOMBRE'] : "Sin definir" }}
        <strong> Municipio: </strong>{{ $data['municipio']['NOMBRE'] != "" ? $data['municipio']['NOMBRE'] : "Sin definir" }}
        <strong> Localidad: </strong>{{ $data['localidad']['NOMBRE'] != "" ? $data['localidad']['NOMBRE'] : "Sin definir" }}
        </p>

        <div class="table-responsive scrollId">
            <table id="example" class="table table-sm table-bordered table-hover example {{ request()->session()->get('role_name') != "invitado" ? "" : "table-nondownload" }} " style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle text-center">Fecha de captura</th>
                        <th class="align-middle text-center">Clave de evento</th>
                        <th class="align-middle text-center">Estado</th>
                        <th class="align-middle text-center">Municipio</th>
                        <th class="align-middle text-center">Localidad</th>
                        <th class="align-middle text-center">Coordenadas punto medio (Longitud, Latitud, Altitud)</th>
                        <th class="align-middle text-center">Área erradicada en m<sup>2</sup></th>
                        <th class="align-middle text-center">Área erradicada en Hectárea (ha)</th>
                        <th class="width70 text-center align-middle"><i class="fa fa-map-marker tooltipsC" title="Ver posición en mapa" aria-hidden="true"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['eventos'] as $evento)
                        <tr>

                            <td>{{ $evento['f_t_registro'] }}</td>
                            <td>{{ $evento['c_v_evento'] }}</td>
                            <td>{{ $evento['estado']['NOMBRE'] }}</td>
                            <td>{{ $evento['municipio']['NOMBRE'] }}</td>
                            <td>{{ $evento['localidad']['NOMBRE'] }}</td>
                            <td>{{ $evento['d_v_medio'] }}</td>
                            <td class="align-middle">{{ formatMoney($evento['n_d_area'], 1) }}</td>
                            <td class="align-middle">{{ formatMoney(($evento['n_d_area'] / 10000), 1) }}</td>

                            @if ($evento["d_v_medio"]!=[])
                                <?php
                                    $coordenadas = explode(",", $evento["d_v_medio"]);
                                ?>
                                <th class="align-middle text-center">
                                    <a href="#" class="btn tooltipsC" title="Ver posición en mapa" onclick="graficar(<?= $coordenadas[0] ?>,<?= $coordenadas[1] ?>);">
                                        <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
                                    </a>
                                </th>
                            @else
                                <td>Sin punto central</td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-12 text-center" style="padding: 15px;"><a href="{{route('dispositives')}}" class="btn btn-success"><i class="fa fa-fw fa-reply-all"></i> Volver</a></div>
    </div>


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

    <script>

        function graficar(lon, lat){

            $("#exampleModal").modal();
            $("#exampleModalLabel").text('Posición registrada: ' + lon + ',' + lat);
            $("#contentMap").empty();
            $("#contentMap").append('<div id="test" class="gmap3"></div>');
            var center = [lon,lat];
            /*
            $('#test')
                .gmap3({
                    center: center,
                    zoom: 15,
                    mapTypeId : google.maps.MapTypeId.HYBRID,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                    },
                    navigationControl: true,
                    scrollwheel: true,
                    streetViewControl: true
                })
                .marker({
                    position: center,
                    icon: 'https://maps.google.com/mapfiles/marker_green.png'
                });
            */

            var map = new google.maps.Map(document.getElementById('test'), {
                center: {lat: lat, lng: lon},
                mapTypeId: 'hybrid',
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                //mapTypeId: 'satellite',
                //mapTypeId: 'terrain'
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
        $(function(){
            $('div[onload]').trigger('onload');
        });

    </script>

@endsection
