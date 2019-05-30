<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoCarga.php';
require_once '../util/funciones/Funciones.clase.php';

$id_tipo_carga = $_POST["id_tipo_carga"];

try {
    $obj = new TipoCarga();
    $resultado = $obj->leerDatos($id_tipo_carga);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_tipo_carga" => $resultado[$i]["id_tipo_carga"],
            "nombre" => $resultado[$i]["nombre"],
            "precio" => $resultado[$i]["precio"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
