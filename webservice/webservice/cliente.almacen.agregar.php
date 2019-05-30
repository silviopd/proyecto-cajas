<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenCliente.php';
require_once '../util/funciones/Funciones.clase.php';

$nombre = $_POST["nombre"];
$estado = $_POST["estado"];

try {

    $obj = new AlmacenCliente();
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
