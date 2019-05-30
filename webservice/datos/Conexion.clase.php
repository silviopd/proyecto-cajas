<?php

require_once 'configuracion.php';
require_once '../util/funciones/Funciones.clase.php'; 

class Conexion {

    protected $dblink;

    public function __construct() {
        $this->abrirConexion();
        //echo "conexión abierta";
    }

    public function __destruct() {
        $this->dblink = NULL;
        //echo "Conexión cerrada";
    }
    
    protected function abrirConexion() {
        
        /* MySql */
        $servidor = "mysql:host=".SERVIDOR_BD.";port=".PUERTO_BD.";dbname=".NOMBRE_BD;
        /* MySql */

        
        $usuario = USUARIO_BD;
        $clave = CLAVE_BD;

        try {
            $this->dblink = new PDO($servidor, $usuario, $clave);
            /* MySql */
            $this->dblink->exec("SET NAMES 'utf8';");
            /* MySql */
            $this->dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $exc) {
            Funciones::mensaje($exc->getMessage(), "e");
        }        
        return $this->dblink;
    }

}
 mysql://x3fu2375euen2n9s:taap2l8oulg83056@g8mh6ge01lu2z3n1.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/xxnybg345bfz1s1t