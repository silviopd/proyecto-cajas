<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoAlmacenGeneral.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto= $_POST["id_producto"];
$nombre = $_POST["nombre"];
$stock = $_POST["stock"];
$unidad_medida = $_POST["unidad_medida"];

try {

    $obj = new ProductoAlmacenGeneral();
    $obj->setId_producto($id_producto);
    $obj->setNombre($nombre);
    $obj->setStock($stock);
    $obj->setUnidad_medida($unidad_medida);
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