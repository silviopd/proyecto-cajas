<?php

require_once '../datos/Conexion.clase.php';

class Sesion extends Conexion{
        
    public function iniciarSesionWeb($dni, $clave) {
        try {
            $sql = "CALL f_inicio_sesion( :p_usuario , md5(:p_password) )";
            $sentencia = $this->dblink->prepare($sql);

            $sentencia->bindValue(":p_usuario", $dni);
            $sentencia->bindValue(":p_password", $clave);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            if ($sentencia->rowCount()) {
                return $resultado;
            } else {
                throw new Exception("Correo o contraseña incorrectos.");
            }
        } catch (PDOException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}

