<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoCarga.php';
require_once '../util/funciones/Funciones.clase.php';

$id_tipo_carga = $_POST["id_tipo_carga"];

try {

    $obj = new TipoCarga();
    $obj->setId_tipo_carga($id_tipo_carga);
    $resultado = $obj->buscarPrecio();

    if ($resultado) {
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(200, "Ocurrio un error", $resultado);
    }

} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
