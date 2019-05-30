<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenCliente.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new AlmacenCliente();
    $resultado = $obj->listarAutocompletar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_cliente" => $resultado[$i]["id_cliente"],
            "nombre" => $resultado[$i]["nombre"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}