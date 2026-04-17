<?php
class EstadisticasModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // 1. Tipos de dispositivos que más llegan
    public function obtenerDispositivos() {
        $sql = "SELECT t.tipo as etiqueta, COUNT(e.id_equipo) as total 
                FROM equipos e 
                JOIN tipos_equipo t ON e.id_tipo_equipo = t.id_tipo_equipo 
                GROUP BY t.id_tipo_equipo";
        return $this->conexion->query($sql);
    }

    // 2. Cómo supieron del lugar (Tabla marketing + medios_contacto)
    public function obtenerMedios() {
        $sql = "SELECT m.medio as etiqueta, COUNT(mk.id_encuesta) as total 
                FROM marketing mk 
                JOIN medios_contacto m ON mk.id_medio_contacto = m.id_medio 
                GROUP BY m.id_medio";
        return $this->conexion->query($sql);
    }

    // 3. Frecuencia con la que hacen servicio a sus equipos
    public function obtenerFrecuencia() {
        $sql = "SELECT f.frecuencia as etiqueta, COUNT(mk.id_encuesta) as total 
                FROM marketing mk 
                JOIN frecuencias_servicio f ON mk.id_frecuencia_servicio = f.id_frecuencia 
                GROUP BY f.id_frecuencia";
        return $this->conexion->query($sql);
    }

    // 4. Para qué usan sus equipos (Gaming, Trabajo, etc.)
    public function obtenerUso() {
        $sql = "SELECT u.uso as etiqueta, COUNT(mk.id_encuesta) as total 
                FROM marketing mk 
                JOIN tipos_uso u ON mk.id_tipo_uso = u.id_tipo_uso 
                GROUP BY u.id_tipo_uso";
        return $this->conexion->query($sql);
    }

    // 5. Porcentaje de clientes nuevos vs clientes que regresan
    public function obtenerNuevosRecurrentes() {
        $sql = "SELECT es_primera_vez as etiqueta, COUNT(id_encuesta) as total 
                FROM marketing 
                GROUP BY es_primera_vez";
        return $this->conexion->query($sql);
    }
}