<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Personal.php';
require_once '../util/funciones/Funciones.clase.php';

$dni = $_POST["dni"];

try {
    $obj = new Personal();
    $resultado = $obj->leerDatos($dni);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "dni" => $resultado[$i]["dni"],
            "nombres_apellidos" => $resultado[$i]["nombres_apellidos"],
            "id_tipo_personal" => $resultado[$i]["id_tipo_personal"],
            "estado" => $resultado[$i]["estado"],
            "nro_carretilla" => $resultado[$i]["nro_carretilla"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
