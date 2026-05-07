<?php
// ========================================================
// MODELO: servicios_model.php
// UBICACIÓN: app/models/servicios_model.php
// CONTROLADOR: servicios_controller.php
// pagina que se encarga de controlar las funciones de la pagina de servcios, la cual muestra servicios, 
// y tiene un buscador que funciona en base a el nombre del servicio
// ========================================================


class ServicioModel {
    // 1. Usaremos "conexion" en toda la clase
    private mysqli $conexion;

    public function __construct( mysqli $conexion) {
        $this->conexion = $conexion;
    }
//funcion para guardar servicio
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
//funcion de elbuscador
    public function buscarServicios(string $termino) {
        $q = "%$termino%";
        $sql = "SELECT tipo_servicio, precio FROM servicios WHERE estado = 'activo' AND tipo_servicio LIKE ? LIMIT 5";
        // Ahora esto ya no dará error porque arriba definimos $this->conexion
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $q);
        $stmt->execute();
        return $stmt->get_result();
    }

  
    
}


?>