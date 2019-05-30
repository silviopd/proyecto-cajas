<?php

require_once '../datos/Conexion.clase.php';

class Ubicacion extends Conexion {

    private $id_ubicacion,$nombre,$capacidad;
    
    function getId_ubicacion() {
        return $this->id_ubicacion;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCapacidad() {
        return $this->capacidad;
    }

    function setId_ubicacion($id_ubicacion) {
        $this->id_ubicacion = $id_ubicacion;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCapacidad($capacidad) {
        $this->capacidad = $capacidad;
    }
        
    public function listar() {
        try {
            $sql = "select * from ubicacion";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function listarCapacidad() {
        try {
            $sql = "select * from ubicacion where id_ubicacion=:p_id_ubicacion";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_ubicacion", $this->getId_ubicacion());
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

            $sql = "INSERT INTO ubicacion(nombre,capacidad) VALUES( :p_nombre , :p_peso );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_peso", $this->getCapacidad());
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
            $sql = "select * from ubicacion";
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
            $sql = "SELECT * FROM ubicacion where id_ubicacion = :p_id_producto";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_producto", $p_id_cliente);
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
            $sql = "UPDATE ubicacion SET nombre=:p_nombre,capacidad=:p_peso where id_ubicacion=:p_id_producto";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_peso", $this->getCapacidad());
            $sentencia->bindValue(":p_id_producto", $this->getId_ubicacion());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla producto_congelado.");
        }
    }

    //put your code here
}
