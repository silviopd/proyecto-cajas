<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Congelado.php';
require_once '../util/funciones/Funciones.clase.php';

$operacion = $_POST["operacion"];
$contacto = $_POST["contacto"];
$id_producto = $_POST["id_producto"];
$id_usuario_area = $_POST["id_usuario_area"];
$bloques = $_POST["bloques"];
$observaciones = $_POST["observaciones"];
$id_cliente = $_POST["id_cliente"];

try {

    $obj = new Congelado();
    $obj->setOperacion($operacion);
    $obj->setContacto($contacto);
    $obj->setId_producto($id_producto);
    $obj->setId_usuario_area($id_usuario_area);
    $obj->setBloques($bloques);
    $obj->setObservaciones($observaciones);
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
