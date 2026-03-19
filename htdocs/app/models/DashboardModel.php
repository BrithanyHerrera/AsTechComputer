<?php
class DashboardModel {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    // Obtener los datos del usuario conectado
    public function obtenerInfoUsuario($id_empleado) {
        $sql = "SELECT e.nombre, e.apellido, p.nombre_puesto, p.id_puesto 
                FROM empleados e 
                JOIN puestos p ON e.id_puesto = p.id_puesto 
                WHERE e.id_empleado = ?";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_empleado);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        return $resultado;
    }

    // Obtener las últimas conexiones (Solo para el Administrador/Gerente)
    public function obtenerConexiones() {
        $sql = "SELECT b.fecha_hora, e.nombre, e.apellido, p.nombre_puesto 
                FROM bitacora_logins b 
                JOIN empleados e ON b.id_empleado = e.id_empleado 
                JOIN puestos p ON e.id_puesto = p.id_puesto 
                ORDER BY b.fecha_hora DESC LIMIT 20"; // Limitamos a las últimas 20
        
        $resultado = $this->conexion->query($sql);
        $conexiones = [];
        
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $conexiones[] = $fila;
            }
        }
        return $conexiones;
    }
}
?>