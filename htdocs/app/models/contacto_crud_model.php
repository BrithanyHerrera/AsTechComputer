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