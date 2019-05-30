<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoAlquilerBalanza.php';
require_once '../util/funciones/Funciones.clase.php';

$nombre_producto = $_POST["nombre_producto"];

try {

    $obj = new ProductoAlquilerBalanza();
    $obj->setNombre($nombre_producto);
    $resultado = $obj->listarAutocompletarNumero();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_producto" => $resultado[$i]["id_producto"],
            "numero_balanza" => $resultado[$i]["numero_balanza"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}