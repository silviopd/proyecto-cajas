<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoCategoria.php';
require_once '../util/funciones/Funciones.clase.php';

$id_tipo_categoria = $_POST["id_tipo_categoria"];

try {
    $obj = new TipoCategoria;
    $resultado = $obj->leerDatos($id_tipo_categoria);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_tipo_categoria" => $resultado[$i]["id_tipo_categoria"],
            "nombre" => $resultado[$i]["nombre"],
            "precio" => $resultado[$i]["precio"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
