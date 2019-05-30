<?php

require_once '../datos/Conexion.clase.php';

class AlmacenCliente extends Conexion {

    private $id_cliente, $nombre, $estado;

    function getId_cliente() {
        return $this->id_cliente;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function listar() {
        try {
            $sql = "select * from cliente";
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

            $sql = "INSERT INTO cliente(nombre,estado) VALUES( :p_nombre , :p_estado );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
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
            $sql = "select id_cliente,nombre from cliente where estado like 'H'";
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
            $sql = "SELECT * FROM cliente where id_cliente = :p_id_cliente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_cliente", $p_id_cliente);
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
            $sql = "UPDATE cliente SET nombre=:p_nombre,estado=:p_estado where id_cliente=:p_id_cliente ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_id_cliente", $this->getId_cliente());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }

    //put your code here
}
