<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Usuario.php';
require_once '../util/funciones/Funciones.clase.php';

$id_usuario = $_POST["id_usuario"];
$pass = $_POST["pass"];
$estado = $_POST["estado"];

try {

    $obj = new Usuario();
    $obj->setId_usuario($id_usuario);
    $obj->setPass($pass);
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
