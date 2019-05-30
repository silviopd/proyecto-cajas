<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlquilerBalanzaRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto = $_POST["id_producto"];
$id_usuario_area = $_POST["id_usuario_area"];
$observaciones = $_POST["observaciones"];
$id_cliente = $_POST["id_cliente"];
$id_area = $_POST["id_area_alquiler_balanza"];

try {

    $obj = new AlquilerBalanzaRegistro();
    $obj->setId_producto($id_producto);
    $obj->setId_usuario_area($id_usuario_area);
    $obj->setObservaciones($observaciones);
    $obj->setId_cliente($id_cliente);
    $obj->setId_area($id_area);
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
