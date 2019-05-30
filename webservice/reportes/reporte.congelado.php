<?php

header('Access-Control-Allow-Origin: *');

// require_once './plugins/dompdf/dompdf_config.inc.php';
require_once './plugins/dompdf2/autoload.inc.php';
require_once '../negocio/AlmacenGeneralRegistro.php';

use Dompdf\Dompdf;

try {

    $objCliente = new Congelado();
    $resultado = $objCliente->reporte();

//    $total = 0;
//
//    for ($i = 0; $i < count($resultado); $i++) {
//        $total += $resultado[$i]["sub_total"];
//    }

    $html = '
<!DOCTYPE html>    
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="plugins/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="css/reporte.css" rel="stylesheet" type="text/css" />        
        <title>REPORTE AREA CONGELADO</title>
    </head>
    <body >
        <section>
            <header>
                <h1 class="text-center">REPORTE - AREA CONGELADO</h1>
            </header>
        </section>
        <br>
        <section>
            <table id="example" class="table table-sm table-bordered table-striped tabla-contenido" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Registro</th>
                        <th>Movimientos</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Producto</th>
                        <th>Peso (KG)</th>
                        <th>Operacion</th>
                        <th>Bloques</th>
                        <th>Bloques Ant.</th>
                        <th>Bloques Act.</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>';
    for ($i = 0; $i < count($resultado); $i++) {
        $html .= '<tr>';
        $html .= '<td>' . $resultado[$i]["id_registro"] . '</td>';
        $html .= '<td>' . $resultado[$i]["id_historial"] . '</td>';
        $html .= '<td>' . $resultado[$i]["fecha"] . ' - ' . $resultado[$i]["hora"] . '</td>';
        $html .= '<td>' . $resultado[$i]["nombre_cliente"] . '</td>';
        $html .= '<td>' . $resultado[$i]["contacto"] . '</td>';
        $html .= '<td>' . $resultado[$i]["nombre_producto"] . '</td>';
        $html .= '<td>' . $resultado[$i]["peso"] . '</td>';
        $html .= '<td>' . $resultado[$i]["operacion"] . '</td>';
        $html .= '<td>' . $resultado[$i]["bloques"] . '</td>';
        $html .= '<td>' . $resultado[$i]["bloques_anterior"] . '</td>';
        $html .= '<td>' . $resultado[$i]["bloques_actual"] . '</td>';
        $html .= '<td>' . $resultado[$i]["observaciones"] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody>
            </table>
        </section>
        
        <!--div class="derecha">
            <strong>TOTAL: ' . round($total, 2) . '</strong>
        </div-->
        
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

    $pdf->set_paper("A4", "landscape");
    $pdf->load_html($html);
    $pdf->render();

    $canvas = $pdf->get_canvas();
    $canvas->page_text(330, 570, "Página {PAGE_NUM} de {PAGE_COUNT}      " . date('d/m/Y') . "     " . date('h:i') . " " . date('A'), null, 10, array(0, 0, 0));

    file_put_contents('./congelado.pdf', $pdf->output());
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}
?>