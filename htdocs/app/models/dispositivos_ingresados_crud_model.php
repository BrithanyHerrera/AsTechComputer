
<?php

// ========================================================
// MODELO: dispositivos_ingresados_crud_model.php
// UBICACIÓN: app/models/dispositivos_ingresados_crud_model.php
//
// Responsabilidad: SOLO habla con la base de datos.
// No hace HTML, no maneja sesiones, no redirige.
// El controlador lo instancia y llama sus métodos.
// ========================================================


class RegistrosModel {
    private $conexion; // Conexión mysqli recibida desde el controlador

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // ----------------------------------------------------------
    // LECTURA: Trae todos los registros del sistema con sus
    // datos relacionados (cliente, equipo, marca, tipo).
    // Ordenados del más reciente al más antiguo.
    // Retorna: array de filas asociativas
    // ----------------------------------------------------------
    public function obtenerRegistros() {
        $sql = "SELECT 
                    o.folio, o.id_gabinete, o.estado, o.fecha_listo, o.fecha_entrega,
                    DATE(o.fecha_ingreso) AS fecha_ingreso,
                    TIME(o.fecha_ingreso) AS hora_ingreso,
                    o.descripcion_problema, o.condicion_fisica, 
                    o.accesorios_entregados, o.observaciones_recepcion,
                    c.id_cliente, c.nombre, c.apellido, c.telefono AS whatsapp, c.correo AS correo_cliente,
                    e.modelo, e.numero_serie, m.marca, t.tipo,
                    emp.nombre AS tecnico_asignado,
                    -- Datos de Condiciones (Paso 3)
                    cs.autoriza_revision_costo AS autoriza_revision,
                    cs.tiempo_estimado,
                    cs.dudas_cliente,
                    -- Datos de Marketing (Paso 4)
                    IF(mk.medio_contacto_otro IS NOT NULL AND mk.medio_contacto_otro != '', mk.medio_contacto_otro, mc.medio) AS origen,
                    mk.es_primera_vez AS primera_vez,
                    IF(mk.tipo_uso_otro IS NOT NULL AND mk.tipo_uso_otro != '', mk.tipo_uso_otro, tu.uso) AS uso_equipo,
                    IF(mk.frecuencia_servicio_otro IS NOT NULL AND mk.frecuencia_servicio_otro != '', mk.frecuencia_servicio_otro, fs.frecuencia) AS frecuencia,
                    mk.recibir_promociones AS promociones
                FROM ordenes_ingreso o
                INNER JOIN equipos e       ON o.id_equipo      = e.id_equipo
                INNER JOIN clientes c      ON e.id_cliente     = c.id_cliente
                INNER JOIN marcas m        ON e.id_marca       = m.id_marca
                INNER JOIN tipos_equipo t  ON e.id_tipo_equipo = t.id_tipo_equipo
                LEFT JOIN empleados emp    ON o.id_tecnico     = emp.id_empleado
                LEFT JOIN condiciones_servicio cs ON o.folio   = cs.folio_orden
                LEFT JOIN marketing mk     ON o.folio          = mk.folio_orden
                LEFT JOIN medios_contacto mc ON mk.id_medio_contacto = mc.id_medio
                LEFT JOIN tipos_uso tu       ON mk.id_tipo_uso = tu.id_tipo_uso
                LEFT JOIN frecuencias_servicio fs ON mk.id_frecuencia_servicio = fs.id_frecuencia
                ORDER BY o.fecha_ingreso DESC";

        $resultado = $this->conexion->query($sql);
        $registros = [];
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $registros[] = $row;
            }
        }
        return $registros;
    }

    // ESCRITURA: Marca un equipo como listo y registra la fecha de finalización
    public function marcarComoListo($folio) {
        $sql = "UPDATE ordenes_ingreso SET estado = 'listo', fecha_listo = NOW() WHERE folio = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $folio);
        return $stmt->execute();
    }

    // ----------------------------------------------------------
    // ESCRITURA: Marca un equipo como entregado y libera
    // el gabinete donde estaba almacenado.
    // Usa transacción para que AMBAS actualizaciones ocurran
    // juntas o ninguna ocurra (atomicidad).
    // Retorna: true si todo salió bien, false si hubo error
    // ----------------------------------------------------------
    public function entregarEquipo($folio, $id_gabinete) {
        $this->conexion->begin_transaction();
        try {
            // 1. Marcar la orden como entregada y registrar la fecha/hora exacta
            $stmt1 = $this->conexion->prepare(
                "UPDATE ordenes_ingreso SET estado = 'entregado', fecha_entrega = NOW() WHERE folio = ?"
            );
            $stmt1->bind_param("s", $folio);
            $stmt1->execute();

            // 2. Liberar el gabinete para que pueda recibir otro equipo
            $stmt2 = $this->conexion->prepare(
                "UPDATE gabinetes SET estado = 'disponible' WHERE id_gabinete = ?"
            );
            $stmt2->bind_param("s", $id_gabinete);
            $stmt2->execute();

            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            // Si algo falla, revertimos todo para no dejar datos inconsistentes
            $this->conexion->rollback();
            return false;
        }
    }

    // ----------------------------------------------------------
    // ESCRITURA: Actualiza simultáneamente los datos de la
    // orden de ingreso Y los datos del cliente en una sola
    // operación atómica (transacción).
    // Retorna: true si todo salió bien, false si hubo error
    // ----------------------------------------------------------
    public function actualizarRegistro(
        $folio, $estado, $condicion, $accesorios, $observaciones,
        $id_cliente, $nombre, $apellido, $telefono
    ) {
        $this->conexion->begin_transaction();
        try {
            // 1. Actualizar estado y condiciones de la orden de ingreso
            $sql1 = "UPDATE ordenes_ingreso 
                     SET estado=?, condicion_fisica=?, accesorios_entregados=?, observaciones_recepcion=? 
                     WHERE folio=?";
            $stmt1 = $this->conexion->prepare($sql1);
            $stmt1->bind_param("sssss", $estado, $condicion, $accesorios, $observaciones, $folio);
            $stmt1->execute();

            // 2. Actualizar datos del cliente (por si se capturaron mal al ingreso)
            $sql2 = "UPDATE clientes SET nombre=?, apellido=?, telefono=? WHERE id_cliente=?";
            $stmt2 = $this->conexion->prepare($sql2);
            $stmt2->bind_param("sssi", $nombre, $apellido, $telefono, $id_cliente);
            $stmt2->execute();

            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            $this->conexion->rollback();
            return false;
        }
    }
}
?>