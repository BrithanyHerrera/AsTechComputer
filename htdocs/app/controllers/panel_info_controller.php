<?php
/* PANEL_INFO_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador del Panel de Información (Dashboard Controller) - As Tech Computer
 * PROPÓSITO: Actuar como el intermediario (Controller) principal para la pantalla de inicio del panel de administración, preparando los datos del perfil del usuario, gestionando los filtros de búsqueda y calculando la paginación para la bitácora de actividad.
 * FUNCIONALIDADES:
 * - Inicio y validación segura de la sesión del empleado activo.
 * - Identificación del nivel de acceso (rol) para determinar si el usuario cuenta con privilegios de administrador (Puestos 3 o 4).
 * - Captura estructurada de parámetros de búsqueda enviados a través de la URL (método GET) para aplicar filtros dinámicos (nombre, puesto, rango de fechas).
 * - Interacción con el Modelo (DashboardModel) para extraer el catálogo de puestos, contar el total de registros coincidentes y obtener el historial de movimientos de manera paginada.
 * - Construcción dinámica de URLs para la botonera de paginación, asegurando que los filtros seleccionados no se pierdan al cambiar de página.
 */

/* =============================================================
   1. INICIO DE SESIÓN E INCLUSIÓN DE DEPENDENCIAS
   ============================================================= */
/**
 * El sistema verifica si no existe una sesión activa y la inicia. 
 * Posteriormente, carga las configuraciones de la base de datos y 
 * el modelo correspondiente a este controlador.
 */
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/panel_info_model.php';

// Instanciación del modelo para gestionar las consultas
$model = new DashboardModel($conexion);

/* =============================================================
   2. IDENTIFICACIÓN DEL USUARIO Y CONTROL DE ACCESOS
   ============================================================= */
/**
 * El sistema recupera el identificador del empleado desde la sesión y 
 * extrae su información de perfil. Si ocurre una anomalía, asigna 
 * valores genéricos de seguridad. Además, determina si el usuario 
 * tiene permisos de administrador (Roles 3 o 4).
 */
$id_empleado_actual = $_SESSION['id_empleado'] ?? 1;

$usuario = $model->obtenerInfoUsuario($id_empleado_actual);
if (!$usuario) {
    $usuario = ['nombre' => 'Usuario', 'apellido' => 'Desconocido', 'nombre_puesto' => 'Sin Rol', 'id_puesto' => 0];
}

$es_admin = ($usuario['id_puesto'] == 3 || $usuario['id_puesto'] == 4);

/* =============================================================
   3. CAPTURA DE PARÁMETROS DE FILTRADO (GET)
   ============================================================= */
/**
 * El sistema captura los valores enviados a través de la URL para 
 * los diferentes filtros de búsqueda, asignando valores predeterminados 
 * en caso de que el usuario no haya seleccionado ninguno.
 */
$val_nombre      = $_GET['filtro_nombre']      ?? '';
$val_puesto      = $_GET['filtro_puesto']      ?? 'todos';
$val_fecha_inicio = $_GET['filtro_fecha_inicio'] ?? '';
$val_fecha_fin   = $_GET['filtro_fecha_fin']   ?? '';
$val_limite      = isset($_GET['limite']) ? (int)$_GET['limite'] : 50;

// Se extrae el catálogo de puestos para rellenar la lista desplegable en la Vista
$puestos = $model->obtenerPuestos();

/* =============================================================
   4. LÓGICA DE PAGINACIÓN Y EXTRACCIÓN DE BITÁCORA
   ============================================================= */
/**
 * Se inicializan las variables de la tabla. Si el usuario es administrador, 
 * el sistema empaqueta los filtros, calcula el desplazamiento (offset) matemático 
 * para la paginación y solicita al modelo los registros exactos correspondientes 
 * a la página actual.
 */
$actividad_reciente = [];
$total_paginas      = 1;
$pagina_actual      = 1;

if ($es_admin) {
    $filtros = [
        'nombre'       => $val_nombre,
        'puesto'       => $val_puesto,
        'fecha_inicio' => $val_fecha_inicio,
        'fecha_fin'    => $val_fecha_fin
    ];

    // Validación de la página actual solicitada por el usuario
    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina_actual < 1) $pagina_actual = 1;

    $offset = ($pagina_actual - 1) * $val_limite;

    // Cálculo del total de páginas basado en los registros coincidentes
    $total_registros = $model->contarConexiones($filtros);
    $total_paginas   = ceil($total_registros / $val_limite);
    if ($total_paginas < 1) $total_paginas = 1;

    // Extracción final de la porción de datos a mostrar
    $actividad_reciente = $model->obtenerConexiones($filtros, $val_limite, $offset);
}

/* =============================================================
   5. CONSTRUCCIÓN DINÁMICA DE URLs PARA PAGINACIÓN
   ============================================================= */
/**
 * El sistema reconstruye la URL base tomando todos los parámetros GET 
 * actuales (los filtros aplicados), eliminando únicamente el indicador 
 * de página. Esto asegura que al presionar "Siguiente" o "Anterior", 
 * los filtros de búsqueda no se reinicien.
 */
$params_url = $_GET;
unset($params_url['pagina']);
$url_base_paginacion = '?' . http_build_query($params_url) . '&pagina=';
?>