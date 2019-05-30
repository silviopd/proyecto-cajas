<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/ProductoAlmacenGeneral.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new ProductoAlmacenGeneral();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_producto" => $resultado[$i]["id_producto"],
            "nombre" => $resultado[$i]["nombre"],
            "stock" => $resultado[$i]["stock"],
            "unidad_medida" => $resultado[$i]["unidad_medida"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}