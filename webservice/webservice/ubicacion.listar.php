<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Ubicacion.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Ubicacion();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_producto" => $resultado[$i]["id_ubicacion"],
            "nombre" => $resultado[$i]["nombre"],
            "peso" => $resultado[$i]["capacidad"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}