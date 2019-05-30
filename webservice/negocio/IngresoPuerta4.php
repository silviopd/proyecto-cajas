<?php

require_once '../datos/Conexion.clase.php';

class IngresoPuerta4 extends Conexion {

    private $dni, $estado, $id_usuario_area, $sub_total, $fecha_hora_salida;

    function getDni() {
        return $this->dni;
    }

    function getEstado() {
        return $this->estado;
    }

    function getId_usuario_area() {
        return $this->id_usuario_area;
    }

    function getSub_total() {
        return $this->sub_total;
    }

    function getFecha_hora_salida() {
        return $this->fecha_hora_salida;
    }

    function setDni($dni) {
        $this->dni = str_pad($dni, 8, '0', STR_PAD_LEFT);
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setId_usuario_area($id_usuario_area) {
        $this->id_usuario_area = $id_usuario_area;
    }

    function setSub_total($sub_total) {
        $this->sub_total = $sub_total;
    }

    function setFecha_hora_salida($fecha_hora_salida) {
        $this->fecha_hora_salida = $fecha_hora_salida;
    }

    public function tipoPersonal($dni) {
        try {
            $sql = "select id_tipo_personal from personal where dni = :p_dni";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_dni", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function datosPersonal($dni) {
        try {
            $sql = "SELECT id_tipo_personal FROM personal where dni = :p_id_caja";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            $id_tipo_personal = $resultado["id_tipo_personal"];

            if ($id_tipo_personal == 7) {
                $sql = "select pe.*,tp.precio,tp.nombre as nombre_tipo_personal,DATE_FORMAT(gu.fecha_pagada,'%d-%m-%Y') as fecha_pagada,(SELECT DATEDIFF(CURDATE(),gu.fecha_pagada)) as dias_pagar,pe.nro_carretilla,(DATE_FORMAT(CURDATE(),'%d-%m-%Y')) as fecha_hoy
                        from personal pe inner join tipo_personal tp on pe.id_tipo_personal=tp.id_tipo_personal
                                	 inner join guardiania gu on gu.dni = pe.dni
                        where pe.dni = :p_id_caja order by id_guardiania desc limit 1";
            } else {
                $sql = "select pe.*,tp.precio,tp.nombre as nombre_tipo_personal,(DATE_FORMAT(CURDATE(),'%d-%m-%Y')) as fecha_hoy
                        from personal pe inner join tipo_personal tp on pe.id_tipo_personal=tp.id_tipo_personal
                        where pe.dni = :p_id_caja";
            }

            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function idRegistroPersonal($dni) {
        try {
            $sql = "SELECT id_ingreso FROM ingreso where dni = :p_id_caja order by 1 desc limit 1 ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function agregarOtros() {
        $this->dblink->beginTransaction();

        try {
            $sql = "select tp.precio from tipo_personal tp inner join personal pe on tp.id_tipo_personal=pe.id_tipo_personal where pe.dni like :p_id_caja;";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $this->getDni());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            $precio = $resultado["precio"];


            $sql = "INSERT INTO `ingreso`
                    (`dni`,
                    `id_usuario_area`,
                    `sub_total`)
                    VALUES (
                    :p_dni,
                    :p_id_usuario_area,
                    :p_sub_total
                     );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_dni", $this->getDni());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->bindValue(":p_sub_total", $precio);
            $sentencia->execute();

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function agregarCarretillero() {
        $this->dblink->beginTransaction();

        try {
            $sql = "select tp.precio from tipo_personal tp inner join personal pe on tp.id_tipo_personal=pe.id_tipo_personal where pe.dni like :p_id_caja;";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $this->getDni());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            $precio = $resultado["precio"];

            $sql = "select (SELECT DATEDIFF(CURDATE(),fecha_pagada)) as dias_a_pagar from guardiania where dni like :p_dni order by id_guardiania desc limit 1;";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_dni", $this->getDni());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            $dias_a_pagar = $resultado["dias_a_pagar"];

            if ($dias_a_pagar > 0) {
                $sql = "INSERT INTO `guardiania`(`dni`) VALUES (:p_dni);";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindValue(":p_dni", $this->getDni());
                $sentencia->execute();
            }

            $sql = "INSERT INTO `ingreso`
                    (`dni`,
                    `id_usuario_area`,
                    `sub_total`)
                    VALUES (
                    :p_dni,
                    :p_id_usuario_area,
                    :p_sub_total
                     );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_dni", $this->getDni());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->bindValue(":p_sub_total", $precio + ($dias_a_pagar * 2));
            $sentencia->execute();

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }
    
    public function reporte() {
        try {
            $sql = "SELECT  tp.nombre,
                            tp.precio, 
                            count(p.id_tipo_personal) as cantidad,			
                            sum(i.sub_total) as sub_total
                    FROM ingreso i 
                            INNER JOIN personal p ON ( i.dni = p.dni  )  	
                                    INNER JOIN tipo_personal tp ON ( p.id_tipo_personal = tp.id_tipo_personal  ) 
                    WHERE date(i.fecha_hora_ingreso) = CURDATE()
                            GROUP BY p.id_tipo_personal";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
