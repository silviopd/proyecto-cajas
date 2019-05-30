<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoAlquilerBalanza.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new ProductoAlquilerBalanza();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_producto" => $resultado[$i]["id_producto"],
            "nombre" => $resultado[$i]["nombre"],
            "numero_balanza" => $resultado[$i]["numero_balanza"],
            "estado" => $resultado[$i]["estado"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}