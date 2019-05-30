<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new AlmacenRegistro();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_registro" => $resultado[$i]["id_registro"],
            "contacto" => $resultado[$i]["contacto"],
            "cantidad" => $resultado[$i]["cantidad"],            
            "observaciones" => $resultado[$i]["observaciones"],            
            "fecha" => $resultado[$i]["fecha"],
            "hora" => $resultado[$i]["hora"],            
            "operacion" => $resultado[$i]["operacion"],            
            "nombre_caja" => $resultado[$i]["nombre_caja"],
            "stock_actual" => $resultado[$i]["stock_actual"],
            "stock_anterior" => $resultado[$i]["stock_anterior"],            
            "nombre_ubicacion" => $resultado[$i]["nombre_ubicacion"],
            "nombre_cliente" => $resultado[$i]["nombre_cliente"],
            "nombre_usuario" => $resultado[$i]["nombre_usuario"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}