<?php
class EmpleadosModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function agregarEmpleado($datos) {
        $sql = "INSERT INTO empleados 
        (nombre, apellido, telefono, correo, nombre_usuario, contrasena, id_puesto)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        // Se usa la función antigua password_hash si generas contraseñas desde el form
        // (Pero tú lo estabas hasheando desde el controller, no hay problema)
        $contrasena_hash = password_hash($datos['contrasena'], PASSWORD_DEFAULT);

        $stmt->bind_param("ssssssi", 
            $datos['nombre'],
            $datos['apellido'],
            $datos['telefono'],
            $datos['correo'],
            $datos['nombre_usuario'],
            $datos['contrasena'], // Usamos la que ya viene hasheada desde el controller
            $datos['id_puesto']
        );

        return $stmt->execute();
    }
    
    public function eliminarEmpleado($id) {
        $stmt = $this->conexion->prepare("DELETE FROM empleados WHERE id_empleado = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    // MODIFICADO: Ahora acepta la contraseña opcionalmente
    public function actualizarEmpleado($id, $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $contrasena_hash = null) {
        
        if (!empty($contrasena_hash)) {
            // Si mandaron contraseña, la actualizamos
            $sql = "UPDATE empleados SET nombre = ?, apellido = ?, telefono = ?, correo = ?, nombre_usuario = ?, id_puesto = ?, contrasena = ? WHERE id_empleado = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssssisi", $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $contrasena_hash, $id);
        } else {
            // Si NO mandaron contraseña, la dejamos intacta
            $sql = "UPDATE empleados SET nombre = ?, apellido = ?, telefono = ?, correo = ?, nombre_usuario = ?, id_puesto = ? WHERE id_empleado = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssssii", $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $id);
        }

        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }
}
?>