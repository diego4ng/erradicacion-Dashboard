@extends("theme.$theme.layout")
@section('titulo')
Validación
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
                    <div class="col-md-12">
                    @if (request()->startDate < request()->endDate)
                    <p style="margin-bottom: 0.5rem;">Filtro rango de fechas de: {{ request()->startDate }} a {{ request()->endDate }} </p>
                    @endif

                    @if (isset(request()->estado_ids))
                        <p style="margin-bottom: 0.5rem;"> Filtro de estado(s):
                            @foreach (request()->estado_ids as $estado_id)
                                {{ $catalogo_estados[$estado_id] }} /
                            @endforeach
                        </p>
                    @endif
                </div>
                <div class="text-center" style="margin-top: 5px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-filter" aria-hidden="true"></i> Filtrar información
                    </button>
                </div>
            </div>
            <div class="box-body">

                <div class="table-responsive scrollId">
                    <table id="example" class="table table-sm table-bordered table-hover example table-nondownload {{ request()->session()->get('role_name') != "invitado" ? "" : "table-nondownload" }} " style="width:100%">
                        <thead class="thead-dark align-middle text-center">
                            <tr>
                                <th class="align-middle">Clave de evento</th>
                                <th class="align-middle tableexport-ignore">Evidencia antesx</th>
                                <th class="align-middle tableexport-ignore">Metadatos antes</th>
                                <th class="align-middle tableexport-ignore">Evidencia durante</th>
                                <th class="align-middle tableexport-ignore">Metadatos durante</th>
                                <th class="align-middle tableexport-ignore">Evidencia después</th>
                                <th class="align-middle tableexport-ignore">Metadatos después</th>
                                <th class="align-middle">Fecha y hora de captura</th>
                                <th class="align-middle">Coordenadas registradas <br> (Latitud, Longitud, Altitud)</th>
                                <th class="align-middle tableexport-ignore">Loc.</th>
                                <th class="align-middle tableexport-ignore">Pol.</th>
                                <th class="align-middle tableexport-ignore">Loc. Fotos</th>
                                <th class="align-middle tableexport-ignore">Área de polígono</th>
                            </tr>
                        </thead>
                        <tbody>

                            <script language='javascript' type='text/javascript'>
                                var puntos_centrales = new Array();
                                var poligonoArray = new Array();
                                var poligonoArray2 = new Array();
                                var coordenada_central_fotos = new Array();
                            </script>

                            @foreach ($datas as $index => $data)
                                <?php
                                    //dump($data->toArray());
                                ?>
                                <tr>
                                    <script language='javascript' type='text/javascript'>
                                        imagenCoordenadasObj = new Array();
                                    </script>

                                    <td class="align-middle" style="text-align: center">{{ $data["c_v_evento"] }}</td>

                                    @foreach ($data['metadatos'] as $index_image => $image)

                                        <td class="tableexport-ignore align-middle" style="text-align: center">
                                            <p><?= $image['d_v_nombre'] ?></p>
                                            <?php 
                                            $fecha = explode('-',$image['f_t_registro']);
                                            ?>
                                            <?php 
                                            $folio = $data['dependencia']['d_v_folio'];
                                            ?>
                                           <?php 
                                            $name_image = $image['d_v_nombre'];
                                            ?>
                                            <?php $tipo_imagen = ''; ?>
                                            @switch($image['c_i_timagen'])
                                                @case(1)
                                                    <?php $tipo_imagen = 'antes'; ?>
                                                    @break
                                                @case(2)
                                                    <?php $tipo_imagen = 'durante'; ?>
                                                    @break
                                                @case(3)
                                                    <?php $tipo_imagen = 'despues'; ?>
                                                    @break
                                                @default
                                            @endswitch
                                            <!--a href="file://10.3.248.135/Mexw34$/w34_production/" target="_blank">Web principal Fotos</a-->
                                            <!--img style="cursor: pointer" onclick="switchImg(this)" data-nameimage={{ $image['d_v_nombre'] }} alt="evidencia_antes" height="120px" width="200px" src="file://10.3.248.135/Mexw34$/w34_production/<?= $tipo_imagen ?>/<?= $data['dependencia']['d_v_folio']?>/<?=$fecha[0]?>/<?= $image['d_v_nombre'] ?>"-->
                                            <img style="cursor: pointer" onclick="switchImg(this)" data-nameimage={{ $image['d_v_nombre'] }} alt="evidencia_antes" height="120px" width="200px" src="{{asset("assets/img/w34_production/$tipo_imagen/$folio/$fecha[0]/$name_image")}}">
                            <!--a<a href="file://10.3.248.135/Mexw34$/w34_production/antes/SDN/2019/da4c9776a49d_1.-_SDN-2276-19_ANTES.jpg" class="btn-accion-tabla tooltipsC" title="Ver imagen"></a-->
                                 <!--a   <i class="fa fa-image fa-2x"></i>
                                </a> </a-->
                                        </td>
                                        <td class="align-middle" style="text-align: center">
                                            <p>Latitud: {{ $image['d_v_latitude'] }}</p>
                                            <p>Longitud: {{ $image['d_v_longitude'] }}</p>
                                            <p>Altitud: {{ $image['	d_v_altitude'] }}</p>
                                        </td>
                                        <script language='javascript' type='text/javascript'>
                                            /*puntos_centrales[<?= $index ?>][<?= $index_image ?>] = ({ "lon":<?= $image['d_v_longitude'] ?>,"lat":<?= $image['d_v_latitude'] ?> });*/
                                            imagenCoordenadasObj.push([<?= $image['d_v_latitude'] ?>,<?= $image['d_v_longitude'] ?> ]);
                                        </script>
                                    @endforeach
                                    <script language='javascript' type='text/javascript'>
                                        puntos_centrales["<?=$data['c_v_evento'] ?>"] = imagenCoordenadasObj;
                                        console.log('puntos_centrales');
                                        console.log(puntos_centrales);
                                    </script>

                                    <td class="align-middle" style="text-align: center">{{$data["f_t_captura"]}}</td>

                                    <script language='javascript' type='text/javascript'>
                                        poligonoObj = new Array();
                                        poligonoObj2 = new Array();
                                    </script>

                                    <?php $coordenadasPoligono = ''; ?>
                                    @foreach ($data['coordenadas'] as $index2 => $coordenada)
                                        <?php $coordenadasPoligono .= '('.$coordenada['d_v_latitude'].','.$coordenada['d_v_longitude'].','.$coordenada['d_v_altitude'].') '; ?>
                                        <script language='javascript' type='text/javascript'>
                                            poligonoObj.push([<?= $coordenada['d_v_latitude'] ?>,<?= $coordenada['d_v_longitude'] ?> ]);
                                            poligonoObj2.push({lat:Number(<?= $coordenada['d_v_latitude'] ?>),lng:Number(<?= $coordenada['d_v_longitude'] ?>)});
                                        </script>
                                    @endforeach

                                    <script language='javascript' type='text/javascript'>
                                        poligonoArray["<?=$data['c_v_evento'] ?>"] = poligonoObj;
                                        poligonoArray2["<?=$data['c_v_evento'] ?>"] = poligonoObj2;
                                    </script>

                                    <td class="align-middle" style="text-align: center">  <?= $coordenadasPoligono; ?></td>

                                    <!--opción un ping -->
                                    @if ($data["coordenada_central"]!=[])

                                        <?php
                                            $coordenadas = explode(",",$data["coordenada_central"]["d_v_medio"]);
                                        ?>

                                        <script language='javascript' type='text/javascript'>
                                            /*puntos_centrales[<?= $index ?>] = ({ "lon":<?= $coordenadas[0] ?>,"lat":<?= $coordenadas[1] ?> });*/
                                        </script>

                                        <td class="tableexport-ignore align-middle" onclick = "this.style.background = '#38d91280'">
                                            <a href="#" class="btn btn-accion-tabla tooltipsC" title="Ver posición central del evento" onclick="openMap(<?= $coordenadas[0] ?>,<?= $coordenadas[1] ?>,'<?= $data["estado"]["NOMBRE"] ?>','<?= $data["municipio"]["NOMBRE"] ?>','<?= $data["localidad"]["NOMBRE"] ?>')">
                                                <i class="fas fa-map-marker-alt fa-3x" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                        <td class="tableexport-ignore align-middle" onclick = "this.style.background = '#38d91280'">
                                            <a href="#" class="btn btn-accion-tabla tooltipsC" title="Ver polígono de coordenadas del evento" onclick="openMapPolygon(<?= $coordenadas[0] ?>,<?= $coordenadas[1] ?>,'<?= $data["c_v_evento"] ?>','<?= $data["estado"]["NOMBRE"] ?>','<?= $data["municipio"]["NOMBRE"] ?>','<?= $data["localidad"]["NOMBRE"] ?>' )">
                                                <i class="fas fa fa-globe fa-3x" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                        <td class="tableexport-ignore align-middle" onclick = "this.style.background = '#38d91280'">
                                            <?php $c_v_evento = $data['c_v_evento']; ?>
                                            <a href="#" class="btn btn-accion-tabla tooltipsC" title="Ver coordenadas de fotografías" onclick="openallmarkers('<?=$data['c_v_evento'] ?>')">
                                                <i class="fas fa fa-map-pin fa-3x" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                        <td class="tableexport-ignore align-middle" onclick = "this.style.background = '#38d91280'">
                                            <a href="#" class="btn btn-accion-tabla tooltipsC" title="Ver área de polígono" onclick="openMapAreaPolygon(<?= $coordenadas[0] ?>,<?= $coordenadas[1] ?>,'<?= $data["c_v_evento"] ?>','<?= $data["estado"]["NOMBRE"] ?>','<?= $data["municipio"]["NOMBRE"] ?>','<?= $data["localidad"]["NOMBRE"] ?>' )">
                                                <i class="fas fa fa-map-o fa-3x" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                    @else
                                        <td></td><td></td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="col-sm-12 col-lg-4 offset-4" style="margin-top: 10px;">
                    @if(!session()->has('filtrado'))
                        {!! $datas->render() !!}
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $(function() {

        $('ul.sidebar-menu').find('li.active').parents('li').addClass('nav-item has-treeview menu-open').children('a').addClass('active open-menu');

        //TOOLTIPS
        $('body').tooltip({
            trigger: 'hover',
            selector: '.tooltipsC',
            placement: 'top',
            html: true,
            container: 'body'
        });

        @if(session()->has('filtrado'))
            //DATATABLES INITIALIZE
            $('#example').DataTable({
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "paging": true,
            });
        @else
            //DATATABLES INITIALIZE
            $('#example').DataTable({
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "paging": false,
                "bInfo" : false,
            });
        @endif

        //DATA TABLES EXPORT
        if(($(".table").length) && ($(".table-nondownload").length == 0)){
            $(".table").tableExport({
                formats: ["xlsx","txt", "csv"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
                position: 'bottom',  // Posicion que se muestran los botones puedes ser: (top, bottom)
                bootstrap: true,//Usar lo estilos de css de bootstrap para los botones (true, false)
                fileName: "Erradicacion MEXW34",    //Nombre del archivo
            });
        }

        //SCROLLBARS
        $('.scrollId').overlayScrollbars({
            //Parameters
        });

        $('body').overlayScrollbars({
            //Parameters
        });

        //GO BACK ON BUTTON
        $('button#cancel').on('click', function(e){
            e.preventDefault();
            window.history.back();
        });
    });

    function switchImg(img){
        console.log('img.src: '+img.src);
        console.log($(img).data('nameimage'));
        $("#titulo_evidencia").text("Nombre de evidencia: "+$(img).data('nameimage'));
        $('#img_src_modal').attr('src', img.src);
        $('#evidencia_modal').modal('show');
    }

    function openMap(lon, lat,estado, municipio, localidad){
        $('#modalMap').modal('show');
        $("#exampleModalLabel").text("Longitud: "+lon+" Latitud: "+lat+" Estado: "+estado+" Municipio: "+municipio+" Localidad: "+localidad);
        $("#map").remove();
        $("#contenedorMapa").after($('<div/>', {
            class: 'gmap3',
            id: "map",
        }));

        var map = new google.maps.Map(document.getElementById('map'), {
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

    function openMapPolygon(lon, lat, evento, estado, municipio, localidad){

        $('#modalMap').modal('show');
        $("#exampleModalLabel").text("Longitud: "+lon+" Latitud: "+lat+" Estado: "+estado+" Municipio: "+municipio+" Localidad: "+localidad);
        $("#map").remove();
        $("#contenedorMapa").after($('<div/>', {
            class: 'gmap3',
            id: "map",
        }));

        var center = [lon,lat];
        $('#map')
            .gmap3({
                zoom: 18,
                center: center,
                mapTypeId : google.maps.MapTypeId.HYBRID,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                navigationControl: true,
                scrollwheel: true,
                streetViewControl: true
            })
            .polygon({
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                paths:poligonoArray[evento]
            })
            .marker({
                position: center,
                //icon: 'https://maps.google.com/mapfiles/marker_green.png',
                animation: google.maps.Animation.DROP
            });
    }

    function openMapAreaPolygon(lon, lat, evento, estado, municipio, localidad){

        $('#modalMap').modal('show');
        $("#exampleModalLabel").text("Longitud: "+lon+" Latitud: "+lat+" Estado: "+estado+" Municipio: "+municipio+" Localidad: "+localidad);
        $("#map").remove();
        $("#contenedorMapa").after($('<div/>', {
            class: 'gmap3',
            id: "map",
        }));

        var center = [lon,lat];
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: lon,
                lng: lat
                },
            zoom: 18,
            mapTypeId: 'hybrid',
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
        });

        var infowindow = new google.maps.InfoWindow();
        var polygon = new google.maps.Polygon({
            path: poligonoArray2[evento],
            map: map,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
        });
        var area = google.maps.geometry.spherical.computeArea(polygon.getPath());
        var perimetro= google.maps.geometry.spherical.computeLength(polygon.getPath());

        infowindow.setContent("Área de polígono = " + area.toFixed(2) + " mts2");
        infowindow.setPosition(polygon.getPath().getAt(0));
        infowindow.open(map);
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: true,
            drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['polygon']
            },
            drawingMode: null
        });

        google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
            var area = google.maps.geometry.spherical.computeArea(polygon.getPath());
            infowindow.setContent("polygon area=" + area.toFixed(2) + " sq meters");
            infowindow.setPosition(polygon.getPath().getAt(0));
            infowindow.open(map);
        });
        drawingManager.setMap(map);
    }

    function addMarker(cooredenadasImagen){
        //var center = [lon,lat];
        $('#all-markers')
            .gmap3({
                center: cooredenadasImagen,
                zoom: 19,
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
                position: cooredenadasImagen,
                //icon: 'https://maps.google.com/mapfiles/marker_green.png',
                animation: google.maps.Animation.DROP
            });
    }

    function openallmarkers(id){
        $('#modalMapAllMarkers').modal('show');
        $("#all-markers").remove();
        $("#contenedorMapaAllMarkers").after($('<div/>', {
            class: 'gmap3',
            id: "all-markers",
        }));
        console.log('puntos_centrales[id]: ' + puntos_centrales[id]);
        var ultima_coordenada = '0,0';
        $.each(puntos_centrales[id], function(index, value) {
            if(value!='0,0'){
                addMarker(value);
            }
            console.log('value: ' + value);
            ultima_coordenada = value;
        });


        $('#all-markers')
            .gmap3({
                zoom: 17,
                center: ultima_coordenada,
                mapTypeId : google.maps.MapTypeId.HYBRID,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                navigationControl: true,
                scrollwheel: true,
                streetViewControl: true
            })
            .polygon({
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                paths:poligonoArray[id]
            });
            /*.marker({
                position: ultima_coordenada,
                icon: 'https://maps.google.com/mapfiles/marker_green.png',
                animation: google.maps.Animation.DROP
            });*/

    }

    function addMarkerMapaCalor(lon, lat){
        var center = [lon,lat];
        new google.maps.LatLng(lon, lat)
    }

    var map, heatmap;
    function openmapacalor(){
        $('#modalMapCalor').modal('show');
        $("#mapaCalor").remove();
        $("#contenedorMapaACalor").after($('<div/>', {
            class: 'gmap3',
            id: "mapaCalor",
        }));

        console.log(puntos_centrales);
        var latCentral = 0;
        var lngCentral = 0;
        $.each(puntos_centrales, function(index, value) {
            latCentral = value['lat'];
            lngCentral = value['lon'];
            return false;
        });

        map = new google.maps.Map(document.getElementById('mapaCalor'), {
            zoom: 5,
            center: {lat:lngCentral , lng: latCentral},
            mapTypeId: 'hybrid',
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
            data: getPoints(),
            map: map
        });

        function getPoints() {
            var coordenadas = new Array();

            $.each(puntos_centrales, function(index, value) {
                coordenadas.push(new google.maps.LatLng(value['lon'],value['lat']));
            });

            console.log(coordenadas);
            return coordenadas;
        }
    }

    function toggleHeatmap() {
    heatmap.setMap(heatmap.getMap() ? null : map);
    }

    function changeGradient() {
    var gradient = [
        'rgba(0, 255, 255, 0)',
        'rgba(0, 255, 255, 1)',
        'rgba(0, 191, 255, 1)',
        'rgba(0, 127, 255, 1)',
        'rgba(0, 63, 255, 1)',
        'rgba(0, 0, 255, 1)',
        'rgba(0, 0, 223, 1)',
        'rgba(0, 0, 191, 1)',
        'rgba(0, 0, 159, 1)',
        'rgba(0, 0, 127, 1)',
        'rgba(63, 0, 91, 1)',
        'rgba(127, 0, 63, 1)',
        'rgba(191, 0, 31, 1)',
        'rgba(255, 0, 0, 1)'
    ]
    heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
    }

    function changeRadius() {
    heatmap.set('radius', heatmap.get('radius') ? null : 20);
    }

    function changeOpacity() {
    heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
    }
</script>

<!--script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwJFiyPp5W--JhIrrLCzhP6TYCHBa4Nn0&libraries=visualization">
</script-->

    <!-- Modal 1 posición-->
    <div class="modal fade bd-example-modal-lg" id="modalMap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-12 row">
                    <div class="col-md-3">
                    <label class="modal-title">Datos de captura del evento:</label>
                    </div>
                    <div class="col-md-9">
                    <p class="modal-title" id="exampleModalLabel"></p>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="contenedorMapa"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Area Polygon posición-->
    <div class="modal fade bd-example-modal-lg" id="modalMapArea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-12 row">
                    <div class="col-md-3">
                    <label class="modal-title">Datos de captura del evento:</label>
                    </div>
                    <div class="col-md-9">
                    <p class="modal-title" id="exampleModalLabelArea"></p>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="contenedorMapa"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal todas las posiciones-->
    <div class="modal fade bd-example-modal-lg" id="modalMapAllMarkers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelAllMarkers" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelAllMarkers">Coordenadas de fotografías</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="contenedorMapaAllMarkers"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal mapa de calor-->
    <div class="modal fade bd-example-modal-lg" id="modalMapCalor" tabindex="-1" role="dialog" aria-labelledby="exampleModalMapaCalor" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalMapaCalor">Mapa de calor con posiciones centrales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="contenedorMapaACalor"></div>
                <div id="floating-panel">
                    <button onclick="toggleHeatmap()">Activar/Desactivar</button>
                    <button onclick="changeGradient()">Cambiar color</button>
                    <button onclick="changeRadius()">Cambiar grosor</button>
                    <button onclick="changeOpacity()">Cambiar opacidad</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- The modal of image-->
    <div class="modal fade fade bd-example-modal-lg" id="evidencia_modal" tabindex="-1" role="dialog" aria-labelledby="titulo_evidencia" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo_evidencia">Evidencias erradicación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img  id="img_src_modal" style="width: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection
