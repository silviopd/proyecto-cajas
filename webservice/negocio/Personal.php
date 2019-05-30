<?php

require_once '../datos/Conexion.clase.php';

class Personal extends Conexion {

    private $dni, $nombres_apellidos, $id_tipo_personal, $estado, $nro_carretilla;

    function getDni() {
        return $this->dni;
    }

    function getNombres_apellidos() {
        return $this->nombres_apellidos;
    }

    function getId_tipo_personal() {
        return $this->id_tipo_personal;
    }

    function getEstado() {
        return $this->estado;
    }

    function setDni($dni) {
        $this->dni =  str_pad($dni, 8, '0', STR_PAD_LEFT);
    }

    function setNombres_apellidos($nombres_apellidos) {
        $this->nombres_apellidos = $nombres_apellidos;
    }

    function setId_tipo_personal($id_tipo_personal) {
        $this->id_tipo_personal = $id_tipo_personal;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getNro_carretilla() {
        return $this->nro_carretilla;
    }

    function setNro_carretilla($nro_carretilla) {
        $this->nro_carretilla = $nro_carretilla;
    }

    public function listar() {
        try {
            $sql = "SELECT p.dni,p.nombres_apellidos,p.id_tipo_personal,tp.nombre as nombre_tipo_personal,p.nro_carretilla,p.estado FROM personal p inner join tipo_personal tp on p.id_tipo_personal=tp.id_tipo_personal";
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

            $sql = "INSERT INTO personal VALUES(:p_dni , :p_nombres_apellidos  , :p_estado, :p_id_tipo_personal,:p_nro_carretilla);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_dni", $this->getDni());
            $sentencia->bindValue(":p_nombres_apellidos", $this->getNombres_apellidos());
            $sentencia->bindValue(":p_id_tipo_personal", $this->getId_tipo_personal());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_nro_carretilla", $this->getNro_carretilla());
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
            $sql = "select dni,nombres_apellidos as nombres from personal";
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
            $sql = "SELECT * FROM personal where dni = :p_dni";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_dni", str_pad($p_id_cliente, 8, '0', STR_PAD_LEFT));
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
            $sql = "UPDATE personal SET nombres_apellidos=:p_nombres,id_tipo_personal=:p_id_tipo_personal,estado=:p_estado,nro_carretilla=:p_nro_carretilla where dni=:p_dni";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombres", $this->getNombres_apellidos());
            $sentencia->bindValue(":p_id_tipo_personal", $this->getId_tipo_personal());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_dni", str_pad($this->getDni(), 8, '0', STR_PAD_LEFT));
            $sentencia->bindValue(":p_nro_carretilla", $this->getNro_carretilla());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }

    //put your code here
}
