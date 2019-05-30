<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/SalidaPuerta4.php';
require_once '../util/funciones/Funciones.clase.php';

$nro_placa = $_POST["nro_placa"];
$estado = $_POST["estado"];
$id_tipo_carga = $_POST["id_tipo_carga"];
$cantidad = $_POST["cantidad"];
$id_tipo_categoria = $_POST["id_tipo_categoria"];
$id_usuario_area = $_POST["id_usuario_area"];

try {

    $obj = new SalidaPuerta4();
    $obj->setNro_placa($nro_placa);
    $obj->setEstado($estado);
    $obj->setId_tipo_carga($id_tipo_carga);
    $obj->setCantidad($cantidad);
    $obj->setId_tipo_categoria($id_tipo_categoria);
    $obj->setId_usuario_area($id_usuario_area);
    $resultado = $obj->agregar();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Registro Satisfactorio", "");
    }else{
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
      
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
