<?php
/* CITAS_MODEL.PHP  */
/*
Este archivo es el Modelo (Model) en tu arquitectura MVC. Su única responsabilidad es interactuar directamente con la base de datos MySQL (tu base astech_bd). Aquí se agrupan todas las consultas (SELECT), inserciones (INSERT), actualizaciones (UPDATE) y eliminaciones (DELETE) relacionadas con las citas. Actúa como un "puente" de datos: recibe peticiones del Controlador (por ejemplo, "dame las marcas disponibles" o "guarda esta nueva cita"), ejecuta la consulta en la base de datos de forma segura (usando sentencias preparadas para evitar inyecciones SQL) y le devuelve los resultados al Controlador. Incluye la nueva actualización para guardar el id_google_calendar al registrar una cita.
*/

/* ==========================================
   1. DEFINICIÓN DE LA CLASE Y CONSTRUCTOR
   ========================================== */
class CitaModel {
    private $conexion;

    // El constructor recibe la conexión a la base de datos ya establecida
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /* ==========================================
       2. MÉTODOS PARA EL PANEL ADMINISTRADOR (CRUD BASE)
       ========================================== */
       
    // Elimina citas cuya fecha y hora ya hayan pasado (caducadas)
    public function limpiarCitasExpiradas() {
        $sql = "DELETE FROM citas_web WHERE TIMESTAMP(fecha_cita, hora_cita) < DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
        return $this->conexion->query($sql);
    }

    // Elimina una cita específica basada en su ID
    public function eliminarCita($id_db) {
        $stmt = $this->conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
        $stmt->bind_param("i", $id_db);
        return $stmt->execute();
    }

    // Actualiza los datos de una cita existente desde el panel de admin
    public function actualizarCita($datos) {
        $stmt = $this->conexion->prepare("UPDATE citas_web SET nombre_cliente=?, apellido_cliente=?, id_tipo_equipo=?, id_marca=?, modelo=?, numero_serie=?, problema_reportado=?, fecha_cita=?, hora_cita=?, whatsapp=? WHERE id_cita=?");
        $stmt->bind_param("ssiissssssi", $datos['nombre'], $datos['apellido'], $datos['id_tipo'], $datos['id_marca'], $datos['modelo'], $datos['n_serie'], $datos['falla'], $datos['fecha'], $datos['hora'], $datos['whatsapp'], $datos['id_db']);
        return $stmt->execute();
    }

    // Obtiene todas las marcas registradas (para uso general)
    public function obtenerMarcas() {
        return $this->conexion->query("SELECT * FROM marcas ORDER BY marca ASC");
    }

    // Obtiene todos los tipos de equipo registrados (para uso general)
    public function obtenerTipos() {
        return $this->conexion->query("SELECT * FROM tipos_equipo ORDER BY tipo ASC");
    }

    // Obtiene el historial completo de citas cruzando datos con marcas y tipos (JOIN)
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

    // Obtiene los servicios configurados como 'activos' en la BD
    public function obtenerServiciosActivos() {
        $sql = "SELECT id_servicio, tipo_servicio FROM servicios WHERE estado = 'activo' ORDER BY tipo_servicio ASC";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    /* ==========================================
       3. MÉTODOS PARA EL FLUJO DEL CLIENTE (AGENDAR)
       ========================================== */

    // Verifica si un horario específico ya está ocupado en la base de datos
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

    // Registra una nueva cita en la base de datos, incluyendo el ID generado por Google Calendar
    public function registrarCita($datos) {
        $sql = "INSERT INTO citas_web (id_google_calendar, nombre_cliente, apellido_cliente, whatsapp, id_tipo_equipo, tipo_equipo_otro, id_marca, marca_otro, modelo, numero_serie, problema_reportado, fecha_cita, hora_cita) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        // El primer parámetro 's' corresponde al id_google_calendar
        $stmt->bind_param("ssssisissssss", $datos['id_google_calendar'], $datos['nombre'], $datos['apellido'], $datos['whatsapp'], $datos['id_tipo_equipo'], $datos['tipo_equipo_otro'], $datos['id_marca'], $datos['marca_otro'], $datos['modelo'], $datos['numero_serie'], $datos['problema'], $datos['fecha'], $datos['hora']);
        
        if (!$stmt->execute()) { throw new Exception("Error DB: " . $stmt->error); }
        $stmt->close();
        return true;
    }

    // Obtiene el nombre en texto de una marca usando su ID
    public function obtenerNombreMarca($id_marca) {
        $q = $this->conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        return ($q->num_rows > 0) ? $q->fetch_assoc()['marca'] : null;
    }

    // Obtiene el nombre en texto de un tipo de equipo usando su ID
    public function obtenerNombreTipo($id_tipo) {
        $q = $this->conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo'");
        return ($q->num_rows > 0) ? $q->fetch_assoc()['tipo'] : null;
    }

    /* ==========================================
       4. MÉTODOS EXCLUSIVOS PARA LLENAR SELECTS DEL FORMULARIO
       ========================================== */

    // Obtiene tipos de equipo excluyendo la opción "Otro" (ID 7) que se carga manual
    public function obtenerTiposFormulario() {
        return $this->conexion->query("SELECT id_tipo_equipo, tipo FROM tipos_equipo WHERE id_tipo_equipo != 7 ORDER BY tipo ASC");
    }

    // Obtiene marcas excluyendo la opción "Otra marca" (ID 12) que se carga manual
    public function obtenerMarcasFormulario() {
        return $this->conexion->query("SELECT id_marca, marca FROM marcas WHERE id_marca != 12 ORDER BY marca ASC");
    }

    // Extrae la tabla de relaciones para saber qué marcas aplican a qué tipo de equipo
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

    // Obtiene una lista de todas las horas ocupadas desde el día actual en adelante
    public function obtenerCitasOcupadas() {
        $q = $this->conexion->query("SELECT fecha_cita, hora_cita FROM citas_web WHERE fecha_cita >= CURDATE()");
        $ocupadas = [];
        if ($q) {
            while ($row = $q->fetch_assoc()) {
                // Se formatea a "HH:MM" (ej. 10:00) para cruzarlo con el JS del frontend
                $ocupadas[$row['fecha_cita']][] = substr($row['hora_cita'], 0, 5); 
            }
        }
        return $ocupadas;
    }
}
?>