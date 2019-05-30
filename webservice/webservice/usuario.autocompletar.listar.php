<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Usuario.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Usuario();
    $resultado = $obj->listarAutocompletar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_usuario" => $resultado[$i]["id_usuario"],
            "nombres" => $resultado[$i]["nombres"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}