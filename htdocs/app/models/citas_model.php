<?php
class CitaModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // ==========================================
    // MÉTODOS PARA EL ADMINISTRADOR
    // ==========================================
    public function limpiarCitasExpiradas() {
        $sql = "DELETE FROM citas_web WHERE TIMESTAMP(fecha_cita, hora_cita) < DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
        return $this->conexion->query($sql);
    }

    public function eliminarCita($id_db) {
        $stmt = $this->conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
        $stmt->bind_param("i", $id_db);
        return $stmt->execute();
    }

    public function actualizarCita($datos) {
        $stmt = $this->conexion->prepare("UPDATE citas_web SET nombre_cliente=?, apellido_cliente=?, id_tipo_equipo=?, id_marca=?, modelo=?, numero_serie=?, problema_reportado=?, fecha_cita=?, hora_cita=?, whatsapp=? WHERE id_cita=?");
        $stmt->bind_param("ssiissssssi", $datos['nombre'], $datos['apellido'], $datos['id_tipo'], $datos['id_marca'], $datos['modelo'], $datos['n_serie'], $datos['falla'], $datos['fecha'], $datos['hora'], $datos['whatsapp'], $datos['id_db']);
        return $stmt->execute();
    }

    public function obtenerMarcas() {
        return $this->conexion->query("SELECT * FROM marcas ORDER BY marca ASC");
    }

    public function obtenerTipos() {
        return $this->conexion->query("SELECT * FROM tipos_equipo ORDER BY tipo ASC");
    }

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

    // Obtener los servicios activos para el combo de "Problema o Falla"
    public function obtenerServiciosActivos() {
        $sql = "SELECT id_servicio, tipo_servicio FROM servicios WHERE estado = 'activo' ORDER BY tipo_servicio ASC";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    // ==========================================
    // MÉTODOS PARA EL CLIENTE
    // ==========================================
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

    // ¡AQUÍ ESTÁ EL CAMBIO PRINCIPAL!
    public function registrarCita($datos) {
        $sql = "INSERT INTO citas_web (id_google_calendar, nombre_cliente, apellido_cliente, whatsapp, id_tipo_equipo, tipo_equipo_otro, id_marca, marca_otro, modelo, numero_serie, problema_reportado, fecha_cita, hora_cita) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        // Se agregó una 's' al inicio del string de tipos y la variable $datos['id_google_calendar']
        $stmt->bind_param("ssssisissssss", $datos['id_google_calendar'], $datos['nombre'], $datos['apellido'], $datos['whatsapp'], $datos['id_tipo_equipo'], $datos['tipo_equipo_otro'], $datos['id_marca'], $datos['marca_otro'], $datos['modelo'], $datos['numero_serie'], $datos['problema'], $datos['fecha'], $datos['hora']);
        
        if (!$stmt->execute()) { throw new Exception("Error DB: " . $stmt->error); }
        $stmt->close();
        return true;
    }

    public function obtenerNombreMarca($id_marca) {
        $q = $this->conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        return ($q->num_rows > 0) ? $q->fetch_assoc()['marca'] : null;
    }

    public function obtenerNombreTipo($id_tipo) {
        $q = $this->conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo'");
        return ($q->num_rows > 0) ? $q->fetch_assoc()['tipo'] : null;
    }

    // ==========================================
    // NUEVOS MÉTODOS PARA EL FORMULARIO DEL CLIENTE
    // ==========================================
    public function obtenerTiposFormulario() {
        return $this->conexion->query("SELECT id_tipo_equipo, tipo FROM tipos_equipo WHERE id_tipo_equipo != 7 ORDER BY tipo ASC");
    }

    public function obtenerMarcasFormulario() {
        return $this->conexion->query("SELECT id_marca, marca FROM marcas WHERE id_marca != 12 ORDER BY marca ASC");
    }

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

    public function obtenerCitasOcupadas() {
        $q = $this->conexion->query("SELECT fecha_cita, hora_cita FROM citas_web WHERE fecha_cita >= CURDATE()");
        $ocupadas = [];
        if ($q) {
            while ($row = $q->fetch_assoc()) {
                // Solo tomamos H:i (ej. 10:00)
                $ocupadas[$row['fecha_cita']][] = substr($row['hora_cita'], 0, 5); 
            }
        }
        return $ocupadas;
    }
}
?>