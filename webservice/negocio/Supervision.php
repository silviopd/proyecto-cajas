<?php

require_once '../datos/Conexion.clase.php';

class Supervision extends Conexion{
        
    public function listar() {
        try {
            $sql = "SELECT * FROM v_supervision where estado like 'P'";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}
