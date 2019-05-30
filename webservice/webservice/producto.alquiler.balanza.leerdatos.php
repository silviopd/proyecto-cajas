<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoAlquilerBalanza.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto = $_POST["id_producto"];

try {
    $obj = new ProductoAlquilerBalanza();
    $resultado = $obj->leerDatos($id_producto);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_producto" => $resultado[$i]["id_producto"],
            "nombre" => $resultado[$i]["nombre"],
            "numero_balanza" => $resultado[$i]["numero_balanza"],
            "estado" => $resultado[$i]["estado"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
