<?php

require_once '../datos/Conexion.clase.php';

class ProductoCongelado extends Conexion {

    private $id_producto, $nombre, $peso;
    
    function getId_producto() {
        return $this->id_producto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPeso() {
        return $this->peso;
    }

    function setId_producto($id_producto) {
        $this->id_producto = $id_producto;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }
    
    public function listar() {
        try {
            $sql = "select * from producto_congelado";
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

            $sql = "INSERT INTO producto_congelado(nombre,peso) VALUES( :p_nombre , :p_peso );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_peso", $this->getPeso());
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
            $sql = "select * from producto_congelado";
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
            $sql = "SELECT * FROM producto_congelado where id_producto = :p_id_producto";
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
            $sql = "UPDATE producto_congelado SET nombre=:p_nombre,peso=:p_peso where id_producto=:p_id_producto";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_peso", $this->getPeso());
            $sentencia->bindValue(":p_id_producto", $this->getId_producto());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla producto_congelado.");
        }
    }

    //put your code here
}
