<?php

header('Access-Control-Allow-Origin: *');

require_once '../negocio/Sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';

/*
  if (!isset($_POST["dni"]) || !isset($_POST["clave"])) {
  Funciones::imprimeJSON(500, "Falta completar los datos requeridos", "");
  exit();
  }
 */

$dni = $_POST["usuario"];
$clave = $_POST["password"];

try {
    $objSesion = new Sesion();
    $resultado = $objSesion->iniciarSesionWeb($dni, $clave);

    if ($resultado[0]["estado"] == 200) {

         /* Generar un token de seguridad */
        require_once 'token.generar.php';
        $token = generarToken(null, 3600);
        //$resultado["token"] = $token;
        /* Generar un token de seguridad */
        
        Funciones::imprimeJSON(200,$token , $resultado);
    } else {
        Funciones::imprimeJSON(500, $resultado, "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
