<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

$id_registro = $_POST["id_registro"];

try {
    $obj = new AlmacenRegistro();
    $obj->setId_registro($id_registro);
    $resultado = $obj->leerDatos();

    $listavendedores = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
            "id_registro" => $resultado[$i]["id_registro"],
            "contacto" => $resultado[$i]["contacto"],            
            "cantidad" => $resultado[$i]["cantidad"],
            "observaciones" => $resultado[$i]["observaciones"],
            "fecha_registro_caja" => $resultado[$i]["fecha_registro_caja"],
            "operacion" => $resultado[$i]["operacion"],
            "id_caja" => $resultado[$i]["id_caja"],
            "id_usuario_area" => $resultado[$i]["id_usuario_area"],
            "stock_anterior" => $resultado[$i]["stock_anterior"],
            "stock_actual" => $resultado[$i]["stock_actual"],
            "sub_total" => $resultado[$i]["sub_total"],
            "id_ubicacion" => $resultado[$i]["id_ubicacion"],
            "id_cliente" => $resultado[$i]["id_cliente"],
            "nombre_ubicacion" => $resultado[$i]["nombre_ubicacion"],
            "capacidad" => $resultado[$i]["capacidad"]
        );

        $listavendedores[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listavendedores);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
