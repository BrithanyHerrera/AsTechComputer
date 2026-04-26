<?php
// ========================================================
// MODELO: servicios_model.php
// UBICACIÓN: app/models/servicios_model.php
// ========================================================

class ServicioCrudModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

 public function obtenerServicios($id_tipo = null) {
        if ($id_tipo) {
            // Se agregaron las 4 columnas nuevas al SELECT
            $sql = "SELECT tipo_servicio, codigo_servicio, descripcion, precio, imagen_servicio, procedimiento, beneficios, indicaciones, exclusiones 
                    FROM servicios 
                    WHERE estado = 'activo' AND id_tipo_servicio = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id_tipo);
        } else {
            // Se agregaron las 4 columnas nuevas al SELECT
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

    public function agregarServicio($datos) {
        // Se agregaron las columnas al INSERT y 4 "?" adicionales
        $sql = "INSERT INTO servicios 
                (tipo_servicio, codigo_servicio, id_tipo_servicio, descripcion, imagen_servicio, tiempo_estimado, precio, estado, procedimiento, beneficios, indicaciones, exclusiones)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);
        
        // Ajuste de bind_param: Se agregaron 4 "s" al final (total 12 parámetros)
        // tipos: sssssdds + ssss = sssssddsssss
        $stmt->bind_param("sssssddsssss", 
            $datos['tipo_servicio'],
            $datos['codigo_servicio'],
            $datos['id_tipo_servicio'],
            $datos['descripcion'],
            $datos['imagen_servicio'],
            $datos['tiempo_estimado'],
            $datos['precio'],
            $datos['estado'],
            $datos['procedimiento'],
            $datos['beneficios'],
            $datos['indicaciones'],
            $datos['exclusiones']
        );
        return $stmt->execute();
    }

    public function editarServicio($datos) {
        if (!empty($datos['imagen_servicio'])) {
            // UPDATE con imagen + nuevas columnas
            $sql = "UPDATE servicios SET tipo_servicio=?, codigo_servicio=?, id_tipo_servicio=?, descripcion=?, precio=?, tiempo_estimado=?, estado=?, procedimiento=?, beneficios=?, indicaciones=?, exclusiones=?, imagen_servicio=? WHERE id_servicio=?";
            $stmt = $this->conexion->prepare($sql);
            // bind_param: 13 parámetros en total
            $stmt->bind_param("ssssddssssssi", 
                $datos['tipo_servicio'], $datos['codigo_servicio'], $datos['id_tipo_servicio'], 
                $datos['descripcion'], $datos['precio'], $datos['tiempo_estimado'], 
                $datos['estado'], $datos['procedimiento'], $datos['beneficios'], 
                $datos['indicaciones'], $datos['exclusiones'], $datos['imagen_servicio'], 
                $datos['id_servicio']
            );
        } else {
            // UPDATE sin imagen + nuevas columnas
            $sql = "UPDATE servicios SET tipo_servicio=?, codigo_servicio=?, id_tipo_servicio=?, descripcion=?, precio=?, tiempo_estimado=?, estado=?, procedimiento=?, beneficios=?, indicaciones=?, exclusiones=? WHERE id_servicio=?";
            $stmt = $this->conexion->prepare($sql);
            // bind_param: 12 parámetros en total
            $stmt->bind_param("ssssddsssssi", 
                $datos['tipo_servicio'], $datos['codigo_servicio'], $datos['id_tipo_servicio'], 
                $datos['descripcion'], $datos['precio'], $datos['tiempo_estimado'], 
                $datos['estado'], $datos['procedimiento'], $datos['beneficios'], 
                $datos['indicaciones'], $datos['exclusiones'], $datos['id_servicio']
            );
        }
        return $stmt->execute();
    }

    public function eliminarServicio($id) {
        $stmt = $this->conexion->prepare("DELETE FROM servicios WHERE id_servicio = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    public function buscarServicios($busqueda)
{
    $sql = "SELECT * FROM servicios 
            WHERE tipo_servicio LIKE ? 
            OR codigo_servicio LIKE ?
            OR descripcion LIKE ?
            OR procedimiento LIKE ?
            OR beneficios LIKE ?
            OR indicaciones LIKE ?
            OR exclusiones LIKE ?
            OR tiempo_estimado LIKE ?
            OR precio LIKE ?
            OR estado LIKE ?";

    $stmt = $this->conexion->prepare($sql);

    $like = "%" . $busqueda . "%";

    $stmt->bind_param(
        "ssssssssss",
        $like, $like, $like, $like, $like,
        $like, $like, $like, $like, $like
    );

    $stmt->execute();
    return $stmt->get_result();
}
}
?>