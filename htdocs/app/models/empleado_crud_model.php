<?php
// ========================================================
//Modelador DE EMPLEADO, SECCION EN LA PAGINA DEL PANEL
//VIEW:empleado_crud_view.php
// CONTROLADOR: empleado_crud_controller.php
// pagina que agrega, edita y elimina empleados
// ========================================================
class EmpleadosModel {
    
    private mysqli $conexion;

    public function __construct(mysqli $conexion) {
        $this->conexion = $conexion;
    }

    /**
     * Obtener todos los puestos
     */
    public function obtenerPuestos(): array {
        $resultado = $this->conexion->query("SELECT * FROM puestos ORDER BY id_puesto ASC");
        $puestos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $puestos[] = $fila;
        }

        return $puestos;
    }

    /**
     * Listar empleados
     */
    public function listarEmpleados(): mysqli_result {
        return $this->conexion->query(
            "SELECT e.*, p.nombre_puesto 
             FROM empleados e 
             JOIN puestos p ON e.id_puesto = p.id_puesto"
        );
    }

    /**
     * Agregar empleado
     */
    public function agregarEmpleado(array $datos): bool {

        $sql = "INSERT INTO empleados 
        (nombre, apellido, telefono, correo, nombre_usuario, contrasena, id_puesto)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        $contrasena_hash = password_hash($datos['contrasena'], PASSWORD_DEFAULT);

        $stmt->bind_param("ssssssi", 
            $datos['nombre'],
            $datos['apellido'],
            $datos['telefono'],
            $datos['correo'],
            $datos['nombre_usuario'],
            $contrasena_hash, // ✅ aquí estaba el error
            $datos['id_puesto']
        );

        return $stmt->execute();
    }
    
    /**
     * Eliminar empleado
     */
    public function eliminarEmpleado(int $id): bool {
        $stmt = $this->conexion->prepare("DELETE FROM empleados WHERE id_empleado = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    /**
     * Restablecer QR (2FA) de un empleado
     */
    public function resetearQR(int $id): bool {
        $sql = "UPDATE empleados SET secreto_2fa = NULL, is_2fa_activo = 0 WHERE id_empleado = ?";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    /**
     * Actualizar empleado
     */
    public function actualizarEmpleado(
        int $id, 
        string $nombre, 
        string $apellido, 
        string $telefono, 
        string $correo, 
        string $usuario, 
        int $puesto, 
        ?string $contrasena_hash = null
    ): bool {

        if (!empty($contrasena_hash)) {

            $sql = "UPDATE empleados 
                    SET nombre = ?, apellido = ?, telefono = ?, correo = ?, nombre_usuario = ?, id_puesto = ?, contrasena = ? 
                    WHERE id_empleado = ?";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssssisi", $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $contrasena_hash, $id);

        } else {

            $sql = "UPDATE empleados 
                    SET nombre = ?, apellido = ?, telefono = ?, correo = ?, nombre_usuario = ?, id_puesto = ? 
                    WHERE id_empleado = ?";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssssii", $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $id);
        }

        return $stmt->execute();
    }
}
?>