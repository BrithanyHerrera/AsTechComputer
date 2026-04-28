<?php
// ========================================================
// MODELO: servicios_model.php
// UBICACIÓN: app/models/servicios_model.php
// ========================================================


class ServicioModel {
    // 1. Usaremos "conexion" en toda la clase
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerServicios($id_tipo = null) {
        if ($id_tipo) {
            $query = "SELECT * FROM servicios WHERE id_tipo_servicio = ? AND estado = 1";
            // Cambiado de $this->db a $this->conexion
            $stmt = $this->conexion->prepare($query); 
            $stmt->bind_param("i", $id_tipo); 
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            $query = "SELECT * FROM servicios WHERE estado = 1";
            // Cambiado de $this->db a $this->conexion
            $resultado = $this->conexion->query($query);
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function buscarServicios($termino) {
        $q = "%$termino%";
        $sql = "SELECT tipo_servicio, precio FROM servicios WHERE estado = 'activo' AND tipo_servicio LIKE ? LIMIT 5";
        // Ahora esto ya no dará error porque arriba definimos $this->conexion
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $q);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function guardarServicio($nombre, $descripcion, $precio, $id_tipo) {
        $query = "INSERT INTO servicios (nombre, descripcion, precio, id_tipo_servicio) VALUES (?, ?, ?, ?)";
        // Cambiado de $this->db a $this->conexion
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id_tipo);
        return $stmt->execute();
    }
}

?>