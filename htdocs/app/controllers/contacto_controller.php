<?php
// ========================================================
// CONTROLADOR: contacto_controller.php
// UBICACIÓN: app/controllers/contacto_controller.php
// ========================================================

// 1. Subimos un nivel (a la carpeta app) y requerimos la BD y el Modelo
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/contacto_model.php';

// 2. Instanciamos el modelo
$modeloContacto = new ContactoModel($conexion);

// 3. Variable para controlar la alerta
$status = ""; 

// 4. Lógica de inserción si viene un POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre  = $_POST['nombre'];
    $email   = $_POST['email'];
    $asunto  = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    try {
        if ($modeloContacto->guardarMensaje($nombre, $email, $asunto, $mensaje)) {
            $status = "success";
        } else {
            $status = "error";
        }
    } catch (Exception $e) {
        $status = "error";
    }
}

// 5. Cargar la vista
require_once dirname(__DIR__) . '/views/contacto_view.php';
?>