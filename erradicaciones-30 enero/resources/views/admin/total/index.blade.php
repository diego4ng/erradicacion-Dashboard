@extends("theme.$theme.layout")
@section('titulo')
Totales
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
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
                        <p style="margin-bottom: 0.5rem;">Filtro de estado(s):
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

                <!-- Tabs -->
                <section id="tabs">
                    <div class="container">
                        <h6 class="section-title h1">TOTALIDADES:</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Tipo de plantío</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Presentación de plantío</a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Área erradicada por tipo de plantío</a>
                                    </div>
                                </nav>
                                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                        <!-- Small boxes (Stat box) -->
                                        <?php
                                            $bginfo = ['bg-info','bg-success','bg-danger','bg-warning','bg-secondary','bg-primary','bg-secondary','bg-dark','bg-info','bg-success','bg-danger','bg-warning','bg-secondary','bg-primary','bg-secondary','bg-dark'];
                                        ?>
                                        <div class="row text-center col-xs-12">
                                            @foreach ($tipos_plantio as $indexTipos => $tipo_plantio )

                                                <?php $total = 0; ?>

                                                @foreach ($data_plantios as $index => $plantio )
                                                    @if ($plantio['c_i_tplantio'] == $indexTipos)
                                                        <?php $total = $plantio['count']; ?>
                                                    @endif
                                                @endforeach

                                                <div class="col-lg-4 col-6">
                                                    <!-- small box -->
                                                    <div class="small-box {{ $bginfo[rand(0, 15)] }}">
                                                        <div class="inner">
                                                            <h3>{{ $total }}</h3>
                                                            <p><h3>{{ $tipo_plantio }}</h3></p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-bag"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <!-- Small boxes (Stat box) -->
                                        <div class="row text-center col-xs-12">

                                            @foreach ($tipos_presentacion as $indexPresentacion => $tipo_presentacion )

                                                <?php $total = 0; ?>

                                                @foreach ($data_presentacion as $index => $presentacion )
                                                    @if ($presentacion['c_i_presentacion'] == $indexPresentacion)
                                                        <?php $total = $presentacion['count']; ?>
                                                    @endif
                                                @endforeach

                                                <div class="col-lg-4 col-6">
                                                    <!-- small box -->
                                                    <div class="small-box {{ $bginfo[rand(0, 15)] }}">
                                                        <div class="inner">
                                                            <h3>{{ $total }}</h3>
                                                            <p><h3>{{ $tipo_presentacion }}</h3></p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-bag"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach

                                        </div>
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

                                        <!-- Small boxes (Stat box) -->
                                        <div class="row text-center col-xs-12">
                                            @foreach ($totalesAreaPlantio as $index => $total_area )
                                                <div class="col-lg-4 col-6">
                                                    <!-- small box -->
                                                    <div class="small-box {{ $bginfo[rand(0, 15)] }}">
                                                        <div class="inner text-center">
                                                            <label style="font-size: 16px">{{ formatMoney($total_area, 1) }} m<sup>2</sup></label>
                                                                <hr>
                                                            <label style="font-size: 16px">{{ formatMoney(($total_area / 10000), 1) }} ha</label>

                                                            <p><h3>
                                                                {{ $tipos_plantio[$index] }}
                                                            </h3></p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-bag"></i>
                                                        </div>
                                                        <!--a-- href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></!--a-->
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

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
