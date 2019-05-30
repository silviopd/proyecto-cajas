<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoAlquilerBalanza.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto = $_POST["id_producto"];
$nombre = $_POST["nombre"];
$numero_balanza = $_POST["numero_balanza"];
$estado = $_POST["estado"];
try {

    $obj = new ProductoAlquilerBalanza();
    $obj->setId_producto($id_producto);
    $obj->setNombre($nombre);
    $obj->setNumero_balanza($numero_balanza);
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