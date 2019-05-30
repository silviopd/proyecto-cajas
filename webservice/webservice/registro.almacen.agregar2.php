<?php

header('Access-Control-Allow-Origin: *');
require_once '../negocio/AlmacenGeneralRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

//if (!isset($_POST["p_datosFormulario"])) {
//    Funciones::imprimeJSON(500, "Faltan paradmetros", "");
//    exit();
//}

//$datosFormulario = $_POST["p_datosFormulario"];
$p_contacto=$_POST["p_contacto"];
$p_id_area=$_POST["p_id_area"];
$p_observacion=$_POST["p_observacion"];
$p_contacto=$_POST["p_contacto"];
$p_operacion=$_POST["p_operacion"];
$p_id_usuario_area=$_POST["p_id_usuario_area"];
$datosJSONDetalle = $_POST["p_datosJSONDetalle"];

//Convertir todos los datos que llegan concatenados a un array
//parse_str($datosFormulario, $datosFormularioArray);


//echo '<pre>';
//print_r($datosFormularioArray);
//echo '</pre>';


try {
    $objVenta = new AlmacenGeneralRegistro();
    $objVenta->setContacto($p_contacto);
    $objVenta->setId_area($p_id_area);
    $objVenta->setObservaciones($p_observacion);
    $objVenta->setOperacion($p_operacion);
    $objVenta->setId_usuario_area($p_id_usuario_area);

    //Enviar los datos del detalle en formato JSON
    $objVenta->setDetalleVenta($datosJSONDetalle);

    $resultado = $objVenta->agregar2();

    if ($resultado == true) {
        Funciones::imprimeJSON(200, "La venta ha sido registrada correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}



