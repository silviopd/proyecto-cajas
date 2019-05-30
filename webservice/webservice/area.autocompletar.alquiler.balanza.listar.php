<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AreaAlquilerBalanza.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new AreaAlquilerBalanza();
    $resultado = $obj->listarAutocompletar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_area_alquiler_balanza" => $resultado[$i]["id_area_alquiler_balanza"],
            "nombre" => $resultado[$i]["nombre"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}