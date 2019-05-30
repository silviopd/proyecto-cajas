<?php

require_once '../datos/Conexion.clase.php';

class SalidaPuerta4 extends Conexion {

    private $nro_placa, $id_salida, $fecha, $cantidad, $estado, $id_tipo_carga, $id_tipo_categoria, $id_usuario_area;

    function getNro_placa() {
        return $this->nro_placa;
    }

    function getId_salida() {
        return $this->id_salida;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getEstado() {
        return $this->estado;
    }

    function getId_tipo_carga() {
        return $this->id_tipo_carga;
    }

    function getId_tipo_categoria() {
        return $this->id_tipo_categoria;
    }

    function getId_usuario_area() {
        return $this->id_usuario_area;
    }

    function setNro_placa($nro_placa) {
        $this->nro_placa = $nro_placa;
    }

    function setId_salida($id_salida) {
        $this->id_salida = $id_salida;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setId_tipo_carga($id_tipo_carga) {
        $this->id_tipo_carga = $id_tipo_carga;
    }

    function setId_tipo_categoria($id_tipo_categoria) {
        $this->id_tipo_categoria = $id_tipo_categoria;
    }

    function setId_usuario_area($id_usuario_area) {
        $this->id_usuario_area = $id_usuario_area;
    }

    public function agregar() {
        $this->dblink->beginTransaction();

        try {

            $sql = "CALL f_salida_agregar_registro(:p_nro_placa,:p_estado,:p_id_tipo_carga,:p_cantidad,:p_id_tipo_categoria,:p_id_usuario_area)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nro_placa", $this->getNro_placa());
            $sentencia->bindValue(":p_estado", $this->getEstado());
            $sentencia->bindValue(":p_id_tipo_carga", $this->getId_tipo_carga());
            $sentencia->bindValue(":p_cantidad", $this->getCantidad());
            $sentencia->bindValue(":p_id_tipo_categoria", $this->getId_tipo_categoria());
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
    
    public function agregar_pagar() {
        $this->dblink->beginTransaction();

        try {

            $sql = "CALL f_salida_agregar_registro_pagar(:p_nro_placa,:p_id_salida,:p_id_tipo_carga)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nro_placa", $this->getNro_placa());
            $sentencia->bindValue(":p_id_salida", $this->getId_salida());
            $sentencia->bindValue(":p_id_tipo_carga", $this->getId_tipo_carga());
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
            $sql = "select  sa.nro_placa,
                            sa.id_salida,
                            DATE_FORMAT(sa.fecha,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(sa.fecha,'%l:%i %p') as hora,
                            sa.cantidad,
                            sa.estado,
                            sa.id_tipo_carga,
                            tc.nombre as nombre_carga,
                            tc.precio as precio_carga,
                            sa.id_tipo_categoria,
                            ta.nombre as nombre_categoria,
                            ta.precio as precio_categoria,
                            sa.id_usuario_area,
                            CONCAT(c.nombres,' ',c.apellidos) as nombre_usuario,
                            sa.sub_total
                    from salida sa inner join tipo_categoria tc on tc.id_tipo_categoria=sa.id_tipo_categoria
                    inner join tipo_carga ta on ta.id_tipo_carga=sa.id_tipo_carga
                    inner join usuario_area ua on sa.id_usuario_area=ua.id_usuario_area
                    inner join usuario u on u.id_usuario=ua.id_usuario
                    inner join colaborador c on c.dni=u.id_usuario
                    order by nro_placa,id_salida;";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function leerDatos($p_nro_placa, $p_id_salida) {
        try {
            $sql = "select *,CONCAT(
            TIMESTAMPDIFF(day,fecha,CURRENT_TIMESTAMP()) , ' days ',
            MOD( TIMESTAMPDIFF(hour,fecha,CURRENT_TIMESTAMP()), 24), ' hours ',
            MOD( TIMESTAMPDIFF(minute,fecha,CURRENT_TIMESTAMP()), 60), ' minutes ') as tiempo 
            from salida where nro_placa = :p_nro_placa and id_salida=:p_id_salida";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nro_placa", $p_nro_placa);
            $sentencia->bindValue(":p_id_salida", $p_id_salida);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function ticket() {
        try {
            $sql = "select  sa.nro_placa,
                            sa.id_salida,
                            DATE_FORMAT(sa.fecha,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(sa.fecha,'%l:%i %p') as hora,                            
                            concat(DATE_FORMAT(CURRENT_TIMESTAMP(),'%d-%m-%Y'),' ',DATE_FORMAT(CURRENT_TIMESTAMP(),'%l:%i %p')) as fecha_hoy,
                            sa.cantidad,
                            sa.estado,
                            sa.id_tipo_carga,
                            tc.nombre as nombre_carga,
                            tc.precio as precio_carga,
                            sa.id_tipo_categoria,
                            ta.nombre as nombre_categoria,
                            ta.precio as precio_categoria,
                            sa.id_usuario_area,
                            CONCAT(c.nombres,' ',c.apellidos) as nombre_usuario,
                            sa.sub_total
                    from salida sa inner join tipo_categoria tc on tc.id_tipo_categoria=sa.id_tipo_categoria
                    inner join tipo_carga ta on ta.id_tipo_carga=sa.id_tipo_carga
                    inner join usuario_area ua on sa.id_usuario_area=ua.id_usuario_area
                    inner join usuario u on u.id_usuario=ua.id_usuario
                    inner join colaborador c on c.dni=u.id_usuario
                    where sa.nro_placa = :p_nro_placa
                    order by nro_placa,id_salida desc
                    limit 1;";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_nro_placa", $this->getNro_placa());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function reporte() {
        try {
            $sql = "SELECT  s.id_tipo_carga, tc.nombre as nombre_carga, tc.precio as precio_carga,count(s.id_tipo_carga) as cantidad_carga,
                            s.id_tipo_categoria, tc1.nombre as nombre_categoria, tc1.precio as precio_categoria,count(s.id_tipo_categoria) as cantidad_categoria,
                            s.cantidad,  sum(s.sub_total) as sub_total
                    FROM salida s 
                            INNER JOIN tipo_carga tc ON ( s.id_tipo_carga = tc.id_tipo_carga  )  
                            INNER JOIN tipo_categoria tc1 ON ( s.id_tipo_categoria = tc1.id_tipo_categoria  )  
                      WHERE date(s.fecha) = CURDATE() 
                            GROUP BY s.cantidad, s.id_tipo_carga, s.id_tipo_categoria, s.sub_total, tc.nombre, tc.precio, tc1.nombre, tc1.precio";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
