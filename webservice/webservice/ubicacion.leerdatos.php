<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Ubicacion.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto = $_POST["id_producto"];

try {
    $obj = new Ubicacion();
    $resultado = $obj->leerDatos($id_producto);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_producto" => $resultado[$i]["id_ubicacion"],
            "nombre" => $resultado[$i]["nombre"],
            "peso" => $resultado[$i]["capacidad"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
