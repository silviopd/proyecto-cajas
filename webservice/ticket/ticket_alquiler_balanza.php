<?php
require_once '../negocio/AlquilerBalanzaRegistro.php';

$id_registro = $_POST["id_registro"];

$obj = new AlquilerBalanzaRegistro();
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
            <h4 class="lineas">N° REGISTRO <?php echo $id_registro ?></h4>
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
                        <td class="tabla-contenido">DNI/RUC:</td>
                        <td class="tabla-contenido"><?php echo $resultado["id_cliente"] ?></td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">Tipo:</td>
                        <td class="tabla-contenido"><?php echo strtoupper($resultado["nombre_producto"]) ?></td>
                    </tr>                 
                    <tr>
                        <td class="tabla-contenido">Nro:</td>
                        <td class="tabla-contenido"><?php echo strtoupper($resultado["numero_producto"]) ?></td>
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
                if ($resultado["mora"] == 1) {
                    
                    echo '<tr>
                            <td class="tabla-contenido"> '.strtoupper($resultado["nombre_producto"])." - ".$resultado["numero_producto"].'</td>
                            <td class="tabla-contenido"> '.$resultado["precio_base"].' </td>
                        </tr>
                        <tr>
                            <td class="tabla-contenido"> DIAS MORA ('.$resultado["dias_mora"].')</td>
                            <td class="tabla-contenido"> '.$resultado["precio"].' </td>
                        </tr>';
                }else{
                     echo '<tr>
                            <td class="tabla-contenido"> '.strtoupper($resultado["nombre_producto"])." - ".$resultado["numero_producto"].' </td>
                            <td class="tabla-contenido"> '.$resultado["precio_base"].' </td>
                        </tr>';
                }
                ?>
                
                <?php
                if ($resultado["adicional"] > 0) {
                    
                    echo '<tr>
                            <td class="tabla-contenido"> Adicional </td>
                            <td class="tabla-contenido"> '.$resultado["adicional"].' </td>
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