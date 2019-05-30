<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlquilerBalanzaRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_area = $_POST["id_registro"];

try {
    $obj = new AlquilerBalanzaRegistro();
    $resultado = $obj->leerDatos($id_area);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_registro" => $resultado[$i]["id_registro"],
            "id_producto" => $resultado[$i]["id_producto"],
            "id_usuario_area" => $resultado[$i]["id_usuario_area"],
            "observaciones" => $resultado[$i]["observaciones"],
            "id_cliente" => $resultado[$i]["id_cliente"],
            "nombre_producto" => $resultado[$i]["nombre_producto"],
            "numero_producto" => $resultado[$i]["numero_producto"],
            "nombre_cliente" => $resultado[$i]["nombre_cliente"],
            "adicional" => $resultado[$i]["adicional"],
            "id_area_alquiler_balanza" => $resultado[$i]["id_area_alquiler_balanza"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
