<?php

class ContenedorModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /**
     * Agregar gabinete (Sin folio)
     */
    public function agregarContenedor($id_gabinete, $tipo, $estado) {
        // Quitamos la columna folio y el cuarto "?"
        $sql = "INSERT INTO gabinetes (id_gabinete, tipo_espacio, estado) 
                VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        // "sss" porque ahora solo son 3 parámetros string
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
        // Usamos $this->db que ya tiene la conexión
        $stmt = $this->db->prepare("DELETE FROM gabinetes WHERE id_gabinete = ?");
        // "s" por si el ID tiene letras (como A1), o "i" si es puro número
        $stmt->bind_param("s", $id);

        return $stmt->execute();
    }

    /**
     * Editar gabinete
     */
    public function editarGabinete($id_gabinete, $tipo_espacio, $estado) {
        // Eliminamos la coma que estaba después de 'estado = ?'
        $sql = "UPDATE gabinetes SET 
                tipo_espacio = ?, 
                estado = ? 
                WHERE id_gabinete = ?";

        $stmt = $this->db->prepare($sql);
        // "sss" para 3 parámetros
        $stmt->bind_param("sss", $tipo_espacio, $estado, $id_gabinete);

        return $stmt->execute();
    }
}

?>