<?php
class MensajesModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function actualizarEstado($id, $estado) {
        $sql = "UPDATE mensajes_contacto SET estado = ? WHERE id_mensaje = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("si", $estado, $id);

        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
}
?>