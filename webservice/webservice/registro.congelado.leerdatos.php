<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Congelado.php';
require_once '../util/funciones/Funciones.clase.php';

$id_caja = $_POST["id_registro"];

try {
    $obj = new Congelado();
    $resultado = $obj->leerDatos($id_caja);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_registro" => $resultado[$i]["id_registro"],
            "fecha" => $resultado[$i]["fecha"],
            "cant" => $resultado[$i]["cant"],
            "contacto" => $resultado[$i]["contacto"],
            "observaciones" => $resultado[$i]["observaciones"],
            "operacion" => $resultado[$i]["operacion"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
