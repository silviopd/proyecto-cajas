<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/SalidaPuerta4.php';
require_once '../util/funciones/Funciones.clase.php';

try {

$obj = new SalidaPuerta4();
    $resultado = $obj->listar();

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "nro_placa" => $resultado[$i]["nro_placa"],
            "id_salida" => $resultado[$i]["id_salida"],
            "fecha" => $resultado[$i]["fecha"],
            "hora" => $resultado[$i]["hora"],
            "cantidad" => $resultado[$i]["cantidad"],
            "estado" => $resultado[$i]["estado"],
            "id_tipo_carga" => $resultado[$i]["id_tipo_carga"],
            "nombre_carga" => $resultado[$i]["nombre_carga"],
            "precio_carga" => $resultado[$i]["precio_carga"],
            "id_tipo_categoria" => $resultado[$i]["id_tipo_categoria"],
            "nombre_categoria" => $resultado[$i]["nombre_categoria"],
            "precio_categoria" => $resultado[$i]["precio_categoria"],
            "id_usuario_area" => $resultado[$i]["id_usuario_area"],
            "nombre_usuario" => $resultado[$i]["nombre_usuario"],
            "sub_total" => $resultado[$i]["sub_total"]
        );

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}