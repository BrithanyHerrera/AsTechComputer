<?php
/* PANEL_INFO_MODEL.PHP */
/*
 * PÁGINA: Modelo del Panel de Información (Dashboard Model) - As Tech Computer
 * PROPÓSITO: Actuar como la capa de abstracción de datos (Model) para el panel de administración, gestionando la extracción de bitácoras de movimiento, información del empleado y catálogos de puestos.
 * FUNCIONALIDADES:
 * - Inyección segura de la conexión a la base de datos (MySQL).
 * - Consulta mediante sentencias preparadas para obtener la información del perfil del usuario (nombre, apellido, puesto).
 * - Extracción del catálogo de puestos para alimentar dinámicamente los selectores de los filtros de búsqueda.
 * - Construcción dinámica de cláusulas SQL (WHERE) para la aplicación de múltiples filtros simultáneos (nombre, puesto, rango de fechas).
 * - Extracción segura y paginada de los registros de la bitácora de movimientos empleando uniones (JOINs) entre tablas.
 * - Ejecución de conteo total de registros filtrados, indispensable para el cálculo matemático de la paginación en la Vista.
 */

/* ========================================================
   1. DEFINICIÓN DE LA CLASE Y CONSTRUCTOR
   ======================================================== */
/**
 * La clase DashboardModel centraliza todas las consultas a la base de 
 * datos requeridas por la pantalla principal del panel de control.
 * El sistema recibe la conexión activa mediante inyección de dependencias.
 */
class DashboardModel {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    /* ========================================================
       2. EXTRACCIÓN DE INFORMACIÓN DE PERFIL
       ======================================================== */
    /**
     * El sistema cruza la información del empleado con la tabla de puestos 
     * mediante un JOIN para obtener los datos precisos del usuario activo, 
     * utilizando una sentencia preparada por seguridad.
     */
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

    /* ========================================================
       3. EXTRACCIÓN DEL CATÁLOGO DE PUESTOS
       ======================================================== */
    /**
     * El sistema recupera una lista ordenada alfabéticamente de los puestos 
     * existentes en la empresa, para poblar el elemento <select> del filtro.
     */
    public function obtenerPuestos() {
        $resultado = $this->conexion->query("SELECT nombre_puesto FROM puestos ORDER BY nombre_puesto ASC");
        $puestos = [];
        while ($p = $resultado->fetch_assoc()) {
            $puestos[] = $p;
        }
        return $puestos;
    }

    /* ========================================================
       4. CONSTRUCCIÓN DINÁMICA DE FILTROS SQL (PRIVADO)
       ======================================================== */
    /**
     * El sistema evalúa el arreglo de filtros proporcionado y concatena 
     * de forma dinámica las cláusulas WHERE y los parámetros necesarios 
     * (tipos y valores) para preparar la consulta final a la bitácora.
     */
    private function construirFiltrosSQL($filtros) {
        $sql = "";
        $tipos = "";
        $valores = [];

        // Filtro por Nombre o Apellido (Búsqueda parcial mediante LIKE)
        if (!empty($filtros['nombre'])) {
            $sql .= " AND (e.nombre LIKE ? OR e.apellido LIKE ?)";
            $tipos .= "ss";
            $valores[] = "%" . $filtros['nombre'] . "%";
            $valores[] = "%" . $filtros['nombre'] . "%";
        }
        
        // Filtro estricto por Puesto
        if (!empty($filtros['puesto']) && $filtros['puesto'] !== 'todos') {
            $sql .= " AND p.nombre_puesto = ?";
            $tipos .= "s";
            $valores[] = $filtros['puesto'];
        }
        
        // Filtro de Rango de Fechas (Cota inferior)
        if (!empty($filtros['fecha_inicio'])) {
            $sql .= " AND DATE(b.fecha_hora) >= ?";
            $tipos .= "s";
            $valores[] = $filtros['fecha_inicio'];
        }
        
        // Filtro de Rango de Fechas (Cota superior)
        if (!empty($filtros['fecha_fin'])) {
            $sql .= " AND DATE(b.fecha_hora) <= ?";
            $tipos .= "s";
            $valores[] = $filtros['fecha_fin'];
        }

        return ['sql' => $sql, 'tipos' => $tipos, 'valores' => $valores];
    }

    /* ========================================================
       5. EXTRACCIÓN DE LA BITÁCORA (CON PAGINACIÓN Y FILTROS)
       ======================================================== */
    /**
     * El sistema une los registros de la bitácora con los empleados y sus 
     * puestos, inyecta dinámicamente las cláusulas de filtro y aplica los 
     * parámetros LIMIT y OFFSET para extraer solo los registros de la página actual.
     */
    public function obtenerConexiones($filtros = [], $limite = 50, $offset = 0) {
        $base_sql = "SELECT b.fecha_hora, b.accion, b.detalle, e.nombre, e.apellido, p.nombre_puesto 
                FROM bitacora_movimientos b 
                JOIN empleados e ON b.id_empleado = e.id_empleado 
                JOIN puestos p ON e.id_puesto = p.id_puesto 
                WHERE 1=1";

        $f = $this->construirFiltrosSQL($filtros);
        $sql = $base_sql . $f['sql'] . " ORDER BY b.fecha_hora DESC LIMIT ? OFFSET ?";
        
        // Se añaden dos enteros 'ii' a los tipos de variable para el LIMIT y el OFFSET
        $tipos = $f['tipos'] . "ii";
        $valores = $f['valores'];
        $valores[] = (int)$limite;
        $valores[] = (int)$offset;

        $stmt = $this->conexion->prepare($sql);
        
        if (!empty($tipos)) {
            // El operador splat (...) expande el arreglo de valores como argumentos individuales
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

    /* ========================================================
       6. CONTEO TOTAL DE REGISTROS (CÁLCULO DE PÁGINAS)
       ======================================================== */
    /**
     * El sistema efectúa un conteo bruto (COUNT) de los registros de la bitácora 
     * que coinciden con los filtros aplicados. Este dato es vital para que 
     * el controlador calcule el número máximo de páginas disponibles.
     */
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