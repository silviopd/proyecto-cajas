<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Usuario.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Usuario();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_usuario" => $resultado[$i]["id_usuario"],
            "nombres" => $resultado[$i]["nombres"],
            "apellidos" => $resultado[$i]["apellidos"],
            "estado" => $resultado[$i]["estado"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}