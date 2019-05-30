<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Area.php';
require_once '../util/funciones/Funciones.clase.php';

$id_area = $_POST["id_area"];

try {
    $obj = new Area();
    $resultado = $obj->leerDatos($id_area);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_area" => $resultado[$i]["id_area"],
            "nombre" => $resultado[$i]["nombre"],
            "estado" => $resultado[$i]["estado"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
