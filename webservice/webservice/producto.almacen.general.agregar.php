<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoAlmacenGeneral.php';
require_once '../util/funciones/Funciones.clase.php';

$nombre = $_POST["nombre"];
$stock = $_POST["stock"];
$unidad_medida = $_POST["unidad_medida"];

try {

    $obj = new ProductoAlmacenGeneral();
    $obj->setNombre($nombre);
    $obj->setStock($stock);
    $obj->setUnidad_medida($unidad_medida);
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
