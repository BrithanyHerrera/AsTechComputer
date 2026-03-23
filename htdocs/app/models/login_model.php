<?php
// ========================================================
// MODELO: login_model.php
// UBICACIÓN: app/models/login_model.php
// ========================================================

class LoginModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para buscar al usuario por su nombre
    public function buscarUsuario($usuario) {
        $stmt = $this->conexion->prepare("SELECT id_empleado, nombre, id_puesto, contrasena FROM empleados WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $empleado = null;
        if ($resultado->num_rows === 1) {
            $empleado = $resultado->fetch_assoc();
        }
        
        $stmt->close();
        return $empleado;
    }

    // Método para guardar el registro en la bitácora
    public function registrarBitacora($id_empleado, $direccion_ip) {
        $stmt = $this->conexion->prepare("INSERT INTO bitacora_logins (id_empleado, direccion_ip) VALUES (?, ?)");
        $stmt->bind_param("is", $id_empleado, $direccion_ip);
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }
}
?>