<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Congelado.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Congelado();
    $resultado = $obj->reporte();
    
//    $total = 0;
//
//    for ($i = 0; $i < count($resultado); $i++) {
//        $total += $resultado[$i]["sub_total"];
//    }

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_registro" => $resultado[$i]["id_registro"],
            "id_historial" => $resultado[$i]["id_historial"],
            "fecha" => $resultado[$i]["fecha"],
            "hora" => $resultado[$i]["hora"],
            "nombre_cliente" => $resultado[$i]["nombre_cliente"],
            "contacto" => $resultado[$i]["contacto"],
            "nombre_producto" => $resultado[$i]["nombre_producto"],
            "peso" => $resultado[$i]["peso"],
            "operacion" => $resultado[$i]["operacion"],
            "bloques" => $resultado[$i]["bloques"],
            "bloques_anterior" => $resultado[$i]["bloques_anterior"],
            "bloques_actual" => $resultado[$i]["bloques_actual"],
            "observaciones" => $resultado[$i]["observaciones"]
        );

        $listadepartamento[$i] = $datos;
    }

    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}