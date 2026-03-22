<?php
// ========================================================
// MODELO: registros_model.php
// UBICACIÓN: app/models/registros_model.php
// ========================================================

class RegistrosModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerRegistros() {
        // Unimos las tablas ordenes_ingreso, equipos, clientes, marcas y tipos
        $sql = "SELECT 
                    o.folio, 
                    o.id_gabinete, 
                    c.nombre, 
                    c.apellido, 
                    c.telefono AS whatsapp, 
                    e.modelo, 
                    m.marca, 
                    t.tipo, 
                    e.numero_serie, 
                    DATE(o.fecha_ingreso) AS fecha_ingreso, 
                    TIME(o.fecha_ingreso) AS hora_ingreso, 
                    o.descripcion_problema, 
                    o.condicion_fisica, 
                    o.accesorios_entregados, 
                    o.observaciones_recepcion, 
                    o.estado
                FROM ordenes_ingreso o
                INNER JOIN equipos e ON o.id_equipo = e.id_equipo
                INNER JOIN clientes c ON e.id_cliente = c.id_cliente
                INNER JOIN marcas m ON e.id_marca = m.id_marca
                INNER JOIN tipos_equipo t ON e.id_tipo_equipo = t.id_tipo_equipo
                ORDER BY o.fecha_ingreso DESC";

        $resultado = $this->conexion->query($sql);
        
        $registros = [];
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $registros[] = $row;
            }
        }
        
        return $registros;
    }
}
?>