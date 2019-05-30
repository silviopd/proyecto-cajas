<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenGeneralRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$contacto = $_POST["contacto"];
$id_producto = $_POST["id_producto"];
$cantidad = $_POST["cantidad"];
$id_area = $_POST["id_area"];
$observacion = $_POST["observacion"];
$operacion = $_POST["operacion"];
$id_usuario_area = $_POST["id_usuario_area"];

try {

    $obj = new AlmacenGeneralRegistro();
    $obj->setContacto($contacto);    
    $obj->setId_producto($id_producto);
    $obj->setCantidad($cantidad);    
    $obj->setId_area($id_area);
    $obj->setObservaciones($observacion);
    $obj->setOperacion($operacion);
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
