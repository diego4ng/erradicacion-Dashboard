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

        .tabla-derecha{
            position: fixed;
            top: 6cm;
            left: 11cm;
            right: 0.5cm;
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
        td{
            border:1px solid black,
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
        <h3 style="text-align: center">REPORTE DE VALIDACIÓN DEL EVENTO</h3>
        <h2 style="text-align: center; color: blue">{{ $datos['c_v_evento'] }}</h2>

        <table class="bordered tabla-derecha" cellspacing="0">
            <tr>
                <td style="width:150px; font-weight: bold; background-color: #e1e1e1">Fecha de validación</td>
                <td style="width:150px; text-align: center">{{ $datos['validacion_dashboard']['created_at'] }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;background-color: #e1e1e1">Validador</td>
                <td style="width:150px; text-align: center">{{ $datos['validacion_dashboard']['usuario_validador']['name'] }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;background-color: #e1e1e1">Score</td>
                <td style="font-weight: bold; text-align: center">{{ $datos['validacion_dashboard']['total_puntos'] }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; background-color: #e1e1e1">Status</td>
                <?php
                    if($datos['validacion_dashboard']['total_puntos']>=90){
                        echo '<td style="font-weight: bold; background-color: #009d17; text-align: center">VALIDADO</td>';
                    }else{
                        echo '<td style="font-weight: bold; background-color: #e70000; text-align: center">RECHAZADO</td>';
                    }
                ?>

            </tr>
        </table>

        <br/><br/><br/><br/><br/>

        <h3>NIVEL 1. ENTRADA</h3>
        <table class="bordered" cellspacing="0" style="width: 100%">
            <tr style="font-weight: bold; background-color: #e1e1e1">
                <td style="width: 30%">Criterio</td>
                <td style="width: 50%">Resultado</td>
                <td style="width: 20%; text-align: center">Puntaje</td>
            </tr>
            <tr>
                <td>1.1 Recopilación</td>
                <td>Resultado</td>
                <td style="text-align: center; <?= ($datos['validacion_dashboard']['total_datos']<27) ? 'background-color: #f7bd35' : ''; ?>"><?= ($datos['validacion_dashboard']['total_datos']>=27) ? 11 : 0; ?></td>
            </tr>
        </table>

        <h3>NIVEL 2. TRANSMISIÓN</h3>
        <table class="bordered" cellspacing="0" style="width: 100%">
            <tr style="font-weight: bold; background-color: #e1e1e1">
                <td style="width: 30%">Criterio</td>
                <td style="width: 50%">Resultado</td>
                <td style="width: 20%; text-align: center">Puntaje</td>
            </tr>
            <tr>
                <td>2.1 Autenticación</td>
                <td>IMEI:{{ $datos['n_v_imei'] }}</td>
                <td style="text-align: center; <?= ($datos['validacion_dashboard']['imei']==0) ? 'background-color: #f7bd35' : ''; ?>"><?= ($datos['validacion_dashboard']['imei']==1) ? 12 : 0; ?></td>
            </tr>
            <tr>
                <td>2.2. Seguridad</td>
                <td><?= ($datos['validacion_dashboard']['seguridad']==1) ? 'Validado' : 'Sin validar'; ?></td>
                <td style="text-align: center; <?= ($datos['validacion_dashboard']['seguridad']==0) ? 'background-color: #f7bd35' : ''; ?>"><?= ($datos['validacion_dashboard']['seguridad']==1) ? 12 : 0; ?></td>
            </tr>
            <tr>
                <td>2.3. Transmisión</td>
                <td><?= ($datos['validacion_dashboard']['transmision']==1) ? 'Acuse de recibo '. $datos['c_v_evento'] : 'Sin acuse de recibo'; ?></td>
                <td style="text-align: center;<?= ($datos['validacion_dashboard']['transmision']==0) ? 'background-color: #f7bd35' : ''; ?>"><?= ($datos['validacion_dashboard']['transmision']==1) ? 11 : 0; ?></td>
            </tr>
        </table>

        <h3>NIVEL 3. CALIDAD</h3>
        <table class="bordered" cellspacing="0" style="width: 100%">
            <tr style="font-weight: bold; background-color: #e1e1e1">
                <td style="width: 30%">Criterio</td>
                <td style="width: 50%">Resultado</td>
                <td style="width: 20%; text-align: center">Puntaje</td>
            </tr>
            <tr>
                <td>3.1 Integridad</td>
                <td><?= ($datos['validacion_dashboard']['integridad']==1) ? 'OK' : 'SIN INTEGRIDAD'; ?></td>
                <td style="text-align: center;<?= ($datos['validacion_dashboard']['integridad']==0) ? 'background-color: #f7bd35' : ''; ?>"><?= ($datos['validacion_dashboard']['integridad']==1) ? 11 : 0; ?></td>
            </tr>
            <tr>
                <td>3.2. Suficiencia</td>
                <td><?= ($datos['validacion_dashboard']['suficiencia']==1) ? '0 Datos fuera de rango ' : 'Con datos fuera de rango'; ?></td>
                <td style="text-align: center;<?= ($datos['validacion_dashboard']['suficiencia']==0) ? 'background-color: #f7bd35' : ''; ?>"><?= ($datos['validacion_dashboard']['imei']==1) ? 11 : 0; ?></td>
            </tr>
            <tr>
                <td>3.3 Oportunidad</td>
                <?php
                $date1 = new DateTime($datos['f_t_captura']);
                $date2 = new DateTime($datos['f_t_registro']);
                $diff = $date1->diff($date2);
                ?>
                <td><?= $diff->days ?> días de diferencia</td>
                <td style="text-align: center;<?= ($datos['validacion_dashboard']['diferencia_dias']==0) ? 'background-color: #f7bd35' : ''; ?>"><?= ($datos['validacion_dashboard']['diferencia_dias']==1) ? 10 : 5; ?></td>
            </tr>
            <tr>
                <td colspan="3" style="font-weight: bold; background-color: #e1e1e1">3.4. Concordancia</td>
            </tr>
            <tr>
                <td>3.4.1 Georreferenciación</td>
                <td>
                    Estado capturado <?= $datos['estado']['NOMBRE'] ?><br/>
                    Opción de coordenada central:
                    <?php
                        if($datos['validacion_dashboard']['georeferencia']==11){
                            echo 'COINCIDE';
                        }else
                        if($datos['validacion_dashboard']['georeferencia']==5){
                            echo 'EN FRONTERA';
                        }else{
                            echo 'NO COINCIDE';
                        }
                    ?>

                </td>
                <td style="text-align: center;<?= ($datos['validacion_dashboard']['georeferencia']<=5) ? 'background-color: #f7bd35' : ''; ?>">
                    <?php
                        if($datos['validacion_dashboard']['georeferencia']==11){
                            echo '11';
                        }else
                        if($datos['validacion_dashboard']['georeferencia']==5){
                            echo '5';
                        }else{
                            echo '0';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>3.4.2 Evidencia</td>
                <td>
                    <?php
                        if($datos['validacion_dashboard']['evidencia']==1){
                            echo 'Imágenes válidas';
                        }else{
                            echo 'Imágenes no válidas';
                        }

                    ?>
                </td>
                <td style="text-align: center;<?= ($datos['validacion_dashboard']['evidencia']==0) ? 'background-color: #f7bd35' : ''; ?>"><?= ($datos['validacion_dashboard']['evidencia']==1) ? 11 : 0; ?></td>
            </tr>
        </table>

        <h3>OBSERVACIONES DEL VALIDADOR</h3>
        <table class="bordered" cellspacing="0" style="width: 100%">
            <tr style="font-weight: bold;">
                <td style="min-height: 50px">
                    <?php
                    if($datos['validacion_dashboard']['observaciones_validador']<>''){
                        echo $datos['validacion_dashboard']['observaciones_validador'];
                    }else{
                        echo 'Sin observaciones';
                    }
                    ?>
                </td>
            </tr>
        </table>
        <p style="text-align: right; font-size: 12px"><b>Fuente:</b> Tablero de Control. Erradicación MEXW34. {{ $datos['validacion_dashboard']['created_at'] }}</p>
        @else
        <h2 style="color: red">Lo sentimos, sin datos para esta clave proporcionada.</h2>
        @endif
    </main>
</body>

</html>
