<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/SalidaPuerta4.php';
require_once '../util/funciones/Funciones.clase.php';

$nro_placa = $_POST["nro_placa"];
$id_salida = $_POST["id_salida"];
$id_tipo_carga = $_POST["id_tipo_carga"];


try {

    $obj = new SalidaPuerta4();
    $obj->setNro_placa($nro_placa);
    $obj->setId_salida($id_salida);
    $obj->setId_tipo_carga($id_tipo_carga);
    $resultado = $obj->agregar_pagar();

    if ($resultado) {
        Funciones::imprimeJSON(200, "Registro Satisfactorio", "");
    }else{
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
      
} catch (Exception $exc) {
    //Funciones::imprimeJSON(500, $exc->getMessage(), "");
    echo $exc->getMessage();
}
