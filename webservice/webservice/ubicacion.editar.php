<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Ubicacion.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto= $_POST["id_producto"];
$nombre = $_POST["nombre"];
$peso = $_POST["peso"];

try {

    $obj = new Ubicacion();
    $obj->setId_ubicacion($id_producto);
    $obj->setNombre($nombre);
    $obj->setCapacidad($peso);
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