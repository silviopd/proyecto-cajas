<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Area.php';
require_once '../util/funciones/Funciones.clase.php';

$id_area = $_POST["id_area"];
$nombre = $_POST["nombre"];
$estado = $_POST["estado"];

try {

    $obj = new Area();
    $obj->setId_area($id_area);
    $obj->setNombre($nombre);
    $obj->setEstado($estado);
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