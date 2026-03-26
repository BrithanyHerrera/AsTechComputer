<?php
// ========================================================
// MODELO: servicios_model.php
// UBICACIÓN: app/models/servicios_model.php
// ========================================================

class ServicioModel {
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

public function agregarServicio($datos) {
        $sql = "INSERT INTO servicios 
                (tipo_servicio, id_tipo_servicio, descripcion, imagen_servicio, tiempo_estimado, precio, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);
        // "ssssdds" -> s: string, d: double/decimal
        $stmt->bind_param("ssssdds", 
            $datos['tipo_servicio'],
            $datos['id_tipo_servicio'],
            $datos['descripcion'],
            $datos['imagen_servicio'],
            $datos['tiempo_estimado'],
            $datos['precio'],
            $datos['estado']
        );
        return $stmt->execute();
    }

    public function editarServicio($datos) {
        if (!empty($datos['imagen_servicio'])) {
            $sql = "UPDATE servicios SET tipo_servicio=?, id_tipo_servicio=?, descripcion=?, precio=?, tiempo_estimado=?, estado=?, imagen_servicio=? WHERE id_servicio=?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssdsssi", $datos['tipo_servicio'], $datos['id_tipo_servicio'], $datos['descripcion'], $datos['precio'], $datos['tiempo_estimado'], $datos['estado'], $datos['imagen_servicio'], $datos['id_servicio']);
        } else {
            $sql = "UPDATE servicios SET tipo_servicio=?, id_tipo_servicio=?, descripcion=?, precio=?, tiempo_estimado=?, estado=? WHERE id_servicio=?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssdssi", $datos['tipo_servicio'], $datos['id_tipo_servicio'], $datos['descripcion'], $datos['precio'], $datos['tiempo_estimado'], $datos['estado'], $datos['id_servicio']);
        }
        return $stmt->execute();
    }

    public function eliminarServicio($id) {
        $stmt = $this->conexion->prepare("DELETE FROM servicios WHERE id_servicio = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function buscarServicios($termino) {
        $q = "%$termino%";
        $sql = "SELECT tipo_servicio, precio FROM servicios WHERE estado = 'activo' AND tipo_servicio LIKE ? LIMIT 5";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $q);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>