@extends("theme.$theme.layout")
@section('titulo')
Gráficas
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/core.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/charts.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/themes/animated.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/themes/material.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/js/amcharts4/data-graficas.js")}}" type="text/javascript"></script>
@endsection

@section('contenido')

<div class="row">
    <div class="col-lg-12">
        @include('includes.mensaje')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title" style="max-width: 75%;">
                    @if (request()->startDate < request()->endDate)
                        Filtro rango de fechas de: {{ request()->startDate }} a {{ request()->endDate }}
                    @endif

                    @if ((request()->startDate < request()->endDate) && (isset(request()->estado_ids)))
                        <hr>
                    @endif

                    @if (isset(request()->estado_ids))
                        Filtro de estado(s):
                        @foreach (request()->estado_ids as $estado_id)
                            {{ $catalogo_estados[$estado_id] }} /
                        @endforeach
                    @endif
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-filter" aria-hidden="true"></i> Filtrar información
                    </button>
                </div>
            </div>
            <div class="box-body">
                <!-- Tabs -->
                <section id="tabs">
                    <div class="container">
                        <h6 class="section-title h1">GRÁFICAS DE TOTALIDADES:</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Tipo de plantío</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Presentación de plantío</a>
                                        <a class="nav-item nav-link" id="nav-indstitucion-tab" data-toggle="tab" href="#nav-indstitucion" role="tab" aria-controls="nav-indstitucion" aria-selected="false">Institución que erradica</a>
                                        <a class="nav-item nav-link" id="nav-hectarea-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Área erradicada por tipo de plantío m<sup>2</sup></a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-hectarea" role="tab" aria-controls="nav-hectarea" aria-selected="false">Área erradicada por tipo de plantío ha</a>
                                    </div>
                                </nav>
                                <div class="tab-content py-3 px-3 px-sm-0 col-md-12" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                        <div class="row text-center col-xs-12">

                                            @foreach ($data_plantios as $index => $plantio )

                                                <?php
                                                    $tipos_plantios[$index] = $plantio['count'];
                                                    $tipos_plantios_text[$index] = $plantio['tipo_plantio']['d_v_tplantio'];
                                                ?>

                                            @endforeach
                                        </div>

                                        <script language='javascript' type='text/javascript'>
                                            var misDatos = new Array();
                                        </script>

                                        @foreach ($data_plantios as $index => $plantio)

                                            <script language='javascript' type='text/javascript'>
                                                misDatos[<?= $index ?>] = { "tipo_plantio":"<?= $tipos_plantios_text[$index]; ?>","total": <?= $tipos_plantios[$index] ?> };
                                            </script>

                                        @endforeach

                                        <div id="chartdivtipos" style="width: 100%; height: 500px"></div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                                        <div class="row text-center col-xs-12">
                                            @foreach ($data_presentacion as $index => $presentacion )

                                                <?php
                                                    $tipos_presentaciones[$index] = $presentacion['count'];
                                                ?>

                                                @if($presentacion['presentacion']['d_v_presentacion']==null)
                                                    <?php $tipos_presentaciones_text[$index] = 'Otra'; ?>
                                                @else
                                                    <?php $tipos_presentaciones_text[$index] = $presentacion['presentacion']['d_v_presentacion']; ?>
                                                @endif

                                                @endforeach

                                            <script language='javascript' type='text/javascript'>
                                                var misDatosPresentacion = new Array();
                                            </script>

                                            <?php
                                                foreach ($data_presentacion as $index => $presentacion){
                                            ?>
                                                    <script language='javascript' type='text/javascript'>
                                                        misDatosPresentacion[<?= $index ?>] = { "tipo_presentacion":"<?= $tipos_presentaciones_text[$index]; ?>","total_presentacion": <?= $tipos_presentaciones[$index]?> };
                                                    </script>
                                            <?php
                                                }
                                            ?>
                                        </div>

                                        <div id="chartdivpresentacion" style="width: 100%; height: 500px"></div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-indstitucion" role="tabpanel" aria-labelledby="nav-indstitucion-tab">


                                        <?php $totalesIntituciones = Array(); ?>

                                        @foreach ($data_institucion_erradica as $index => $institucion )
                                            <?php $totalesIntituciones[$institucion['institucion_erradica']['c_i_dependencia']] = 0; ?>
                                        @endforeach

                                        @foreach ($data_institucion_erradica as $index => $institucion )
                                            <?php $totalesIntituciones[$institucion['institucion_erradica']['c_i_dependencia']] = $totalesIntituciones[$institucion['institucion_erradica']['c_i_dependencia']] + 1; ?>
                                        @endforeach

                                        <script language='javascript' type='text/javascript'>
                                            var misDatosInstituciones = new Array();
                                        </script>

                                        <?php
                                            foreach ($totalesIntituciones as $index => $totalInstituciones){
                                        ?>
                                            <script language='javascript' type='text/javascript'>
                                                misDatosInstituciones[<?= $index ?>] = { "tipo_institucion":"<?= $tipos_institucion[$index]; ?>","total_institucion": <?= $totalInstituciones?> };
                                            </script>
                                        <?php
                                            }
                                        ?>

                                        <div id="chartInstituciones" style="width: 100%; height: 500px"></div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <?php
                                            $totalesAreaPlantio = [];
                                        ?>
                                        @foreach ($tipos_plantio as $index => $tipo_plantio )
                                            <?php $totalesAreaPlantio[$index] = 0 ?>
                                        @endforeach

                                        @foreach ($data_area as $index => $area )
                                            <?php $totalesAreaPlantio[$area['c_i_tplantio']] = $totalesAreaPlantio[$area['c_i_tplantio']] + $area['area_erradicada']['n_d_area']; ?>
                                        @endforeach

                                        <script language='javascript' type='text/javascript'>
                                            var misDatosArea = new Array();
                                        </script>

                                        <?php
                                            foreach ($totalesAreaPlantio as $index => $totalArea){
                                        ?>
                                                <script language='javascript' type='text/javascript'>
                                                    misDatosArea[<?= $index ?>] = { "tipo_plantio_area":"<?= $tipos_plantio[$index]; ?>","total_area": <?= $totalesAreaPlantio[$index]?> };
                                                </script>
                                        <?php
                                            }
                                        ?>

                                        <div id="chartdivarea" style="width: 100%; height: 500px"></div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-hectarea" role="tabpanel" aria-labelledby="nav-hectarea-tab">
                                        <?php
                                            $totalesAreaPlantioHectarea = [];
                                        ?>
                                        @foreach ($tipos_plantio as $index => $tipo_plantio )
                                            <?php $totalesAreaPlantioHectarea[$index] = 0 ?>
                                        @endforeach

                                        @foreach ($data_area as $index => $area )
                                            <?php $totalesAreaPlantioHectarea[$area['c_i_tplantio']] = $totalesAreaPlantioHectarea[$area['c_i_tplantio']] + ($area['area_erradicada']['n_d_area'] / 10000); ?>
                                        @endforeach

                                        <script language='javascript' type='text/javascript'>
                                            var misDatosAreaHectarea = new Array();
                                        </script>

                                        <?php
                                            foreach ($totalesAreaPlantioHectarea as $index => $totalArea){
                                        ?>
                                                <script language='javascript' type='text/javascript'>
                                                    misDatosAreaHectarea[<?= $index ?>] = { "tipo_plantio_area_hectarea":"<?= $tipos_plantio[$index]; ?>","total_area_hectarea": <?= $totalesAreaPlantioHectarea[$index]?> };
                                                </script>
                                        <?php
                                            }
                                        ?>

                                        <div id="chartdiha" style="width: 100%; height: 500px"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

@endsection
