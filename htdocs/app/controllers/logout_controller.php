<?php
// ========================================================
// CONTROLADOR: logout_controller.php
// UBICACIÓN: app/controllers/logout_controller.php
// ========================================================

// 1. Reanudamos la sesión actual para saber cuál borrar
session_start();

// 2. Vaciamos todas las variables de sesión (id_empleado, nombre, etc.)
session_unset();

// 3. Destruimos la sesión por completo en el servidor
session_destroy();

// 4. Redirigimos de vuelta al controlador del login
header("Location: login_controller.php");
exit;
?>