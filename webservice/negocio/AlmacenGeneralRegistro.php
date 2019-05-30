<?php

require_once '../datos/Conexion.clase.php';

class AlmacenGeneralRegistro extends Conexion {

    private $id_registro, $fecha, $operacion, $contacto, $id_producto, $id_usuario_area, $cantidad, $stock_anterior, $stock_actual, $observaciones, $id_cliente, $id_area, $stock;
    private $detalleVenta;


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

    function getCantidad() {
        return $this->cantidad;
    }

    function getStock_anterior() {
        return $this->stock_anterior;
    }

    function getStock_actual() {
        return $this->stock_actual;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getId_cliente() {
        return $this->id_cliente;
    }

    function getId_area() {
        return $this->id_area;
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

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setStock_anterior($stock_anterior) {
        $this->stock_anterior = $stock_anterior;
    }

    function setStock_actual($stock_actual) {
        $this->stock_actual = $stock_actual;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    function setId_area($id_area) {
        $this->id_area = $id_area;
    }

    function getStock() {
        return $this->stock;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }
    public function getDetalleVenta()
    {
        return $this->detalleVenta;
    }

    public function setDetalleVenta($detalleVenta)
    {
        $this->detalleVenta = $detalleVenta;

        return $this;
    }
    public function listar() {
        try {
            $sql = "select
			  ra.id_registro,
				DATE_FORMAT(ra.fecha,'%d-%m-%Y') as fecha,
                    DATE_FORMAT(ra.fecha,'%l:%i %p') as hora,
			  ra.operacion,
			  ra.contacto,
			  ra.id_producto,
			  pa.nombre as nombre_producto,
			  ra.id_usuario_area,
			  CONCAT(c.nombres,' ',c.apellidos) as nombre_usuario,
			  ra.cantidad,
			  ra.stock_anterior,
			  ra.stock_actual,
			  ra.observaciones,
			  ra.id_area,
			  aa.nombre as nombre_area
                    from registro_almacen_general ra
                    inner join producto_almacen_general pa on ra.id_producto=pa.id_producto
                    inner join area aa on aa.id_area=ra.id_area
                    inner join usuario_area ua on ra.id_usuario_area=ua.id_usuario_area
                    inner join usuario u on u.id_usuario=ua.id_usuario
                    inner join colaborador c on c.dni=u.id_usuario";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function buscarStock() {
        try {

            $sql = "select stock from producto_almacen_general where id_producto = :p_id_caja";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindValue(":p_id_caja", $this->getId_producto());
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }

    public function agregar() {
        $this->dblink->beginTransaction();

        try {
            $sql = "SELECT stock FROM producto_almacen_general where id_producto = :p_id_caja";
            $sentencia2 = $this->dblink->prepare($sql);
            $sentencia2->bindValue(":p_id_caja", $this->getId_producto());
            $sentencia2->execute();
            $resultado = $sentencia2->fetch(PDO::FETCH_ASSOC);
            $stock_anterior = $resultado["stock"];

            $this->setStock($stock_anterior);


            $sql = "INSERT INTO registro_almacen_general
                    (
                    operacion,
                    contacto,
                    id_usuario_area,
                    cantidad,              
                    observaciones,
                    id_area)
                    VALUES
                    ( :p_operacion,
                    :p_contacto,
                    :p_id_producto,
                    :p_id_usuario_area,
                    :p_cantidad,                 
                    :p_observaciones,
                    :p_id_area
                    );
                    ";
            $sentencia = $this->dblink->prepare($sql);

            $sentencia->bindValue(":p_operacion", $this->getOperacion());
            $sentencia->bindValue(":p_contacto", $this->getContacto());
            $sentencia->bindValue(":p_id_producto", $this->getId_producto());
            $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
            $sentencia->bindValue(":p_cantidad", $this->getCantidad());
            $sentencia->bindValue(":p_observaciones", $this->getObservaciones());

            if (strcmp($this->getOperacion(), 'I') === 0) {
                $sentencia->bindValue(":p_stock_actual", $this->getStock() + $this->getCantidad());
            } else if (strcmp($this->getOperacion(), 'S') === 0) {
                $sentencia->bindValue(":p_stock_actual", $this->getStock() - $this->getCantidad());
            }

            $sentencia->bindValue(":p_observaciones", $this->getObservaciones());
            $sentencia->bindValue(":p_id_area", $this->getId_area());
            $sentencia->execute();

            if (strcmp($this->getOperacion(), 'I') === 0) {
                $sql = "UPDATE producto_almacen_general SET stock = stock+:p_cantidad where id_producto = :p_id_caja;";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindValue(":p_cantidad", $this->getCantidad());
                $sentencia->bindValue(":p_id_caja", $this->getId_producto());
                $sentencia->execute();
            } else if (strcmp($this->getOperacion(), 'S') === 0) {
                $sql = "UPDATE producto_almacen_general SET stock = stock-:p_cantidad where id_producto = :p_id_caja;";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindValue(":p_cantidad", $this->getCantidad());
                $sentencia->bindValue(":p_id_caja", $this->getId_producto());
                $sentencia->execute();
            } else {
                $this->dblink->rollBack(); //Extornar toda la transacción
                throw $exc;
            }

            $this->dblink->commit();

            return true; //significa que todo se ha ejecutado correctamente
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function reporteRegistro() {
        try {
            $sql = "SELECT  rag.id_registro, 
                            DATE_FORMAT(rag.fecha,'%d-%m-%Y') as fecha,
                            DATE_FORMAT(rag.fecha,'%l:%i %p') as hora,
                            case when rag.operacion = 'I' then 'INGRESO' else 'SALIDA' end as operacion, 
                            rag.contacto, 
                            rag.id_usuario_area, 
                            rag.observaciones, 
                            rag.id_area, 
                            concat(c.nombres,' ',c.apellidos) as nombre_usuario, 
                            a.nombre as nombre_area, 
                            drag.id_registro_almacen_general, 
                            drag.id_producto, 
                            drag.cantidad, 
                            pag.nombre as nombre_producto, 
                            pag.unidad_medida
                    FROM registro_almacen_general rag 
                            INNER JOIN usuario_area ua ON ( rag.id_usuario_area = ua.id_usuario_area  )  
                                    INNER JOIN usuario u ON ( ua.id_usuario = u.id_usuario  )  
                                            INNER JOIN colaborador c ON ( u.id_usuario = c.dni  )  
                            INNER JOIN area a ON ( rag.id_area = a.id_area  )  
                            INNER JOIN detalle_registro_almacen_general drag ON ( rag.id_registro = drag.id_registro  )  
                                    INNER JOIN producto_almacen_general pag ON ( drag.id_producto = pag.id_producto  )
                    WHERE rag.id_registro = (select count(*) from registro_almacen_general)";
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
            $sql = "select
			  ra.id_registro,
				DATE_FORMAT(ra.fecha,'%d-%m-%Y') as fecha,
                    DATE_FORMAT(ra.fecha,'%l:%i %p') as hora,
			  ra.operacion,
			  ra.contacto,
			  ra.id_producto,
			  pa.nombre as nombre_producto,
			  ra.id_usuario_area,
			  CONCAT(c.nombres,' ',c.apellidos) as nombre_usuario,
			  ra.cantidad,
			  ra.stock_anterior,
			  ra.stock_actual,
			  ra.observaciones,
			  ra.id_area,
			  aa.nombre as nombre_area
                    from registro_almacen_general ra
                    inner join producto_almacen_general pa on ra.id_producto=pa.id_producto
                    inner join area aa on aa.id_area=ra.id_area
                    inner join usuario_area ua on ra.id_usuario_area=ua.id_usuario_area
                    inner join usuario u on u.id_usuario=ua.id_usuario
                    inner join colaborador c on c.dni=u.id_usuario
                     WHERE date(ra.fecha) >= :p_fecha_inicio and date(ra.fecha) <= :p_fecha_final
                     ORDER BY 1 desc;";
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



    /* LA QUE SI FUNCIONA :V */ 



    public function agregar2() {
        $this->dblink->beginTransaction();
        try {
            $sql = "select count(*)+1 as nc from registro_almacen_general";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            $nuevoNumeroVenta = $resultado["nc"];
            $this->setId_registro($nuevoNumeroVenta);
            

                $sql = "INSERT INTO registro_almacen_general
                                ( id_registro,operacion, contacto, id_usuario_area,
                                  observaciones, id_area)
                                 
                    VALUES
                    ( :p_id_registro,
                        :p_operacion,
                    :p_contacto,
                    :p_id_usuario_area,               
                    :p_observaciones,
                    :p_id_area
                    );";

                $sentencia = $this->dblink->prepare($sql);

                $sentencia->bindValue(":p_id_registro", $this->getId_registro());
                $sentencia->bindValue(":p_operacion", $this->getOperacion());
                $sentencia->bindValue(":p_contacto", $this->getContacto());
                $sentencia->bindValue(":p_id_usuario_area", $this->getId_usuario_area());
                $sentencia->bindValue(":p_observaciones", $this->getObservaciones());
                $sentencia->bindValue(":p_id_area", $this->getId_area());

                $sentencia->execute();

                /* INSERTAR EN LA TABLA VENTA_DETALLE */
                $detalleVentaArray = json_decode($this->getDetalleVenta()); //Convertir de formato JSON a formato array


                $item = 0;

                foreach ($detalleVentaArray as $key => $value) { //permite recorrer el array
                    $sql = "select stock,nombre from producto_almacen_general where id_producto=:p_codigo_articulo;";
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindValue(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->execute();
                    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                    /*
                    if ($resultado["stock"] < $value->cantidad) {
                        throw new Exception("No hay stock suficiente" . " \n" . " Articulo: " . $value->codigoArticulo . " - " . $resultado["nombre"] . "\n" . " stock actual: " . $resultado["stock"] . "\n" . "cantidad de venta: " . $value->cantidad);
                    }
                     */

                    $sql = "INSERT INTO detalle_registro_almacen_general
                    ( id_registro, id_registro_almacen_general, id_producto, cantidad) values
                      (:p_numero_venta,:p_item,:p_codigo_articulo,:p_cantidad);";


                    //Preparar la sentencia
                    $sentencia = $this->dblink->prepare($sql);

                    $item++;

                    //Asignar un valor a cada parametro
                    $sentencia->bindValue(":p_numero_venta", $this->getId_registro());
                    $sentencia->bindValue(":p_item", $item);
                    $sentencia->bindValue(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->bindValue(":p_cantidad", $value->cantidad);


                    //Ejecutar la sentencia preparada
                    $sentencia->execute();
                    if (strcmp($this->getOperacion(), 'S') === 0) {
                        $sql = "update producto_almacen_general set stock = stock-:p_cantidad where id_producto = :p_codigo_articulo";
                        $sentencia = $this->dblink->prepare($sql);
                        $sentencia->bindValue(":p_cantidad", $value->cantidad);
                        $sentencia->bindValue(":p_codigo_articulo", $value->codigoArticulo);
                        $sentencia->execute();
                    }else{
                        $sql = "update producto_almacen_general set stock = stock+:p_cantidad where id_producto = :p_codigo_articulo";
                        $sentencia = $this->dblink->prepare($sql);
                        $sentencia->bindValue(":p_cantidad", $value->cantidad);
                        $sentencia->bindValue(":p_codigo_articulo", $value->codigoArticulo);
                        $sentencia->execute();
                    }

                    
                }
                /* INSERTAR EN LA TABLA VENTA_DETALLE */


                //Terminar la transacción
                $this->dblink->commit();


                return true;
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        return false;
    }
}
