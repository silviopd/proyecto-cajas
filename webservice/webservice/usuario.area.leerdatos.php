<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/UsuarioArea.php';
require_once '../util/funciones/Funciones.clase.php';

$id_usuario_area = $_POST["id_usuario_area"];

try {
    $obj = new UsuarioArea();
    $resultado = $obj->leerDatos($id_usuario_area);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_usuario_area" => $resultado[$i]["id_usuario_area"],
            "id_usuario" => $resultado[$i]["id_usuario"],
            "id_modulo" => $resultado[$i]["id_modulo"],
            "estado" => $resultado[$i]["estado"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
