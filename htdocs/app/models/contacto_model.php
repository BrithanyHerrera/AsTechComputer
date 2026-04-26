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

    $sqlCheck = "SELECT fecha_envio FROM mensajes_contacto 
                 WHERE correo = ? 
                 AND fecha_envio > DATE_SUB(NOW(), INTERVAL 5 MINUTE)
                 ORDER BY fecha_envio DESC LIMIT 1";
    
    $stmtCheck = $this->conexion->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $resultadoCheck = $stmtCheck->get_result();

    if ($resultadoCheck->num_rows > 0) {
        $stmtCheck->close();
        
        throw new Exception("wait"); 
    }
    $stmtCheck->close();

   
    $sql = "INSERT INTO mensajes_contacto (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $asunto, $mensaje);
    $resultado = $stmt->execute();
    $stmt->close();

    return $resultado;
} 
}
?>