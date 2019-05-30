<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoCarga.php';
require_once '../util/funciones/Funciones.clase.php';

$id_tipo_carga = $_POST["id_tipo_carga"];
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];

try {

    $obj = new TipoCarga();
    $obj->setId_tipo_carga($id_tipo_carga);
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