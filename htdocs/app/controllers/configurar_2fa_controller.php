<?php
// UBICACIÓN: app/controllers/configurar_2fa_controller.php
session_start();

// Si alguien intenta entrar sin haber pasado por el login, lo saca
if (!isset($_SESSION['temp_empleado']) || !isset($_SESSION['qr_image'])) {
    header("Location: ../../index.php");
    exit;
}

// Si pasó la validación de seguridad, cargamos la vista (el HTML)
require_once __DIR__ . '/../views/acciones/configurar_2fa_view.php';
?>