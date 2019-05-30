<?php

header('Access-Control-Allow-Origin: *');

// require_once './plugins/dompdf/dompdf_config.inc.php';
require_once './plugins/dompdf2/autoload.inc.php';
require_once '../negocio/AlmacenGeneralRegistro.php';

use Dompdf\Dompdf;

try {

    $objCliente = new AlmacenGeneralRegistro();
    $resultado = $objCliente->reporteRegistro();

    $html = '
<!DOCTYPE html>    
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="plugins/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="css/reporte.css" rel="stylesheet" type="text/css" />        
        <title>REPORTE ALMACEN GENERAL REGISTRO</title>
    </head>
    <body >
        <section>
            <header>
                <h1 class="text-center">REPORTE REGISTRO - ALMACEN GENERAL</h1>
            </header>
        </section>
        <br>
        <section class="izquierda2">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr>
                        <td class="tabla-contenido">Area:  </td>
                        <td class="tabla-contenido">' . $resultado[0]["nombre_area"] . '</td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">Contacto:  </td>
                        <td class="tabla-contenido">' . $resultado[0]["contacto"] . '</td>
                    </tr>    
                    <tr>
                        <td class="tabla-contenido">Fecha:  </td>
                        <td class="tabla-contenido">' . $resultado[0]["fecha"] . ' - ' . $resultado[0]["hora"] . '</td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">Proceso:  </td>
                        <td class="tabla-contenido">' . $resultado[0]["operacion"] . '</td>
                    </tr>                                    
                    <tr>
                        <td class="tabla-contenido">Responsable de turno:  </td>
                        <td class="tabla-contenido">' . $resultado[0]["nombre_usuario"] . '</td>
                    </tr>
                    <tr>
                        <td class="tabla-contenido">Observaciones:  </td>
                        <td class="tabla-contenido">' . $resultado[0]["observaciones"] . '</td>
                    </tr>
                </tbody>
            </table>			
        </section>	
        <section>
            <table id="example" class="table table-sm table-bordered table-striped" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Unidad Medida</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>';
    for ($i = 0; $i < count($resultado); $i++) {
        $html .= '<tr>';
        $html .= '<td>' . $resultado[$i]["nombre_producto"] . '</td>';
        $html .= '<td>' . $resultado[$i]["unidad_medida"] . '</td>';
        $html .= '<td>' . $resultado[$i]["cantidad"] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody>
            </table>
        </section>
        
        <div class="centrar-tabla">
            <table class="tabla">			
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <td class="izquierda">______________</td>
                        <td class="derecha">_________________</td>
                    </tr>
                    <tr>
                        <td class="izquierda">Recibi Conforme</td>
                        <td class="derecha">Entregue Conforme</td>
                    </tr>
                </tbody>
            </table>	
        </div>
        
        
        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/bootstrap/bootstrap.min.js"></script>
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
    </body>
</html>
';

    $dompdf = new Dompdf();

    ini_set('max_execution_time', 300);
    ini_set("memory_limit", "512M");

    $pdf->set_paper("A4", "portrait");
    $pdf->load_html($html);
    $pdf->render();

    file_put_contents('./reporte-almacen-general.pdf', $pdf->output());
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}
?>