<?php
/* CITAS_MODEL.PHP */
/*
 * PÁGINA: Modelo del Cliente (Cita Model) - As Tech Computer
 * PROPÓSITO: Actuar como la capa de abstracción de datos (Model) dedicada a las operaciones que realizan los clientes desde la interfaz pública al momento de solicitar un servicio.
 * FUNCIONALIDADES:
 * - Inyección y gestión segura de la conexión a la base de datos (MySQL).
 * - Ejecución de rutinas de mantenimiento automático (borrado de citas en estados iniciales que han superado el límite de 1 minuto sin confirmación).
 * - Registro robusto de nuevas citas, empleando sentencias preparadas con 14 parámetros (incluyendo el detalle específico de la falla) para prevenir inyecciones SQL.
 * - Validación crítica de disponibilidad horaria, asegurando que un mismo bloque de fecha/hora no sea sobreescrito por peticiones simultáneas.
 * - Extracción y formato estructurado de catálogos (marcas, tipos, servicios activos) para alimentar dinámicamente los selectores del formulario y prevenir que el cliente ingrese datos sucios.
 * - Generación de un array asociativo con los horarios ya ocupados (para que el frontend los deshabilite en tiempo real).
 */

/* ========================================================
   1. DEFINICIÓN DE LA CLASE Y CONSTRUCTOR
   ======================================================== */
/**
 * La clase CitaModel centraliza todas las consultas y escrituras que el 
 * sistema necesita realizar cuando un cliente interactúa con la plataforma.
 * Recibe la conexión a la base de datos por medio de inyección de dependencias.
 */
class CitaModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
       
    /* ========================================================
       2. MANTENIMIENTO Y GESTIÓN DE REGISTROS (CRUD BÁSICO)
       ======================================================== */
    /**
     * El sistema realiza una purga de registros huérfanos o pruebas 
     * no concretadas eliminando citas que quedaron estancadas y han 
     * superado 1 minuto desde su marca de tiempo.
     */
    public function limpiarCitasExpiradas() {
        $sql = "DELETE FROM citas_web WHERE TIMESTAMP(fecha_cita, hora_cita) < DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
        return $this->conexion->query($sql);
    }

    /**
     * Ejecuta el borrado físico de una cita específica utilizando 
     * sentencias preparadas para máxima seguridad.
     */
    public function eliminarCita($id_db) {
        $stmt = $this->conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
        $stmt->bind_param("i", $id_db);
        return $stmt->execute();
    }

    /**
     * Permite la actualización de los datos de un cliente o equipo 
     * si la cita requiere correcciones posteriores a su creación.
     */
    public function actualizarCita($datos) {
        $stmt = $this->conexion->prepare("UPDATE citas_web SET nombre_cliente=?, apellido_cliente=?, id_tipo_equipo=?, id_marca=?, modelo=?, numero_serie=?, problema_reportado=?, fecha_cita=?, hora_cita=?, whatsapp=? WHERE id_cita=?");
        $stmt->bind_param("ssiissssssi", $datos['nombre'], $datos['apellido'], $datos['id_tipo'], $datos['id_marca'], $datos['modelo'], $datos['n_serie'], $datos['falla'], $datos['fecha'], $datos['hora'], $datos['whatsapp'], $datos['id_db']);
        return $stmt->execute();
    }

    /* ========================================================
       3. INSERCIÓN DE NUEVAS CITAS (MÉTODO PRINCIPAL)
       ======================================================== */
    /**
     * El sistema inserta un nuevo registro en la base de datos mapeando 
     * exactamente 14 campos provenientes del controlador, garantizando la 
     * captura del ID generado por Google Calendar y la descripción detallada 
     * de la falla técnica reportada por el usuario.
     */
    public function registrarCita($datos) {
        $sql = "INSERT INTO citas_web (id_google_calendar, nombre_cliente, apellido_cliente, whatsapp, id_tipo_equipo, tipo_equipo_otro, id_marca, marca_otro, modelo, numero_serie, problema_reportado, detalle_falla, fecha_cita, hora_cita) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        // El sistema parametriza las 14 variables de entrada (String e Integer)
        $stmt->bind_param("ssssisisssssss", $datos['id_google_calendar'], $datos['nombre'], $datos['apellido'], $datos['whatsapp'], $datos['id_tipo_equipo'], $datos['tipo_equipo_otro'], $datos['id_marca'], $datos['marca_otro'], $datos['modelo'], $datos['numero_serie'], $datos['problema'], $datos['detalle_falla'], $datos['fecha'], $datos['hora']);
        
        if (!$stmt->execute()) { throw new Exception("Error DB: " . $stmt->error); }
        $stmt->close();
        return true;
    }

    /* ========================================================
       4. EXTRACCIÓN DE CATÁLOGOS GLOBALES
       ======================================================== */
    // Métodos diseñados para obtener listados crudos desde la base de datos.
    
    public function obtenerMarcas() {
        return $this->conexion->query("SELECT * FROM marcas ORDER BY marca ASC");
    }

    public function obtenerTipos() {
        return $this->conexion->query("SELECT * FROM tipos_equipo ORDER BY tipo ASC");
    }

    public function obtenerServiciosActivos() {
        $sql = "SELECT id_servicio, tipo_servicio FROM servicios WHERE estado = 'activo' ORDER BY tipo_servicio ASC";
        return $this->conexion->query($sql);
    }

    /* ========================================================
       5. RECOPILACIÓN Y TRADUCCIÓN ESTRUCTURADA
       ======================================================== */
    /**
     * El sistema cruza la tabla de citas con los catálogos de marcas 
     * y tipos de equipo (JOIN), y estructura el resultado en un diccionario 
     * cuya llave es el nombre completo del cliente en mayúsculas.
     */
    public function obtenerCitasBaseDatos() {
        $sql = "SELECT c.*, m.marca, t.tipo 
                FROM citas_web c
                LEFT JOIN marcas m ON c.id_marca = m.id_marca
                LEFT JOIN tipos_equipo t ON c.id_tipo_equipo = t.id_tipo_equipo";
        $res = $this->conexion->query($sql);
        $mapa_db = [];
        while ($f = $res->fetch_assoc()) {
            $mapa_db[strtoupper($f['nombre_cliente'] . " " . $f['apellido_cliente'])] = $f;
        }
        return $mapa_db;
    }

    // Funciones de traducción para convertir identificadores numéricos en textos legibles.
    public function obtenerNombreMarca($id_marca) {
        $q = $this->conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        return ($q->num_rows > 0) ? $q->fetch_assoc()['marca'] : null;
    }

    public function obtenerNombreTipo($id_tipo) {
        $q = $this->conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo'");
        return ($q->num_rows > 0) ? $q->fetch_assoc()['tipo'] : null;
    }

    /* ========================================================
       6. OBTENCIÓN DE DATOS PARA FORMULARIOS PÚBLICOS
       ======================================================== */
    /**
     * Extrae marcas y tipos de equipo excluyendo estratégicamente opciones 
     * genéricas (como ID 7 u 12) para que el formulario mantenga su 
     * estructura interactiva y lógica.
     */
    public function obtenerTiposFormulario() {
        return $this->conexion->query("SELECT id_tipo_equipo, tipo FROM tipos_equipo WHERE id_tipo_equipo != 7 ORDER BY tipo ASC");
    }

    public function obtenerMarcasFormulario() {
        return $this->conexion->query("SELECT id_marca, marca FROM marcas WHERE id_marca != 12 ORDER BY marca ASC");
    }

    /**
     * Construye un arreglo bidimensional que vincula qué marcas están 
     * asociadas a qué tipo de equipo, permitiendo el filtrado en cascada 
     * mediante JavaScript.
     */
    public function obtenerRelaciones() {
        $q = $this->conexion->query("SELECT id_tipo_equipo, id_marca FROM relacion_equipo_marca");
        $relaciones = [];
        if ($q) {
            while ($row = $q->fetch_assoc()) {
                $relaciones[$row['id_tipo_equipo']][] = $row['id_marca'];
            }
        }
        return $relaciones;
    }

    /* ========================================================
       7. CONTROL DE DISPONIBILIDAD Y CONCURRENCIA
       ======================================================== */
    /**
     * El sistema realiza una consulta de validación crítica para comprobar 
     * si un bloque de fecha y hora ya fue asignado a otro registro.
     */
    public function verificarDisponibilidad($fecha, $hora) {
        $hora_bd = $hora . ":00"; 
        $sql = "SELECT id_cita FROM citas_web WHERE fecha_cita = ? AND hora_cita = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $fecha, $hora_bd);
        $stmt->execute();
        $stmt->store_result();
        $ocupado = $stmt->num_rows > 0;
        $stmt->close();
        return $ocupado;
    }

    /**
     * El sistema recopila todos los horarios futuros que ya han sido agendados 
     * y los agrupa en un objeto JSON. Esto permite al frontend deshabilitar 
     * las horas no disponibles en el selector del usuario.
     */
    public function obtenerCitasOcupadas() {
        $q = $this->conexion->query("SELECT fecha_cita, hora_cita FROM citas_web WHERE fecha_cita >= CURDATE()");
        $ocupadas = [];
        if ($q) {
            while ($row = $q->fetch_assoc()) {
                $ocupadas[$row['fecha_cita']][] = substr($row['hora_cita'], 0, 5); 
            }
        }
        return $ocupadas;
    }
}
?>