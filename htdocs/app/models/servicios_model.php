<?php
// ========================================================
// MODELO: servicios_model.php
// UBICACIÓN: app/models/servicios_model.php
// ========================================================

class ServiciosModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerServicios($id_tipo = null) {
        if ($id_tipo) {
            $sql = "SELECT tipo_servicio, descripcion, precio, imagen_servicio 
                    FROM servicios 
                    WHERE estado = 'activo' AND id_tipo_servicio = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id_tipo);
        } else {
            $sql = "SELECT tipo_servicio, descripcion, precio, imagen_servicio 
                    FROM servicios 
                    WHERE estado = 'activo'";
            $stmt = $this->conexion->prepare($sql);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $servicios = [];
        while ($row = $resultado->fetch_assoc()) {
            $servicios[] = $row;
        }

        $stmt->close();
        return $servicios;
    }
}
?>