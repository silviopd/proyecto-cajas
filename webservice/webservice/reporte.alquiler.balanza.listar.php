<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlquilerBalanzaRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new AlquilerBalanzaRegistro();
    $resultado = $obj->reporte();
    
    $total = 0;

    for ($i = 0; $i < count($resultado); $i++) {
        $total += $resultado[$i]["sub_total"];
    }

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_registro" => $resultado[$i]["id_registro"],
            "nombre_cliente" => $resultado[$i]["nombre_cliente"],
            "nombre_producto" => $resultado[$i]["nombre_producto"],
            "numero_balanza" => $resultado[$i]["numero_balanza"],           
            "adicional" => $resultado[$i]["adicional"],           
            "sub_total" => $resultado[$i]["sub_total"],           
            "observaciones" => $resultado[$i]["observaciones"],           
            "nombre_area" => $resultado[$i]["nombre_area"],           
            "total" => $total
        );

        $listadepartamento[$i] = $datos;
    }

    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}