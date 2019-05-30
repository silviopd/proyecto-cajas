<?php

require_once '../datos/Conexion.clase.php';

class TipoPersonal extends Conexion {

    private $id_tipo_personal, $nombre, $precio;

    function getId_tipo_personal() {
        return $this->id_tipo_personal;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setId_tipo_personal($id_tipo_personal) {
        $this->id_tipo_personal = $id_tipo_personal;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

        
    public function listar() {
        try {
            $sql = "select * from tipo_personal";
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

            $sql = "INSERT INTO tipo_personal(nombre,precio) VALUES( :p_nombre , :p_precio );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_precio", $this->getPrecio());
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
            $sql = "select id_tipo_personal,nombre from tipo_personal";
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
            $sql = "SELECT * FROM tipo_personal where id_tipo_personal = :p_tipo_personal";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_tipo_personal", $p_id_cliente);
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
            $sql = "UPDATE tipo_personal SET nombre=:p_nombre,precio=:p_precio where id_tipo_personal=:p_id_tipo_personal";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_precio", $this->getPrecio());
            $sentencia->bindValue(":p_id_tipo_personal", $this->getId_tipo_personal());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }

    //put your code here
}
