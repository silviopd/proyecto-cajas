<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Usuario.php';
require_once '../util/funciones/Funciones.clase.php';

$id_usuario = $_POST["id_usuario"];

try {
    $obj = new Usuario();
    $resultado = $obj->leerDatos($id_usuario);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_usuario" => $resultado[$i]["id_usuario"],
            "pass" => $resultado[$i]["pass"],
            "estado" => $resultado[$i]["estado"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
