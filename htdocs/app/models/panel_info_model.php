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

    // ==========================================
    // FUNCIÓN INTERNA PARA CONSTRUIR LOS FILTROS
    // ==========================================
    private function construirFiltrosSQL($filtros) {
        $sql = "";
        $tipos = "";
        $valores = [];

        // Filtro por Nombre o Apellido
        if (!empty($filtros['nombre'])) {
            $sql .= " AND (e.nombre LIKE ? OR e.apellido LIKE ?)";
            $tipos .= "ss";
            $valores[] = "%" . $filtros['nombre'] . "%";
            $valores[] = "%" . $filtros['nombre'] . "%";
        }
        
        // Filtro por Puesto
        if (!empty($filtros['puesto']) && $filtros['puesto'] !== 'todos') {
            $sql .= " AND p.nombre_puesto = ?";
            $tipos .= "s";
            $valores[] = $filtros['puesto'];
        }
        
        // Filtro de Rango de Fechas (Desde)
        if (!empty($filtros['fecha_inicio'])) {
            $sql .= " AND DATE(b.fecha_hora) >= ?";
            $tipos .= "s";
            $valores[] = $filtros['fecha_inicio'];
        }
        
        // Filtro de Rango de Fechas (Hasta)
        if (!empty($filtros['fecha_fin'])) {
            $sql .= " AND DATE(b.fecha_hora) <= ?";
            $tipos .= "s";
            $valores[] = $filtros['fecha_fin'];
        }

        return ['sql' => $sql, 'tipos' => $tipos, 'valores' => $valores];
    }

    // ==========================================
    // OBTENER LOS REGISTROS CON LÍMITE (PAGINACIÓN)
    // ==========================================
    public function obtenerConexiones($filtros = [], $limite = 50, $offset = 0) {
        $base_sql = "SELECT b.fecha_hora, b.accion, b.detalle, e.nombre, e.apellido, p.nombre_puesto 
                FROM bitacora_movimientos b 
                JOIN empleados e ON b.id_empleado = e.id_empleado 
                JOIN puestos p ON e.id_puesto = p.id_puesto 
                WHERE 1=1";

        // Traemos los filtros dinámicos
        $f = $this->construirFiltrosSQL($filtros);
        $sql = $base_sql . $f['sql'] . " ORDER BY b.fecha_hora DESC LIMIT ? OFFSET ?";
        
        // Agregamos los parámetros para LIMIT y OFFSET ("ii" significa dos enteros)
        $tipos = $f['tipos'] . "ii";
        $valores = $f['valores'];
        $valores[] = (int)$limite;
        $valores[] = (int)$offset;

        $stmt = $this->conexion->prepare($sql);
        
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

    // ==========================================
    // CONTAR EL TOTAL DE REGISTROS (PARA SABER CUÁNTAS PÁGINAS SON)
    // ==========================================
    public function contarConexiones($filtros = []) {
        $base_sql = "SELECT COUNT(*) as total 
                FROM bitacora_movimientos b 
                JOIN empleados e ON b.id_empleado = e.id_empleado 
                JOIN puestos p ON e.id_puesto = p.id_puesto 
                WHERE 1=1";

        $f = $this->construirFiltrosSQL($filtros);
        $sql = $base_sql . $f['sql'];

        $stmt = $this->conexion->prepare($sql);
        
        if (!empty($f['tipos'])) {
            $stmt->bind_param($f['tipos'], ...$f['valores']);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        return $resultado['total'];
    }
}
?>