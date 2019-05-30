<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoCategoria.php';
require_once '../util/funciones/Funciones.clase.php';

$id_tipo_categoria = $_POST["id_tipo_categoria"];
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];

try {

    $obj = new TipoCategoria();
    $obj->setId_tipo_categoria($id_tipo_categoria);
    $obj->setNombre($nombre);
    $obj->setPrecio($precio);
    $resultado = $obj->editar();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Modificación Satisfactorio", "");
    }else{
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
      
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}