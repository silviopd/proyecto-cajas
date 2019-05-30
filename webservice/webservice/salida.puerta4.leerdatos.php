<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/SalidaPuerta4.php';
require_once '../util/funciones/Funciones.clase.php';

$nro_placa = $_POST["nro_placa"];
$id_salida = $_POST["id_salida"];

try {
    $obj = new SalidaPuerta4();
    $resultado = $obj->leerDatos($nro_placa, $id_salida);

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "nro_placa" => $resultado[$i]["nro_placa"],
            "id_salida" => $resultado[$i]["id_salida"],
            "fecha" => $resultado[$i]["fecha"],
            "cantidad" => $resultado[$i]["cantidad"],
            "estado" => $resultado[$i]["estado"],
            "id_tipo_carga" => $resultado[$i]["id_tipo_carga"],
            "id_tipo_categoria" => $resultado[$i]["id_tipo_categoria"],
            "sub_total" => $resultado[$i]["sub_total"],
            "tiempo" => $resultado[$i]["tiempo"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
