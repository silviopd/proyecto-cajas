<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenCaja.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new AlmacenCaja();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_caja" => $resultado[$i]["id_caja"],
            "nombre" => $resultado[$i]["nombre"],
            "precio_base" => $resultado[$i]["precio_base"],
            "precio_retraso" => $resultado[$i]["precio_retraso"],
            "estado" => $resultado[$i]["estado"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}