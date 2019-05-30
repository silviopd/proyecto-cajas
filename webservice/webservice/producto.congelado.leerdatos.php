<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoCongelado.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto = $_POST["id_producto"];

try {
    $obj = new ProductoCongelado();
    $resultado = $obj->leerDatos($id_producto);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_producto" => $resultado[$i]["id_producto"],
            "nombre" => $resultado[$i]["nombre"],
            "peso" => $resultado[$i]["peso"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
