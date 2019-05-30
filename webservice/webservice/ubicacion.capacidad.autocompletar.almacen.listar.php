<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Ubicacion.php';
require_once '../util/funciones/Funciones.clase.php';

$id_ubicacion = $_POST["id_ubicacion"];

try {

    $obj = new Ubicacion();
    $obj->setId_ubicacion($id_ubicacion);
    $resultado = $obj->listarCapacidad();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_ubicacion" => $resultado[$i]["id_ubicacion"],
            "nombre" => $resultado[$i]["nombre"],
            "capacidad" => $resultado[$i]["capacidad"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}