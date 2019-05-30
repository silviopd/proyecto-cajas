<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoCongelado.php';
require_once '../util/funciones/Funciones.clase.php';

$nombre = $_POST["nombre"];
$peso = $_POST["peso"];

try {

    $obj = new ProductoCongelado();
    $obj->setNombre($nombre);
    $obj->setPeso($peso);
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
