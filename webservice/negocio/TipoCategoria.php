<?php

require_once '../datos/Conexion.clase.php';

class TipoCategoria extends Conexion {

    private $id_tipo_categoria, $nombre,$precio;

    function getId_tipo_categoria() {
        return $this->id_tipo_categoria;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setId_tipo_categoria($id_tipo_categoria) {
        $this->id_tipo_categoria = $id_tipo_categoria;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function listar() {
        try {
            $sql = "select * from tipo_categoria where id_tipo_categoria > 1";
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

            $sql = "INSERT INTO tipo_categoria(nombre,precio) VALUES( :p_nombre,:p_precio );";
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
            $sql = "select id_tipo_categoria,nombre from tipo_categoria where id_tipo_categoria > 1";
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
            $sql = "SELECT * FROM tipo_categoria where id_tipo_categoria = :p_tipo_categoria";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_tipo_categoria", $p_id_cliente);
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
            $sql = "UPDATE tipo_categoria SET nombre=:p_nombre, precio=:p_precio where id_tipo_categoria=:p_tipo_categoria ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_precio", $this->getPrecio());
            $sentencia->bindValue(":p_tipo_categoria", $this->getId_tipo_categoria());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }
    
    public function buscarPrecio() {
        try {
            $sql = "select precio from tipo_categoria where id_tipo_categoria=:p_id_tipo_categoria";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_tipo_categoria", $this->getId_tipo_categoria());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    //put your code here
}
