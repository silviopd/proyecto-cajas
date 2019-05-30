<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Area.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Area();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_area" => $resultado[$i]["id_area"],
            "nombre" => $resultado[$i]["nombre"],
            "estado" => $resultado[$i]["estado"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}