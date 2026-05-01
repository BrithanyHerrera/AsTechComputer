<?php
/* TOOLBAR_MODEL.PHP */
/*
 * PÁGINA: Modelo de la Barra de Navegación (Toolbar Model) - As Tech Computer
 * PROPÓSITO: Gestionar el acceso a la base de datos para extraer la información estructurada que nutre el Mega Menú de la barra de navegación.
 * FUNCIONALIDADES: 
 * - Inyección segura de la conexión a la base de datos a través del constructor.
 * - Extracción de las categorías principales (tipos de servicios) ordenadas para el menú lateral.
 * - Recuperación y agrupación en memoria de los servicios activos, asociándolos a su categoría correspondiente.
 * - Consulta segura (mediante sentencias preparadas) para obtener los servicios añadidos más recientemente, previniendo inyecciones SQL.
 */

/* ========================================================
   1. DEFINICIÓN DE LA CLASE Y CONSTRUCTOR
   ======================================================== */
/*
La clase ToolbarModel encapsula toda la lógica de acceso a datos 
requerida exclusivamente por la barra de navegación. Utiliza el patrón 
de inyección de dependencias al recibir la conexión en su constructor.
*/
class ToolbarModel
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    /* ========================================================
       2. EXTRACCIÓN DE CATEGORÍAS PRINCIPALES
       ======================================================== */
    /*
    El sistema realiza una consulta a la tabla 'tipos_servicios' para 
    obtener las categorías padre. Estos datos se utilizan para 
    renderizar los botones principales del acordeón interactivo.
    */
    public function obtenerTiposServicios()
    {
        $query = "SELECT id_tipo_servicio, nombre_tipo FROM tipos_servicios ORDER BY id_tipo_servicio ASC";
        $resultado = $this->conexion->query($query);
        $tipos = [];
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $tipos[] = $row;
            }
        }
        return $tipos;
    }

    /* ========================================================
       3. EXTRACCIÓN Y AGRUPACIÓN DE SERVICIOS
       ======================================================== */
    /*
    El sistema extrae todos los servicios que cuentan con un estado 'activo'.
    Para optimizar el rendimiento en la vista, agrupa los resultados 
    en un array multidimensional utilizando el 'id_tipo_servicio' como clave.
    */
    public function obtenerServiciosAgrupados()
    {
        $serviciosPorTipo = [];
        $query = "SELECT * FROM servicios WHERE estado = 'activo'";
        $resultado = $this->conexion->query($query);
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $serviciosPorTipo[$row['id_tipo_servicio']][] = $row;
            }
        }
        return $serviciosPorTipo;
    }

    /* ========================================================
       4. EXTRACCIÓN DE SERVICIOS RECIENTES (CONSULTA SEGURA)
       ======================================================== */
    /*
    El sistema ejecuta una consulta combinada (JOIN) para obtener los últimos 
    servicios registrados junto con el nombre de su categoría. Se emplea 
    una sentencia preparada (prepared statement) para inyectar el límite 
    de resultados de forma segura, evitando vulnerabilidades.
    */
    public function obtenerServiciosRecientes($limite = 4)
    {
        $query = "SELECT s.*, t.nombre_tipo 
                  FROM servicios s
                  JOIN tipos_servicios t ON s.id_tipo_servicio = t.id_tipo_servicio
                  WHERE s.estado = 'activo' 
                  ORDER BY s.id_servicio DESC 
                  LIMIT ?";

        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $recientes = [];
        while ($row = $resultado->fetch_assoc()) {
            $recientes[] = $row;
        }
        return $recientes;
    }
}
?>