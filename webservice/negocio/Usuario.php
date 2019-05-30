<?php

require_once '../datos/Conexion.clase.php';

class Usuario extends Conexion {

    private $id_usuario, $pass, $estado;

    function getId_usuario() {
        return $this->id_usuario;
    }

    function getPass() {
        return $this->pass;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
    
    public function listar() {
        try {
            $sql = "select u.id_usuario,c.nombres,c.apellidos,u.estado from usuario u inner join colaborador c on c.dni=u.id_usuario";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function agregar() {
        $this->dblink->beginTransaction();

        try {

            $sql = "INSERT INTO usuario VALUES( :p_id_usuario ,md5(:p_pass) , :p_estado );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_usuario", $this->getId_usuario());
            $sentencia->bindValue(":p_pass", $this->getPass());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->execute();

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function listarAutocompletar() {
        try {
            $sql = "SELECT u.id_usuario, concat(c.nombres,' ',c.apellidos) as nombres FROM usuario u inner join colaborador c on c.dni=u.id_usuario";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function leerDatos($p_id_cliente) {
        try {
            $sql = "SELECT * FROM usuario where id_usuario = :p_id_usuario";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_usuario", $p_id_cliente);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function editar() {
        $this->dblink->beginTransaction();
        try {
            $sql = "UPDATE usuario SET pass=md5(:p_pass),estado=:p_estado where id_usuario=:p_id_usuario";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_pass", $this->getPass());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_id_usuario", $this->getId_usuario());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }

    //put your code here
}
