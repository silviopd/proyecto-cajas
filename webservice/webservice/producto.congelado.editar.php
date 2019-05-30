<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoCongelado.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto= $_POST["id_producto"];
$nombre = $_POST["nombre"];
$peso = $_POST["peso"];

try {

    $obj = new ProductoCongelado();
    $obj->setId_producto($id_producto);
    $obj->setNombre($nombre);
    $obj->setPeso($peso);
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