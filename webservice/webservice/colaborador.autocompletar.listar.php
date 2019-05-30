<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Colaborador.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Colaborador();
    $resultado = $obj->listarAutocompletar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "dni" => $resultado[$i]["dni"],
            "nombre" => $resultado[$i]["nombre"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}