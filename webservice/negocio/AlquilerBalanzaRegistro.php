<?php

require_once '../datos/Conexion.clase.php';

class AlquilerBalanzaRegistro extends Conexion {

    private $id_registro,$id_area, $fecha, $id_producto, $id_usuario_area, $observaciones, $id_cliente, $sub_total, $estado, $adicional;

    function getId_registro() {
        return $this->id_registro;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getId_producto() {
        return $this->id_producto;
    }

    function getId_usuario_area() {
        return $this->id_usuario_area;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getId_cliente() {
        return $this->id_cliente;
    }

    function getSub_total() {
        return $this->sub_total;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId_registro($id_registro) {
        $this->id_registro = $id_registro;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setId_producto($id_producto) {
        $this->id_producto = $id_producto;
    }

    function setId_usuario_area($id_usuario_area) {
        $this->id_usuario_area = $id_usuario_area;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    function setSub_total($sub_total) {
        $this->sub_total = $sub_total;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
    
    function getAdicional() {
        return $this->adicional;
    }

    function setAdicional($adicional) {
        $this->adicional = $adicional;
    }
    
    function getId_area() {
        return $this->id_area;
    }

    function setId_area($id_area) {
        $this->id_area = $id_area;
    }    
        
    public function leerDatos($p_id_cliente) {
        try {
            $sql = "SELECT rab.id_registro,rab.adicional, rab.fecha, rab.id_producto, rab.id_usuario_area, rab.observaciones, rab.id_cliente, rab.sub_total, rab.estado, pab.nombre as nombre_producto, pab.numero_balanza as numero_producto, cab.nombre as nombre_cliente,aa.id_area_alquiler_balanza
                    FROM registro_alquiler_balanza rab 
                    INNER JOIN producto_alquiler_balanza pab ON ( rab.id_producto = pab.id_producto  )  
                    INNER JOIN cliente_alquiler_balanza cab ON ( rab.id_cliente = cab.id_cliente  )  
                    inner join area_alquiler_balanza aa on aa.id_area_alquiler_balanza = rab.id_area_alquiler_balanza
                    WHERE rab .id_registro = :p_id_area";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_area", $p_id_cliente);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar() {
        try {
            $sql = "select  ra.id_registro,
                            DATE_FORMAT(ra.fecha,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(ra.fecha,'%l:%i %p') as hora,
                            ra.id_producto,
                            pa.nombre as nombre_producto,
                             pa.numero_balanza as numero_producto,
                            ra.id_usuario_area,
                            CONCAT(c.nombres,' ',c.apellidos) as nombre_usuario,
                            ra.observaciones,
                            ra.id_cliente,
                            ca.nombre as nombre_cliente,
                            ra.sub_total,
                            ra.estado,
                            ra.adicional,
                            aa.nombre as nombre_area
                    from registro_alquiler_balanza ra inner join producto_alquiler_balanza pa on ra.id_producto = pa.id_producto
                    inner join cliente_alquiler_balanza ca on ca.id_cliente=ra.id_cliente
                    inner join usuario_area ua on ra.id_usuario_area=ua.id_usuario_area
                    inner join usuario u on u.id_usuario=ua.id_usuario
                    inner join colaborador c on c.dni=u.id_usuario
                    inner join area_alquiler_balanza aa on aa.id_area_alquiler_balanza = ra.id_area_alquiler_balanza
                    order by 1 desc;";
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

            $sql = "INSERT INTO registro_alquiler_balanza
                    ( id_producto, id_usuario_area, observaciones, id_cliente,id_area_alquiler_balanza) VALUES
                    (:p_id_producto, :p_id_usuario_area, :p_observaciones, :p_id_cliente,:p_id_area_alquiler_balanza );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_producto", $this->getId_producto());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->bindValue(":p_observaciones", $this->getObservaciones());
            $sentencia->bindValue(":p_id_cliente", $this->getId_cliente());
            $sentencia->bindValue(":p_id_area_alquiler_balanza", $this->getId_area());
            $sentencia->execute();

            $sql = "update producto_alquiler_balanza set estado = 'O' where id_producto=:p_id_producto";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_producto", $this->getId_producto());
            $sentencia->execute();

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function devolver() {
        $this->dblink->beginTransaction();

        try {
            $sql = "CALL f_registro_alquiler_balanza_devolver(:p_id_registro)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_registro", $this->getId_registro());
            $sentencia->execute();

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function mora_precio() {
        try {
            $sql = "select  ra.id_registro,
                            DATE_FORMAT(date(NOW()),'%d-%m-%Y') as fecha_hoy,
                            DATE_FORMAT(ra.fecha,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(ra.fecha,'%l:%i %p') as hora,
                            ra.id_producto,
                            pa.nombre as nombre_producto,
                            pa.numero_balanza as numero_producto,
                            ra.id_usuario_area,
                            CONCAT(c.nombres,' ',c.apellidos) as nombre_usuario,
                            ra.observaciones,
                            ra.id_cliente,
                            ca.nombre as nombre_cliente,
                            (case when TIMESTAMPDIFF(MINUTE,ra.fecha,CONCAT(date(CURRENT_TIMESTAMP()),' 12:00:00')) > 720 then (case when TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) > 0 then TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) else 1 end)*aa.precio_retraso+aa.precio_base else aa.precio_base end) as sub_total,
                            ra.estado,
                            aa.precio_base,
                            aa.precio_retraso,
                            aa.nombre as nombre_area,
                            ra.adicional,
                            (case when TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) > 0 then TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) else 1 end) as dias_mora,
                            (case when TIMESTAMPDIFF(MINUTE,ra.fecha,CONCAT(date(CURRENT_TIMESTAMP()),' 12:00:00')) > 720 then 1 else 0 end) as mora, 
                            (case when TIMESTAMPDIFF(MINUTE,ra.fecha,CONCAT(date(CURRENT_TIMESTAMP()),' 12:00:00')) > 720 then (case when TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) > 0 then TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) else 1 end)*aa.precio_retraso else aa.precio_base end) as precio
                    from registro_alquiler_balanza ra inner join producto_alquiler_balanza pa on ra.id_producto = pa.id_producto
                    inner join cliente_alquiler_balanza ca on ca.id_cliente=ra.id_cliente
                    inner join usuario_area ua on ra.id_usuario_area=ua.id_usuario_area
                    inner join usuario u on u.id_usuario=ua.id_usuario
                    inner join colaborador c on c.dni=u.id_usuario
                    inner join area_alquiler_balanza aa on aa.id_area_alquiler_balanza = ra.id_area_alquiler_balanza
                    where id_registro = :p_id_registro";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_registro", $this->getId_registro());
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function ticket() {
        try {
            $sql = "select  ra.id_registro,
                            concat(DATE_FORMAT(CURRENT_TIMESTAMP(),'%d-%m-%Y'),' ',DATE_FORMAT(CURRENT_TIMESTAMP(),'%l:%i %p')) as fecha_hoy,
                            DATE_FORMAT(ra.fecha,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(ra.fecha,'%l:%i %p') as hora,
                            ra.id_producto,
                            pa.nombre as nombre_producto,
                            pa.numero_balanza as numero_producto,
                            ra.id_usuario_area,
                            CONCAT(c.nombres,' ',c.apellidos) as nombre_usuario,
                            ra.observaciones,
                            ra.id_cliente,
                            ca.nombre as nombre_cliente,
                            ra.sub_total,
                            ra.estado,
                            aa.precio_base,
                            aa.precio_retraso,
                            aa.nombre as nombre_area,
                            ra.adicional,
                            (case when TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) > 0 then TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) else 1 end) as dias_mora,
                            (case when TIMESTAMPDIFF(MINUTE,ra.fecha,CONCAT(date(CURRENT_TIMESTAMP()),' 12:00:00')) > 720 then 1 else 0 end) as mora, 
                            (case when TIMESTAMPDIFF(MINUTE,ra.fecha,CONCAT(date(CURRENT_TIMESTAMP()),' 12:00:00')) > 720 then (case when TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) > 0 then TIMESTAMPDIFF(DAY,fecha, CURRENT_TIMESTAMP()) else 1 end)*aa.precio_retraso else aa.precio_base end) as precio
                    from registro_alquiler_balanza ra inner join producto_alquiler_balanza pa on ra.id_producto = pa.id_producto
                    inner join cliente_alquiler_balanza ca on ca.id_cliente=ra.id_cliente
                    inner join usuario_area ua on ra.id_usuario_area=ua.id_usuario_area
                    inner join usuario u on u.id_usuario=ua.id_usuario
                    inner join colaborador c on c.dni=u.id_usuario
                    inner join area_alquiler_balanza aa on aa.id_area_alquiler_balanza = ra.id_area_alquiler_balanza
                     where id_registro = :p_id_caja";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $this->getId_registro());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function editar() {
        $this->dblink->beginTransaction();
        try {
            $sql = "UPDATE registro_alquiler_balanza SET adicional=:p_adicional,observaciones=:p_observaciones,id_area_alquiler_balanza=:p_id_area_alquiler_balanza where id_registro=:p_id_area";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_adicional", $this->getAdicional());
            $sentencia->bindValue(":p_id_area", $this->getId_registro());
            $sentencia->bindValue(":p_observaciones", $this->getObservaciones());
            $sentencia->bindValue(":p_id_area_alquiler_balanza", $this->getId_area());
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception("No se ha configurado el correlativo para la tabla personal.");
        }
    }
    
    public function reporte() {
        try {
            $sql = "SELECT  rab.id_registro, 
                            DATE_FORMAT(rab.fecha,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(rab.fecha,'%l:%i %p') as hora,          
                            rab.id_producto, 
                            rab.observaciones, 
                            rab.id_cliente, 
                            rab.sub_total, 
                            rab.estado, 
                            rab.adicional, 
                            pab.nombre nombre_producto, 
                            pab.numero_balanza, 
                            cab.nombre as nombre_cliente,
                            aa.nombre as nombre_area
                    FROM registro_alquiler_balanza rab 
                            INNER JOIN producto_alquiler_balanza pab ON ( rab.id_producto = pab.id_producto  )  
                            INNER JOIN cliente_alquiler_balanza cab ON ( rab.id_cliente = cab.id_cliente  )  
                            inner join area_alquiler_balanza aa on aa.id_area_alquiler_balanza = rab.id_area_alquiler_balanza
                    WHERE rab.estado = 'D'and date(rab.fecha) = CURDATE()
                    ORDER BY 1 ASC";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
