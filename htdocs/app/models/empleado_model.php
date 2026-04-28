<?php
class EmpleadosModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /**
     * Obtener todos los puestos para los dropdowns del formulario
     */
    public function obtenerPuestos() {
        $resultado = $this->conexion->query("SELECT * FROM puestos ORDER BY id_puesto ASC");
        $puestos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $puestos[] = $fila;
        }
        return $puestos;
    }

    /**
     * Listar todos los empleados con su nombre de puesto
     */
    public function listarEmpleados() {
        return $this->conexion->query(
            "SELECT e.*, p.nombre_puesto FROM empleados e JOIN puestos p ON e.id_puesto = p.id_puesto"
        );
    }

    public function agregarEmpleado($datos) {
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
            $datos['contrasena'],
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

    public function actualizarEmpleado($id, $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $contrasena_hash = null) {
        
        if (!empty($contrasena_hash)) {
            $sql = "UPDATE empleados SET nombre = ?, apellido = ?, telefono = ?, correo = ?, nombre_usuario = ?, id_puesto = ?, contrasena = ? WHERE id_empleado = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssssisi", $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $contrasena_hash, $id);
        } else {
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