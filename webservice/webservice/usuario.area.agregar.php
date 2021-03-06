<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/UsuarioArea.php';
require_once '../util/funciones/Funciones.clase.php';

$id_usuario = $_POST["id_usuario"];
$id_area = $_POST["id_modulo"];
$estado = $_POST["estado"];

try {

    $obj = new UsuarioArea();
    $obj->setId_usuario($id_usuario);
    $obj->setId_area($id_area);
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
