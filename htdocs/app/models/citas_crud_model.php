<?php
/* CITAS_CRUD_MODEL.PHP */
/*
Este archivo constituye el Modelo (Model) para las operaciones de administración de citas. Su responsabilidad es servir como capa de abstracción para todas las interacciones directas con la base de datos astech_bd referentes al CRUD (Crear, Leer, Actualizar, Eliminar). Centraliza funciones como el cambio de estado de una cita, la extracción de registros expirados, la recuperación de catálogos (marcas y tipos) necesarios para los menús desplegables del administrador, y la generación de un mapa completo de citas vinculadas mediante cláusulas JOIN para que el Controlador pueda utilizarlas fácilmente sin escribir código SQL repetitivo.
*/

/* ========================================================
   1. DEFINICIÓN DE LA CLASE Y CONSTRUCTOR (MODELO CRUD)
   ======================================================== */
class CitasAdminModel {
    private $conexion;

    // Inicializa la clase recibiendo la conexión activa a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /* ========================================================
       2. ACTUALIZACIÓN RÁPIDA DE ESTADOS (AJAX)
       ======================================================== */
    // Permite cambiar el estado de la cita (Ej: "Pendiente" a "Entregado")
    public function actualizarEstado($id_cita, $nuevo_estado) {
        $stmt = $this->conexion->prepare("UPDATE citas_web SET estado = ? WHERE id_cita = ?");
        $stmt->bind_param("si", $nuevo_estado, $id_cita);
        return $stmt->execute();
    }

    /* ========================================================
       3. OBTENCIÓN Y ELIMINACIÓN DE REGISTROS EXPIRADOS
       ======================================================== */
    // Recupera todas las citas cuya fecha programada superó 1 mes de antigüedad
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

    // Elimina físicamente una cita de la base de datos local utilizando su ID
    public function eliminarCitaLocal($id_cita) {
        $stmt = $this->conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
        $stmt->bind_param("i", $id_cita);
        return $stmt->execute();
    }

    /* ========================================================
       4. TRADUCCIÓN DE IDs PARA SINCRONIZACIÓN CON GOOGLE
       ======================================================== */
    // Obtiene el nombre textual de una marca basada en su identificador numérico
    public function obtenerNombreMarca($id_marca) {
        $res = $this->conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        return $res ? $res->fetch_assoc()['marca'] : 'Desconocida';
    }

    // Obtiene el nombre textual del tipo de equipo basado en su identificador numérico
    public function obtenerNombreTipo($id_tipo) {
        $res = $this->conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo'");
        return $res ? $res->fetch_assoc()['tipo'] : 'Desconocido';
    }

    /* ========================================================
       5. EDICIÓN PROFUNDA DE REGISTROS (VENTANA MODAL)
       ======================================================== */
    // Sobrescribe todos los campos de una cita existente con los nuevos datos recibidos
    public function actualizarCitaCompleta($id_cita, $nombre, $apellido, $id_tipo, $id_marca, $modelo, $n_serie, $falla, $detalle_falla, $fecha, $hora, $whatsapp, $estado) {
        
        $stmt = $this->conexion->prepare("UPDATE citas_web SET nombre_cliente=?, apellido_cliente=?, id_tipo_equipo=?, id_marca=?, modelo=?, numero_serie=?, problema_reportado=?, detalle_falla=?, fecha_cita=?, hora_cita=?, whatsapp=?, estado=? WHERE id_cita=?");
        
        // CORREGIDO: 13 letras exactas para las 13 variables (ssiissssssssi)
        $stmt->bind_param("ssiissssssssi", $nombre, $apellido, $id_tipo, $id_marca, $modelo, $n_serie, $falla, $detalle_falla, $fecha, $hora, $whatsapp, $estado, $id_cita);
        
        return $stmt->execute();
    }

    /* ========================================================
       6. EXTRACCIÓN DE CATÁLOGOS Y MAPEO ESTRUCTURAL (VISTA)
       ======================================================== */
    // Recupera el catálogo completo de marcas ordenadas alfabéticamente
    public function obtenerMarcas() {
        return $this->conexion->query("SELECT * FROM marcas ORDER BY marca ASC");
    }

    // Recupera el catálogo completo de tipos de equipo ordenados alfabéticamente
    public function obtenerTiposEquipo() {
        return $this->conexion->query("SELECT * FROM tipos_equipo ORDER BY tipo ASC");
    }

    // Extrae todas las citas y cruza sus datos con los catálogos para devolver nombres legibles
    public function obtenerCitasCompletas() {
        $sql = "SELECT c.*, m.marca, t.tipo 
                FROM citas_web c
                LEFT JOIN marcas m ON c.id_marca = m.id_marca
                LEFT JOIN tipos_equipo t ON c.id_tipo_equipo = t.id_tipo_equipo";
        $resultado = $this->conexion->query($sql);
        
        $mapa = [];
        if ($resultado) {
            while ($f = $resultado->fetch_assoc()) {
                // LA MAGIA: Usamos el ID de Google Calendar como llave del mapa
                $mapa[$f['id_google_calendar']] = $f;
            }
        }
        return $mapa;
    }

    /* ========================================================
       7. CATÁLOGO DE SERVICIOS DINÁMICOS
       ======================================================== */
    // Recupera los servicios configurados en la tabla 'servicios'
    public function obtenerServiciosConfigurados() {
        try {
            // Reemplaza 'nombre_servicio' por como se llame tu columna realmente
            $resultado = $this->conexion->query("SELECT tipo_servicio FROM servicios ORDER BY tipo_servicio ASC");
            return $resultado;
        } catch (Exception $e) {
            // Si la columna no existe, regresamos false en lugar de tirar la página (Error 500)
            return false; 
        }
    }
}
?>