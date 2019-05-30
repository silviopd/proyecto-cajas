<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoPersonal.php';
require_once '../util/funciones/Funciones.clase.php';

$id_tipo_personal = $_POST["id_tipo_personal"];

try {
    $obj = new TipoPersonal();
    $resultado = $obj->leerDatos($id_tipo_personal);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_tipo_personal" => $resultado[$i]["id_tipo_personal"],
            "nombre" => $resultado[$i]["nombre"],
            "precio" => $resultado[$i]["precio"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
