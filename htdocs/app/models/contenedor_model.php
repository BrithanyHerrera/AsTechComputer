<?php

class ContenedorModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /**
     * Listar todos los gabinetes con su folio activo (si existe)
     */
    public function listarContenedores() {
        $sql = "SELECT 
                    g.id_gabinete, 
                    g.tipo_espacio, 
                    g.estado, 
                    o.folio 
                FROM gabinetes g 
                LEFT JOIN ordenes_ingreso o 
                    ON g.id_gabinete = o.id_gabinete 
                    AND o.estado != 'entregado'";

        return $this->db->query($sql);
    }

    /**
     * Agregar gabinete (Sin folio)
     */
    public function agregarContenedor($id_gabinete, $tipo, $estado) {
        $sql = "INSERT INTO gabinetes (id_gabinete, tipo_espacio, estado) 
                VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $id_gabinete, $tipo, $estado);

        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    /**
     * Eliminar gabinete
     */
    public function eliminarGabinete($id) {
        $stmt = $this->db->prepare("DELETE FROM gabinetes WHERE id_gabinete = ?");
        $stmt->bind_param("s", $id);

        return $stmt->execute();
    }

    /**
     * Editar gabinete
     */
    public function editarGabinete($id_gabinete, $tipo_espacio, $estado) {
        $sql = "UPDATE gabinetes SET 
                tipo_espacio = ?, 
                estado = ? 
                WHERE id_gabinete = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $tipo_espacio, $estado, $id_gabinete);

        return $stmt->execute();
    }
}

?>