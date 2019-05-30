<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenCliente.php';
require_once '../util/funciones/Funciones.clase.php';

$id_cliente = $_POST["id_cliente"];

try {
    $obj = new AlmacenCliente();
    $resultado = $obj->leerDatos($id_cliente);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_cliente" => $resultado[$i]["id_cliente"],
            "nombre" => $resultado[$i]["nombre"],
            "estado" => $resultado[$i]["estado"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
