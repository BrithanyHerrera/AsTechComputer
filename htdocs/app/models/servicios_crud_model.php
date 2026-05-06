<?php
// ========================================================
// MODELO: servicios_model.php
// UBICACIÓN: app/models/servicios_model.php
// ========================================================

class ServicioCrudModel {
    private mysqli $conexion;

    public function __construct(mysqli $conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerServicios(?int $id_tipo = null): array {
        if ($id_tipo !== null) {
            $sql = "SELECT tipo_servicio, codigo_servicio, descripcion, precio, imagen_servicio, procedimiento, beneficios, indicaciones, exclusiones 
                    FROM servicios 
                    WHERE estado = 'activo' AND id_tipo_servicio = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id_tipo);
        } else {
            $sql = "SELECT tipo_servicio, codigo_servicio, descripcion, precio, imagen_servicio, procedimiento, beneficios, indicaciones, exclusiones 
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

    public function agregarServicio(array $datos): bool {
        $sql = "INSERT INTO servicios 
                (tipo_servicio, codigo_servicio, id_tipo_servicio, descripcion, imagen_servicio, tiempo_estimado, precio, estado, procedimiento, beneficios, indicaciones, exclusiones)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        // CASTEO CORRECTO
        $id_tipo = (int)$datos['id_tipo_servicio'];
        $tiempo = (float)$datos['tiempo_estimado'];
        $precio = (float)$datos['precio'];

        $stmt->bind_param(
            "ssissddsssss",
            $datos['tipo_servicio'],
            $datos['codigo_servicio'],
            $id_tipo,
            $datos['descripcion'],
            $datos['imagen_servicio'],
            $tiempo,
            $precio,
            $datos['estado'],
            $datos['procedimiento'],
            $datos['beneficios'],
            $datos['indicaciones'],
            $datos['exclusiones']
        );

        return $stmt->execute();
    }

    public function editarServicio(array $datos): bool {
        $id_tipo = (int)$datos['id_tipo_servicio'];
        $tiempo = (float)$datos['tiempo_estimado'];
        $precio = (float)$datos['precio'];
        $id_servicio = (int)$datos['id_servicio'];

        if (!empty($datos['imagen_servicio'])) {
            $sql = "UPDATE servicios 
                    SET tipo_servicio=?, codigo_servicio=?, id_tipo_servicio=?, descripcion=?, precio=?, tiempo_estimado=?, estado=?, procedimiento=?, beneficios=?, indicaciones=?, exclusiones=?, imagen_servicio=? 
                    WHERE id_servicio=?";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bind_param(
                "ssissdssssssi",
                $datos['tipo_servicio'],
                $datos['codigo_servicio'],
                $id_tipo,
                $datos['descripcion'],
                $precio,
                $tiempo,
                $datos['estado'],
                $datos['procedimiento'],
                $datos['beneficios'],
                $datos['indicaciones'],
                $datos['exclusiones'],
                $datos['imagen_servicio'],
                $id_servicio
            );
        } else {
            $sql = "UPDATE servicios 
                    SET tipo_servicio=?, codigo_servicio=?, id_tipo_servicio=?, descripcion=?, precio=?, tiempo_estimado=?, estado=?, procedimiento=?, beneficios=?, indicaciones=?, exclusiones=? 
                    WHERE id_servicio=?";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bind_param(
                "ssissdsssssi",
                $datos['tipo_servicio'],
                $datos['codigo_servicio'],
                $id_tipo,
                $datos['descripcion'],
                $precio,
                $tiempo,
                $datos['estado'],
                $datos['procedimiento'],
                $datos['beneficios'],
                $datos['indicaciones'],
                $datos['exclusiones'],
                $id_servicio
            );
        }

        return $stmt->execute();
    }

    public function eliminarServicio(int $id): bool {
        $stmt = $this->conexion->prepare("DELETE FROM servicios WHERE id_servicio = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

public function buscarServiciosAvanzado(array $filtros): mysqli_result {
    $sql = "SELECT s.*, t.nombre_tipo 
            FROM servicios s
            LEFT JOIN tipos_servicios t ON s.id_tipo_servicio = t.id_tipo_servicio 
            WHERE 1=1";
    
    $params = [];
    $types = "";

    // Filtro de texto (Buscador original)
    if (!empty($filtros['busqueda'])) {
        $sql .= " AND (s.tipo_servicio LIKE ? OR s.descripcion LIKE ? OR s.codigo_servicio LIKE ?)";
        $like = "%" . $filtros['busqueda'] . "%";
        $params[] = $like; $params[] = $like; $params[] = $like;
        $types .= "sss";
    }

    // Filtro por ID de Tipo
    if (!empty($filtros['id_tipo'])) {
        $sql .= " AND s.id_tipo_servicio = ?";
        $params[] = (int)$filtros['id_tipo'];
        $types .= "i";
    }

    // Filtro por Precio Máximo
    if (!empty($filtros['precio_max'])) {
        $sql .= " AND s.precio <= ?";
        $params[] = (float)$filtros['precio_max'];
        $types .= "d";
    }

    $stmt = $this->conexion->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}
}
?>