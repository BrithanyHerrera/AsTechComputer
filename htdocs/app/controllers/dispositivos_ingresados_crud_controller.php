<?php
// ========================================================
// CONTROLADOR: dispositivos_ingresados_crud_controller.php
// UBICACIÓN: app/controllers/dispositivos_ingresados_crud_controller.php
//
// Responsabilidad: Recibir peticiones (GET/POST), decidir
// qué acción ejecutar, llamar al Modelo y preparar las
// variables que la Vista necesita para dibujarse.
// No escribe SQL ni HTML directamente.
// ========================================================

// Iniciamos sesión si aún no está activa
// (necesario para leer $_SESSION['id_puesto'])
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/dispositivos_ingresados_crud_model.php';

// Instanciamos el modelo pasándole la conexión activa
$modeloRegistros = new RegistrosModel($conexion);

// Capturamos la acción solicitada desde la URL (ej. ?accion=entregar)
$accion = $_GET['accion'] ?? '';

// ----------------------------------------------------------
// VARIABLE PARA LA VISTA
// El puesto del usuario logueado controla qué columnas y
// botones se muestran (ej. los técnicos ven datos limitados)
// ----------------------------------------------------------
$puesto_usuario = $_SESSION['id_puesto'] ?? 0;

// ----------------------------------------------------------
// PROCESAMIENTO DE ACCIONES POST
// Solo entramos aquí si el formulario fue enviado
// ----------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ACCIÓN: Marcar equipo como entregado y liberar gabinete
    if ($accion == 'entregar') {
        $modeloRegistros->entregarEquipo($_POST['folio'], $_POST['id_gabinete']);
        header("Location: administracion_controller.php?seccion=registros_ingresados_crud_view");
        exit;
    }

    // ACCIÓN: Editar datos de la orden y del cliente
    if ($accion == 'editar') {
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
        header("Location: administracion_controller.php?seccion=registros_ingresados_crud_view&status=success_edit");
        exit;
    }
}

// ----------------------------------------------------------
// PREPARAR DATOS PARA LA VISTA
// Si no hubo acción POST (o ya fue procesada), cargamos
// todos los registros para mostrar en la tabla.
// ----------------------------------------------------------
$lista_registros = $modeloRegistros->obtenerRegistros();
?>