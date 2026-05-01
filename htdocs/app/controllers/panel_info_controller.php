<?php
// =============================================================
// panel_info_controller.php — Prepara todas las variables
// que la vista necesita. No incluye la vista.
// =============================================================

if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/panel_info_model.php';

$model = new DashboardModel($conexion);

$id_empleado_actual = $_SESSION['id_empleado'] ?? 1;

$usuario = $model->obtenerInfoUsuario($id_empleado_actual);
if (!$usuario) {
    $usuario = ['nombre' => 'Usuario', 'apellido' => 'Desconocido', 'nombre_puesto' => 'Sin Rol', 'id_puesto' => 0];
}

$es_admin = ($usuario['id_puesto'] == 3 || $usuario['id_puesto'] == 4);

// Valores para los filtros del formulario
$val_nombre      = $_GET['filtro_nombre']      ?? '';
$val_puesto      = $_GET['filtro_puesto']      ?? 'todos';
$val_fecha_inicio = $_GET['filtro_fecha_inicio'] ?? '';
$val_fecha_fin   = $_GET['filtro_fecha_fin']   ?? '';
$val_limite      = isset($_GET['limite']) ? (int)$_GET['limite'] : 50;

// Lista de puestos para el select del filtro
$puestos = $model->obtenerPuestos();

// Datos de la tabla y paginación
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

    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina_actual < 1) $pagina_actual = 1;

    $offset = ($pagina_actual - 1) * $val_limite;

    $total_registros = $model->contarConexiones($filtros);
    $total_paginas   = ceil($total_registros / $val_limite);
    if ($total_paginas < 1) $total_paginas = 1;

    $actividad_reciente = $model->obtenerConexiones($filtros, $val_limite, $offset);
}

// Constructor de URL para que los botones de paginación no pierdan los filtros
$params_url = $_GET;
unset($params_url['pagina']);
$url_base_paginacion = '?' . http_build_query($params_url) . '&pagina=';
?>