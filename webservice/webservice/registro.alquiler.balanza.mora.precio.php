<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlquilerBalanzaRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_registro = $_POST["id_registro"];

try {

    $obj = new AlquilerBalanzaRegistro();
    $obj->setId_registro($id_registro);
    $resultado = $obj->mora_precio();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "mora" => $resultado[$i]["mora"],
            "dias_mora" => $resultado[$i]["dias_mora"],
            "precio" => $resultado[$i]["precio"],
            "sub_total" => $resultado[$i]["sub_total"],
            "adicional" => $resultado[$i]["adicional"],            
            "subtotal_adicional" => round($resultado[$i]["adicional"]+$resultado[$i]["sub_total"], 2),            
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}