<?php
// ========================================================
// CONTROLADOR: registros_controller.php
// UBICACIÓN: app/controllers/dispositivos_ingresados_crud_controller.php
// ========================================================

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/dispositivos_ingresados_crud_model.php';

$modeloRegistros = new RegistrosModel($conexion);
$accion = $_GET['accion'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($accion == 'entregar') {
        $modeloRegistros->entregarEquipo($_POST['folio'], $_POST['id_gabinete']);
        header("Location: administracion_controller.php?seccion=registros_ingresados_crud_view");
        exit;
    }
    
    if ($accion == 'editar') {
        // Le pasamos la información de la orden y la del cliente
        $modeloRegistros->actualizarRegistro(
            $_POST['folio'], 
            $_POST['estado'], 
            $_POST['condicion_fisica'], 
            $_POST['accesorios_entregados'], 
            $_POST['observaciones_recepcion'],
            $_POST['id_cliente'],
            $_POST['nombre_cliente'],
            $_POST['apellido_cliente'],
            $_POST['telefono_cliente']
        );
        header("Location: administracion_controller.php?seccion=registros_ingresados_crud_view");
        exit;
    }
}

$lista_registros = $modeloRegistros->obtenerRegistros();
?>