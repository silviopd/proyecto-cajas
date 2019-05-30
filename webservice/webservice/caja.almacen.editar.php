<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenCaja.php';
require_once '../util/funciones/Funciones.clase.php';

$id_caja = $_POST["id_caja"];
$nombre = $_POST["nombre"];
$precio_base = $_POST["precio_base"];
$precio_retraso = $_POST["precio_retraso"];
$estado = $_POST["estado"];

try {

    $obj = new AlmacenCaja();
    $obj->setId_caja($id_caja);
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