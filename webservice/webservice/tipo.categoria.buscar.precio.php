<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoCategoria.php';
require_once '../util/funciones/Funciones.clase.php';

$id_tipo_categoria = $_POST["id_tipo_categoria"];

try {

    $obj = new TipoCategoria();
    $obj->setId_tipo_categoria($id_tipo_categoria);
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
