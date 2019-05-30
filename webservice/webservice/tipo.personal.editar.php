<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoPersonal.php';
require_once '../util/funciones/Funciones.clase.php';

$id_tipo_personal = $_POST["id_tipo_personal"];
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];

try {

    $obj = new TipoPersonal();
    $obj->setId_tipo_personal($id_tipo_personal);
    $obj->setNombre($nombre);
    $obj->setPrecio($precio);
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