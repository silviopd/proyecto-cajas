<?php

require_once '../datos/Conexion.clase.php';

class ProductoAlmacenGeneral extends Conexion {

    private $id_producto, $nombre, $stock,$unidad_medida;
    
    function getId_producto() {
        return $this->id_producto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getStock() {
        return $this->stock;
    }

    function setId_producto($id_producto) {
        $this->id_producto = $id_producto;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }
    
    function getUnidad_medida() {
        return $this->unidad_medida;
    }

    function setUnidad_medida($unidad_medida) {
        $this->unidad_medida = $unidad_medida;
    }
    
    public function listar() {
        try {
            $sql = "select * from producto_almacen_general";
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

            $sql = "INSERT INTO producto_almacen_general(nombre,stock,unidad_medida) VALUES( :p_nombre,:p_stock,:p_unidad_medida );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_stock", $this->getStock());
            $sentencia->bindValue(":p_unidad_medida", $this->getUnidad_medida());
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
            $sql = "select id_producto,nombre from producto_almacen_general";
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
            $sql = "SELECT * FROM producto_almacen_general where id_producto = :p_id_producto";
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
            $sql = "UPDATE producto_almacen_general SET nombre=:p_nombre,stock=:p_stock,unidad_medida=:p_unidad_medida where id_producto=:p_id_producto";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_stock", $this->getStock());
            $sentencia->bindValue(":p_unidad_medida", $this->getUnidad_medida());
            $sentencia->bindValue(":p_id_producto", $this->getId_producto());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla producto_almacen_general.");
        }
    }

    //put your code here
}
