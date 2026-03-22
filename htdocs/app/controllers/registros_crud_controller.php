<?php
// ========================================================
// CONTROLADOR: registros_controller.php
// UBICACIÓN: app/controllers/registros_controller.php
// ========================================================

require_once dirname(__DIR__) . '/models/registros_crud_model.php';

// Aunque aún no usamos la BD, le pasamos $conexion por si ya está definida 
// en el controlador principal (administracion_controller.php)
$modeloRegistros = new RegistrosModel($conexion ?? null);

// Obtenemos la lista de ingresos y la guardamos en una variable
$lista_registros = $modeloRegistros->obtenerRegistros();

// Fin del controlador. La vista será incluida por administracion_view.php
?>