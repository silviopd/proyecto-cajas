<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoPersonal.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new TipoPersonal();
    $resultado = $obj->listarAutocompletar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_tipo_personal" => $resultado[$i]["id_tipo_personal"],
            "nombre" => $resultado[$i]["nombre"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}