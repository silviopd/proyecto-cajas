<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/AlmacenGeneralRegistro.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_final = $_POST["fecha_final"];
    
    $obj = new AlmacenGeneralRegistro();
    $resultado = $obj->listarReporteRegistroFechas($fecha_inicio, $fecha_final);

    $listadepartamento = array();
    for ($i = 0; $i < count($resultado); $i++) {

        $datos = array(
           "id_registro" => $resultado[$i]["id_registro"],
            "fecha" => $resultado[$i]["fecha"],
            "hora" => $resultado[$i]["hora"],
            "operacion" => $resultado[$i]["operacion"],
            "contacto" => $resultado[$i]["contacto"],
            "id_producto" => $resultado[$i]["id_producto"],
            "nombre_producto" => $resultado[$i]["nombre_producto"],
            "id_usuario_area" => $resultado[$i]["id_usuario_area"],
            "nombre_usuario" => $resultado[$i]["nombre_usuario"],
            "cantidad" => $resultado[$i]["cantidad"],
            "stock_anterior" => $resultado[$i]["stock_anterior"],
            "stock_actual" => $resultado[$i]["stock_actual"],
            "observaciones" => $resultado[$i]["observaciones"],
            "id_area" => $resultado[$i]["id_area"],
            "nombre_area" => $resultado[$i]["nombre_area"]
        );            

        $listadepartamento[$i] = $datos;
    }
    Funciones::imprimeJSON(200, "", $listadepartamento);
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}