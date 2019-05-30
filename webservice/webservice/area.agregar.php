<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Area.php';
require_once '../util/funciones/Funciones.clase.php';

$nombre = $_POST["nombre"];
$estado = $_POST["estado"];

try {

    $obj = new Area();
    $obj->setNombre($nombre);
    $obj->setEstado($estado);
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
