<?php
// =============================================================
// ingreso_controller.php — El Director de Orquesta
// Recibe peticiones, decide qué hacer, llama al Modelo y
// prepara las variables que la Vista necesita para dibujarse.
// Nunca toca HTML ni escribe SQL directamente.
// =============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/ingreso_model.php';

$model = new IngresoModel($conexion);

// ==========================================
// 0. CONTROL DE MODO EDICIÓN
// ==========================================
// Si el técnico entra desde el menú izquierdo (URL limpia), borramos cualquier edición atrapada
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['retorno']) && !isset($_GET['editar'])) {
    unset($_SESSION['memoria_ingreso'], $_SESSION['modo_edicion'], $_SESSION['id_cliente_edicion'], $_SESSION['id_equipo_edicion'], $_SESSION['gabinete_original']);
}

// Si se recibe la orden de editar, extraemos todas las tablas de golpe
if (isset($_GET['editar']) && !isset($_SESSION['modo_edicion'])) {
    $folio_editar = $_GET['editar'];
    $db_data = $model->obtenerDatosPorFolio($folio_editar);

    if ($db_data) {
        // Activamos los candados de edición
        $_SESSION['modo_edicion']       = $folio_editar;
        $_SESSION['id_cliente_edicion'] = $db_data['id_cliente'];
        $_SESSION['id_equipo_edicion']  = $db_data['id_equipo'];
        $_SESSION['gabinete_original']  = $db_data['id_gabinete'];

        // Mapas inversos para los botones de radio
        $m_uso  = [1=>'estudio', 2=>'oficina', 3=>'disenio_edicion', 4=>'gaming'];
        $m_frec = [1=>'1_vez_anio', 2=>'2-3_veces_anio', 3=>'mas_3_anio', 4=>'descompone'];
        $m_orig = [1=>'recomendacion', 2=>'redes_sociales', 3=>'google_web']; 
        $origen_cargado = '';
        if ($db_data['id_medio_contacto'] == 4) {
            $origen_cargado = $db_data['medio_contacto_otro'];
        } else {
            $origen_cargado = $m_orig[$db_data['id_medio_contacto']] ?? '';
        }

        $_SESSION['memoria_ingreso'] = [
            'nombre_cliente'         => $db_data['nombre'],
            'apellido_cliente'       => $db_data['apellido'],
            'telefono_cliente'       => $db_data['telefono'],
            'correo_cliente'         => $db_data['correo'],
            'fecha_ingreso'          => date('Y-m-d', strtotime($db_data['fecha_ingreso'])),
            'espacio_almacenamiento' => $db_data['id_gabinete'],
            'folio'                  => $db_data['folio'],
            'condicion'              => explode(', ', $db_data['condicion_fisica']),
            'accesorios'             => explode(', ', $db_data['accesorios_entregados']),
            'motivo_ingreso'         => $db_data['descripcion_problema'],
            'tecnico_asignado'       => $db_data['id_tecnico'],
            'observaciones_equipo'   => $db_data['observaciones_recepcion'],
            'autoriza_revision'      => $db_data['autoriza_revision_costo'],
            'tiempo_estimado'        => $db_data['tiempo_estimado'],
            'dudas_cliente'          => $db_data['dudas_cliente'],
            'tipo_equipo'            => $db_data['id_tipo_equipo'],
            'marca'                  => $db_data['id_marca'],
            'modelo'                 => $db_data['modelo'],
            'numero_serie'           => $db_data['numero_serie'],
            'primera_vez'            => $db_data['es_primera_vez'],
            'promociones'            => $db_data['recibir_promociones'],
            'claro_pago'             => ($db_data['recordatorio_anticipo'] == 'si') ? 'on' : null,
            'uso_equipo'             => $m_uso[$db_data['id_tipo_uso']] ?? '',
            'frecuencia'             => $m_frec[$db_data['id_frecuencia_servicio']] ?? '',
            'origen'                 => $origen_cargado
        ];

        $r_gab = $model->obtenerTipoGabinete($db_data['id_gabinete']);
        if ($r_gab) $_SESSION['memoria_ingreso']['tipo_almacenamiento'] = $r_gab['tipo_espacio'];
    }
}

// ==========================================
// 1. GUARDADO PROGRESIVO EN MEMORIA Y AUTOCARGA
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Guardado normal de lo que el técnico escribió
    foreach ($_POST as $key => $value) {
        if ($key !== 'step' && $key !== 'finalizar_registro') {
            $_SESSION['memoria_ingreso'][$key] = $value;
        }
    }

    // MAGIA DE ARQUITECTO: Si el técnico seleccionó una cita, extraemos todo de la base de datos
    // y lo inyectamos secretamente en la memoria para que aparezca en los Pasos 2 y 5.
    if (isset($_POST['id_cita_importada']) && !empty($_POST['id_cita_importada'])) {
        $id_cita = (int)$_POST['id_cita_importada'];
        $cita_bd = $model->obtenerDatosCita($id_cita);

        if ($cita_bd) {
            $_SESSION['memoria_ingreso']['motivo_ingreso'] = $cita_bd['problema_reportado'] . ($cita_bd['detalle_falla'] ? ' - ' . $cita_bd['detalle_falla'] : '');
            $_SESSION['memoria_ingreso']['tipo_equipo']    = $cita_bd['id_tipo_equipo'];
            $_SESSION['memoria_ingreso']['marca']          = $cita_bd['id_marca'];
            $_SESSION['memoria_ingreso']['modelo']         = $cita_bd['modelo'];
            $_SESSION['memoria_ingreso']['numero_serie']   = $cita_bd['numero_serie'];
        }
    }
}

// ==========================================
// 2. GUARDADO FINAL EN LAS 5 TABLAS
// ==========================================
if (isset($_POST['finalizar_registro'])) {
    $datos = $_SESSION['memoria_ingreso'];

    // ----------------------------------------------------------
    // FIX: VALIDAR QUE EL GABINETE SIGUE DISPONIBLE ANTES DE
    // INTENTAR CUALQUIER INSERT. Si ya está ocupado, volver al
    // paso 2 con un mensaje de error claro en lugar de fallar
    // silenciosamente y regresar al inicio del formulario.
    // ----------------------------------------------------------
    $espacio_elegido = $datos['espacio_almacenamiento'] ?? '';
    $gabinete_actual = $model->verificarEstadoGabinete($espacio_elegido);

    $es_mismo_gabinete_original = isset($_SESSION['gabinete_original']) &&
                                  $_SESSION['gabinete_original'] === $espacio_elegido;

    if (!$gabinete_actual || ($gabinete_actual['estado'] !== 'disponible' && !$es_mismo_gabinete_original)) {
        unset($_SESSION['memoria_ingreso']['espacio_almacenamiento'], $_SESSION['memoria_ingreso']['folio'], $_SESSION['memoria_ingreso']['tipo_almacenamiento']);
        $_SESSION['error_espacio'] = "El espacio <strong>{$espacio_elegido}</strong> ya no está disponible. Elige otro espacio.";
        
        // REDIRECCIÓN LIMPIA JS
        echo "<script>window.location.href = 'administracion_controller.php?seccion=ingreso&retorno=2';</script>";
        exit;
    }

    try {
        if (isset($_SESSION['modo_edicion'])) {
            $model->actualizarRegistro(
                $datos, $_SESSION['modo_edicion'], $_SESSION['id_cliente_edicion'], $_SESSION['id_equipo_edicion'], $_SESSION['gabinete_original']
            );
            unset($_SESSION['memoria_ingreso'], $_SESSION['modo_edicion'], $_SESSION['id_cliente_edicion'], $_SESSION['id_equipo_edicion'], $_SESSION['gabinete_original']);
            
            // REDIRECCIÓN A LA TABLA CON ESTATUS "success_edit"
            echo "<script>window.location.href = 'administracion_controller.php?seccion=registros_ingresados_crud_view&status=success_edit';</script>";
            exit;

        } else {
            $model->crearRegistro($datos);
            unset($_SESSION['memoria_ingreso']);
            
            // REDIRECCIÓN A INGRESO CON ESTATUS "success"
            echo "<script>window.location.href = 'administracion_controller.php?seccion=ingreso&status=success';</script>";
            exit;
        }

    } catch (Exception $e) {
        $_SESSION['error_db'] = "Error al guardar: " . $e->getMessage();
        echo "<script>window.location.href = 'administracion_controller.php?seccion=ingreso&retorno=5';</script>";
        exit;
    }
}

// ==========================================
// 3. CONTROL DE LA NAVEGACIÓN (PASOS)
// FIX: Leer el parámetro GET 'retorno' para los redirects de error,
// ya que header('Location:...) no puede ir acompañado de un POST.
// ==========================================
if (isset($_GET['retorno'])) {
    $paso = (int) $_GET['retorno'];
} elseif (isset($_POST['step'])) {
    $paso = (int) $_POST['step'];
} else {
    $paso = 1;
}
if ($paso < 1) $paso = 1;
if ($paso > 5) $paso = 5;

// ==========================================
// 4. CONSULTAS DINÁMICAS (delegadas al Modelo)
// El controlador pide los datos y los prepara para la Vista
// ==========================================
$query_tecnicos = $model->obtenerTecnicos();
$query_marcas   = $model->obtenerMarcas();
$query_tipos    = $model->obtenerTiposEquipo();

$query_relaciones = $model->obtenerRelacionesEquipoMarca();
$relaciones = [];
if ($query_relaciones) {
    while ($row = $query_relaciones->fetch_assoc()) {
        $relaciones[$row['id_tipo_equipo']][] = $row['id_marca'];
    }
}
$json_relaciones = json_encode($relaciones);

// ==========================================
// CONSULTA DE CITAS PENDIENTES (Para autollenado)
// Traemos las citas desde ayer en adelante
// ==========================================
$query_citas = $model->obtenerCitasPendientes();
$citas_agendadas = [];
if ($query_citas) {
    while ($row = $query_citas->fetch_assoc()) {
        $citas_agendadas[$row['id_cita']] = $row;
    }
}
$json_citas = json_encode($citas_agendadas);

// FIX: Esta consulta siempre trae SOLO los gabinetes con estado
// 'disponible' al momento de renderizar la página. Así el JS nunca
// puede mostrar espacios ocupados porque simplemente no están en
// el objeto espaciosDB que recibe.
$gabinete_original_sesion = $_SESSION['gabinete_original'] ?? null;
$query_gabinetes = $model->obtenerGabinetesDisponibles($gabinete_original_sesion);

$gabinetes_disponibles = [
    'laptop'                 => [],
    'computadora_escritorio' => [],
    'otro'                   => [],
];
if ($query_gabinetes) {
    while ($row = $query_gabinetes->fetch_assoc()) {
        $gabinetes_disponibles[$row['tipo_espacio']][] = $row['id_gabinete'];
    }
}
$json_gabinetes = json_encode($gabinetes_disponibles);

// FIX: Al renderizar el paso 2, verificar que el espacio guardado en
// sesión todavía exista en la lista de disponibles. Si ya fue ocupado
// por otro registro, lo limpiamos ANTES de pintar el formulario, para
// que el select dinámico quede vacío y se muestre el mensaje de aviso.
if ($paso == 2 && isset($_SESSION['memoria_ingreso']['espacio_almacenamiento'])) {
    $tipo_ses    = $_SESSION['memoria_ingreso']['tipo_almacenamiento'] ?? '';
    $espacio_ses = $_SESSION['memoria_ingreso']['espacio_almacenamiento'];

    $es_gabinete_original = isset($_SESSION['gabinete_original']) &&
                            $_SESSION['gabinete_original'] === $espacio_ses;

    $espacio_sigue_disponible =
        $es_gabinete_original || // ← el gabinete propio siempre es válido al editar
        ($tipo_ses !== '' &&
         isset($gabinetes_disponibles[$tipo_ses]) &&
         in_array($espacio_ses, $gabinetes_disponibles[$tipo_ses]));

    if (!$espacio_sigue_disponible) {
        unset($_SESSION['memoria_ingreso']['espacio_almacenamiento']);
        unset($_SESSION['memoria_ingreso']['folio']);
        // Solo limpiamos el tipo si ese tipo ya no tiene espacios libres
        if (empty($gabinetes_disponibles[$tipo_ses])) {
            unset($_SESSION['memoria_ingreso']['tipo_almacenamiento']);
        }
        if (!isset($_SESSION['error_espacio'])) {
            $_SESSION['error_espacio'] = "El espacio que tenías seleccionado ya no está disponible. Por favor, elige otro.";
        }
    }
}