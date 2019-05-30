<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AreaAlquilerBalanza.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto = $_POST["id_area_alquiler_balanza"];
$nombre = $_POST["nombre"];
$precio_base = $_POST["precio_base"];
$precio_retraso = $_POST["precio_retraso"];
$estado = $_POST["estado"];
try {

    $obj = new AreaAlquilerBalanza();
    $obj->setId_area_alquiler_balanza($id_producto);
    $obj->setNombre($nombre);
    $obj->setPrecio_base($precio_base);
    $obj->setPrecio_retraso($precio_retraso);
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