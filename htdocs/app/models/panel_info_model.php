<?php
class DashboardModel {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    public function obtenerInfoUsuario($id_empleado) {
        $sql = "SELECT e.nombre, e.apellido, p.nombre_puesto, p.id_puesto 
                FROM empleados e 
                JOIN puestos p ON e.id_puesto = p.id_puesto 
                WHERE e.id_empleado = ?";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_empleado);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        return $resultado;
    }

    // NUEVO: Ahora recibe un arreglo con los filtros
    public function obtenerConexiones($filtros = []) {
        $sql = "SELECT b.fecha_hora, b.accion, b.detalle, e.nombre, e.apellido, p.nombre_puesto 
                FROM bitacora_movimientos b 
                JOIN empleados e ON b.id_empleado = e.id_empleado 
                JOIN puestos p ON e.id_puesto = p.id_puesto 
                WHERE 1=1"; // 1=1 es un truco para concatenar los AND fácilmente

        $tipos = "";
        $valores = [];

        // Filtro por Nombre o Apellido
        if (!empty($filtros['nombre'])) {
            $sql .= " AND (e.nombre LIKE ? OR e.apellido LIKE ?)";
            $tipos .= "ss";
            $valores[] = "%" . $filtros['nombre'] . "%";
            $valores[] = "%" . $filtros['nombre'] . "%";
        }

        // Filtro por Puesto (Exacto)
        if (!empty($filtros['puesto']) && $filtros['puesto'] !== 'todos') {
            $sql .= " AND p.nombre_puesto = ?";
            $tipos .= "s";
            $valores[] = $filtros['puesto'];
        }

        // Filtro por Fecha (Día exacto)
        if (!empty($filtros['fecha'])) {
            $sql .= " AND DATE(b.fecha_hora) = ?";
            $tipos .= "s";
            $valores[] = $filtros['fecha'];
        }

        $sql .= " ORDER BY b.fecha_hora DESC LIMIT 500"; 
        
        $stmt = $this->conexion->prepare($sql);
        
        // Si hay filtros, vinculamos los parámetros de forma segura
        if (!empty($tipos)) {
            $stmt->bind_param($tipos, ...$valores);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $conexiones = [];
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $conexiones[] = $fila;
            }
        }
        $stmt->close();
        return $conexiones;
    }
}
?>