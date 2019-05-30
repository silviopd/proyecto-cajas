<?php

require_once '../datos/Conexion.clase.php';

class Congelado extends Conexion {

    private $id_registro, $fecha, $operacion, $contacto, $id_producto, $id_usuario_area, $bloques, $bloques_anterior, $bloques_actual, $observaciones, $id_cliente;

    function getId_registro() {
        return $this->id_registro;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getOperacion() {
        return $this->operacion;
    }

    function getContacto() {
        return $this->contacto;
    }

    function getId_producto() {
        return $this->id_producto;
    }

    function getId_usuario_area() {
        return $this->id_usuario_area;
    }

    function getBloques() {
        return $this->bloques;
    }

    function getBloques_anterior() {
        return $this->bloques_anterior;
    }

    function getBloques_actual() {
        return $this->bloques_actual;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getId_cliente() {
        return $this->id_cliente;
    }

    function setId_registro($id_registro) {
        $this->id_registro = $id_registro;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setOperacion($operacion) {
        $this->operacion = $operacion;
    }

    function setContacto($contacto) {
        $this->contacto = $contacto;
    }

    function setId_producto($id_producto) {
        $this->id_producto = $id_producto;
    }

    function setId_usuario_area($id_usuario_area) {
        $this->id_usuario_area = $id_usuario_area;
    }

    function setBloques($bloques) {
        $this->bloques = $bloques;
    }

    function setBloques_anterior($bloques_anterior) {
        $this->bloques_anterior = $bloques_anterior;
    }

    function setBloques_actual($bloques_actual) {
        $this->bloques_actual = $bloques_actual;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function agregar() {
        $this->dblink->beginTransaction();

        try {

            $sql = "CALL f_registro_congelado(:p_operacion,:p_contacto,:p_id_producto,:p_id_usuario_area,:p_bloques,:p_observaciones,:p_id_cliente);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_operacion", $this->getOperacion());
            $sentencia->bindValue(":p_contacto", $this->getContacto());
            $sentencia->bindValue(":p_id_producto", $this->getId_producto());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->bindValue(":p_bloques", $this->getBloques());
            $sentencia->bindValue(":p_observaciones", $this->getObservaciones());
            $sentencia->bindValue(":p_id_cliente", $this->getId_cliente());
            $sentencia->execute();

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function actualizar() {
        $this->dblink->beginTransaction();

        try {

            $sql = "call f_act_registrocongelado(:p_id_registro,:p_cant,:p_tipo_operacion,:p_id_usuario_area,:p_contacto,:p_observaciones);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_registro", $this->getId_registro());
            $sentencia->bindValue(":p_cant", $this->getBloques());
            $sentencia->bindValue(":p_tipo_operacion", $this->getOperacion());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->bindValue(":p_contacto", $this->getContacto());
            $sentencia->bindValue(":p_observaciones", $this->getObservaciones());
            $sentencia->execute();

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function listar() {
        try {
            $sql = "SELECT rc.id_registro, cast(rc.fecha as DATE) AS fecha, rc.contacto, rc.id_producto , pc.nombre as producto, rc.id_usuario_area, rc.bloques as cant, 
                            rc.bloques_actual as cant_actual, rc.observaciones, rc.id_cliente, cc.nombre as cliente,concat(c.nombres,' ', c.apellidos) as nombre_usuario,pc.peso
                                        FROM registro_congelado rc 
                                            INNER JOIN producto_congelado pc ON ( rc.id_producto = pc.id_producto  )  
                                            INNER JOIN cliente_congelado cc ON ( rc.id_cliente = cc.id_cliente  ) 
                                                    INNER JOIN usuario_area ua ON ( rc.id_usuario_area = ua.id_usuario_area  )  
                                            INNER JOIN usuario u ON ( ua.id_usuario = u.id_usuario  )  
                                                    INNER JOIN colaborador c ON ( u.id_usuario = c.dni  )  
                                            where rc.bloques_actual>0 ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function leerDatos($p_id_registro) {
        try {
            $sql = "select id_registro,
                    cast(fecha as DATE) AS fecha,
                    contacto,bloques_actual as cant,
                    observaciones,
                    operacion from registro_congelado where id_registro= :p_id_registro";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_registro", $p_id_registro);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function reporte() {
        try {
            $sql = "SELECT  hrc.id_registro, 
                            hrc.id_historial, 
                            DATE_FORMAT(hrc.fecha,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(hrc.fecha,'%l:%i %p') as hora,        
                           case when hrc.operacion = 'I' then 'INGRESO' else 'SALIDA' end as operacion, 
                            hrc.contacto, 
                            hrc.id_usuario_area, 
                            hrc.bloques, 
                            hrc.bloques_anterior, 
                            hrc.bloques_actual, 
                            hrc.observaciones, 
                            pc.nombre as nombre_producto, 
                            pc.peso, 
                            cc.nombre as nombre_cliente
                    FROM historial_registro_congelado hrc 
                            INNER JOIN registro_congelado rc ON ( hrc.id_registro = rc.id_registro  )  
                                    INNER JOIN producto_congelado pc ON ( rc.id_producto = pc.id_producto  )  
                                    INNER JOIN cliente_congelado cc ON ( rc.id_cliente = cc.id_cliente  )  
                    WHERE date(hrc.fecha) = CURDATE()";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
