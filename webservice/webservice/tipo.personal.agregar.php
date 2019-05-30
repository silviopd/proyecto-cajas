<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoPersonal.php';
require_once '../util/funciones/Funciones.clase.php';

$nombre = $_POST["nombre"];
$precio = $_POST["precio"];

try {

    $obj = new TipoPersonal();
    $obj->setNombre($nombre);
    $obj->setPrecio($precio);
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
