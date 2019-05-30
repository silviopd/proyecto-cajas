<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/IngresoPuerta4.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new IngresoPuerta4();
    $resultado = $obj->reporte();
    
    $total = 0;

    for ($i = 0; $i < count($resultado); $i++) {
        $total += $resultado[$i]["sub_total"];
    }

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "nombre" => $resultado[$i]["nombre"],
            "precio" => $resultado[$i]["precio"],
            "cantidad" => $resultado[$i]["cantidad"],
            "sub_total" => $resultado[$i]["sub_total"],           
            "total" => $total
        );

        $listadepartamento[$i] = $datos;
    }

    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}