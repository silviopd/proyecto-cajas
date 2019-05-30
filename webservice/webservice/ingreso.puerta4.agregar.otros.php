<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/IngresoPuerta4.php';
require_once '../util/funciones/Funciones.clase.php';

$dni = str_pad($_POST["dni"], 8, '0', STR_PAD_LEFT);
$id_usuario = $_POST["id_usuario"];

try {

    $obj = new IngresoPuerta4();
    $obj->setDni($dni);
    $obj->setId_usuario_area($id_usuario);
    $resultado = $obj->agregarOtros();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Registro Satisfactorio", "");
    } else {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
