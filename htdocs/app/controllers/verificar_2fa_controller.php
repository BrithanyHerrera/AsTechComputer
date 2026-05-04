<?php
// UBICACIÓN: app/controllers/verificar_2fa_controller.php
session_start();

// Si no hay sesión temporal, lo regresamos al login
if (!isset($_SESSION['temp_empleado'])) {
    header("Location: ../../index.php");
    exit;
}

// Si todo está bien, cargamos la vista
require_once __DIR__ . '/../views/acciones/verificar_2fa_view.php';
?>