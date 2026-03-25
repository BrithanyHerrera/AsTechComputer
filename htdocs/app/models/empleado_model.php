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

}
?>