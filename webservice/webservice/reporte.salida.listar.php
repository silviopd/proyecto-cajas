<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/SalidaPuerta4.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new SalidaPuerta4();
    $resultado = $obj->reporte();

    $total = 0;

    for ($i = 0; $i < count($resultado); $i++) {
        $total += $resultado[$i]["sub_total"];
    }

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        if ($resultado[$i]["nombre_categoria"] == "NO SE COBRA") {
            $datos = array(
                "nombre" => $resultado[$i]["nombre_carga"],
                "precio" => $resultado[$i]["precio_carga"],
                "cantidad" => $resultado[$i]["cantidad"],
                "cantidad_tipo" => $resultado[$i]["cantidad_carga"],
                "sub_total" => $resultado[$i]["sub_total"],
                "total" => $total
            );
        } else {
            $datos = array(
                "nombre" => $resultado[$i]["nombre_categoria"],
                "precio" => $resultado[$i]["precio_categoria"],                
                "cantidad" => $resultado[$i]["cantidad"],
                "cantidad_tipo" => $resultado[$i]["cantidad_categoria"],
                "sub_total" => $resultado[$i]["sub_total"],
                "total" => $total
            );
        }
        
        $listadepartamento[$i] = $datos;
    }

    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}