<?php
// =============================================================
// ingreso_model.php — La Bóveda de Datos
// Solo habla con la base de datos. Nada de HTML, sesiones
// ni redirecciones. Solo extrae, guarda y devuelve datos limpios.
// =============================================================

class IngresoModel {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // ----------------------------------------------------------
    // LECTURA: Obtiene todos los datos de una orden por folio
    // (usado al activar el modo edición)
    // ----------------------------------------------------------
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

    // ----------------------------------------------------------
    // LECTURA: Obtiene el tipo de espacio de un gabinete por ID
    // ----------------------------------------------------------
    public function obtenerTipoGabinete($id_gabinete) {
        $q = $this->conexion->query("SELECT tipo_espacio FROM gabinetes WHERE id_gabinete = '" . $this->conexion->real_escape_string($id_gabinete) . "'");
        return $q ? $q->fetch_assoc() : null;
    }

    // ----------------------------------------------------------
    // LECTURA: Obtiene los datos de una cita por su ID
    // ----------------------------------------------------------
    public function obtenerDatosCita($id_cita) {
        $stmt = $this->conexion->prepare("SELECT * FROM citas_web WHERE id_cita = ?");
        $stmt->bind_param("i", $id_cita);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ----------------------------------------------------------
    // LECTURA: Verifica el estado actual de un gabinete
    // ----------------------------------------------------------
    public function verificarEstadoGabinete($id_gabinete) {
        $stmt = $this->conexion->prepare("SELECT estado FROM gabinetes WHERE id_gabinete = ?");
        $stmt->bind_param("s", $id_gabinete);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ----------------------------------------------------------
    // LECTURA: Catálogos para poblar los selects del formulario
    // ----------------------------------------------------------
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
        return $this->conexion->query("SELECT id_tipo_equipo, id_marca FROM relacion_equipo_marca");
    }

    // ----------------------------------------------------------
    // LECTURA: Citas web pendientes (desde ayer en adelante)
    // ----------------------------------------------------------
    public function obtenerCitasPendientes() {
        return $this->conexion->query("
            SELECT id_cita, nombre_cliente, apellido_cliente, whatsapp, id_tipo_equipo, id_marca, modelo, numero_serie, problema_reportado, detalle_falla, fecha_cita, hora_cita 
            FROM citas_web 
            WHERE fecha_cita >= CURDATE() - INTERVAL 1 DAY 
            ORDER BY fecha_cita ASC, hora_cita ASC
        ");
    }

    // ----------------------------------------------------------
    // LECTURA: Gabinetes disponibles.
    // En modo edición incluye también el gabinete original aunque
    // esté "ocupado", para que el técnico pueda mantenerlo.
    // ----------------------------------------------------------


    // ----------------------------------------------------------
    // ESCRITURA: Actualiza un registro existente en las 5 tablas
    // ----------------------------------------------------------
    public function actualizarRegistro($datos, $folio_edit, $id_cliente, $id_equipo, $gabinete_original) {
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

        // Si el técnico decidió cambiarlo de gabinete físico,
        // liberamos el viejo y ocupamos el nuevo
        if ($datos['espacio_almacenamiento'] !== $gabinete_original) {
            $this->conexion->query("UPDATE gabinetes SET estado = 'disponible' WHERE id_gabinete = '" . $this->conexion->real_escape_string($gabinete_original) . "'");
            $this->conexion->query("UPDATE gabinetes SET estado = 'ocupado' WHERE id_gabinete = '" . $this->conexion->real_escape_string($datos['espacio_almacenamiento']) . "'");
        }

        $this->conexion->commit();
    }

    // ----------------------------------------------------------
    // ESCRITURA: Crea un nuevo registro completo en las 5 tablas
    // ----------------------------------------------------------
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

        // 1. Verificar si el cliente ya existe (Buscamos por Nombre, Apellido y Teléfono)
        $stmt_check_cliente = $this->conexion->prepare("SELECT id_cliente FROM clientes WHERE nombre = ? AND apellido = ? AND telefono = ? LIMIT 1");
        $stmt_check_cliente->bind_param("sss", $datos['nombre_cliente'], $datos['apellido_cliente'], $telefono);
        $stmt_check_cliente->execute();
        $resultado_cliente = $stmt_check_cliente->get_result();

        if ($resultado_cliente->num_rows > 0) {
            // EL CLIENTE YA EXISTE: Reciclamos su ID para no duplicarlo
            $fila_cliente = $resultado_cliente->fetch_assoc();
            $id_cliente = $fila_cliente['id_cliente'];
            
            // Actualizamos su correo por si en esta nueva visita dio uno diferente
            $stmt_update_correo = $this->conexion->prepare("UPDATE clientes SET correo = ? WHERE id_cliente = ?");
            $stmt_update_correo->bind_param("si", $datos['correo_cliente'], $id_cliente);
            $stmt_update_correo->execute();
            
        } else {
            // ES UN CLIENTE NUEVO: Lo insertamos de cero
            $stmt1 = $this->conexion->prepare("INSERT INTO clientes (nombre, apellido, telefono, correo) VALUES (?, ?, ?, ?)");
            $stmt1->bind_param("ssss", $datos['nombre_cliente'], $datos['apellido_cliente'], $telefono, $datos['correo_cliente']);
            $stmt1->execute();
            $id_cliente = $this->conexion->insert_id;
        }

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

        $stmt6 = $this->conexion->prepare("UPDATE gabinetes SET estado = 'ocupado' WHERE id_gabinete = ?");
        $stmt6->bind_param("s", $datos['espacio_almacenamiento']);
        $stmt6->execute();

        $this->conexion->commit();
    }

    public function obtenerGabinetesDisponibles($gabinete_original = null) {
    if ($gabinete_original) {
        $stmt = $this->conexion->prepare("SELECT id_gabinete, tipo_espacio FROM gabinetes WHERE estado = 'disponible' OR id_gabinete = ? ORDER BY id_gabinete ASC");
        $stmt->bind_param("s", $gabinete_original);
        $stmt->execute();
        return $stmt->get_result();
    }
    return $this->conexion->query("SELECT id_gabinete, tipo_espacio FROM gabinetes WHERE estado = 'disponible' ORDER BY id_gabinete ASC");
}

public function actualizarEstadoGabinete($id_gabinete, $estado) {
    $stmt = $this->conexion->prepare("UPDATE gabinetes SET estado = ? WHERE id_gabinete = ?");
    $stmt->bind_param("ss", $estado, $id_gabinete);
    return $stmt->execute();
}
}