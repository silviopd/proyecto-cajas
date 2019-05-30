<?php
require_once '../negocio/IngresoPuerta4.php';

$dni = $_POST["dni"];

$obj = new IngresoPuerta4();
$resultado = $obj->datosPersonal($dni);

$resultado2 = $obj->idRegistroPersonal($dni);

$sub_total = 0;


if ($resultado["id_tipo_personal"] == 7) {
    $fecha_pagada = $_POST["fecha_pagada"];
    $fecha_pagar = date_diff(date_create(date('Y-m-d')), date_create(date('Y-m-d', strtotime($fecha_pagada))))->d;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="ticker.css">
    </head>
    <body class="centrar">
        <section>
            <h3 class="titulo">Ecomphisa</h3>
            <h4 class="subtitulo">R.U.C. N° 20271407263</h4>
            <h4 class="lineas subtitulo">Prolong. Mariscal Castilla S/N Santa Rosa - Chiclayo - Lambayeque</h4>	
            <p class="lineas">---------------------------------------------------------</p>
            <h4 class="lineas">COMPROBANTE DE PAGO</h4>
            <h4 class="lineas">N° REGISTRO <?php echo $resultado2["id_ingreso"] ?></h4>
            <p class="lineas">---------------------------------------------------------</p>
        </section>	
        <section class="izquierda">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tabla-contenido">Cliente:</td>
                        <td class="tabla-contenido"><?php echo strtoupper($resultado["nombres_apellidos"]) ?></td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">DNI/RUC:</td>
                        <td class="tabla-contenido"><?php echo $resultado["dni"] ?></td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">Tipo:</td>
                        <td class="tabla-contenido"><?php echo strtoupper($resultado["nombre_tipo_personal"]) ?></td>
                    </tr>
                    <?php
                    if ($resultado["id_tipo_personal"] == 7) {
                        echo '<tr>
                                <td class="tabla-contenido">Nro:</td>
                                <td class="tabla-contenido">' . $resultado["nro_carretilla"] . '</td>
                              </tr>';
                    }
                    ?>                    

                    <tr>
                        <td class="tabla-contenido">Estado:</td>
                        <td class="tabla-contenido">PAGO</td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">Cond. Pago:</td>
                        <td class="tabla-contenido">CONTADO</td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">Fecha:</td>
                        <td class="tabla-contenido"><?php echo $resultado["fecha_hoy"] ?></td>
                    </tr>
                </tbody>
            </table>			
        </section>	
        <p class="lineas">---------------------------------------------------------</p>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tabla-contenido"><?php echo strtoupper($resultado["nombre_tipo_personal"]) ?></td>
                    <td class="tabla-contenido"><?php echo $resultado["precio"] ?></td>
                </tr>
                <?php
                if ($resultado["id_tipo_personal"] == 7) {
                    $sub_total = number_format($fecha_pagar * 2, 2, '.', ' ');
                    echo '<tr>
                                <td class="tabla-contenido">Guardiania (' . $fecha_pagada . ')</td>
                                <td class="tabla-contenido">' . $sub_total . '</td>
                              </tr>';
                }
                ?>

            </tbody>		
        </table>
        <p class="lineas">---------------------------------------------------------</p>
        <table class="tabla">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="pagar">TOTAL A PAGAR</td>
                    <td class="pagar"><?php echo number_format($sub_total + $resultado["precio"], 2, '.', ' ') ?></td>
                </tr>	
            </tbody>
        </table>
        <footer>
            <h4 class="footer">* GRACIAS POR SU VISITA *</h4>
        </footer>
        <button class="oculto-impresion" onclick="imprimir()">IMPRIMIR</button>
        <script src="ticker.js"></script>
    </body>
</html>