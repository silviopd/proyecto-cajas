<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Colaborador.php';
require_once '../util/funciones/Funciones.clase.php';

$dni = $_POST["dni"];

try {
    $obj = new Colaborador();
    $resultado = $obj->leerDatos($dni);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "dni" => $resultado[$i]["dni"],
            "nombres" => $resultado[$i]["nombres"],
            "apellidos" => $resultado[$i]["apellidos"],
            "estado" => $resultado[$i]["estado"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
