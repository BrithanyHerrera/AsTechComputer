<?php
require_once __DIR__ . "/../config/conexion.db.php";
require_once __DIR__ . "/../models/index_model.php";

// Obtener datos primero
$info = obtenerInfoIndex($conexion);

// Validar si viene vacío
if (!$info) {
    $info = [
        'quienes_somos' => 'Información pendiente de cargar desde la base de datos.',
        'mision' => '',
        'vision' => '',
        'frase_fundador' => ''
    ];
}

$base_url = "../../";

// Ahora sí incluir la vista
include __DIR__ . "/../views/index_view.php";