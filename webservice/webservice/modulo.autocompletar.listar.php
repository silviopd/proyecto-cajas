<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Modulo.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Modulo();
    $resultado = $obj->listarAutocompletar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_modulo" => $resultado[$i]["id_modulo"],
            "nombre" => $resultado[$i]["nombre"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}