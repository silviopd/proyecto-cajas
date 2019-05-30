<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/IngresoPuerta4.php';
require_once '../util/funciones/Funciones.clase.php';

$dni = $_POST["dni"];

try {
    $obj = new IngresoPuerta4;
    $resultado = $obj->tipoPersonal($dni);
    $id_tipo_personal = $resultado["id_tipo_personal"];

    $resultado = $obj->datosPersonal($dni);
    
    $listavendedores = array();

        $datos = array(
            "dni" => $resultado["dni"],
            "id_tipo_personal" => $resultado["id_tipo_personal"],
            "precio" => floatval($resultado["precio"])
        );
        
        if ($id_tipo_personal == 7) {
            $datos["fecha_pagada"] = $resultado["fecha_pagada"];
            $datos["dias_pagar"] = floatval($resultado["dias_pagar"]);
            $datos["sub_total"] = 2 * $resultado["dias_pagar"];
        }
        
        $listavendedores = $datos;
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}