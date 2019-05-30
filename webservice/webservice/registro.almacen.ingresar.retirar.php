<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_registro = $_POST["id_registro"];
$contacto = $_POST["contacto"];
$cantidad = $_POST["cantidad"];
$observacion = $_POST["observacion"];
$operacion = $_POST["operacion"];
$id_usuario_area = $_POST["id_usuario_area"];

try {

    $obj = new AlmacenRegistro();
    $obj->setId_registro($id_registro);
    $obj->setContacto($contacto);
    $obj->setCantidad($cantidad);
    $obj->setObservaciones($observacion);    
    $obj->setOperacion($operacion);
    $obj->setId_usuario_area($id_usuario_area);
    
    $resultado = $obj->ingresar_retirar();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Registro Satisfactorio", "");
    }else{
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
      
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
