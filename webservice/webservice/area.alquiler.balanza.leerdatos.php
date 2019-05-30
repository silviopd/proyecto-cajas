<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AreaAlquilerBalanza.php';
require_once '../util/funciones/Funciones.clase.php';

$id_producto = $_POST["id_area_alquiler_balanza"];

try {
    $obj = new AreaAlquilerBalanza();
    $resultado = $obj->leerDatos($id_producto);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_area_alquiler_balanza" => $resultado[$i]["id_area_alquiler_balanza"],
            "nombre" => $resultado[$i]["nombre"],
            "precio_base" => $resultado[$i]["precio_base"],
            "precio_retraso" => $resultado[$i]["precio_retraso"],
            "estado" => $resultado[$i]["estado"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
