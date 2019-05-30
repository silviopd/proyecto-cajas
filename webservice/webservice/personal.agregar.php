<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Personal.php';
require_once '../util/funciones/Funciones.clase.php';

$dni = $_POST["dni"];
$nombres_apellidos = $_POST["nombres_apellidos"];
$id_tipo_personal = $_POST["id_tipo_personal"];
$estado = $_POST["estado"];
$nro_carretilla = $_POST["nro_carretilla"];

try {

    $obj = new Personal();
    $obj->setDni($dni);
    $obj->setNombres_apellidos($nombres_apellidos);
    $obj->setId_tipo_personal($id_tipo_personal);
    $obj->setEstado($estado);
    $obj->setNro_carretilla($nro_carretilla);
    $resultado = $obj->agregar();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Registro Satisfactorio", "");
    } else {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
