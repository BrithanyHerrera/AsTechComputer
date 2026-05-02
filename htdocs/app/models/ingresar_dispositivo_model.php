<?php
/* INGRESAR_DISPOSITIVO_MODEL.PHP */
/*
 * PÁGINA: Modelo de Ingreso de Dispositivos (Ingreso Model) - As Tech Computer
 * PROPÓSITO: Centralizar toda la lógica de interacción con la base de datos para el módulo de ingreso y edición de equipos, actuando como la "Bóveda de Datos" del sistema MVC.
 * FUNCIONALIDADES: 
 * - Consultas de Lectura Estructuradas: Extracción segura de registros completos mediante JOINs, verificación de disponibilidad de gabinetes, y obtención de catálogos (técnicos, marcas, tipos de equipo).
 * - Importación de Citas: Recuperación de datos de clientes desde el módulo de agendamiento web para autocompletar el asistente físico.
 * - Transacciones ACID (Escritura y Actualización): Ejecución atómica de bloques de inserción (o actualización) a través de 5 tablas interconectadas (clientes, equipos, ordenes_ingreso, condiciones_servicio y marketing), asegurando que si una falla, ninguna se guarde.
 * - Control de Inventario: Gestión del estado de los gabinetes físicos (cambiando su disponibilidad a 'ocupado' o 'disponible' según el flujo del usuario).
 * - Protección contra Duplicidad: Verificación de clientes existentes por nombre, apellido y teléfono antes de crear un nuevo registro, reciclando su ID para mantener la base de datos limpia.
 */

/* =============================================================
   1. DEFINICIÓN DE LA CLASE Y CONSTRUCTOR
   ============================================================= */
/**
 * La clase IngresoModel encapsula exclusivamente la lógica de base de datos.
 * Cumple con el principio de responsabilidad única del patrón MVC, 
 * sin procesar variables de sesión ni emitir HTML.
 */
class IngresoModel {

    private $conexion;

    // El modelo recibe la conexión activa desde el controlador (Inyección de Dependencias)
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /* =============================================================
       2. BLOQUE DE LECTURA (SELECTS)
       ============================================================= */

    /**
     * LECTURA: Obtiene todos los datos de una orden por folio
     * (Usado cuando el usuario activa el modo edición).
     * Emplea JOINs para unificar la información dispersa en 5 tablas.
     */
    public function obtenerDatosPorFolio($folio) {
        $sql = "SELECT o.*, c.*, e.*, s.*, m.recibir_promociones, m.es_primera_vez, m.id_tipo_uso, m.id_frecuencia_servicio, m.id_medio_contacto, m.medio_contacto_otro 
                FROM ordenes_ingreso o
                JOIN equipos e ON o.id_equipo = e.id_equipo
                JOIN clientes c ON e.id_cliente = c.id_cliente
                LEFT JOIN condiciones_servicio s ON o.folio = s.folio_orden
                LEFT JOIN marketing m ON o.folio = m.folio_orden
                WHERE o.folio = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $folio);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * LECTURA: Identifica si un gabinete corresponde a laptops, PC, u otro.
     */
    public function obtenerTipoGabinete($id_gabinete) {
        $q = $this->conexion->query("SELECT tipo_espacio FROM gabinetes WHERE id_gabinete = '" . $this->conexion->real_escape_string($id_gabinete) . "'");
        return $q ? $q->fetch_assoc() : null;
    }

    /**
     * LECTURA: Extrae la información de una cita agendada en la web
     * para rellenar automáticamente el formulario físico.
     */
    public function obtenerDatosCita($id_cita) {
        $stmt = $this->conexion->prepare("SELECT * FROM citas_web WHERE id_cita = ?");
        $stmt->bind_param("i", $id_cita);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * LECTURA: Verifica en tiempo real si un espacio físico sigue libre,
     * previniendo colisiones de asignación entre técnicos.
     */
    public function verificarEstadoGabinete($id_gabinete) {
        $stmt = $this->conexion->prepare("SELECT estado FROM gabinetes WHERE id_gabinete = ?");
        $stmt->bind_param("s", $id_gabinete);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /* =============================================================
       3. BLOQUE DE CATÁLOGOS (SELECTS SIMPLES)
       ============================================================= */
    // Métodos para alimentar las listas desplegables del formulario

    public function obtenerTecnicos() {
        return $this->conexion->query("SELECT id_empleado, nombre, apellido FROM empleados WHERE id_puesto = 1");
    }

    public function obtenerMarcas() {
        return $this->conexion->query("SELECT id_marca, marca FROM marcas ORDER BY marca ASC");
    }

    public function obtenerTiposEquipo() {
        return $this->conexion->query("SELECT id_tipo_equipo, tipo FROM tipos_equipo ORDER BY tipo ASC");
    }

    public function obtenerRelacionesEquipoMarca() {
        $sql = "SELECT id_tipo_equipo, id_marca FROM relacion_equipo_marca";
        $res = $this->conexion->query($sql);
        $relaciones = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $relaciones[$row['id_tipo_equipo']][] = $row['id_marca'];
            }
        }
        return $relaciones;
    }

    /**
     * LECTURA: Obtiene las citas web que no han sido procesadas,
     * desde el día de ayer en adelante.
     */
    public function obtenerCitasPendientes() {
        $sql = "SELECT id_cita, nombre_cliente, apellido_cliente, whatsapp, id_tipo_equipo, id_marca, modelo, numero_serie, problema_reportado, detalle_falla, fecha_cita, hora_cita 
                FROM citas_web 
                WHERE fecha_cita >= CURDATE() - INTERVAL 1 DAY AND estado = 'pendiente'
                ORDER BY fecha_cita ASC, hora_cita ASC";
        $res = $this->conexion->query($sql);
        $citas = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $citas[$row['id_cita']] = $row;
            }
        }
        return $citas;
    }

    /**
     * LECTURA: Estructura los gabinetes disponibles en un array asociativo 
     * listo para ser convertido en JSON. Si se está editando un registro, 
     * incluye el gabinete originalmente asignado para evitar que el técnico lo pierda.
     */
    public function obtenerGabinetesDisponibles($gabinete_original = null) {
        if ($gabinete_original) {
            $stmt = $this->conexion->prepare("SELECT id_gabinete, tipo_espacio FROM gabinetes WHERE estado = 'disponible' OR id_gabinete = ? ORDER BY id_gabinete ASC");
            $stmt->bind_param("s", $gabinete_original);
            $stmt->execute();
            $res = $stmt->get_result();
        } else {
            $res = $this->conexion->query("SELECT id_gabinete, tipo_espacio FROM gabinetes WHERE estado = 'disponible' ORDER BY id_gabinete ASC");
        }

        $gabinetes = ['laptop' => [], 'computadora_escritorio' => [], 'otro' => []];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                if (isset($gabinetes[$row['tipo_espacio']])) {
                    $gabinetes[$row['tipo_espacio']][] = $row['id_gabinete'];
                }
            }
        }
        return $gabinetes;
    }

    /* =============================================================
       4. BLOQUE DE ESCRITURA Y ACTUALIZACIÓN (TRANSACCIONES)
       ============================================================= */

    public function actualizarEstadoGabinete($id_gabinete, $estado) {
        $stmt = $this->conexion->prepare("UPDATE gabinetes SET estado = ? WHERE id_gabinete = ?");
        $stmt->bind_param("ss", $estado, $id_gabinete);
        return $stmt->execute();
    }

    /**
     * ESCRITURA: Actualiza un registro existente.
     * Utiliza 'begin_transaction' para asegurar que si falla el guardado
     * en una de las 5 tablas, se revierta todo (ACID compliance).
     */
    public function actualizarRegistro($datos, $folio_edit, $id_cliente, $id_equipo, $gabinete_original) {
        $this->conexion->begin_transaction();

        $telefono          = $datos['telefono_cliente'] ?? '';
        $condicion_txt     = isset($datos['condicion'])  ? implode(", ", $datos['condicion'])  : 'Ninguna';
        $accesorios_txt    = isset($datos['accesorios']) ? implode(", ", $datos['accesorios']) : 'Ninguno';
        $recordatorio_pago = isset($datos['claro_pago']) ? 'si' : 'no';

        // Traducción de valores textuales a IDs relacionales
        $map_uso        = ['estudio'=>1, 'oficina'=>2, 'disenio_edicion'=>3, 'gaming'=>4];
        $map_frecuencia = ['1_vez_anio'=>1, '2-3_veces_anio'=>2, 'mas_3_anio'=>3, 'descompone'=>4];
        $map_origen     = ['recomendacion'=>1, 'redes_sociales'=>2, 'google_web'=>3, 'cartel'=>4, 'cucosta'=>4, 'recurrente'=>4];

        $id_uso         = $map_uso[$datos['uso_equipo']] ?? 5;
        $id_frecuencia  = $map_frecuencia[$datos['frecuencia']] ?? 6;
        $id_origen      = $map_origen[$datos['origen']] ?? 4;
        $origen_otro    = ($id_origen == 4) ? $datos['origen'] : null;
        $id_tipo_equipo = $datos['tipo_equipo'];
        $id_marca       = $datos['marca'];
        $id_tecnico     = $datos['tecnico_asignado'] ?? 1;

        // Actualización secuencial de las 5 entidades
        $stmt1 = $this->conexion->prepare("UPDATE clientes SET nombre=?, apellido=?, telefono=?, correo=? WHERE id_cliente=?");
        $stmt1->bind_param("ssssi", $datos['nombre_cliente'], $datos['apellido_cliente'], $telefono, $datos['correo_cliente'], $id_cliente);
        $stmt1->execute();

        $stmt2 = $this->conexion->prepare("UPDATE equipos SET id_marca=?, id_tipo_equipo=?, modelo=?, numero_serie=? WHERE id_equipo=?");
        $stmt2->bind_param("iissi", $id_marca, $id_tipo_equipo, $datos['modelo'], $datos['numero_serie'], $id_equipo);
        $stmt2->execute();

        $stmt3 = $this->conexion->prepare("UPDATE ordenes_ingreso SET id_tecnico=?, id_gabinete=?, fecha_ingreso=?, condicion_fisica=?, accesorios_entregados=?, descripcion_problema=?, observaciones_recepcion=? WHERE folio=?");
        $stmt3->bind_param("isssssss", $id_tecnico, $datos['espacio_almacenamiento'], $datos['fecha_ingreso'], $condicion_txt, $accesorios_txt, $datos['motivo_ingreso'], $datos['observaciones_equipo'], $folio_edit);
        $stmt3->execute();

        $stmt4 = $this->conexion->prepare("UPDATE condiciones_servicio SET autoriza_revision_costo=?, tiempo_estimado=?, recordatorio_anticipo=?, dudas_cliente=? WHERE folio_orden=?");
        $stmt4->bind_param("sssss", $datos['autoriza_revision'], $datos['tiempo_estimado'], $recordatorio_pago, $datos['dudas_cliente'], $folio_edit);
        $stmt4->execute();

        $stmt5 = $this->conexion->prepare("UPDATE marketing SET id_medio_contacto=?, medio_contacto_otro=?, recibir_promociones=?, id_tipo_uso=?, es_primera_vez=?, id_frecuencia_servicio=? WHERE folio_orden=?");
        $stmt5->bind_param("issisis", $id_origen, $origen_otro, $datos['promociones'], $id_uso, $datos['primera_vez'], $id_frecuencia, $folio_edit);
        $stmt5->execute();

        // Si el técnico decidió reasignar el equipo a un nuevo espacio físico, 
        // el sistema se encarga de cambiar los estados de ambos gabinetes simultáneamente.
        if ($datos['espacio_almacenamiento'] !== $gabinete_original) {
            $this->conexion->query("UPDATE gabinetes SET estado = 'disponible' WHERE id_gabinete = '" . $this->conexion->real_escape_string($gabinete_original) . "'");
            $this->conexion->query("UPDATE gabinetes SET estado = 'ocupado' WHERE id_gabinete = '" . $this->conexion->real_escape_string($datos['espacio_almacenamiento']) . "'");
        }

        // Se confirma y sella la transacción global.
        $this->conexion->commit();
    }

    /**
     * ESCRITURA: Crea un nuevo registro completo.
     * Incorpora lógica inteligente para detectar si el cliente ya existe
     * en la base de datos, evitando registros duplicados.
     */
    public function crearRegistro($datos) {
        $this->conexion->begin_transaction();

        $telefono          = $datos['telefono_cliente'] ?? '';
        $condicion_txt     = isset($datos['condicion'])  ? implode(", ", $datos['condicion'])  : 'Ninguna';
        $accesorios_txt    = isset($datos['accesorios']) ? implode(", ", $datos['accesorios']) : 'Ninguno';
        $recordatorio_pago = isset($datos['claro_pago']) ? 'si' : 'no';

        $map_uso        = ['estudio'=>1, 'oficina'=>2, 'disenio_edicion'=>3, 'gaming'=>4];
        $map_frecuencia = ['1_vez_anio'=>1, '2-3_veces_anio'=>2, 'mas_3_anio'=>3, 'descompone'=>4];
        $map_origen     = ['recomendacion'=>1, 'redes_sociales'=>2, 'google_web'=>3, 'cartel'=>4, 'cucosta'=>4, 'recurrente'=>4];

        $id_uso         = $map_uso[$datos['uso_equipo']] ?? 5;
        $id_frecuencia  = $map_frecuencia[$datos['frecuencia']] ?? 6;
        $id_origen      = $map_origen[$datos['origen']] ?? 4;
        $origen_otro    = ($id_origen == 4) ? $datos['origen'] : null;
        $id_tipo_equipo = $datos['tipo_equipo'];
        $id_marca       = $datos['marca'];
        $id_tecnico     = $datos['tecnico_asignado'] ?? 1;

        // BÚSQUEDA DE DUPLICADOS: Si el nombre, apellido y teléfono coinciden, se recicla el ID.
        $stmt_check_cliente = $this->conexion->prepare("SELECT id_cliente FROM clientes WHERE nombre = ? AND apellido = ? AND telefono = ? LIMIT 1");
        $stmt_check_cliente->bind_param("sss", $datos['nombre_cliente'], $datos['apellido_cliente'], $telefono);
        $stmt_check_cliente->execute();
        $resultado_cliente = $stmt_check_cliente->get_result();

        if ($resultado_cliente->num_rows > 0) {
            $fila_cliente = $resultado_cliente->fetch_assoc();
            $id_cliente = $fila_cliente['id_cliente'];
            
            // Actualización del correo (el usuario pudo proporcionar uno nuevo)
            $stmt_update_correo = $this->conexion->prepare("UPDATE clientes SET correo = ? WHERE id_cliente = ?");
            $stmt_update_correo->bind_param("si", $datos['correo_cliente'], $id_cliente);
            $stmt_update_correo->execute();
            
        } else {
            // INSERCIÓN: Es un cliente completamente nuevo.
            $stmt1 = $this->conexion->prepare("INSERT INTO clientes (nombre, apellido, telefono, correo) VALUES (?, ?, ?, ?)");
            $stmt1->bind_param("ssss", $datos['nombre_cliente'], $datos['apellido_cliente'], $telefono, $datos['correo_cliente']);
            $stmt1->execute();
            $id_cliente = $this->conexion->insert_id;
        }

        // Inserciones en cascada (Equipos, Ordenes, Condiciones y Marketing)
        $stmt2 = $this->conexion->prepare("INSERT INTO equipos (id_cliente, id_marca, id_tipo_equipo, modelo, numero_serie) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("iiiss", $id_cliente, $id_marca, $id_tipo_equipo, $datos['modelo'], $datos['numero_serie']);
        $stmt2->execute();
        $id_equipo = $this->conexion->insert_id;

        $stmt3 = $this->conexion->prepare("INSERT INTO ordenes_ingreso (folio, id_equipo, id_tecnico, id_gabinete, fecha_ingreso, condicion_fisica, accesorios_entregados, descripcion_problema, observaciones_recepcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param("siissssss", $datos['folio'], $id_equipo, $id_tecnico, $datos['espacio_almacenamiento'], $datos['fecha_ingreso'], $condicion_txt, $accesorios_txt, $datos['motivo_ingreso'], $datos['observaciones_equipo']);
        $stmt3->execute();

        $stmt4 = $this->conexion->prepare("INSERT INTO condiciones_servicio (folio_orden, autoriza_revision_costo, tiempo_estimado, recordatorio_anticipo, dudas_cliente) VALUES (?, ?, ?, ?, ?)");
        $stmt4->bind_param("sssss", $datos['folio'], $datos['autoriza_revision'], $datos['tiempo_estimado'], $recordatorio_pago, $datos['dudas_cliente']);
        $stmt4->execute();

        $stmt5 = $this->conexion->prepare("INSERT INTO marketing (folio_orden, id_medio_contacto, medio_contacto_otro, recibir_promociones, id_tipo_uso, es_primera_vez, id_frecuencia_servicio) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param("sissisi", $datos['folio'], $id_origen, $origen_otro, $datos['promociones'], $id_uso, $datos['primera_vez'], $id_frecuencia);
        $stmt5->execute();

        // Se actualiza el estado del gabinete para que no pueda ser asignado a otro equipo.
        $stmt6 = $this->conexion->prepare("UPDATE gabinetes SET estado = 'ocupado' WHERE id_gabinete = ?");
        $stmt6->bind_param("s", $datos['espacio_almacenamiento']);
        $stmt6->execute();

        $this->conexion->commit();
    }
}
?>