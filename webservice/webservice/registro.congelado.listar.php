<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Congelado.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Congelado();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_registro" => $resultado[$i]["id_registro"],
            "fecha" => $resultado[$i]["fecha"],
            "contacto" => $resultado[$i]["contacto"],
            "id_producto" => $resultado[$i]["id_producto"],
            "producto" => $resultado[$i]["producto"],
            "id_usuario_area" => $resultado[$i]["id_usuario_area"],
            "cant" => $resultado[$i]["cant"],
            "cant_actual" => $resultado[$i]["cant_actual"],
            "observaciones" => $resultado[$i]["observaciones"],
            "id_cliente" => $resultado[$i]["id_cliente"],
            "cliente" => $resultado[$i]["cliente"],
            "nombre_usuario" => $resultado[$i]["nombre_usuario"],
            "peso" => $resultado[$i]["peso"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}