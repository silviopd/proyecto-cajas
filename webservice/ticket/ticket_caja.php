<?php
require_once '../negocio/AlmacenRegistro.php';

$id_registro = $_POST["id_registro"];

$obj = new AlmacenRegistro();
$obj->setId_registro($id_registro);
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
            <h4 class="lineas">N° REGISTRO <?php echo $id_registro.' - '.$resultado["id_historial"] ?></h4>
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
                        <td class="tabla-contenido"><?php echo strtoupper($resultado["nombre_cliente"]) ?></td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">Producto</td>
                        <td class="tabla-contenido"><?php echo strtoupper($resultado["nombre_caja"]) ?></td>
                    </tr>
                     <tr>
                        <td class="tabla-contenido">Ubicacion</td>
                        <td class="tabla-contenido"><?php echo strtoupper($resultado["nombre_ubicacion"]) ?></td>
                    </tr>
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
                        <td class="tabla-contenido"><?php echo $resultado["fecha"] . ' - ' . $resultado["hora"] ?></td>
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
                echo    '<tr>
                            <td class="tabla-contenido"> Cantidad </td>
                            <td class="tabla-contenido"> ' . $resultado["cantidad"] . ' </td>
                        </tr>
                        <tr>
                            <td class="tabla-contenido"> Precio </td>
                            <td class="tabla-contenido"> ' . $resultado["precio_base"] . ' </td>
                        </tr>';
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