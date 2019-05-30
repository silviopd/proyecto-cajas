<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_caja = $_POST["id_caja"];

try {

    $obj = new AlmacenRegistro();
    $obj->setId_caja($id_caja);
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
