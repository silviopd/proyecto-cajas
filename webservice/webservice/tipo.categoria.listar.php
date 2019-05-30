<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoCategoria.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new TipoCategoria();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_tipo_categoria" => $resultado[$i]["id_tipo_categoria"],
            "nombre" => $resultado[$i]["nombre"],
            "precio" => $resultado[$i]["precio"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}