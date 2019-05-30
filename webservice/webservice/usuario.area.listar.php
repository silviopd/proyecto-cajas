<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/UsuarioArea.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new UsuarioArea();
    $resultado = $obj->listar();
    
    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_usuario_area" => $resultado[$i]["id_usuario_area"],
            "id_usuario" => $resultado[$i]["id_usuario"],
            "nombre_usuario" => $resultado[$i]["nombre_usuario"],
            "id_modulo" => $resultado[$i]["id_modulo"],
            "nombre_modulo" => $resultado[$i]["nombre_modulo"],
            "estado" => $resultado[$i]["estado"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}