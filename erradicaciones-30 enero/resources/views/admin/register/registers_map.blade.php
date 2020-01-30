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

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"  style="margin-right: 15px;width: 200px;">
                        <i class="fa fa-filter" aria-hidden="true"></i> Filtrar información
                    </button>

                    <button type="button" class="btn btn-success" data-toggle="modal"  onclick="openallmarkers();"style="margin-right: 15px;width: 200px;">
                        <i class="fa fa-globe"></i> Todas las posiciones
                    </button>

                    <button type="button" class="btn btn-danger" data-toggle="modal"  onclick="openmapacalor();"style="margin-right: 15px;width: 200px;">
                        <i class="fa fa-fire"></i> Mapa de calor
                    </button>

                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive scrollId" style="height: 500px;">
                    <table id="example" class="table table-bordered table-hover example" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th class="align-middle">Clave de evento</th>
                                <th class="align-middle">Fecha de captura</th>
                                <th class="align-middle">Fecha de envío</th>
                                <th class="align-middle">Estado</th>
                                <th class="align-middle">Municipio</th>
                                <th class="align-middle">Localidad</th>
                                <th class="align-middle">Institución que erradicó</th>
                                <th class="align-middle">Coordenadas registradas <br> (Latitud, Longitud, Altitud)</th>
                                <th class="align-middle tableexport-ignore">Loc.</th>
                                <th class="align-middle tableexport-ignore">Pol.</th>
                                <th class="align-middle tableexport-ignore">Área de polígono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <script language='javascript' type='text/javascript'>
                                var puntos_centrales = new Array();
                                var poligonoArray = new Array();
                                var poligonoArray2 = new Array();
                            </script>
                            @foreach ($datas as $index => $data)

                                <tr>
                                    <td  class="align-middle">{{$data["c_v_evento"]}}</td>
                                    <td  class="align-middle">{{$data["f_t_captura"]}}</td>
                                    <td  class="align-middle">{{$data["f_t_registro"]}}</td>
                                    <td  class="align-middle">{{$data["estado"]["NOMBRE"]}}</td>
                                    <td  class="align-middle">{{$data["municipio"]["NOMBRE"]}}</td>
                                    <td  class="align-middle">{{$data["localidad"]["NOMBRE"]}}</td>
                                    <td  class="align-middle">{{$data["dependencia"]["d_v_dependencia"]}}</td>

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
                                            poligonoArray["<?=$data["c_v_evento"] ?>"] = poligonoObj;
                                            poligonoArray2["<?=$data['c_v_evento'] ?>"] = poligonoObj2;
                                        </script>
                                    <td  class="align-middle"> <?php echo $coordenadasPoligono; ?></td>

                                    <!--opción un ping -->
                                    @if ($data["coordenada_central"]!=[])

                                        <?php
                                            $coordenadas = explode(",",$data["coordenada_central"]["d_v_medio"]);
                                        ?>

                                        <script language='javascript' type='text/javascript'>
                                            puntos_centrales[<?= $index ?>] = ({ "lon":<?= $coordenadas[0] ?>,"lat":<?= $coordenadas[1] ?> });
                                        </script>

                                        <td class="tableexport-ignore" onclick = "this.style.background = '#38d91280'">
                                            <a href="#" class="btn btn-accion-tabla tooltipsC" title="Ver posición central del evento" onclick="openMap(<?= $coordenadas[0] ?>,<?= $coordenadas[1] ?>,'<?= $data["estado"]["NOMBRE"] ?>','<?= $data["municipio"]["NOMBRE"] ?>','<?= $data["localidad"]["NOMBRE"] ?>')">
                                                <i class="fas fa-map-marker-alt fa-3x" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                        <td class="tableexport-ignore" onclick = "this.style.background = '#38d91280'">
                                            <a href="#" class="btn btn-accion-tabla tooltipsC" title="Ver polígono de coordenadas del evento" onclick="openMapPolygon(<?= $coordenadas[0] ?>,<?= $coordenadas[1] ?>,'<?= $data["c_v_evento"] ?>','<?= $data["estado"]["NOMBRE"] ?>','<?= $data["municipio"]["NOMBRE"] ?>','<?= $data["localidad"]["NOMBRE"] ?>' )">
                                                <i class="fas fa fa-globe fa-3x" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                        <td class="tableexport-ignore" onclick = "this.style.background = '#38d91280'">
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


        $(".align-middle").each(function(){
            $(this).text($.trim($(this).text()));
        });

        //DATA TABLES EXPORT
        if(($(".table").length) && ($(".table-nondownload").length == 0)){
            $(".table").tableExport({
                formats: ["xlsx", "txt", "csv"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
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

    function openMap(lon, lat,estado, municipio, localidad){
        $('#modalMap').modal('show');
        $("#exampleModalLabel").text("Longitud: "+lon+" Latitud: "+lat+" Estado: "+estado+" Municipio: "+municipio+" Localidad: "+localidad);
        $("#map").remove();
        $("#contenedorMapa").after($('<div/>', {
            class: 'gmap3',
            id: "map",
        }));


        console.log('lat1: '+lat);
        console.log('lon1: '+lon);
        /*
        var center = [lon,lat];
        var ts;
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
            })
            .marker({
                position: center,
                name:"marker",
                icon: 'https://maps.google.com/mapfiles/marker_green.png',
                animation: google.maps.Animation.DROP,
                draggable: true,
                full:true,
            })
            .circle({
                center: center,
                radius : 30,
                fillColor : "#FFAF9F",
                strokeColor : "#FFAF9F"
            })
            // hashmap example
            .on({
                // examples of use with a handler
                click: function (circle, event) {
                    circle.setOptions({fillColor: "#AAFF55"});
                    setTimeout(function () {
                        circle.setOptions({fillColor: "#FFAF9F"});
                    }, 200);
                },
                mouseover: function (circle, event) {
                    circle.setOptions({strokeColor: "#0000FF"});
                },
                // example of use with an array of handler
                mouseout: [
                    function (circle, event) {
                        circle.setOptions({strokeColor: "#FF512F"});
                    },
                    function (circle, event) {
                        console.log('mouseout', circle, event);
                    }
                ]
            })
            // named example
            .on(
                'mousemove',
                function (circle, event) {
                    if (!ts) {
                        circle.setOptions({fillColor: "#cccccc"});
                    }
                    clearTimeout(ts);
                    ts = setTimeout(function () {
                        circle.setOptions({fillColor: "#FFAF9F"});
                        ts = null;
                    }, 200);
                },
                function (circle, event) {
                console.log('mousemove')
                }
            );
        */
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
                icon: 'https://maps.google.com/mapfiles/marker_green.png',
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
        console.log('ÁREA: '+ area.toFixed(4));
        console.log('PERÍMETRO: '+ perimetro.toFixed(4));

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

    function addMarker(lon, lat){
        var center = [lon,lat];
        $('#all-markers')
            .gmap3({
                center: center,
                zoom: 5,
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
                icon: 'https://maps.google.com/mapfiles/marker_green.png',
                animation: google.maps.Animation.DROP
            });
    }

    function openallmarkers(){
        $('#modalMapAllMarkers').modal('show');
        $("#all-markers").remove();
        $("#contenedorMapaAllMarkers").after($('<div/>', {
            class: 'gmap3',
            id: "all-markers",
        }));

        console.log(puntos_centrales);
        $.each(puntos_centrales, function(index, value) {
            addMarker(value['lon'],value['lat']);
        });
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
                <h5 class="modal-title" id="exampleModalLabelAllMarkers">Todas las coordenadas centrales registradas</h5>
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
@endsection
