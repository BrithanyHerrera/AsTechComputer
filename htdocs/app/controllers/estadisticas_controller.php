<?php
// ========================================================
// CONTROLADOR: estadisticas_controller.php
// UBICACIÓN: app/controllers/estadisticas_controller.php
//
// Responsabilidad: Validar sesión, llamar al Modelo para
// obtener los 5 datasets y convertirlos a JSON para que
// el JS de Chart.js pueda leerlos directamente.
// No escribe SQL ni HTML directamente.
// ========================================================

// Iniciamos sesión para leer los datos del empleado logueado
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Solo Admin (4) y Gerente (3) pueden ver estadísticas
if (!isset($_SESSION['id_empleado']) || $_SESSION['id_puesto'] < 3) {
    header("Location: ../../index.php");
    exit;
}

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/estadisticas_model.php';

$modelo = new EstadisticasModel($conexion);

// ----------------------------------------------------------
// DATASET 1: Tipos de dispositivos
// ----------------------------------------------------------
$datosDispositivos = [];
$res = $modelo->obtenerDispositivos();
if ($res) { while ($f = $res->fetch_assoc()) { $datosDispositivos[] = $f; } }

// ----------------------------------------------------------
// DATASET 2: Medios de contacto (Marketing)
// ----------------------------------------------------------
$datosMarketing = [];
$resM = $modelo->obtenerMedios();
if ($resM) { while ($f = $resM->fetch_assoc()) { $datosMarketing[] = $f; } }

// ----------------------------------------------------------
// DATASET 3: Frecuencia de servicio
// ----------------------------------------------------------
$datosFrecuencia = [];
$resF = $modelo->obtenerFrecuencia();
if ($resF) { while ($f = $resF->fetch_assoc()) { $datosFrecuencia[] = $f; } }

// ----------------------------------------------------------
// DATASET 4: Tipo de uso del equipo
// ----------------------------------------------------------
$datosUso = [];
$resU = $modelo->obtenerUso();
if ($resU) { while ($f = $resU->fetch_assoc()) { $datosUso[] = $f; } }

// ----------------------------------------------------------
// DATASET 5: Nuevos vs Recurrentes
// Transformamos "si/no" en etiquetas legibles para la gráfica
// ----------------------------------------------------------
$datosNuevos = [];
$resN = $modelo->obtenerNuevosRecurrentes();
if ($resN) {
    while ($f = $resN->fetch_assoc()) {
        $f['etiqueta'] = ($f['etiqueta'] == 'si') ? 'Primera vez' : 'Cliente frecuente';
        $datosNuevos[] = $f;
    }
}

// ----------------------------------------------------------
// PREPARAR JSON para que el JS de Chart.js los lea
// Las variables $json_* se imprimen en la vista dentro de
// etiquetas <script> para pasarlas al navegador.
// ----------------------------------------------------------
$json_dispositivos = json_encode(array_column($datosDispositivos, 'etiqueta'));
$json_dispositivos_total = json_encode(array_column($datosDispositivos, 'total'));

$json_marketing = json_encode(array_column($datosMarketing, 'etiqueta'));
$json_marketing_total = json_encode(array_column($datosMarketing, 'total'));

$json_frecuencia = json_encode(array_column($datosFrecuencia, 'etiqueta'));
$json_frecuencia_total = json_encode(array_column($datosFrecuencia, 'total'));

$json_uso = json_encode(array_column($datosUso, 'etiqueta'));
$json_uso_total = json_encode(array_column($datosUso, 'total'));

$json_nuevos = json_encode(array_column($datosNuevos, 'etiqueta'));
$json_nuevos_total = json_encode(array_column($datosNuevos, 'total'));
?>