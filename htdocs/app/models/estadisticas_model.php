<?php
// ========================================================
// MODELO: estadisticas_model.php
// UBICACIÓN: app/models/estadisticas_model.php
//
// Responsabilidad: SOLO ejecuta consultas de agregación
// sobre la base de datos para alimentar las gráficas.
// No hace HTML, no maneja sesiones, no redirige.
// Cada método retorna un mysqli_result listo para iterar.
// ========================================================

class EstadisticasModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // ----------------------------------------------------------
    // Gráfica 1: Tipos de dispositivos que más llegan al taller
    // Retorna: etiqueta (tipo de equipo) + total (cantidad)
    // ----------------------------------------------------------
    public function obtenerDispositivos() {
        $sql = "SELECT t.tipo AS etiqueta, COUNT(e.id_equipo) AS total 
                FROM equipos e 
                JOIN tipos_equipo t ON e.id_tipo_equipo = t.id_tipo_equipo 
                GROUP BY t.id_tipo_equipo";
        return $this->conexion->query($sql);
    }

    // ----------------------------------------------------------
    // Gráfica 2: Cómo supieron del lugar (medios de contacto)
    // Retorna: etiqueta (medio) + total (cantidad de clientes)
    // ----------------------------------------------------------
    public function obtenerMedios() {
        $sql = "SELECT m.medio AS etiqueta, COUNT(mk.id_encuesta) AS total 
                FROM marketing mk 
                JOIN medios_contacto m ON mk.id_medio_contacto = m.id_medio 
                GROUP BY m.id_medio";
        return $this->conexion->query($sql);
    }

    // ----------------------------------------------------------
    // Gráfica 3: Con qué frecuencia los clientes hacen servicio
    // Retorna: etiqueta (frecuencia) + total (cantidad)
    // ----------------------------------------------------------
    public function obtenerFrecuencia() {
        $sql = "SELECT f.frecuencia AS etiqueta, COUNT(mk.id_encuesta) AS total 
                FROM marketing mk 
                JOIN frecuencias_servicio f ON mk.id_frecuencia_servicio = f.id_frecuencia 
                GROUP BY f.id_frecuencia";
        return $this->conexion->query($sql);
    }

    // ----------------------------------------------------------
    // Gráfica 4: Para qué usan sus equipos (Gaming, Trabajo, etc.)
    // Retorna: etiqueta (tipo de uso) + total (cantidad)
    // ----------------------------------------------------------
    public function obtenerUso() {
        $sql = "SELECT u.uso AS etiqueta, COUNT(mk.id_encuesta) AS total 
                FROM marketing mk 
                JOIN tipos_uso u ON mk.id_tipo_uso = u.id_tipo_uso 
                GROUP BY u.id_tipo_uso";
        return $this->conexion->query($sql);
    }

    // ----------------------------------------------------------
    // Gráfica 5: Clientes nuevos vs clientes recurrentes
    // Retorna: etiqueta (si/no) + total (cantidad)
    // El controlador transforma "si/no" en etiquetas legibles
    // ----------------------------------------------------------
    public function obtenerNuevosRecurrentes() {
        $sql = "SELECT es_primera_vez AS etiqueta, COUNT(id_encuesta) AS total 
                FROM marketing 
                GROUP BY es_primera_vez";
        return $this->conexion->query($sql);
    }
}
?>