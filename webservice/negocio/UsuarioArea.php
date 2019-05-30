<?php

require_once '../datos/Conexion.clase.php';

class UsuarioArea extends Conexion {

    private $id_usuario_area, $id_usuario, $id_area, $estado;

    function getId_usuario_area() {
        return $this->id_usuario_area;
    }

    function getId_usuario() {
        return $this->id_usuario;
    }

    function getId_area() {
        return $this->id_area;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_usuario_area($id_usuario_area) {
        $this->id_usuario_area = $id_usuario_area;
    }

    function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function setId_area($id_area) {
        $this->id_area = $id_area;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function listar() {
        try {
            $sql = "SELECT  ua.id_usuario_area, 
                            ua.id_usuario, 
                            ua.id_modulo, 
                            ua.estado, 
                            UPPER(concat(c.nombres,' ',c.apellidos)) as nombre_usuario, 
                            m.id_modulo,
                            m.nombre as nombre_modulo
                    FROM usuario_area ua 
                            INNER JOIN usuario u ON ( ua.id_usuario = u.id_usuario  )  
                                    INNER JOIN colaborador c ON ( u.id_usuario = c.dni  )  
                            INNER JOIN modulo m ON ( ua.id_modulo = m.id_modulo  )  ";
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

            $sql = "INSERT INTO usuario_area(id_usuario, id_modulo, estado) VALUES (:p_id_usuario,:p_id_area,:p_estado)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_usuario", $this->getId_usuario());
            $sentencia->bindValue(":p_id_area", $this->getId_area());
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
            $sql = "select u.id_usuario,concat(c.nombres,' ',c.apellidos ) as nombres from usuario u inner join colaborador c on c.dni=u.id_usuario where u.estado = 'H'";
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
            $sql = "SELECT * FROM usuario_area where id_usuario_area = :id_usuario_area";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":id_usuario_area", $p_id_cliente);
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
            $sql = "UPDATE usuario_area SET
                    id_usuario=:p_id_usuario,
                    id_modulo=:p_id_area,
                    estado=:p_estado
                    where id_usuario_area=:p_id_usuario_area";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_usuario", $this->getId_usuario());
            $sentencia->bindValue(":p_id_area", $this->getId_area());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }
}

