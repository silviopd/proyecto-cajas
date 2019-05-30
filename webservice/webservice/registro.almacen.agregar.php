<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$contacto = $_POST["contacto"];
$cantidad = $_POST["cantidad"];
$observacion = $_POST["observacion"];
$operacion = $_POST["operacion"];
$id_caja = $_POST["id_caja"];
$id_usuario_area = $_POST["id_usuario_area"];
$id_ubicacion = $_POST["id_ubicacion"];
$id_cliente = $_POST["id_cliente"];

try {

    $obj = new AlmacenRegistro();
    $obj->setContacto($contacto);
    $obj->setCantidad($cantidad);
    $obj->setObservaciones($observacion);    
    $obj->setOperacion($operacion);
    $obj->setId_caja($id_caja);
    $obj->setId_usuario_area($id_usuario_area);
    $obj->setId_ubicacion($id_ubicacion);
    $obj->setId_cliente($id_cliente);
    
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
