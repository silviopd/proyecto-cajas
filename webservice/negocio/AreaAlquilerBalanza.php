<?php

require_once '../datos/Conexion.clase.php';

class AreaAlquilerBalanza extends Conexion {

    private $id_area_alquiler_balanza, $nombre, $precio_base, $precio_retraso, $estado;

    function getId_area_alquiler_balanza() {
        return $this->id_area_alquiler_balanza;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPrecio_base() {
        return $this->precio_base;
    }

    function getPrecio_retraso() {
        return $this->precio_retraso;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_area_alquiler_balanza($id_area_alquiler_balanza) {
        $this->id_area_alquiler_balanza = $id_area_alquiler_balanza;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPrecio_base($precio_base) {
        $this->precio_base = $precio_base;
    }

    function setPrecio_retraso($precio_retraso) {
        $this->precio_retraso = $precio_retraso;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
    
    public function listar() {
        try {
            $sql = "select * from area_alquiler_balanza";
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

            $sql = "INSERT INTO area_alquiler_balanza(nombre,precio_base,precio_retraso,estado)
                    values(:p_nombre,:p_precio_base,:p_precio_retraso,:p_estado)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", strtoupper($this->getNombre()));
            $sentencia->bindValue(":p_precio_base", $this->getPrecio_base());
            $sentencia->bindValue(":p_precio_retraso", $this->getPrecio_retraso());
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
            $sql = "select id_area_alquiler_balanza,nombre from area_alquiler_balanza where estado like 'H' group by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($p_id_caja) {
        try {
            $sql = "SELECT * FROM area_alquiler_balanza where id_area_alquiler_balanza = :p_id_caja";
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
            $sql = "update area_alquiler_balanza
                    set nombre=:p_nombre,
                             precio_base=:p_precio_base,
                             precio_retraso=:p_precio_restado,
                             estado=:p_estado
                    where id_area_alquiler_balanza = :p_id_area_alquiler_balanza ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombre", $this->getNombre());
            $sentencia->bindValue(":p_precio_base", $this->getPrecio_base());
            $sentencia->bindValue(":p_precio_restado", $this->getPrecio_retraso());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_id_area_alquiler_balanza", $this->getId_area_alquiler_balanza());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }

    //put your code here
}
