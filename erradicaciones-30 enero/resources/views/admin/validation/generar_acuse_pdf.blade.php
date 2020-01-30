<!DOCTYPE html>
<html>

<head>
    <style>
        /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0.5cm;
            left: 0.5cm;
            right: 0cm;
            height: 3cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        p {
            line-height: 0.1cm;
        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <img src="http://localhost/erradicaciones/public/assets/img/logo.jpg" width="13%" height="100%" />
    </header>

    <footer>
        <img src="http://localhost/erradicaciones/public/assets/img/footer.jpg" width="100%" height="100%" />
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        @if ((isset($data[0])) && (!empty($data[0])))
        <?php $datos = $data[0]; ?>
        <h3 style="text-align: center">ACUSE DE RECIBO</h3>
        <h4 style="text-align: center">FOLIO: {{ $datos['c_v_evento'] }}</h4>
        <p><b>Usuario:</b> {{ $datos['c_v_usureg'] }}</p>
        <p><b>Fecha de generación:</b> <?= date("Y-m-d H:i:s") ?></p>
        <p><b>Superficie:</b> {{ formatMoney($datos["coordenada_central"]['n_d_area'], 2) }} m<sup>2</sup></p>
        <p><b>Fecha y hora de envío:</b> {{ $datos['f_t_envio'] }}</p>
        <p><b>Fecha y hora de registro:</b> {{ $datos['f_t_registro'] }}</p>

        <?php
            $count = 3;
        ?>

        @foreach ($datos['plantios'] as $plantio)

        @if($plantio["tipo_plantio"]!=[])
            <p><h4>{{ $plantio['tipo_plantio']['d_v_tplantio'] }}</h4></p>
        @else
            <p><h4>Sin opción en catálogo</h4></p>
        @endif

        @if($plantio["c_i_tplantio"]==1)
            <p style="margin-left: 50px;">Color de la Flor: {{ $plantio['color_flor']['d_v_cflor'] }}</p>
            <p style="margin-left: 50px;">Número de bulbos: {{ ($plantio['n_i_bulbos']==null) ? 0 : $plantio['n_i_bulbos'] }}</p>
            <p style="margin-left: 50px;">Etapa: {{ $plantio['etapa']['c_i_etapa'] }}</p>
        @endif

        <p style="margin-left: 50px;">Altura: {{ $plantio['n_i_altura'] }}</p>

        @if($plantio["presentacion"]!=[])
            <p style="margin-left: 50px;">Presentación: {{ $plantio['presentacion']['d_v_presentacion'] }}</p>
        @else
            <p style="margin-left: 50px;">Presentación: Sin opción en catálogo</p>
        @endif

        <p style="margin-left: 50px;">Peso en Densidad x m/2: {{ $plantio['n_i_cantidad'] }}</p>

        <?php $count--; ?>
        @endforeach
        <br/>
        <p><h4>CARÁCTERISTICAS DEL PLANTÍO</h4></p>
        <p style="margin-left: 50px;">Método de Erradicación: {{ $datos['caracteristicas']['metodo_erradicacion']['d_v_merradica'] }}</p>
        <p style="margin-left: 50px;">Manejo Cultural: {{ $datos['caracteristicas']['manejo_cultural']['d_v_manejoc'] }}</p>
        <p style="margin-left: 50px;">Presenta Resiembra: {{ $datos['caracteristicas']['s_v_resiembra'] }} </p>
        <p style="margin-left: 50px;">Afectado por Aspersión:{{ $datos['caracteristicas']['s_v_aspersion'] }}</p>
        <p style="margin-left: 50px;">Método de Siembra: {{ $datos['caracteristicas']['metodo_siembra']['d_v_msiembra'] }}</p>
        <p style="margin-left: 50px;">Evento Coordinado: {{ $datos['caracteristicas']['s_v_coordinado'] }} </p>
        <p style="margin-left: 50px;">Evento Coordinado-Dependencia: {{ $datos['caracteristicas']['c_v_dependencias'] }} </p>
        <p style="margin-left: 50px;">Clima: {{ $datos['caracteristicas']['clima']['d_v_clima'] }} </p>
        <p style="margin-left: 50px;">Temperatura: {{ ($datos['caracteristicas']['n_i_temperatura']==null) ? 'null': $datos['caracteristicas']['n_i_temperatura'] }} </p>
        <p style="margin-left: 50px;">Tipo de Terreno: {{ $datos['caracteristicas']['terreno']['d_v_terreno'] }} </p>
        <p style="margin-left: 50px;">Exposición al Sol: {{ $datos['caracteristicas']['s_v_expsol'] }} </p>
        <p style="margin-left: 50px;">Exposición al Viento: {{ $datos['caracteristicas']['s_v_expviento'] }} </p>
        <p style="margin-left: 50px;">Mimetización: {{ $datos['caracteristicas']['mimetizacion']['d_v_mimetizacion'] }} </p>
        <p style="margin-left: 50px;">Sistema de Riego: {{ $datos['caracteristicas']['riego']['d_v_riego'] }} </p>
        <p style="margin-left: 50px;">Fertilizante: {{ $datos['caracteristicas']['s_v_fertilizante'] }} </p>
        <p style="margin-left: 50px;">Viviendas: {{ $datos['caracteristicas']['s_v_viviendas'] }} </p>
        <p style="margin-left: 50px;">Accesibilidad: {{ $datos['caracteristicas']['accesibilidad']['d_v_accesibilidad'] }} </p>
        <p style="margin-left: 50px;">Accesibilidad-Terrestre: {{ ($datos['caracteristicas']['c_i_accesot']==null) ? 'null': $datos['caracteristicas']['c_i_accesot'] }} </p>
        <p style="margin-left: 50px;">Novedad: {{ ($datos['caracteristicas']['c_v_novedades']=='') ? '[]': $datos['caracteristicas']['c_v_novedades'] }} </p>
        <p style="margin-left: 50px;">Otros Aseguramientos: {{ ($datos['caracteristicas']['c_i_aseguramientos']=='') ? '[]': $datos['caracteristicas']['c_i_aseguramientos'] }} </p>

        <br/>
        <p><h4>IDENTIFICACIÓN</h4></p>
        <p style="margin-left: 50px;">Dependencia: {{ $datos['identificacion']['dependencia']['d_v_dependencia'] }}</p>
        <p style="margin-left: 50px;">Región Militar: {{ $datos['identificacion']['region_militar']['d_v_regionm'] }}</p>
        <p style="margin-left: 50px;">Zona Militar: {{ $datos['identificacion']['d_v_zonam'] }}</p>
        <p style="margin-left: 50px;">Arma o Cuerpo Especial: {{ $datos['identificacion']['armas']['d_v_armace'] }}</p>
        <p style="margin-left: 50px;">Unidades: {{ $datos['identificacion']['unidad']['d_v_unidad'] }}</p>
        <p style="margin-left: 50px;">Número Unidad: {{ $datos['identificacion']['n_v_unidad'] }}</p>

        <br/>
        <p><h4>EVIDENCIA</h4></p>
        <p style="margin-left: 50px;">Estado: {{ $datos['estado']['NOMBRE'] }}</p>
        <p style="margin-left: 50px;">Municipio: {{ $datos['municipio']['NOMBRE'] }}</p>
        <p style="margin-left: 50px;">Localidad: {{ $datos['localidad']['NOMBRE'] }}</p>

        <br/>
        <p style="margin-left: 50px;"><h4>COORDENADAS</h4></p>
        @foreach ($datos['coordenadas'] as $index2 => $coordenada)
            <p style="margin-left: 50px;">latitud = {{ $coordenada['d_v_latitude'] }}, longitud  = {{ $coordenada['d_v_longitude'] }}, altitud  = {{ $coordenada['d_v_altitude'] }}</p>
        @endforeach

        <div style="page-break-after:always;"></div>

        <?php
        $tipo_imagen = 1;
        foreach ($datos['metadatos'] as $index_image => $image):
            if($image['c_i_timagen']==$tipo_imagen):
                if($index_image==2):
                    echo '<div style="page-break-after:always;"></div>';
                endif;
        ?>

                <p style="tetx-align: center"><h4 style="text-align: center">EVIDENCIA {{ $image['c_i_timagen']['tipo_imagen']['d_v_timagen'] }} DE LA ERRADICACIÓN</h4></p>
                <p><img style="margin-left: 25%;" width="50%" height="50%" src="{{asset("assets/img/evidencias/antes/2a87fa4355e6_1.-_SDN-2125-19_ANTES.jpg")}}"></p>
                <p><h5 style="text-align: center">Información de fotografía</h5></p>
                <p style="margin-left: 50px;">Coordenadas: latitud = {{ $image['d_v_latitude'] }}, longitud  = {{ $image['d_v_longitude'] }}, altitud  = {{ $image['d_v_altitude'] }}</p>
                <p style="margin-left: 50px;">Dirección: {{ $image['d_v_rotacion'] }}</p>

        <?php
                $tipo_imagen++;
            endif;
        endforeach
        ?>

        @else
        <h2 style="color: red">Lo sentimos, sin datos para esta clave proporcionada.</h2>
        @endif
    </main>
</body>

</html>
