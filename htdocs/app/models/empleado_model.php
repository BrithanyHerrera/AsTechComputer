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

        $contrasena_hash = password_hash($datos['contrasena'], PASSWORD_DEFAULT);

        $stmt->bind_param("ssssssi", 
            $datos['nombre'],
            $datos['apellido'],
            $datos['telefono'],
            $datos['correo'],
            $datos['nombre_usuario'],
            $contrasena_hash,
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
public function actualizarEmpleado($id, $nombre, $apellido, $telefono, $correo, $usuario, $puesto) {
        $sql = "UPDATE empleados SET 
                nombre = ?, 
                apellido = ?, 
                telefono = ?, 
                correo = ?, 
                nombre_usuario = ?, 
                id_puesto = ? 
                WHERE id_empleado = ?";
        
        $stmt = $this->conexion->prepare($sql);
        // ssssii (4 strings, 2 ints, 1 int para el ID) -> Total 7 parámetros
        $stmt->bind_param("sssssii", $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $id);

        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            // Re-lanzamos la excepción para que el controlador la atrape y decida qué hacer
            throw $e;
        }
    }

}
?>