<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenGeneralRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto = $_POST["id_producto"];

try {

    $obj = new AlmacenGeneralRegistro();
    $obj->setId_producto($id_producto);
    $resultado = $obj->buscarStock();

    if ($resultado) {
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(200, "Ocurrio un error", $resultado);
    }

} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
