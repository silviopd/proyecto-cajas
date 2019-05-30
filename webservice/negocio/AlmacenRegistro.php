<?php

require_once '../datos/Conexion.clase.php';

class AlmacenRegistro extends Conexion {

    private $id_registro, $contacto, $cantidad, $observaciones, $fecha_registro_caja, $id_ubicacion, $id_cliente, $operacion, $stock, $id_caja, $id_usuario_area;

    function getId_registro() {
        return $this->id_registro;
    }

    function getContacto() {
        return $this->contacto;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFecha_registro_caja() {
        return $this->fecha_registro_caja;
    }

    function getId_ubicacion() {
        return $this->id_ubicacion;
    }

    function getOperacion() {
        return $this->operacion;
    }

    function getStock() {
        return $this->stock;
    }

    function getId_caja() {
        return $this->id_caja;
    }

    function getId_usuario_area() {
        return $this->id_usuario_area;
    }

    function setId_registro($id_registro) {
        $this->id_registro = $id_registro;
    }

    function setContacto($contacto) {
        $this->contacto = $contacto;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFecha_registro_caja($fecha_registro_caja) {
        $this->fecha_registro_caja = $fecha_registro_caja;
    }

    function setId_ubicacion($id_ubicacion) {
        $this->id_ubicacion = $id_ubicacion;
    }

    function setOperacion($operacion) {
        $this->operacion = $operacion;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }

    function setId_caja($id_caja) {
        $this->id_caja = $id_caja;
    }

    function setId_usuario_area($id_usuario_area) {
        $this->id_usuario_area = $id_usuario_area;
    }

    function getId_cliente() {
        return $this->id_cliente;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function leerDatos() {
        try {
            $sql = "SELECT rc.id_registro, rc.contacto, rc.cantidad, rc.observaciones, rc.fecha_registro_caja, rc.operacion, rc.id_caja, rc.id_usuario_area, rc.stock_anterior, rc.stock_actual, rc.sub_total, rc.id_ubicacion, rc.id_cliente, u.nombre as nombre_ubicacion, u.capacidad
                    FROM registro_caja rc 
                            INNER JOIN ubicacion u ON ( rc.id_ubicacion = u.id_ubicacion  )  
                            where rc.id_registro = :p_id_registro";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_registro", $this->getId_registro());
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar() {
        try {
            $sql = "SELECT 
                    rc.id_registro, 
                    rc.contacto, 
                    rc.cantidad, 
                    rc.observaciones, 
                    DATE_FORMAT(rc.fecha_registro_caja,'%d-%m-%Y') as fecha,
                    DATE_FORMAT(rc.fecha_registro_caja,'%l:%i %p') as hora,
                    rc.operacion, 
                    rc.id_caja, 
                    c.nombre as nombre_caja, 
                    rc.stock_anterior, 
                    rc.stock_actual, 
                    rc.id_ubicacion,  
                    u.nombre as nombre_ubicacion,    
                    u.capacidad,
                    rc.id_cliente,
                    c1.nombre as nombre_cliente,
                    rc.id_usuario_area, 
                    concat(c2.nombres,' ',c2.apellidos) as nombre_usuario
                  FROM registro_caja rc 
                          INNER JOIN caja c ON ( rc.id_caja = c.id_caja  )  
                          INNER JOIN usuario_area ua ON ( rc.id_usuario_area = ua.id_usuario_area  )  
                                  INNER JOIN usuario u1 ON ( ua.id_usuario = u1.id_usuario  )  
                                          INNER JOIN colaborador c2 ON ( u1.id_usuario = c2.dni  )  
                          INNER JOIN ubicacion u ON ( rc.id_ubicacion = u.id_ubicacion  )  
                          INNER JOIN cliente c1 ON ( rc.id_cliente = c1.id_cliente  ) 
                    WHERE rc.cantidad > 0
                    ORDER BY 1 DESC";
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

            $sql = "CALL  f_registro_caja( :p_contacto, :p_cantidad, :p_observaciones, :p_operacion,:p_id_caja, :p_id_usuario_area, :p_id_ubicacion, :p_id_cliente);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_contacto", $this->getContacto());
            $sentencia->bindValue(":p_cantidad", $this->getCantidad());
            $sentencia->bindValue(":p_observaciones", $this->getObservaciones());
            $sentencia->bindValue(":p_operacion", $this->getOperacion());
            $sentencia->bindValue(":p_id_caja", $this->getId_caja());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->bindValue(":p_id_ubicacion", $this->getId_ubicacion());
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

    public function ingresar_retirar() {
        $this->dblink->beginTransaction();

        try {

            $sql = "CALL  f_registro_caja_ingreso_salida( :p_id_registro, :p_contacto, :p_cantidad, :p_observaciones, :p_operacion, :p_id_usuario_area);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_registro", $this->getId_registro());
            $sentencia->bindValue(":p_contacto", $this->getContacto());
            $sentencia->bindValue(":p_cantidad", $this->getCantidad());
            $sentencia->bindValue(":p_observaciones", $this->getObservaciones());
            $sentencia->bindValue(":p_operacion", $this->getOperacion());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->execute();

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function buscarStock() {
        try {

            $sql = "select stock from caja where id_caja = :p_id_caja";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $this->getId_caja());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }

    /* FUNCION DEL REPORTE */

    public function reporteRegistro() {
        try {
            $sql = "select * from v_reporte_almacen_caja
            WHERE date(fecha_registro_caja) = CURDATE() AND
                 lower(nombre_cliente) != lower('ecomphisa') AND operacion = 'SALIDA'";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listarReporteRegistroFechas($fecha_inicio, $fecha_final) {
        try {
            $sql = "select * from v_reporte_almacen_caja
            WHERE date(fecha_registro_caja) >= :p_fecha_inicio and date(fecha_registro_caja) <= :p_fecha_final AND
                 lower(nombre_cliente) != lower('ecomphisa') AND operacion = 'SALIDA'";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_fecha_inicio", $fecha_inicio);
            $sentencia->bindValue(":p_fecha_final", $fecha_final);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function reporteRegistroEcomphisa() {
        try {
            $sql = "SELECT  hrc.id_registro, 
                    hrc.id_historial,
                    rc.id_cliente, 
                    c1.nombre AS nombre_cliente,
                    hrc.contacto, 
                    hrc.cantidad, 
                    hrc.observaciones, 
                    hrc.fecha_registro_caja, 
                    DATE_FORMAT(hrc.fecha_registro_caja,'%d-%m-%Y') as fecha,
                    DATE_FORMAT(hrc.fecha_registro_caja,'%l:%i %p') as hora,
                    (CASE WHEN hrc.operacion = 'I' then 'INGRESO' ELSE 'SALIDA' END) AS operacion, 
                    hrc.id_usuario_area, 
                    hrc.stock_anterior, 
                    hrc.stock_actual, 
                    hrc.sub_total, 
                    rc.id_caja, 
                    c.precio_base,
                    c.nombre as nombre_caja, 
                    rc.id_ubicacion, 
                    u.nombre AS nombre_ubicacion,         
                    concat(c2.nombres,' ',c2.apellidos) AS nombre_usuario
            FROM historial_registro_caja hrc 
                    INNER JOIN registro_caja rc ON ( hrc.id_registro = rc.id_registro  )  
                            INNER JOIN caja c ON ( rc.id_caja = c.id_caja  )  
                            INNER JOIN usuario_area ua ON ( rc.id_usuario_area = ua.id_usuario_area  )  
                                    INNER JOIN usuario u1 ON ( ua.id_usuario = u1.id_usuario  )  
                                            INNER JOIN colaborador c2 ON ( u1.id_usuario = c2.dni  )  
                            INNER JOIN ubicacion u ON ( rc.id_ubicacion = u.id_ubicacion  )  
                            INNER JOIN cliente c1 ON ( rc.id_cliente = c1.id_cliente  ) 
            WHERE date(hrc.fecha_registro_caja) = CURDATE() AND
                 lower(c1.nombre) = lower('ecomphisa') AND hrc.operacion = 'S'";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listarReporteRegistroEcomphisaFechas($fecha_inicio, $fecha_final) {
        try {
            $sql = "SELECT  hrc.id_registro, 
                    hrc.id_historial,
                    rc.id_cliente, 
                    c1.nombre AS nombre_cliente,
                    hrc.contacto, 
                    hrc.cantidad, 
                    hrc.observaciones, 
                    hrc.fecha_registro_caja, 
                    DATE_FORMAT(hrc.fecha_registro_caja,'%d-%m-%Y') as fecha,
                    DATE_FORMAT(hrc.fecha_registro_caja,'%l:%i %p') as hora,
                    (CASE WHEN hrc.operacion = 'I' then 'INGRESO' ELSE 'SALIDA' END) AS operacion, 
                    hrc.id_usuario_area, 
                    hrc.stock_anterior, 
                    hrc.stock_actual, 
                    hrc.sub_total, 
                    rc.id_caja, 
                    c.precio_base,
                    c.nombre as nombre_caja, 
                    rc.id_ubicacion, 
                    u.nombre AS nombre_ubicacion,         
                    concat(c2.nombres,' ',c2.apellidos) AS nombre_usuario
            FROM historial_registro_caja hrc 
                    INNER JOIN registro_caja rc ON ( hrc.id_registro = rc.id_registro  )  
                            INNER JOIN caja c ON ( rc.id_caja = c.id_caja  )  
                            INNER JOIN usuario_area ua ON ( rc.id_usuario_area = ua.id_usuario_area  )  
                                    INNER JOIN usuario u1 ON ( ua.id_usuario = u1.id_usuario  )  
                                            INNER JOIN colaborador c2 ON ( u1.id_usuario = c2.dni  )  
                            INNER JOIN ubicacion u ON ( rc.id_ubicacion = u.id_ubicacion  )  
                            INNER JOIN cliente c1 ON ( rc.id_cliente = c1.id_cliente  ) 
            WHERE date(hrc.fecha_registro_caja) >= :p_fecha_inicio and date(hrc.fecha_registro_caja) <= :p_fecha_final AND
                 lower(c1.nombre) = lower('ecomphisa') AND hrc.operacion = 'S'";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_fecha_inicio", $fecha_inicio);
            $sentencia->bindValue(":p_fecha_final", $fecha_final);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function ticket() {
        try {
            $sql = "SELECT  hrc.id_registro, 
                            hrc.contacto, 
                            hrc.cantidad, 
                            hrc.observaciones, 
                            DATE_FORMAT(hrc.fecha_registro_caja,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(hrc.fecha_registro_caja,'%l:%i %p') as hora, 
                            hrc.operacion, 
                            hrc.id_usuario_area, 
                            hrc.stock_anterior, 
                            hrc.stock_actual, 
                            hrc.sub_total, 
                            hrc.id_historial, 
                            c.nombre as nombre_caja, 
                            c.precio_base, 
                            concat(c1.nombres,' ',c1.apellidos) as nombre_usuario, 
                            u1.nombre as nombre_ubicacion, 
                            c2.nombre as nombre_cliente
                    FROM historial_registro_caja hrc 
                            INNER JOIN registro_caja rc ON ( hrc.id_registro = rc.id_registro  )  
                                    INNER JOIN caja c ON ( rc.id_caja = c.id_caja  )  
                                    INNER JOIN usuario_area ua ON ( rc.id_usuario_area = ua.id_usuario_area  )  
                                            INNER JOIN usuario u ON ( ua.id_usuario = u.id_usuario  )  
                                                    INNER JOIN colaborador c1 ON ( u.id_usuario = c1.dni  )  
                                    INNER JOIN ubicacion u1 ON ( rc.id_ubicacion = u1.id_ubicacion  )  
                                    INNER JOIN cliente c2 ON ( rc.id_cliente = c2.id_cliente  )
                    WHERE hrc.id_registro = :p_id_registro AND hrc.operacion = 'S'
                    ORDER BY hrc.id_historial DESC LIMIT 1  ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_registro", $this->getId_registro());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    //put your code here
}
