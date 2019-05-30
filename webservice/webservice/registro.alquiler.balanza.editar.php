<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlquilerBalanzaRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_registro = $_POST["id_registro"];
$adicional = $_POST["adicional"];
$observaciones = $_POST["observaciones"];
$id_area_alquiler_balanza = $_POST["id_area_alquiler_balanza"];

try {

    $obj = new AlquilerBalanzaRegistro;
    $obj->setId_registro($id_registro);
    $obj->setAdicional($adicional);
    $obj->setObservaciones($observaciones);
    $obj->setId_area($id_area_alquiler_balanza);
    $resultado = $obj->editar();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Modificación Satisfactorio", "");
    }else{
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
      
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}