<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlquilerBalanzaRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new AlquilerBalanzaRegistro();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_registro" => $resultado[$i]["id_registro"],
            "fecha" => $resultado[$i]["fecha"],
            "hora" => $resultado[$i]["hora"],            
            "id_producto" => $resultado[$i]["id_producto"],
            "nombre_producto" => $resultado[$i]["nombre_producto"],
            "numero_producto" => $resultado[$i]["numero_producto"],
            "id_usuario_area" => $resultado[$i]["id_usuario_area"],
            "nombre_usuario" => $resultado[$i]["nombre_usuario"],
            "observaciones" => $resultado[$i]["observaciones"],
            "id_cliente" => $resultado[$i]["id_cliente"],
            "nombre_cliente" => $resultado[$i]["nombre_cliente"],
            "sub_total" => $resultado[$i]["sub_total"],
            "estado" => $resultado[$i]["estado"],
            "adicional" => $resultado[$i]["adicional"],
            "nombre_area" => $resultado[$i]["nombre_area"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}