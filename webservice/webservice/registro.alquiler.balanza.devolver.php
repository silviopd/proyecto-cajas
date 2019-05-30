<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlquilerBalanzaRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_registro = $_POST["id_registro"];

try {

    $obj = new AlquilerBalanzaRegistro();
    $obj->setId_registro($id_registro);
    $resultado = $obj->devolver();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Registro Satisfactorio", "");
    } else {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
