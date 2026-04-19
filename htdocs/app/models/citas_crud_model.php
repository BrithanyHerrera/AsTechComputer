<?php
// ========================================================
// MODELO: citas_crud_model.php
// UBICACIÓN: app/models/citas_crud_model.php
// ========================================================

class CitasAdminModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // 1. Actualizar estado rápido (AJAX)
    public function actualizarEstado($id_cita, $nuevo_estado) {
        $stmt = $this->conexion->prepare("UPDATE citas_web SET estado = ? WHERE id_cita = ?");
        $stmt->bind_param("si", $nuevo_estado, $id_cita);
        return $stmt->execute();
    }

    // 2. Obtener citas expiradas (más de 1 mes)
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

    // 3. Eliminar una cita de la base de datos
    public function eliminarCitaLocal($id_cita) {
        $stmt = $this->conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
        $stmt->bind_param("i", $id_cita);
        return $stmt->execute();
    }

    // 4. Obtener nombre de marca y tipo para Google Calendar
    public function obtenerNombreMarca($id_marca) {
        $res = $this->conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        return $res ? $res->fetch_assoc()['marca'] : 'Desconocida';
    }

    public function obtenerNombreTipo($id_tipo) {
        $res = $this->conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo'");
        return $res ? $res->fetch_assoc()['tipo'] : 'Desconocido';
    }

    // 5. Actualizar todos los datos de la cita
    public function actualizarCitaCompleta($id_cita, $nombre, $apellido, $id_tipo, $id_marca, $modelo, $n_serie, $falla, $fecha, $hora, $whatsapp) {
        $stmt = $this->conexion->prepare("UPDATE citas_web SET nombre_cliente=?, apellido_cliente=?, id_tipo_equipo=?, id_marca=?, modelo=?, numero_serie=?, problema_reportado=?, fecha_cita=?, hora_cita=?, whatsapp=? WHERE id_cita=?");
        $stmt->bind_param("ssiissssssi", $nombre, $apellido, $id_tipo, $id_marca, $modelo, $n_serie, $falla, $fecha, $hora, $whatsapp, $id_cita);
        return $stmt->execute();
    }

    // 6. Consultas de catálogos para la vista
    public function obtenerMarcas() {
        return $this->conexion->query("SELECT * FROM marcas ORDER BY marca ASC");
    }

    public function obtenerTiposEquipo() {
        return $this->conexion->query("SELECT * FROM tipos_equipo ORDER BY tipo ASC");
    }

    public function obtenerCitasCompletas() {
        $sql = "SELECT c.*, m.marca, t.tipo 
                FROM citas_web c
                LEFT JOIN marcas m ON c.id_marca = m.id_marca
                LEFT JOIN tipos_equipo t ON c.id_tipo_equipo = t.id_tipo_equipo";
        $resultado = $this->conexion->query($sql);
        
        $mapa = [];
        if ($resultado) {
            while ($f = $resultado->fetch_assoc()) {
                // Creamos el mapa usando el nombre completo en mayúsculas como llave
                $mapa[strtoupper($f['nombre_cliente'] . " " . $f['apellido_cliente'])] = $f;
            }
        }
        return $mapa;
    }
}
?>