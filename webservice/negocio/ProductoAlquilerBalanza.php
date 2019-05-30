<?php

require_once '../datos/Conexion.clase.php';

class ProductoAlquilerBalanza extends Conexion {

    private $id_producto, $nombre, $estado, $numero_balanza;

    function getId_producto() {
        return $this->id_producto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstado() {
        return $this->estado;
    }

    function getNumero_balanza() {
        return $this->numero_balanza;
    }

    function setId_producto($id_producto) {
        $this->id_producto = $id_producto;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setNumero_balanza($numero_balanza) {
        $this->numero_balanza = $numero_balanza;
    }

    public function listar() {
        try {
            $sql = "select * from producto_alquiler_balanza";
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

            $sql = "INSERT INTO producto_alquiler_balanza(nombre,numero_balanza,estado)
                    values(:p_nombre,:p_numero_balanza,:p_estado)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", strtoupper($this->getNombre()));
            $sentencia->bindValue(":p_numero_balanza", $this->getNumero_balanza());
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
            $sql = "select id_producto,nombre from producto_alquiler_balanza where estado like 'H' group by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function listarAutocompletarNumero() {
        try {
            $sql = "select id_producto,numero_balanza from producto_alquiler_balanza where estado like 'H' and nombre like :p_nombre";
            $sentencia = $this->dblink->prepare($sql);
             $sentencia->bindValue(":p_nombre", strtoupper($this->getNombre()));
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function leerDatos($p_id_caja) {
        try {
            $sql = "SELECT * FROM producto_alquiler_balanza where id_producto = :p_id_caja";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $p_id_caja);
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
            $sql = "update producto_alquiler_balanza
                    set nombre=:p_nombre,
                             numero_balanza=:p_numero_balanza,
                             estado=:p_estado
                    where id_producto = :p_id_producto ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_numero_balanza", $this->getNumero_balanza());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_id_producto", $this->getId_producto());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }

    //put your code here
}
