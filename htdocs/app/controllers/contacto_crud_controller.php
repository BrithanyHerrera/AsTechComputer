<?php
/**
 * PÁGINA: Controlador de Contacto - As Tech Computer (contacto_crud_controller.php)
 * PROPÓSITO: Gestionar el flujo de datos y las peticiones del usuario relacionadas con 
 * los mensajes de contacto, coordinando el modelo y las redirecciones de vista.
 * FUNCIONALIDADES:
 * - Carga de dependencias: Conexión a BD, modelo de contacto y archivos de configuración global.
 * - Procesamiento de Acciones mediante parámetros GET:
 * • Acción 'eliminar': Captura el ID del mensaje, invoca al modelo y redirige a la vista 
 * con un estado de confirmación (deleted) o error.
 * • Acción 'actualizar': Captura el ID y el nuevo estado del mensaje, actualiza la 
 * información y redirige con estado de éxito (success) o error.
 * - Preparación de datos para la vista:
 * • Ejecución automática de consulta de mensajes para poblar la tabla principal de la interfaz.
 * - Manejo de redirecciones seguras: Uso de constantes de URL base y finalización de scripts con exit().
 */
?>
<?php
require_once __DIR__ . "/../config/conexion.db.php";
require_once __DIR__ . "/../models/contacto_crud_model.php";
require_once dirname(__DIR__) . '/config/config.php'; // o como se llame tu archivo

$modelo = new ContactoModel($conexion);

// Lógica para acciones (Eliminar o Actualizar)
if (isset($_GET['action'])) {
    $id = $_GET['id'] ?? null;
    
    if ($_GET['action'] === 'eliminar' && $id) {
        if ($modelo->eliminarMensaje($id)) {
header("Location: " . BASE_URL . "app/controllers/administracion_controller.php?seccion=contacto&status=deleted");
        } else {
            header("Location: " . BASE_URL . "app/controllers/administracion_controller.php?seccion=contacto&status=error");
        }
        exit();
    }

    if ($_GET['action'] === 'actualizar' && $id && isset($_GET['estado'])) {
        if ($modelo->actualizarEstado($id, $_GET['estado'])) {
            header("Location: " . BASE_URL . "app/controllers/administracion_controller.php?seccion=contacto&status=success");
        } else {
           header("Location: " . BASE_URL . "app/controllers/administracion_controller.php?seccion=contacto&status=error");
        }
        exit();
    }
}

// Para la vista principal: obtener los datos
$resultado = $modelo->obtenerMensajes();
?>