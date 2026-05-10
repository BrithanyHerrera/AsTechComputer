<?php
// ========================================================
// CONTROLADOR: contacto_controller.php
// UBICACIÓN: app/controllers/contacto_controller.php
//se encarga de procesar el formulario de contacto: recibe los datos enviados por el usuario, 
//los valida y los guarda en la base de datos mediante el modelo. 
//También maneja el estado de la operación (éxito o error)
//finalmente carga la vista para mostrar la página de contacto.
// ========================================================

//urls
require_once __DIR__ . "/../config/config.php"; 
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/contacto_model.php';


$modeloContacto = new ContactoModel($conexion);
//guarda los mensajes en la base de datos
$status = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim elimina espacios al inicio y final
    $nombre  = trim($_POST['nombre']);
    $email   = trim($_POST['email']);
    $asunto  = trim($_POST['asunto']);
    $mensaje = trim($_POST['mensaje']);

    // Validación de campos vacíos y formato de email
    if (empty($nombre) || empty($mensaje) || empty($asunto)) {
        $status = "No se permiten campos vacíos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $status = "El formato del correo es inválido.";
    } elseif (preg_match('/^[^a-zA-Z0-9]+$/', $mensaje)) {
        // Verifica si el mensaje contiene SOLO símbolos
        $status = "El mensaje no puede contener solo símbolos.";
    } else {
        try {
            if ($modeloContacto->guardarMensaje($nombre, $email, $asunto, $mensaje)) {
                $status = "success";
            }
        } catch (Exception $e) {
            $status = $e->getMessage(); 
        }
    }
}

require_once dirname(__DIR__) . '/views/contacto_view.php';
?>