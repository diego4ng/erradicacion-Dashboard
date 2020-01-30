@extends("theme.$theme.layout")
@section('titulo')
Validación
@endsection

@section("scripts")

<script src="{{asset("assets/pages/scripts/admin/validation/index.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/pages/scripts/admin/validation/crear.js")}}" type="text/javascript"></script>
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
    <div class="col-md-12">
        @include('includes.mensaje')
        <div class="box">

            <div class="box-header with-border">
                <div class="col-md-12">
                    @if (request()->startDate < request()->endDate)
                    <p style="margin-bottom: 0.5rem;">Filtro rango de fechas de: {{ request()->startDate }} a
                        {{ request()->endDate }} </p>
                    @endif

                    @if (isset(request()->estado_ids))
                    <p style="margin-bottom: 0.5rem;"> Filtro de estado(s):
                        @foreach (request()->estado_ids as $estado_id)
                        {{ $catalogo_estados[$estado_id] }} /
                        @endforeach
                    </p>
                    @endif
                </div>
                <div style="margin-top: 5px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-filter" aria-hidden="true"></i> Filtrar información
                    </button>
                    <label style="margin-left: 63%;">Registros faltantes por validar: {{ $total_faltantes }}</label>
                </div>
            </div>

            <div class="box-body">

                <div class="table-responsive scrollId">
                    <table id="example"
                        class="table table-sm table-bordered table-hover example {{ request()->session()->get('role_name') != "invitado" ? "" : "table-nondownload" }} "
                        style="width:100%">
                        <thead class="thead-dark align-middle text-center">
                            <tr>
                                <th class="align-middle">Clave</th>
                                <th class="align-middle">IMEI</th>
                                <th class="align-middle">Fecha Servidor</th>
                                <th class="align-middle">Fecha Dispositivo</th>
                                <th class="align-middle">Estado</th>
                                <th class="align-middle">Municipio</th>
                                <th class="align-middle">Institución</th>
                                <th class="align-middle">Validación</th>
                                <th class="align-middle">Usuario Validador</th>
                                <th class="align-middle">Evidencia</th>
                                <th class="align-middle">Reporte</th>
                                <th class="align-middle">Observaciones</th>
                                <th class="align-middle tableexport-ignore">Más info.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)

                            <tr>
                                <td class="align-middle text-center">

                                <?php
                                    if(empty($data["validacion_dashboard"]["estatus_validacion"])):
                                ?>
                                        <a href="{{route('validation', ['id' => $data["c_v_evento"]])}}" class="tooltipsC" title="Iniciar validación">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{$data["c_v_evento"]}}
                                        </a>
                                <?php
                                    else:
                                ?>
                                    {{ $data["c_v_evento"] }}
                                    <?php //dump($data->toArray()); ?>
                                <?php
                                    endif;
                                ?>
                                </td>
                                <td class="align-middle text-center">{{$data["n_v_imei"]}}</td>
                                <td class="align-middle text-center">{{$data["f_t_registro"]}}</td>
                                <td class="align-middle text-center">{{$data["f_t_captura"]}}</td>
                                <td class="align-middle text-center">{{$data["estado"]["NOMBRE"]}}</td>
                                <td class="align-middle text-center">{{$data["municipio"]["NOMBRE"]}}</td>
                                <td class="align-middle text-center">{{$data["dependencia"]["d_v_dependencia"]}}</td>
                                <td class="align-middle text-center">
                                <center>
                                    <?php
                                    if(empty($data["validacion_dashboard"]["estatus_validacion"])){
                                        echo '<div id="circulo2" class="color2 tooltipsC" style="cursor: pointer;" title="Sin validar"></div>';
                                    }else{
                                        if($data["validacion_dashboard"]["estatus_validacion"]==2){
                                            echo '<div id="circulo1" class="color1 tooltipsC" style="cursor: pointer;" title="Validado"></div>';
                                        }else{
                                            echo '<div id="circulo3" class="color3 tooltipsC" style="cursor: pointer;" title="Rechazado"></div>';
                                        }
                                    }
                                    ?>
                                </center>
                                </td>
                                <td class="align-middle">{{$data['validacion_dashboard']['usuario_validador']['name']}}</td>
                                <td class="align-middle text-center">
                                    <?php
                                    if(empty($data["metadatos"])){
                                        echo '0 Fotos';
                                    }else{
                                        echo count($data["metadatos"]).' Fotos';
                                    }
                                    ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?php
                                        if(!empty($data["validacion_dashboard"]["estatus_validacion"])){
                                    ?>
                                            <a href="{{route('generar_reporte_pdf', ['id' => $data["c_v_evento"]])}}" class="tooltipsC" title="Ver reporte de validación"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                    <?php
                                        }
                                    ?>
                                </td>
                                <td class="align-middle text-center">
                                     {{$data["validacion_dashboard"]["observaciones_validador"]}}
                                </td>

                                <?php $caracteristicas = $data["caracteristicas"]->toArray(); ?>

                                <td class="text-center tableexport-ignore">
                                    <a href="{{route('view_register_validation', ['id' => $data["c_v_evento"]])}}"
                                        class="btn btn-accion-tabla tooltipsC" title="Ver más detalles" target="_blank">
                                        <i class="fa fa-arrow-right fa-1x" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="col-lg-6 offset-lg-4 col-md-12 col-sm-12 text-center" style="margin-top: 10px;">
                    @if(!session()->has('filtrado'))
                    {!! $datas->render() !!}
                    @endif
                </div>

                <?php $score = 0; ?>

                @if ((isset($evento)) && ($evento<>null) && ($evento<>[]) && (empty($evento[0]["validacion_dashboard"])))
                    <form action="{{route('validacion')}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off" onsubmit="return verifica();">
                        @csrf
                        <div class="form-group">
                            <?php $datos_evento = $evento[0]; ?>
                            <div class="card">
                                <h5 class="card-header" id="id_evento">Clave de evento: {{ $datos_evento['c_v_evento'] }} </h5>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4 col-md-4">
                                            <div class="card">
                                                <div class="card-body">

                                                    <?php
                                                        $total_registros = 0;
                                                        $suficiencia = 0;
                                                        $suficienciaArray = [];
                                                        //dump($evento);

                                                        if(($datos_evento['c_i_evento']<>null) && ($datos_evento['c_i_evento']<>'')){
                                                            $total_registros++;
                                                        }

                                                        foreach ($datos_evento['metadatos'] as $item):
                                                            $list_imagenes = array(1, 2, 3);
                                                            if (in_array($item['c_i_timagen'], $list_imagenes)) {
                                                                $total_registros++;
                                                            }
                                                        endforeach;

                                                        if(($datos_evento['coordenada_central']['d_v_medio']<>null) && ($datos_evento['coordenada_central']['d_v_medio']<>'')){
                                                            $total_registros++;
                                                        }

                                                        if(($datos_evento['estado']['ID_ESTADO']<>null) && ($datos_evento['estado']['ID_ESTADO']<>'')){
                                                            $total_registros++;
                                                        }else{
                                                            $suficiencia++; //Conteo de elementos fuera de rango
                                                            $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_estado, dato recibido "'.$datos_evento['c_i_estado'].'"' => $datos_evento['c_i_estado']];
                                                        }

                                                        if(($datos_evento['municipio']['ID_MUNICIPIO']<>null) && ($datos_evento['municipio']['ID_MUNICIPIO']<>'')){
                                                            $total_registros++;
                                                        }else{
                                                            $suficiencia++;
                                                            $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_municipio, dato recibido "'.$datos_evento['c_i_municipio'].'"' => $datos_evento['c_i_municipio']];
                                                        }

                                                        if(($datos_evento['localidad']['ID_LOCALIDAD']<>null) && ($datos_evento['localidad']['ID_LOCALIDAD']<>'')){
                                                            $total_registros++;
                                                        }else{
                                                            $suficiencia++;
                                                            $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_localidad, dato recibido "'.$datos_evento['c_i_localidad'].'"' => $datos_evento['c_i_localidad']];
                                                        }

                                                        $presentacion_amapola = array(1,2,3);
                                                        $presentacion_marihuana_coca = array(1,2,4,5,6,7,8);

                                                        foreach ($datos_evento['plantios'] as $item):
                                                            if(($item['c_i_plantio']>0) && ($item['c_i_plantio']<>null) && ($item['tipo_plantio']['c_i_tplantio']<>null)){
                                                                $total_registros++;
                                                            }

                                                            if($item['c_i_tplantio']==1){ //Verificamos el tipo de plantio para comparar con sus presentaciones respecto al tipo de plantío
                                                                if (in_array($item['c_i_presentacion'], $presentacion_amapola)) {//Verifica el id esté en su rango asignado (ver documentación de presentación de plantios)
                                                                    if($item['presentacion']['c_i_presentacion']){ //Verifica si existe el valor en un catálogo válido
                                                                        $total_registros++;
                                                                    }else{
                                                                        $suficiencia++; //Conteo de elementos fuera de rango
                                                                        $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_presentacion, dato recibido "'.$item['c_i_presentacion'].'"'=>$item['c_i_presentacion']];
                                                                    }
                                                                }
                                                                if($item['etapa']['c_i_etapa']){
                                                                    $total_registros++;
                                                                }else{
                                                                    $suficiencia++;
                                                                    $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_etapa, dato recibido "'.$item['c_i_etapa'].'"'=>$item['c_i_etapa']];
                                                                }
                                                                if($item['color_flor']['c_i_cflor']){
                                                                    $total_registros++;
                                                                }else{
                                                                    $suficiencia++;
                                                                    $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_cflor, dato recibido "'.$item['c_i_cflor'].'"'=>$item['c_i_cflor']];
                                                                }

                                                                //Características de tipo de plantío I
                                                                if($datos_evento['caracteristicas']['metodo_erradicacion']['c_i_merradica']){
                                                                    $total_registros++;
                                                                }else{
                                                                    $suficiencia++;
                                                                    $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_merradica, dato recibido "'.$datos_evento['caracteristicas']['c_i_merradica'].'"'=>$datos_evento['caracteristicas']['c_i_merradica']];
                                                                }
                                                                if($datos_evento['caracteristicas']['manejo_cultural']['c_i_manejoc']){
                                                                    $total_registros++;
                                                                }else{
                                                                    $suficiencia++;
                                                                    $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_manejoc, dato recibido "'.$datos_evento['caracteristicas']['c_i_manejoc'].'"'=>$datos_evento['caracteristicas']['c_i_manejoc']];
                                                                }
                                                                if($datos_evento['caracteristicas']['s_v_resiembra']<>null){
                                                                    $total_registros++;
                                                                }
                                                                if($datos_evento['caracteristicas']['s_v_aspersion']<>null){
                                                                    $total_registros++;
                                                                }
                                                                if($datos_evento['caracteristicas']['metodo_siembra']['c_i_msiembra']){
                                                                    $total_registros++;
                                                                }else{
                                                                    $suficiencia++;
                                                                    $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_msiembra, dato recibido "'.$datos_evento['caracteristicas']['c_i_msiembra'].'"'=>$datos_evento['caracteristicas']['c_i_msiembra']];
                                                                }
                                                                if($datos_evento['caracteristicas']['s_v_coordinado']<>null){
                                                                    $total_registros++;
                                                                }
                                                                if(($datos_evento['caracteristicas']['c_v_dependencias']<>null) && ($datos_evento['caracteristicas']['c_v_dependencias']<>"")){
                                                                    $total_registros++;
                                                                }
                                                            }

                                                            if(($item['c_i_tplantio']==2) || ($item['c_i_tplantio']==3)){ //Verificamos el tipo de plantio para comparar con sus presentaciones respecto al tipo de plantío
                                                                if (in_array($item['c_i_presentacion'], $presentacion_marihuana_coca)) {//Verifica el id esté en su rango asignado (ver documentación de presentación de plantios)
                                                                    if($item['presentacion']['c_i_presentacion']){ //Verifica si existe el valor en un catálogo válido
                                                                        $total_registros++;
                                                                    }else{
                                                                        $suficiencia++; //Conteo de elementos fuera de rango
                                                                        $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_presentacion, dato recibido "'.$item['c_i_presentacion'].'"'=>$item['c_i_presentacion']];
                                                                    }
                                                                }

                                                                //Características de tipo de plantío plantío II
                                                                if($item['c_i_tplantio']==2){
                                                                    if(count($datos_evento['caracteristicas']['clima'])>0){
                                                                        $total_registros++;
                                                                    }
                                                                    if(($datos_evento['caracteristicas']['n_i_temperatura']<>null) && ($datos_evento['caracteristicas']['n_i_temperatura']>0)){
                                                                        $total_registros++;
                                                                    }
                                                                    if($datos_evento['caracteristicas']['terreno']['c_i_terreno']){
                                                                        $total_registros++;
                                                                    }else{
                                                                        $suficiencia++;
                                                                        $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_terreno, dato recibido "'.$datos_evento['caracteristicas']['c_i_terreno'].'"'=>$datos_evento['caracteristicas']['c_i_terreno']];
                                                                    }
                                                                    if(($datos_evento['caracteristicas']['s_v_expsol']<>null) && ($datos_evento['caracteristicas']['s_v_expsol']<>"")){
                                                                        $total_registros++;
                                                                    }
                                                                    if(($datos_evento['caracteristicas']['s_v_expviento']<>null) && ($datos_evento['caracteristicas']['s_v_expviento']<>"")){
                                                                        $total_registros++;
                                                                    }
                                                                    if(($datos_evento['caracteristicas']['c_i_mimetizacion']<>null) && ($datos_evento['caracteristicas']['c_i_mimetizacion']<>"")){
                                                                        $total_registros++;
                                                                    }
                                                                    if(($datos_evento['caracteristicas']['c_i_riego']<>null) && ($datos_evento['caracteristicas']['c_i_riego']<>"")){
                                                                        $total_registros++;
                                                                    }
                                                                }
                                                            }

                                                            if($item['c_i_tplantio']==3){
                                                                //Características de tipo de plantío plantío III
                                                                if($datos_evento['caracteristicas']['accesibilidad']['c_i_accesibilidad']){
                                                                    $total_registros++;
                                                                }else{
                                                                    $suficiencia++;
                                                                    $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_accesibilidad, dato recibido "'.$datos_evento['caracteristicas']['c_i_accesibilidad'].'"'=>$datos_evento['caracteristicas']['c_i_accesibilidad']];
                                                                }
                                                                if($datos_evento['caracteristicas']['terrestre']['c_i_accesot']){
                                                                    $total_registros++;
                                                                }else{
                                                                    $suficiencia++;
                                                                    $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_accesot, dato recibido "'.$datos_evento['caracteristicas']['c_i_accesot'].'"'=>$datos_evento['caracteristicas']['c_i_accesot']];
                                                                }
                                                                if(($datos_evento['caracteristicas']['c_v_novedades']<>null) && ($datos_evento['caracteristicas']['c_v_novedades']<>"")){
                                                                    $total_registros++;
                                                                }
                                                                if(($datos_evento['caracteristicas']['c_i_aseguramientos']<>null) && ($datos_evento['caracteristicas']['c_i_aseguramientos']<>"")){
                                                                    $total_registros++;
                                                                }
                                                            }

                                                            if(($item['n_i_altura']>=1) && ($item['n_i_altura']<>null)){
                                                                $total_registros++;
                                                            }
                                                            if(($item['n_i_cantidad']>=1) && ($item['n_i_cantidad']<>null)){
                                                                $total_registros++;
                                                            }
                                                            if(($item['n_i_bulbos']>=1) && ($item['n_i_bulbos']<>null)){
                                                                $total_registros++;
                                                            }
                                                        endforeach;


                                                        //Identificación /S.D.N.
                                                        if($datos_evento['identificacion']['dependencia']['c_i_dependencia']){
                                                            $total_registros++;
                                                        }else{
                                                            $suficiencia++;
                                                            $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_dependencia, dato recibido "'.$datos_evento['identificacion']['c_i_dependencia'].'"'=>$datos_evento['identificacion']['c_i_dependencia']];
                                                        }
                                                        if($datos_evento['identificacion']['region_militar']['c_i_regionm']){
                                                            $total_registros++;
                                                        }else{
                                                            $suficiencia++;
                                                            $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_regionm, dato recibido "'.$datos_evento['identificacion']['c_i_regionm'].'"'=>$datos_evento['identificacion']['c_i_regionm']];
                                                        }
                                                        if(($datos_evento['identificacion']['d_v_zonam']<>null) && ($datos_evento['identificacion']['d_v_zonam']>0) && ($datos_evento['identificacion']['d_v_zonam']<>"")){
                                                            $total_registros++;
                                                        }
                                                        if($datos_evento['identificacion']['armas']['c_i_armace']){
                                                            $total_registros++;
                                                        }else{
                                                            $suficiencia++;
                                                            $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_armace, dato recibido "'.$datos_evento['identificacion']['c_i_armace'].'"'=>$datos_evento['identificacion']['c_i_armace']];
                                                        }
                                                        if($datos_evento['identificacion']['unidad']['c_i_unidad']){
                                                            $total_registros++;
                                                        }else{
                                                            $suficiencia++;
                                                            $suficienciaArray[] = ['Sin valor en catálogo para el campo c_i_unidad, dato recibido "'.$datos_evento['identificacion']['c_i_unidad'].'"'=>$datos_evento['identificacion']['c_i_unidad']];
                                                        }
                                                        if(($datos_evento['identificacion']['n_v_unidad']<>null) && ($datos_evento['identificacion']['n_v_unidad']>0) && ($datos_evento['identificacion']['n_v_unidad']<>"")){
                                                            $total_registros++;
                                                        }
                                                        if(($datos_evento['identificacion']['n_v_unidad']<>null) && ($datos_evento['identificacion']['n_v_unidad']>0) && ($datos_evento['identificacion']['n_v_unidad']<>"")){
                                                            $total_registros++;
                                                        }
                                                        if(($datos_evento['n_v_observaciones']<>null) && ($datos_evento['identificacion']['n_v_unidad']<>"")){
                                                            $total_registros++;
                                                        }

                                                    ?>

                                                    <h5 class="card-title" style="font-weight: bold;">Nivel 1. Entrada</h5>
                                                    <div class="card-text">
                                                        <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="checkbox" class="custom-control-input update_score" id="totalRegistros" name="total_datos"
                                                                value="<?= $total_registros ?>" <?= ($total_registros>=27) ? "checked" : "" ?> >
                                                                <?php ($total_registros>=27) ? $score =  $score + 11 : "" ?>
                                                            <label class="custom-control-label" for="totalRegistros">
                                                                <h5 class="card-title">Total de datos recopilados: <?= $total_registros ?></h5>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">

                                                    <h5 class="card-title" style="font-weight: bold;">Nivel 2. Transmisión</h5>
                                                    <div class="card-text">
                                                        <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="checkbox" class="custom-control-input update_score" id="imei" name="imei"
                                                                value="<?= ($datos_evento['dispositivos']['imei']) ? 1 : 0 ?>"
                                                                <?= ($datos_evento['dispositivos']['imei']) ? "checked" : "" ?>>
                                                            <label class="custom-control-label" for="imei">
                                                                <h5 class="card-title" style="text-align: left">Autenticación IMEI: <?= $datos_evento['n_v_imei'] ?></h5>
                                                            </label>
                                                        </div>
                                                        <?php ($datos_evento['dispositivos']['imei']) ? $score =  $score + 12 : "" ?>
                                                    </div>
                                                    <div class="card-text">
                                                        <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="checkbox" class="custom-control-input update_score" id="seguridad" name="seguridad"
                                                                value="<?= (($datos_evento['validaciones']['s_v_status'] == "A")) ? 1 : 0 ?>"
                                                                <?= ($datos_evento['validaciones']['s_v_status']) ? "checked" : "" ?>>
                                                            <label class="custom-control-label" for="seguridad">
                                                                <h5 class="card-title" style="text-align: left">Seguridad: <?= (($datos_evento['validaciones']['s_v_status'] == "A")) ? 'Validado' : 'Sin validación' ?></h5>
                                                            </label>
                                                        </div>
                                                        <?php (($datos_evento['validaciones']['s_v_status'] == "A")) ? $score =  $score + 12 : "" ?>
                                                    </div>
                                                    <div class="card-text">
                                                        <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="checkbox" class="custom-control-input update_score" id="transmision" name="transmision"
                                                                value="1">
                                                            <label class="custom-control-label" for="transmision">
                                                                <h5 class="card-title">Transmision: <a href="{{route('generar_acuse_pdf', ['id' => $datos_evento['c_v_evento']])}}" class="tooltipsC" title="Ver acuse de recibo">Ver acuse de recibo</a></h5>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-5">
                                            <div class="card">
                                                <div class="card-body">

                                                    <h5 class="card-title" style="font-weight: bold;">Nivel 3. Calidad</h5>
                                                    <div class="card-text">
                                                        <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="checkbox" class="custom-control-input update_score" id="integridad" name="integridad"
                                                                value="<?= (($datos_evento['validaciones']['s_v_status'] == "A")) ? 1 : 0 ?>"
                                                                <?= ($datos_evento['validaciones']['s_v_status']) ? "checked" : "" ?>>
                                                            <label class="custom-control-label" for="integridad">
                                                                <h5 class="card-title" style="text-align: left">Integridad: <?= (($datos_evento['validaciones']['s_v_status'] == "A")) ? 'Ok' : 'Sin integridad' ?></h5>
                                                            </label>
                                                        </div>
                                                        <?php (($datos_evento['validaciones']['s_v_status'] == "A")) ? $score =  $score + 12 : "" ?>
                                                    </div>
                                                    <div class="card-text">
                                                        <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="checkbox" class="custom-control-input update_score" id="suficiencia" name="suficiencia"
                                                                value="<?= ($suficiencia==0) ? 1 : 0 ?>" <?= ($suficiencia==0) ? "checked" : "" ?>>
                                                            <label class="custom-control-label" for="suficiencia">
                                                                <h5 class="card-title">Suficiencia: <a href="#" title="Ver datos fuera de rango"
                                                                        onclick="suficiencia()"> <?= $suficiencia ?> datos fuera de rango</a></h5>
                                                            </label>
                                                        </div>
                                                        <?php ($suficiencia==0) ? $score = $score + 11 : "" ?>
                                                    </div>
                                                    <hr>
                                                    <?php
                                                        $date1 = new DateTime($datos_evento['f_t_captura']);
                                                        $date2 = new DateTime($datos_evento['f_t_registro']);
                                                        $diff = $date1->diff($date2);
                                                    ?>

                                                    <div class="card-text">
                                                        <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="checkbox" class="custom-control-input update_score" id="diferencia_dias"
                                                                name="diferencia_dias" value="1"
                                                                <?= (intval($diff->days)<30) ? "checked" : "" ?> >
                                                            <label class="custom-control-label" for="diferencia_dias">
                                                                <p class="card-title">
                                                                    Fecha de captura: <?= $date1->format('Y-m-d') ?>
                                                                </p>
                                                                <p class="card-title">
                                                                    Fecha de registro: <?= $date2->format('Y-m-d') ?>
                                                                </p>

                                                                <p style="text-align: center" class="card-title">
                                                                    <strong>Días de diferencia: <?=  $diff->days . ' días '; ?></strong>
                                                                </p>
                                                                <?php ($diff->days>30) ? $score = $score + 5 : $score = $score + 10 ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $coordenadas = explode(",",$datos_evento["coordenada_central"]["d_v_medio"]);
                                                    ?>
                                                    <hr>
                                                    <div class="card-text">

                                                        <h5 class="card-title col-md-12" style="text-align: center">
                                                            <p>Georeferenciación</p>
                                                        </h5>

                                                        <div class="card-title">
                                                            Estado: <?= $datos_evento['estado']['NOMBRE'] ?><br />
                                                            Municipio: <?= $datos_evento['municipio']['NOMBRE'] ?><br />
                                                            Localidad: <?= $datos_evento['localidad']['NOMBRE'] ?><br />
                                                        </div>

                                                       <div class="card-title col-md-12" style="text-align: center; font-size: 16px">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input georeferencia update_score" type="radio" name="georeferencia" id="georeferencia1"
                                                                    value="11">
                                                                <label class="form-check-label" for="inlineRadio1">Coincide</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input georeferencia update_score" type="radio" name="georeferencia" id="georeferencia2"
                                                                    value="5">
                                                                <label class="form-check-label" for="inlineRadio2">En la frontera</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input georeferencia update_score" type="radio" name="georeferencia" id="georeferencia3"
                                                                    value="0">
                                                                <label class="form-check-label" for="inlineRadio3">No coincide</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-text col-md-12" id="contenedorMapa"></div>

                                                    <div class="card-text" style="margin-top: 30px">
                                                            <div class="custom-switch custom-switch-off-danger custom-switch-on-success">

                                                                <table style="margin-top: 15px">
                                                                    <input type="checkbox" class="custom-control-input update_score" id="evidencia" name="evidencia" value="1">
                                                                    <label class="custom-control-label" for="evidencia"><h5 class="card-title">Evidencia</h5></label>
                                                                    <?php
                                                                    $tipo_imagen = 1;
                                                                    foreach ($data['metadatos'] as $index_image => $image):
                                                                        if($image['c_i_timagen']==$tipo_imagen):
                                                                    ?>
                                                                            <td>
                                                                                <img style="cursor: pointer" onclick="switchImg(this)" data-nameimage={{ $image['d_v_nombre'] }} height="50px" width="70px" src="{{asset("assets/img/evidencias/antes/2a87fa4355e6_1.-_SDN-2125-19_ANTES.jpg")}}">
                                                                                <span style="font-size: 10px"><?= $image['d_v_nombre'] ?></span>
                                                                            </td>
                                                                    <?php
                                                                            $tipo_imagen++;
                                                                        endif;
                                                                    endforeach
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    //dump($evento[0]);
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title" style="font-weight: bold;">Validación</h5>
                                                    <h5 class="card-title" id="score_label">Score: {{ $score }} puntos</h5>

                                                    <input type="hidden" name="total_puntos" id="total_puntos" class="form-control" value="<?= $score ?>" required />
                                                    <input type="hidden" name="id_evento" id="id_evento" class="form-control" value="<?= $datos_evento['c_v_evento'] ?>" required />
                                                    <div class="card-text">
                                                        <h5 class="card-title">Estatus:</h5>
                                                        <div id="circulo1" class="color1 tooltipsC col-sm-4 col-md-4" style="cursor: pointer; height: 30px;"
                                                            title="Validado (≥ 90 puntos)"></div>
                                                        <p> Validado</p>
                                                        <div id="circulo2" class="color2 tooltipsC col-sm-4 col-md-4" style="cursor: pointer; height: 30px;"
                                                        title="Pendiente (Sin puntaje asignado)"></div>
                                                        <p> Pendiente</p>
                                                        <div id="circulo3" class="color3 tooltipsC col-sm-4 col-md-4" style="cursor: pointer; height: 30px;"
                                                            title="Rechazado (< 90 puntos)"></div>
                                                        <p> Rechazado</p>
                                                    </div>

                                                    <div class="card-text">
                                                        <div class="form-group row">
                                                            <label for="observaciones_validador" class=" control-label">Observaciones del validador:</label>
                                                            <textarea name="observaciones_validador" rows="5" id="observaciones_validador" class="form-control" maxlength="500"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success">Validar</button>
                                </div>

                            </div>
                        </div>
                    </form>
                @else
                    <div class="card ">
                        <h5 class="card-header">Validación</h5>
                        <div class="card-body">
                            <h5 class="card-title">Para iniciar una validación seleccione una clave de evento de la tabla de arriba.</h5>
                            <p class="card-text">
                                Los estatus de las validaciones se ecuentran en la columna "Validación" de la tabla de arriba e identificados
                                por colores que representan los 3 posibles estatus de la validación las cuales son:
                            </p>

                                <div id="circulo1" class="color1 tooltipsC col-sm-4 col-md-4" style="cursor: pointer; height: 30px;" title="Validado"></div><p> Validado</p>
                                <div id="circulo2" class="color2 tooltipsC col-sm-4 col-md-4" style="cursor: pointer; height: 30px;" title="Pendiente"></div><p> Pendiente</p>
                                <div id="circulo3" class="color3 tooltipsC col-sm-4 col-md-4" style="cursor: pointer; height: 30px;" title="Rechazado"></div><p> Rechazado</p>

                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

<script>

    function verAcuse(){
        alert('Ver acuse');
    }

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
                "lengthMenu": [[3, 5, 10, -1], [3, 5, 10, "Todos"]],
                "pageLength": 3
            });
        @else
            //DATATABLES INITIALIZE
            $('#example').DataTable({
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "paging": false,
                "bInfo" : false,//Para bloquear/desbloquear la paginación
                "bFilter": false,
            });
        @endif

        //$.fn.DataTable.ext.pager.numbers_length = 2;

        /*$(".table td").each(function(){
            $(this).text($.trim($(this).text())); //Se remueve porque elimina los colores de semaforo
        });*/

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

        var temp_val_geolocalizacion = 0;

        //VALIDA VALOR DE LA GEORREFERENCIA
        /*$('.georeferencia').bind("click", function (event) {
            var score = parseInt($("#score").val());
            score = score - temp_val_geolocalizacion;
            var score = parseInt($(this).val()) + score;
            $('#score').val(score).trigger('change');
            $('#score_label').text('Score: '+score+' puntos');
            temp_val_geolocalizacion = parseInt($(this).val());
        });*/

        //ACTUALIZA EL SCORE DEPENDIENDO DE ACTIVACION O DESACTIVACION DE CHECKS
        $( '.update_score' ).on( 'click', function() {
            var conteo = 5; //Direfrencia de días siempre son 5
            var score = parseInt($("#total_puntos").val());
            $(".update_score:checked").each(
                function() {
                    if( $(this).is(':checked') ){
                        if($(this).attr("name")=='total_datos'){
                            conteo = conteo + 11;
                        }
                        if($(this).attr("name")=='imei'){
                            conteo = conteo + 12;
                        }
                        if($(this).attr("name")=='seguridad'){
                            conteo = conteo + 12;
                        }
                        if($(this).attr("name")=='integridad'){
                            conteo = conteo + 11;
                        }
                        if($(this).attr("name")=='suficiencia'){
                            conteo = conteo + 11;
                        }
                        if($(this).attr("name")=='transmision'){
                            conteo = conteo + 11;
                        }
                        if($(this).attr("name")=='diferencia_dias'){
                            conteo = conteo + 5;
                        }
                        if($(this).attr("name")=='evidencia'){
                            conteo = conteo + 11;
                        }
                        if(($(this).attr("name")=='georeferencia') && ($(this).attr("id") == 'georeferencia1')){
                            conteo = conteo + 11;
                        }
                        if(($(this).attr("name")=='georeferencia') && ($(this).attr("id") == 'georeferencia2')){
                            conteo = conteo + 5;
                        }

                    }
                    console.log('conteo: '+conteo+' Nombre: ' +$(this).attr("name")+' ID: ' +$(this).attr("id"));
                }
            );
            $('#score_label').text('Score: '+conteo+' puntos');
            $('#total_puntos').val(conteo).trigger('change');
        });

    });

    function suficiencia(){
        $('#suficienciaModal').modal('show');
    }

    function openMap(lon, lat){
        $("#map").remove();
        $("#contenedorMapa").after($('<div/>', {
            class: 'gmap3',
            id: "map",
            style: 'width: 100%;height: 340px;'
        }));

        console.log('lat1: '+lat);
        console.log('lon1: '+lon);

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lon},
            mapTypeId: 'hybrid',
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            }
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
              $("#infoMapa").text('información '+results[0].formatted_address);
              console.log(results);
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

    <?php  if (isset($evento) && ($evento<>null) && ($evento<>[]) && (empty($evento[0]["validacion_dashboard"]))): ?>
        $(document).ready(function(){
            openMap(<?= $coordenadas[0] ?>,<?= $coordenadas[1] ?>);
        });
    <?php endif; ?>

    function switchImg(img){
        console.log('img.src: '+img.src);
        console.log($(img).data('nameimage'));
        $("#titulo_evidencia").text("Nombre de evidencia: "+$(img).data('nameimage'));
        $('#img_src_modal').attr('src', img.src);
        $('#evidencia_modal').modal('show');
    }

    function verifica(){

        var cont = 0;
        $(".georeferencia:checked").each(function() {
            cont++;
            console.log(cont);
        });

        if(cont > 0){
            return true;
        }else{
            alert('Selecciona una opción en georreferencia');
            return false;
        }

    }

</script>

    @if (isset($evento) && ($evento<>null) && ($evento<>[]) && (empty($evento[0]["validacion_dashboard"])))
        <!-- Modal Suficiencia-->
        <div class="modal fade bd-example-modal-lg" id="suficienciaModal" tabindex="-1" role="dialog" aria-labelledby="suficiencia" aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Datos fuera de rango</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Total datos fuera de rango: <?= $suficiencia ?></h5>
                    <?php
                        if($suficiencia>0):
                    ?>
                    <p>Detalles de los datos fuera de rango encontrados:</p>
                    <ul>
                        <?php
                            foreach($suficienciaArray as $item):
                        ?>
                        <li>
                            @foreach($item as $index => $item)
                                <?= $index ?>
                            @endforeach
                        </il>
                        <?php
                            endforeach;
                        ?>
                    </ul>
                    <?php
                        endif;
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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

    @endif;
@endsection
