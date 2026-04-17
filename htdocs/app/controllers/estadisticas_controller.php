<?php
session_start();
// Validación de sesión (Solo admin/gerente)
if (!isset($_SESSION['id_empleado']) || $_SESSION['id_puesto'] < 3) {
    header("Location: ../../index.php"); exit;
}

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/estadisticas_model.php';

$modelo = new EstadisticasModel($conexion);

// Preparamos los datos para JavaScript
$datosDispositivos = [];
$res = $modelo->obtenerDispositivos();
while($f = $res->fetch_assoc()) { $datosDispositivos[] = $f; }

$datosMarketing = [];
$resM = $modelo->obtenerMedios();
while($f = $resM->fetch_assoc()) { $datosMarketing[] = $f; }

require_once dirname(__DIR__) . '/views/estadisticas_view.php';