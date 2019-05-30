<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Colaborador.php';
require_once '../util/funciones/Funciones.clase.php';

$dni = $_POST["dni"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$estado = $_POST["estado"];

try {

    $obj = new Colaborador();
    $obj->setDni($dni);
    $obj->setNombres($nombres);
    $obj->setApellidos($apellidos);
    $obj->setEstado($estado);
    $resultado = $obj->editar();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Registro Satisfactorio", "");
    }else{
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
      
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
