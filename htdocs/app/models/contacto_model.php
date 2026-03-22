<?php
// ========================================================
// MODELO: contacto_model.php
// UBICACIÓN: app/models/contacto_model.php
// ========================================================

class ContactoModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function guardarMensaje($nombre, $email, $asunto, $mensaje) {
        $sql = "INSERT INTO mensajes_contacto (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssss", $nombre, $email, $asunto, $mensaje);
        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
}
?>