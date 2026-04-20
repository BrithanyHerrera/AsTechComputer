<?php
class RegistrosModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerRegistros() {
        // AGREGADO: c.id_cliente
        $sql = "SELECT 
                    o.folio, o.id_gabinete, c.id_cliente, c.nombre, c.apellido, c.telefono AS whatsapp, 
                    e.modelo, m.marca, t.tipo, e.numero_serie, DATE(o.fecha_ingreso) AS fecha_ingreso, 
                    TIME(o.fecha_ingreso) AS hora_ingreso, o.descripcion_problema, o.condicion_fisica, 
                    o.accesorios_entregados, o.observaciones_recepcion, o.estado
                FROM ordenes_ingreso o
                INNER JOIN equipos e ON o.id_equipo = e.id_equipo
                INNER JOIN clientes c ON e.id_cliente = c.id_cliente
                INNER JOIN marcas m ON e.id_marca = m.id_marca
                INNER JOIN tipos_equipo t ON e.id_tipo_equipo = t.id_tipo_equipo
                ORDER BY o.fecha_ingreso DESC";

        $resultado = $this->conexion->query($sql);
        $registros = [];
        if ($resultado) { while ($row = $resultado->fetch_assoc()) { $registros[] = $row; } }
        return $registros;
    }

    public function entregarEquipo($folio, $id_gabinete) {
        $this->conexion->begin_transaction();
        try {
            $stmt1 = $this->conexion->prepare("UPDATE ordenes_ingreso SET estado = 'entregado', fecha_entrega = NOW() WHERE folio = ?");
            $stmt1->bind_param("s", $folio);
            $stmt1->execute();
            
            $stmt2 = $this->conexion->prepare("UPDATE gabinetes SET estado = 'disponible' WHERE id_gabinete = ?");
            $stmt2->bind_param("s", $id_gabinete);
            $stmt2->execute();
            
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            $this->conexion->rollback();
            return false;
        }
    }

    // AGREGADO: Recibe los datos del cliente y actualiza 2 tablas a la vez
    public function actualizarRegistro($folio, $estado, $condicion, $accesorios, $observaciones, $id_cliente, $nombre, $apellido, $telefono) {
        $this->conexion->begin_transaction();
        try {
            // 1. Actualizar Orden
            $sql1 = "UPDATE ordenes_ingreso SET estado=?, condicion_fisica=?, accesorios_entregados=?, observaciones_recepcion=? WHERE folio=?";
            $stmt1 = $this->conexion->prepare($sql1);
            $stmt1->bind_param("sssss", $estado, $condicion, $accesorios, $observaciones, $folio);
            $stmt1->execute();

            // 2. Actualizar Cliente
            $sql2 = "UPDATE clientes SET nombre=?, apellido=?, telefono=? WHERE id_cliente=?";
            $stmt2 = $this->conexion->prepare($sql2);
            $stmt2->bind_param("sssi", $nombre, $apellido, $telefono, $id_cliente);
            $stmt2->execute();

            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            $this->conexion->rollback();
            return false;
        }
    }
}
?>