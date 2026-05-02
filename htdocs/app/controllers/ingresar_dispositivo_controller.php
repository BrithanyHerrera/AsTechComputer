<?php
/* INGRESAR_DISPOSITIVO_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de Ingreso de Dispositivos - As Tech Computer
 * PROPÓSITO: Gestionar la lógica de negocio, validación y persistencia de datos del asistente (wizard) de 5 pasos para el registro o edición de equipos en sucursal.
 * FUNCIONALIDADES: 
 * - Manejo seguro de sesiones para almacenar progresivamente los datos ingresados en cada paso sin perder información al retroceder.
 * - Control de "Modo Edición": Carga y mapea los datos existentes de un equipo desde la base de datos hacia la memoria de sesión.
 * - Sanitización automática de entradas (conversión a mayúsculas, eliminación de espacios) para estandarizar la base de datos.
 * - Autocompletado inteligente: Extrae datos de citas agendadas y los inyecta en la sesión para agilizar el registro.
 * - Validación estricta de concurrencia: Verifica en tiempo real (Paso 5) si el espacio de almacenamiento (gabinete) sigue disponible antes de concretar la inserción, previniendo colisiones.
 * - Preparación de catálogos y serialización en formato JSON para alimentar los selectores dinámicos de la Vista.
 */

/* =============================================================
   1. INICIALIZACIÓN DE SESIÓN Y DEPENDENCIAS
   ============================================================= */
// El sistema verifica si no existe una sesión activa y la inicia para 
// poder utilizar la persistencia temporal de datos a través de los pasos.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/ingresar_dispositivo_model.php';

// Instanciación del modelo que gestiona la comunicación con la base de datos.
$model = new IngresoModel($conexion);

/* =============================================================
   2. CONTROL DE MODO EDICIÓN Y LIMPIEZA DE SESIÓN
   ============================================================= */
// El sistema verifica si el usuario accede mediante una URL limpia (sin parámetros de edición). 
// De ser así, purga la memoria de sesión para garantizar un registro completamente nuevo.
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['retorno']) && !isset($_GET['editar'])) {
    unset($_SESSION['memoria_ingreso'], $_SESSION['modo_edicion'], $_SESSION['id_cliente_edicion'], $_SESSION['id_equipo_edicion'], $_SESSION['gabinete_original']);
}

// Si se detecta el parámetro de edición y aún no se ha activado el modo, 
// el controlador extrae la información completa del registro desde la base de datos.
if (isset($_GET['editar']) && !isset($_SESSION['modo_edicion'])) {
    $folio_editar = $_GET['editar'];
    $db_data = $model->obtenerDatosPorFolio($folio_editar);

    if ($db_data) {
        // Se activan los candados de edición almacenando los identificadores clave en la sesión.
        $_SESSION['modo_edicion']       = $folio_editar;
        $_SESSION['id_cliente_edicion'] = $db_data['id_cliente'];
        $_SESSION['id_equipo_edicion']  = $db_data['id_equipo'];
        $_SESSION['gabinete_original']  = $db_data['id_gabinete'];

        // Se configuran mapas inversos para traducir los identificadores numéricos 
        // de la base de datos a los valores de texto requeridos por los botones de radio del formulario.
        $m_uso  = [1=>'estudio', 2=>'oficina', 3=>'disenio_edicion', 4=>'gaming'];
        $m_frec = [1=>'1_vez_anio', 2=>'2-3_veces_anio', 3=>'mas_3_anio', 4=>'descompone'];
        $m_orig = [1=>'recomendacion', 2=>'redes_sociales', 3=>'google_web']; 
        
        $origen_cargado = '';
        if ($db_data['id_medio_contacto'] == 4) {
            $origen_cargado = $db_data['medio_contacto_otro'];
        } else {
            $origen_cargado = $m_orig[$db_data['id_medio_contacto']] ?? '';
        }

        // Se inyecta la información extraída directamente en la memoria del asistente.
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

        // Se recupera el tipo de almacenamiento (numérico/letras) asignado al gabinete actual.
        $r_gab = $model->obtenerTipoGabinete($db_data['id_gabinete']);
        if ($r_gab) $_SESSION['memoria_ingreso']['tipo_almacenamiento'] = $r_gab['tipo_espacio'];
    }
}

/* =============================================================
   3. GUARDADO PROGRESIVO EN MEMORIA Y SANITIZACIÓN (POST)
   ============================================================= */
// El sistema captura el envío parcial del formulario para guardar el progreso.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // El sistema aplica un proceso de sanitización y estandarización de datos 
    // (conversión a mayúsculas y limpieza de espacios) previo a su almacenamiento temporal.
    if (isset($_POST['nombre_cliente'])) {
        $_POST['nombre_cliente'] = mb_strtoupper(trim($_POST['nombre_cliente']), 'UTF-8');
    }
    if (isset($_POST['apellido_cliente'])) {
        $_POST['apellido_cliente'] = mb_strtoupper(trim($_POST['apellido_cliente']), 'UTF-8');
    }
    if (isset($_POST['correo_cliente'])) {
        $_POST['correo_cliente'] = strtolower(trim($_POST['correo_cliente']));
    }
    if (isset($_POST['telefono_cliente'])) {
        $_POST['telefono_cliente'] = trim($_POST['telefono_cliente']);
    }

    // Se recorre el POST y se almacenan las variables en la sesión, omitiendo comandos de control de flujo.
    foreach ($_POST as $key => $value) {
        if ($key !== 'step' && $key !== 'finalizar_registro') {
            $_SESSION['memoria_ingreso'][$key] = $value;
        }
    }

    // Autocompletado: Si el técnico selecciona una cita previa, el sistema extrae los detalles 
    // desde la base de datos y los inyecta en la sesión para prellenar los pasos subsiguientes.
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

/* =============================================================
   4. GUARDADO FINAL Y VALIDACIÓN DE CONCURRENCIA
   ============================================================= */
// Al recibir la orden de finalizar, el sistema procede a intentar la inserción o actualización final.
if (isset($_POST['finalizar_registro'])) {
    $datos = $_SESSION['memoria_ingreso'];

    // Validación Crítica de Concurrencia: Antes de persistir los datos, el sistema verifica que 
    // el espacio físico (gabinete) siga disponible, evitando colisiones si otro técnico lo ocupó simultáneamente.
    $espacio_elegido = $datos['espacio_almacenamiento'] ?? '';
    $gabinete_actual = $model->verificarEstadoGabinete($espacio_elegido);

    $es_mismo_gabinete_original = isset($_SESSION['gabinete_original']) &&
                                  $_SESSION['gabinete_original'] === $espacio_elegido;

    if (!$gabinete_actual || ($gabinete_actual['estado'] !== 'disponible' && !$es_mismo_gabinete_original)) {
        // En caso de conflicto, se purga la asignación del espacio de la memoria 
        // y se redirige al usuario de vuelta al Paso 2 con una notificación visual.
        unset($_SESSION['memoria_ingreso']['espacio_almacenamiento'], $_SESSION['memoria_ingreso']['folio'], $_SESSION['memoria_ingreso']['tipo_almacenamiento']);
        $_SESSION['error_espacio'] = "El espacio <strong>{$espacio_elegido}</strong> ya no está disponible. Elige otro espacio.";
        
        header("Location: administracion_controller.php?seccion=ingreso&retorno=2");
        exit;
    }

    try {
        if (isset($_SESSION['modo_edicion'])) {
            // El sistema ejecuta la actualización de los registros y limpia la memoria tras el éxito.
            $model->actualizarRegistro(
                $datos, $_SESSION['modo_edicion'], $_SESSION['id_cliente_edicion'], $_SESSION['id_equipo_edicion'], $_SESSION['gabinete_original']
            );
            unset($_SESSION['memoria_ingreso'], $_SESSION['modo_edicion'], $_SESSION['id_cliente_edicion'], $_SESSION['id_equipo_edicion'], $_SESSION['gabinete_original']);
            
            header("Location: administracion_controller.php?seccion=registrosCRUD&status=success_edit");
            exit;

        } else {
            // El sistema ejecuta la creación de nuevos registros, limpia la memoria y levanta la bandera de éxito.
            $model->crearRegistro($datos);
            unset($_SESSION['memoria_ingreso']);
            $_SESSION['mensaje_exito'] = true; 
            
            header("Location: administracion_controller.php?seccion=ingreso&status=success");
            exit;
        }

    } catch (Exception $e) {
        // Captura de errores en las transacciones de base de datos, retornando al usuario al Paso 5.
        $_SESSION['error_db'] = "Error al guardar: " . $e->getMessage();
        header("Location: administracion_controller.php?seccion=ingreso&retorno=5");
        exit;
    }
}

/* =============================================================
   5. CONTROLADOR DE FLUJO Y NAVEGACIÓN DE PASOS
   ============================================================= */
// El sistema determina en qué paso del asistente se encuentra el usuario basándose 
// en los parámetros GET (para retornos de error) o POST (para navegación normal).
if (isset($_GET['retorno'])) {
    $paso = (int) $_GET['retorno'];
} elseif (isset($_POST['step'])) {
    $paso = (int) $_POST['step'];
} else {
    $paso = 1;
}

// Validación de límites para mantener el flujo entre 1 y 5.
if ($paso < 1) $paso = 1;
if ($paso > 5) $paso = 5;

/* =============================================================
   6. EXTRACCIÓN DE CATÁLOGOS PARA LA VISTA
   ============================================================= */
// El controlador recopila toda la información auxiliar desde la base de datos 
// que será requerida por la interfaz gráfica (técnicos, marcas, tipos).
$query_tecnicos = $model->obtenerTecnicos();
$query_marcas   = $model->obtenerMarcas();
$query_tipos    = $model->obtenerTiposEquipo();

$relaciones = $model->obtenerRelacionesEquipoMarca();
$json_relaciones = json_encode($relaciones);

// Se realiza la consulta de citas vigentes para alimentar el selector de autocompletado del Paso 1.
$citas_agendadas = $model->obtenerCitasPendientes();
$json_citas = json_encode($citas_agendadas);

// Se procesa la matriz de gabinetes disponibles. Esta consulta omite automáticamente
// los gabinetes ocupados (excepto el propio si se está editando), asegurando que el JavaScript 
// solo dibuje espacios válidos.
$gabinete_original_sesion = $_SESSION['gabinete_original'] ?? null;
$gabinetes_disponibles = $model->obtenerGabinetesDisponibles($gabinete_original_sesion);
$gabinetes_disponibles['otro'] = $gabinetes_disponibles['computadora_escritorio']; 
$json_gabinetes = json_encode($gabinetes_disponibles);

/* =============================================================
   7. DOBLE VALIDACIÓN VISUAL DE DISPONIBILIDAD (PASO 2)
   ============================================================= */
// Si el usuario regresa al Paso 2, el sistema re-evalúa si el gabinete previamente 
// guardado en sesión sigue estando libre. De no ser así, purga la selección para 
// forzar al usuario a escoger uno nuevo antes de continuar.
if ($paso == 2 && isset($_SESSION['memoria_ingreso']['espacio_almacenamiento'])) {
    $tipo_ses    = $_SESSION['memoria_ingreso']['tipo_almacenamiento'] ?? '';
    $espacio_ses = $_SESSION['memoria_ingreso']['espacio_almacenamiento'];

    $es_gabinete_original = isset($_SESSION['gabinete_original']) &&
                            $_SESSION['gabinete_original'] === $espacio_ses;

    $espacio_sigue_disponible =
        $es_gabinete_original || 
        ($tipo_ses !== '' &&
         isset($gabinetes_disponibles[$tipo_ses]) &&
         in_array($espacio_ses, $gabinetes_disponibles[$tipo_ses]));

    if (!$espacio_sigue_disponible) {
        unset($_SESSION['memoria_ingreso']['espacio_almacenamiento']);
        unset($_SESSION['memoria_ingreso']['folio']);
        
        if (empty($gabinetes_disponibles[$tipo_ses])) {
            unset($_SESSION['memoria_ingreso']['tipo_almacenamiento']);
        }
        if (!isset($_SESSION['error_espacio'])) {
            $_SESSION['error_espacio'] = "El espacio que tenías seleccionado ya no está disponible. Por favor, elige otro.";
        }
    }
}
?>