<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Congelado.php';
require_once '../util/funciones/Funciones.clase.php';

$operacion = $_POST["operacion"];
$id_reg = $_POST["id_reg"];
$bloques = $_POST["bloques"];
$id_usuario_area = $_POST["id_usuario_area"];
$contacto = $_POST["contacto"];
$observaciones = $_POST["observaciones"];

try {

    $obj = new Congelado();
    $obj->setOperacion($operacion);
    $obj->setBloques($bloques);
    $obj->setId_registro($id_reg);
    $obj->setId_usuario_area($id_usuario_area);
    $obj->setContacto($contacto);
    $obj->setObservaciones($observaciones);
    $resultado = $obj->actualizar();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Registro Satisfactorio", "...");
    }else{
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
      
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
