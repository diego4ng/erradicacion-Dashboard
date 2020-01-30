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

                    @if (request()->validacion<>'')
                        @if (request()->validacion==1)
                            <p style="margin-bottom: 0.5rem;">Tipo validación: PENDIENTE</p>
                        @elseif (request()->validacion==2)
                            <p style="margin-bottom: 0.5rem;">Tipo validación: VALIDADO</p>
                            @elseif (request()->validacion==3)
                                <p style="margin-bottom: 0.5rem;">Tipo validación: RECHAZADO</p>
                        @endif
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

                <div class="table-responsive scrollId" style="height: 500px;">
                    <table id="example" class="table table-sm table-bordered table-hover example {{ request()->session()->get('role_name') != "invitado" ? "" : "table-nondownload" }} " style="width:100%">
                        <thead class="thead-dark align-middle text-center">
                            <tr>
                                <th class="align-middle">Fecha de registro</th>
                                @if ((request()->session()->get('role_name')=='analista') || (request()->session()->get('role_name')=='administrador'))
                                    <th class="align-middle">IMEI</th>
                                    <th class="align-middle">No. serie</th>
                                @endif
                                <th class="align-middle">Clave de evento</th>
                                <th class="align-middle">Fecha de captura</th>
                                <th class="align-middle">Validación</th>
                                <th class="align-middle">Usuario validador</th>
                                <th class="align-middle">Fecha de registro</th>
                                <th class="align-middle">Coordenadas punto medio (Longitud, Latitud, Altitud)</th>
                                <th class="align-middle">Estado</th>
                                <th class="align-middle">Municipio</th>
                                <th class="align-middle">Localidad</th>
                                <th class="align-middle">Institución que erradicó</th>
                                <th class="align-middle text-center">Área erradicada en m<sup>2</sup></th>
                                <th class="align-middle text-center">Área erradicada en Hectárea (ha)</th>
                                <th class="align-middle">Tipo de plantio 1</th>
                                <th class="align-middle">Tipo de presentación 1</th>
                                <th class="align-middle">Tipo de plantio 2</th>
                                <th class="align-middle">Tipo de presentación 2</th>
                                <th class="align-middle">Tipo de plantio 3</th>
                                <th class="align-middle">Tipo de presentación 3</th>
                                <th class="align-middle">Resiembra</th>
                                <th class="align-middle">Método herradicación</th>
                                <th class="align-middle">Manejo cultural</th>
                                <th class="align-middle">Coordinación con otras autoridades</th>
                                <th class="align-middle">Novedades</th>
                                <th class="align-middle">Otros aseguramientos</th>
                                <th class="align-middle tableexport-ignore">Más..</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td class="align-middle">{{$data["f_t_registro"]}}</td>
                                    @if ((request()->session()->get('role_name')=='analista') || (request()->session()->get('role_name')=='administrador'))
                                        <td class="align-middle">{{$data["n_v_imei"]}}</td>
                                        <td class="align-middle">{{$data["n_v_sn"]}}</td>
                                    @endif
                                    <td class="align-middle">{{$data["c_v_evento"]}}</td>
                                    <td class="align-middle">{{$data["f_t_captura"]}}</td>
                                    <td class="align-middle text-center">
                                        <center>
                                            <?php
                                            if(empty($data["validacion_dashboard"]["estatus_validacion"])){
                                                echo 'Sin validar';
                                            }else{
                                                if($data["validacion_dashboard"]["estatus_validacion"]==2){
                                                    echo 'Validado';
                                                }else{
                                                    echo 'Rechazado';
                                                }
                                            }
                                            ?>
                                        </center>
                                    </td>
                                    <td class="align-middle">{{$data['validacion_dashboard']['usuario_validador']['name']}}</td>
                                    <td class="align-middle">{{$data["f_t_captura"]}}</td>
                                    <td class="align-middle">{{$data["coordenada_central"]['d_v_medio']}}</td>
                                    <td class="align-middle">{{$data["estado"]["NOMBRE"]}}</td>
                                    <td class="align-middle">{{$data["municipio"]["NOMBRE"]}}</td>
                                    <td class="align-middle">{{$data["localidad"]["NOMBRE"]}}</td>
                                    <td class="align-middle">{{$data["dependencia"]["d_v_dependencia"]}}</td>
                                    <td class="align-middle">{{ formatMoney($data["coordenada_central"]['n_d_area'], 1) }}</td>
                                    <td class="align-middle">{{ formatMoney(($data["coordenada_central"]['n_d_area'] / 10000), 1) }}</td>
                                    <?php
                                        $count = 3;
                                    ?>
                                    @foreach ($data['plantios'] as $plantioVal)
                                    <?php $plantio = $plantioVal->toArray(); ?>

                                        @if($plantio["tipo_plantio"]!=[])
                                            <td class="align-middle">{{ $plantio['tipo_plantio']['d_v_tplantio'] }}</td>
                                        @else
                                            <td class="align-middle">Sin opción en catálogo</td>
                                        @endif

                                        @if($plantio["presentacion"]!=[])
                                            <td class="align-middle">{{ $plantio['presentacion']['d_v_presentacion'] }}</td>
                                        @else
                                            <td class="align-middle">Sin opción en catálogo</td>
                                        @endif

                                        <?php $count--; ?>
                                    @endforeach

                                    @if ($count>0)
                                        @for ($i = $count; $i > 0; $i--)
                                            <td></td>
                                            <td></td>
                                        @endfor
                                    @endif

                                    <?php $caracteristicas = $data["caracteristicas"]->toArray(); ?>

                                    @if($caracteristicas!=[])
                                        <td class="align-middle">
                                        @if($caracteristicas['s_v_resiembra']==='true')
                                            {{ 'SI' }}
                                        @else
                                            {{ 'NO' }}
                                        @endif
                                    </td>
                                        <td class="align-middle">
                                            {{ $caracteristicas['metodo_erradicacion']['d_v_merradica'] }}
                                        </td>
                                    @endif

                                    <td class="align-middle">{{ $caracteristicas['manejo_cultural']['d_v_manejoc'] }}</td>

                                    <td class="align-middle">
                                        @if($caracteristicas['s_v_coordinado']==='true')
                                            {{ 'SI' }}
                                        @else
                                            {{ 'NO' }}
                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        @if ($caracteristicas['c_v_novedades']!='')
                                            <?php
                                                $novedadesId = explode("|", $caracteristicas['c_v_novedades']);
                                                $contNovedades = count($novedadesId);
                                                $novedades = '';
                                            ?>

                                            @foreach ($novedadesId as $novedadId)
                                                <?php
                                                    $contNovedades--;
                                                    $novedades .= $catalogo_novedades[$novedadId];
                                                ?>
                                                @if ($contNovedades>0)
                                                    <?php $novedades .= ', '; ?>
                                                @endif
                                            @endforeach

                                            {{ $novedades }}

                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        @if ($caracteristicas['c_i_aseguramientos']!='')
                                            <?php
                                                $aseguramientosId = explode("|", $caracteristicas['c_i_aseguramientos']);
                                                $contAseguramientos = count($aseguramientosId);
                                                $aseguramientos = '';
                                            ?>

                                            @foreach ($aseguramientosId as $aseguramientoId)
                                                <?php
                                                    $contAseguramientos--;
                                                    $aseguramientos .= $catalogo_aseguramientos[$aseguramientoId];
                                                ?>
                                                @if ($contAseguramientos>0)
                                                    <?php $aseguramientos .= ', '; ?>
                                                @endif

                                            @endforeach

                                            {{ $aseguramientos }}

                                        @endif
                                    </td>

                                    <th class="text-center tableexport-ignore">
                                        <a href="{{route('view_register', ['id' => $data["c_v_evento"]])}}" class="btn btn-accion-tabla tooltipsC" title="Ver más detalles">
                                            <i class="fa fa-arrow-right fa-3x" aria-hidden="true"></i>
                                        </a>
                                    </th>
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

        $(".table td").each(function(){
            $(this).text($.trim($(this).text()));
        });

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
</script>

@endsection
