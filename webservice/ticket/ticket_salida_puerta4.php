<?php
require_once '../negocio/SalidaPuerta4.php';

$nro_placa = $_POST["nro_placa"];
$estado = $_POST["estado"];

$obj = new SalidaPuerta4();
$obj->setNro_placa($nro_placa);
$resultado = $obj->ticket();
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
            <h4 class="lineas">N° REGISTRO <?php echo ($nro_placa .' - '.$resultado["id_salida"]) ?></h4>
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
                <?php
                if ($estado == 'C') {
                    
                    echo '<tr>
                            <td class="tabla-contenido"> '.strtoupper($resultado["nombre_carga"]).'</td>
                            <td class="tabla-contenido"> '.$resultado["precio_carga"].' </td>
                        </tr>
                        <tr>
                            <td class="tabla-contenido"> CANTIDAD </td>
                            <td class="tabla-contenido"> '.$resultado["cantidad"].' </td>
                        </tr>';
                }else{
                     echo '<tr>
                            <td class="tabla-contenido"> '.strtoupper($resultado["nombre_categoria"]).' </td>
                            <td class="tabla-contenido"> '.$resultado["precio_categoria"].' </td>
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
                    <td class="pagar"><?php echo number_format($resultado["sub_total"], 2, '.', ' ') ?></td>
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