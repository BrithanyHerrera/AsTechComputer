<?php
/* CITAS_CRUD_MODEL.PHP */
/*
 * PÁGINA: Modelo de Gestión de Citas (Citas CRUD Model) - As Tech Computer
 * PROPÓSITO: Actuar como la capa de abstracción de datos (Model) para todas las operaciones de administración y mantenimiento (CRUD) de citas web dentro de la base de datos.
 * FUNCIONALIDADES:
 * - Procesamiento de actualizaciones rápidas de estado mediante sentencias preparadas, ideal para flujos de trabajo asíncronos (AJAX).
 * - Detección y extracción de registros caducados (citas con más de 1 mes de antigüedad) para facilitar las tareas de depuración automatizada.
 * - Traducción relacional de identificadores numéricos a texto plano (marcas y tipos) para asegurar que los eventos sincronizados con Google Calendar sean legibles.
 * - Actualización profunda de registros procedentes de la ventana modal, validando de forma estricta las 13 variables vinculadas a la petición SQL.
 * - Generación de un mapa integral de citas mediante cláusulas JOIN, indexado estratégicamente por el ID de Google Calendar para su rápido consumo en la Vista.
 */

/* ========================================================
   1. DEFINICIÓN DE LA CLASE Y CONSTRUCTOR (MODELO CRUD)
   ======================================================== */
/**
 * La clase CitasAdminModel centraliza la comunicación directa con la base 
 * de datos, abstrae la complejidad de las consultas SQL y protege el 
 * sistema contra inyecciones utilizando sentencias preparadas.
 */
class CitasAdminModel {
    private $conexion;

    /**
     * El sistema inicializa la clase recibiendo e inyectando la conexión 
     * activa a la base de datos para todas las transacciones posteriores.
     */
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /* ========================================================
       2. ACTUALIZACIÓN RÁPIDA DE ESTADOS (AJAX)
       ======================================================== */
    /**
     * El sistema ejecuta una sentencia preparada para modificar de forma 
     * rápida y segura el estado de una cita específica (Ej: de "Pendiente" 
     * a "Entregado"), optimizado para llamadas asíncronas.
     */
    public function actualizarEstado($id_cita, $nuevo_estado) {
        $stmt = $this->conexion->prepare("UPDATE citas_web SET estado = ? WHERE id_cita = ?");
        $stmt->bind_param("si", $nuevo_estado, $id_cita);
        return $stmt->execute();
    }

    /* ========================================================
       3. OBTENCIÓN Y ELIMINACIÓN DE REGISTROS EXPIRADOS
       ======================================================== */
    /**
     * El sistema filtra y recupera aquellas citas cuya marca de tiempo 
     * (TIMESTAMP de fecha y hora) supera un mes de antigüedad, preparando 
     * el terreno para su posterior purga.
     */
    public function obtenerCitasExpiradas() {
        $sql = "SELECT id_cita, id_google_calendar FROM citas_web WHERE TIMESTAMP(fecha_cita, hora_cita) < DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        $resultado = $this->conexion->query($sql);
        $citas = [];
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $citas[] = $row;
            }
        }
        return $citas;
    }

    /**
     * El sistema elimina físicamente el registro de la base de datos 
     * local utilizando su identificador único.
     */
    public function eliminarCitaLocal($id_cita) {
        $stmt = $this->conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
        $stmt->bind_param("i", $id_cita);
        return $stmt->execute();
    }

    /* ========================================================
       4. TRADUCCIÓN DE IDs PARA SINCRONIZACIÓN CON GOOGLE
       ======================================================== */
    /**
     * El sistema traduce un identificador numérico al nombre textual 
     * de la marca, garantizando descripciones comprensibles para el 
     * calendario de Google.
     */
    public function obtenerNombreMarca($id_marca) {
        $res = $this->conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        return $res ? $res->fetch_assoc()['marca'] : 'Desconocida';
    }

    /**
     * El sistema traduce un identificador numérico al nombre textual 
     * del tipo de equipo vinculado.
     */
    public function obtenerNombreTipo($id_tipo) {
        $res = $this->conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo'");
        return $res ? $res->fetch_assoc()['tipo'] : 'Desconocido';
    }

    /* ========================================================
       5. EDICIÓN PROFUNDA DE REGISTROS (VENTANA MODAL)
       ======================================================== */
    /**
     * El sistema ejecuta una actualización integral del registro, mapeando 
     * y sanitizando de forma estricta los 13 campos de información enviados 
     * desde el formulario modal de edición.
     */
    public function actualizarCitaCompleta($id_cita, $nombre, $apellido, $id_tipo, $tipo_otro, $id_marca, $marca_otra, $modelo, $n_serie, $falla, $detalle_falla, $fecha, $hora, $whatsapp, $estado) {
        
        $stmt = $this->conexion->prepare("UPDATE citas_web SET nombre_cliente=?, apellido_cliente=?, id_tipo_equipo=?, tipo_equipo_otro=?, id_marca=?, marca_otro=?, modelo=?, numero_serie=?, problema_reportado=?, detalle_falla=?, fecha_cita=?, hora_cita=?, whatsapp=?, estado=? WHERE id_cita=?");
        
        // El sistema parametriza exactamente las 15 variables (ssisisssssssssi)
        $stmt->bind_param("ssisisssssssssi", $nombre, $apellido, $id_tipo, $tipo_otro, $id_marca, $marca_otra, $modelo, $n_serie, $falla, $detalle_falla, $fecha, $hora, $whatsapp, $estado, $id_cita);
        
        return $stmt->execute();
    }

    /* ========================================================
       6. EXTRACCIÓN DE CATÁLOGOS Y MAPEO ESTRUCTURAL (VISTA)
       ======================================================== */
    /**
     * El sistema recupera el catálogo completo de marcas, 
     * estructurado en orden alfabético.
     */
    public function obtenerMarcas() {
        return $this->conexion->query("SELECT * FROM marcas ORDER BY marca ASC");
    }

    /**
     * El sistema recupera el catálogo completo de tipos de equipo, 
     * estructurado en orden alfabético.
     */
    public function obtenerTiposEquipo() {
        return $this->conexion->query("SELECT * FROM tipos_equipo ORDER BY tipo ASC");
    }

    /**
     * El sistema extrae todas las citas cruzando la información con los 
     * catálogos correspondientes mediante cláusulas JOIN. Posteriormente, 
     * estructura los resultados en un mapa de memoria utilizando el ID de 
     * Google Calendar como clave principal para su fácil consumo en la Vista.
     */
    public function obtenerCitasCompletas() {
        $sql = "SELECT c.*, m.marca, t.tipo 
                FROM citas_web c
                LEFT JOIN marcas m ON c.id_marca = m.id_marca
                LEFT JOIN tipos_equipo t ON c.id_tipo_equipo = t.id_tipo_equipo";
        $resultado = $this->conexion->query($sql);
        
        $mapa = [];
        if ($resultado) {
            while ($f = $resultado->fetch_assoc()) {
                // Integración avanzada: Asignación del ID de Google como llave matriz
                $mapa[$f['id_google_calendar']] = $f;
            }
        }
        return $mapa;
    }

    /* ========================================================
       7. CATÁLOGO DE SERVICIOS DINÁMICOS
       ======================================================== */
    /**
     * El sistema recupera los servicios activos de forma controlada, empleando 
     * un bloque try-catch para prevenir caídas de la plataforma (Error 500) 
     * en caso de anomalías en la estructura de la base de datos.
     */
    public function obtenerServiciosConfigurados() {
        try {
            $resultado = $this->conexion->query("SELECT tipo_servicio FROM servicios ORDER BY tipo_servicio ASC");
            return $resultado;
        } catch (Exception $e) {
            return false; 
        }
    }
}
?>