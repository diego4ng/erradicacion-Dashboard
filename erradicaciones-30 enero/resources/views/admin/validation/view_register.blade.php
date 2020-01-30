@extends("theme.$theme.layout")
@section('titulo')
Registros
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
                <h3 class="box-title">Detalles de evento para validación</h3>
                <div class="box-tools pull-right">
                        <button class="btn btn-block btn-info btn-sm" id="cancel">
                            <i class="fa fa-fw fa-reply-all"></i> Volver a registros
                        </button>
                    </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="align-middle">Clave de evento</th>
                                <th class="align-middle">Fecha de captura</th>
                                <th class="align-middle">Fecha de envío</th>
                                <th class="align-middle">Estado</th>
                                <th class="align-middle">Municipio</th>
                                <th class="align-middle">Localidad</th>
                                <th class="align-middle">Institución que erradicó</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td  class="align-middle">{{$data["c_v_evento"]}}</td>
                                    <td  class="align-middle">{{$data["f_t_captura"]}}</td>
                                    <td  class="align-middle">{{$data["f_t_registro"]}}</td>
                                    <td  class="align-middle">{{$data["estado"]["NOMBRE"]}}</td>
                                    <td  class="align-middle">{{$data["municipio"]["NOMBRE"]}}</td>
                                    <td  class="align-middle">{{$data["localidad"]["NOMBRE"]}}</td>
                                    <td  class="align-middle">{{$data["dependencia"]["d_v_dependencia"]}}</td>
                                </tr>

                                @foreach ($data["plantios"] as $plantio)

                                    @if($plantio["tipo_plantio"]!=[])
                                        <tr>
                                            <td colspan="2" class="table-info align-middle"><strong>Tipo de plantío: </strong></td>
                                            <td colspan="5" class="table-info align-middle">{{ $plantio['tipo_plantio']['d_v_tplantio'] }}</td>
                                        </tr>
                                    @endif

                                    @if($plantio["presentacion"]!=[])
                                        <tr>
                                            <td colspan="2" class="table-info align-middle"><strong>Tipo de presentación: </strong></td>
                                            <td colspan="5" class="table-info align-middle">{{ $plantio['presentacion']['d_v_presentacion'] }}</td>
                                        </tr>
                                    @endif

                                @endforeach

                                @if($data["caracteristicas"]!=[])
                                    <tr>
                                        <td colspan="2" class="table-info align-middle"><strong>Método de erradicación: </strong></td>
                                        <td colspan="5" class="table-info align-middle">{{ $data['caracteristicas']['metodo_erradicacion']['d_v_merradica'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="table-info align-middle"><strong>Presenta resiembra: </strong></td>
                                        <td colspan="5" class="table-info align-middle">
                                            @if($data['caracteristicas']['s_v_resiembra']==='true')
                                                {{ 'SI' }}
                                            @else
                                                {{ 'NO' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="table-info align-middle"><strong>Coordinación con otras autoridades: </strong></td>
                                        <td colspan="5" class="table-info align-middle">
                                            @if($data['caracteristicas']['s_v_coordinado']==='true')
                                                {{ 'SI' }}
                                            @else
                                                {{ 'NO' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="table-info align-middle"><strong>Manejo cultural: </strong></td>
                                        <td colspan="5" class="table-info align-middle">{{ $data['caracteristicas']['manejo_cultural']['d_v_manejoc'] }}</td>
                                    </tr>

                                    @if($data['caracteristicas']['c_v_novedades']!="")
                                        <?php
                                            $novedades = (explode("|",$data['caracteristicas']['c_v_novedades']));
                                        ?>
                                        @foreach ($novedades as $novedad)
                                            <td colspan="2" class="table-info align-middle"><strong>Novedad: </strong></td>
                                            <td colspan="5" class="table-info align-middle">{{ $catalogo_novedades[$novedad] }}</td>
                                        </tr>
                                        @endforeach
                                    @endif


                                @endif

                                @if ($data["coordenada_central"]!=[])
                                    <?php
                                        $coordenadas = explode(",",$data["coordenada_central"]["d_v_medio"]);
                                    ?>
                                    <script language='javascript' type='text/javascript'>
                                        var lon = <?= $coordenadas[0] ?>;
                                        var lat = <?= $coordenadas[1] ?>;
                                    </script>
                                @endif

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="test" class="gmap3" onload="graficar()"></div>

    <script>

        function graficar(){
            var center = [lon,lat];
            /*
            $('#test')
                .gmap3({
                    center: center,
                    zoom: 18,
                    mapTypeId : google.maps.MapTypeId.HYBRID,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                    },
                    navigationControl: true,
                    scrollwheel: true,
                    streetViewControl: true,
                    setTilt: false
                })
                .marker({
                    position: center,
                    icon: 'https://maps.google.com/mapfiles/marker_green.png'
                })
                .circle({
                    center: center,
                    radius : 30,
                    fillColor : "#FFAF9F",
                    strokeColor : "#FF512F"
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
