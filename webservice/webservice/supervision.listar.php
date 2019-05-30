<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Supervision.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $obj = new Supervision();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_supervision_vfr" => $resultado[$i]["id_supervision_vfr"],
            "dni" => $resultado[$i]["dni"],
            "nombres_apellidos" => $resultado[$i]["nombres_apellidos"],
            "id_tipo_personal" => $resultado[$i]["id_tipo_personal"],
            "nombre_tipo_personal" => $resultado[$i]["nombre_tipo_personal"],
            "estado" => $resultado[$i]["estado"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}