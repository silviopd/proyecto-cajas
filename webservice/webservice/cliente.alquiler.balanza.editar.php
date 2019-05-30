<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlquilerBalanzaCliente.php';
require_once '../util/funciones/Funciones.clase.php';

$id_cliente = $_POST["id_cliente"];
$nombre = $_POST["nombre"];
$estado = $_POST["estado"];

try {

    $obj = new AlquilerBalanzaCliente();
    $obj->setId_cliente($id_cliente);
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