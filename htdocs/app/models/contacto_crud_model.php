<?php
/**
 * PÁGINA: Modelo de Gestión de Contactos - As Tech Computer (contacto_crud_model.php)
 * PROPÓSITO: Definir la lógica de acceso a datos para la entidad de mensajes de contacto, 
 * actuando como intermediario entre la base de datos y el controlador.
 * FUNCIONALIDADES:
 * - Estructura de clase (ContactoModel) con inyección de conexión a base de datos mediante constructor.
 * - Lectura de Datos:
 * • Método obtenerMensajes(): Consulta todos los registros de la tabla 'mensajes_contacto' 
 * ordenados cronológicamente por fecha de envío.
 * - Actualización de Datos:
 * • Método actualizarEstado(): Modifica el estatus de un mensaje específico (ID) aplicando 
 * limpieza de datos (real_escape_string) para prevenir SQL Injection.
 * - Eliminación de Datos:
 * • Método eliminarMensaje(): Borra permanentemente un registro de mensaje según su ID 
 * con protección contra inyecciones SQL.
 */
?>
<?php
class ContactoModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // Obtener todos los mensajes
    public function obtenerMensajes() {
        $query = "SELECT * FROM mensajes_contacto ORDER BY fecha_envio DESC";
        return $this->db->query($query);
    }

    // Actualizar el estado de un mensaje
    public function actualizarEstado($id, $estado) {
        $id = $this->db->real_escape_string($id);
        $estado = $this->db->real_escape_string($estado);
        $query = "UPDATE mensajes_contacto SET estado = '$estado' WHERE id_mensaje = '$id'";
        return $this->db->query($query);
    }

    // Eliminar un mensaje
    public function eliminarMensaje($id) {
        $id = $this->db->real_escape_string($id);
        $query = "DELETE FROM mensajes_contacto WHERE id_mensaje = '$id'";
        return $this->db->query($query);
    }
}
?>