<?php
// ========================================================
// CONTROLADOR: contacto_controller.php
// UBICACIÓN: app/controllers/contacto_controller.php
// ========================================================
        require_once __DIR__ . "/../config/config.php"; 

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/contacto_model.php';


$modeloContacto = new ContactoModel($conexion);


$status = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre  = $_POST['nombre'];
    $email   = $_POST['email'];
    $asunto  = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    try {
        if ($modeloContacto->guardarMensaje($nombre, $email, $asunto, $mensaje)) {
            $status = "success";
        }
    } catch (Exception $e) {
   
        $status = $e->getMessage(); 
    }
}


require_once dirname(__DIR__) . '/views/contacto_view.php';
?>