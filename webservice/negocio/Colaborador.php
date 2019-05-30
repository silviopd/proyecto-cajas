<?php

require_once '../datos/Conexion.clase.php';

class Colaborador extends Conexion {

    private $dni, $nombres, $apellidos,$estado;

    function getDni() {
        return $this->dni;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getEstado() {
        return $this->estado;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function listar() {
        try {
            $sql = "select * from colaborador";
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

            $sql = "INSERT INTO colaborador VALUES(:p_dni, :p_nombres, :p_apellidos, :p_estado );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_dni", $this->getDni());
            $sentencia->bindValue(":p_nombres", $this->getNombres());
            $sentencia->bindValue(":p_apellidos", $this->getApellidos());
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
            $sql = "select dni,concat(nombres,' ',apellidos) as nombre from colaborador where estado = 'H'";
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
            $sql = "SELECT * FROM colaborador where dni = :p_dni";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_dni", $p_id_cliente);
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
            $sql = "UPDATE colaborador SET nombres=:p_nombres,apellidos=:p_apellidos,estado=:p_estado where dni=:p_dni";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nombres", $this->getNombres());
            $sentencia->bindValue(":p_apellidos", $this->getApellidos());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_dni", $this->getDni());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }

    //put your code here
}
