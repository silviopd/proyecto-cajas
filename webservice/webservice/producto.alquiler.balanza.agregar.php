<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoAlquilerBalanza.php';
require_once '../util/funciones/Funciones.clase.php';

$nombre = $_POST["nombre"];
$numero_balanza = $_POST["numero_balanza"];
$estado = $_POST["estado"];

try {

    $obj = new ProductoAlquilerBalanza();
    $obj->setNombre($nombre);
    $obj->setNumero_balanza($numero_balanza);
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
