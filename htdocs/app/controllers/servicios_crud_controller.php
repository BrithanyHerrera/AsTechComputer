<?php
// ========================================================
// CONTROLADOR: servicios_controller.php
// UBICACIÓN: app/controllers/servicios_controller.php
// ========================================================

// 1. PRIMERO: Cargar los archivos necesarios
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/servicios_crud_model.php'; // Verifica que la ruta sea correcta

// 2. SEGUNDO: Instanciar el modelo (Ahora sí la clase existe)
$modelo = new ServicioCrudModel($conexion); 
$modeloServicios = $modelo; // Mantengo ambos nombres por si los usas abajo

// 3. TERCERO: Capturar variables de control
$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';
$id_tipo = isset($_GET['id_tipo_servicio']) ? $_GET['id_tipo_servicio'] : null;



$busqueda = $_GET['busqueda'] ?? '';

if (!empty($busqueda)) {
    $servicios = $modelo->buscarServicios($busqueda);
} else {
    $servicios = $modelo->obtenerServicios(); // tu método normal
}
// --- PROCESAMIENTO DE ACCIONES ---

// AGREGAR
if ($accion == 'agregar' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = [
        'tipo_servicio'    => $_POST['tipo_servicio'] ?? '',
        'codigo_servicio' => $_POST['codigo_servicio'] ?? '',
        'id_tipo_servicio' => $_POST['id_tipo_servicio'] ?? '',
        'descripcion'      => $_POST['descripcion'] ?? '',
        'procedimiento'      => $_POST['procedimiento'] ?? '',
        'beneficios'      => $_POST['beneficios'] ?? '',
        'indicaciones'      => $_POST['indicaciones'] ?? '',
        'exclusiones'      => $_POST['exclusiones'] ?? '',
        'imagen_servicio'  => $_POST['imagen_servicio'] ?? '',
        'tiempo_estimado'  => $_POST['tiempo_estimado'] ?? '',
        'precio'           => $_POST['precio'] ?? 0,
        'estado'           => $_POST['estado'] ?? 'activo'
    ];

    if (empty($datos['tipo_servicio']) || empty($datos['precio'])) {
        header("Location: ../views/administracion_view.php?seccion=servicios&status=error&msg=campos_vacios");
    } else {
        try {
            if ($modelo->agregarServicio($datos)) {
                header("Location: ../views/administracion_view.php?seccion=servicios&status=success");
            }
        } catch (Exception $e) {
            header("Location: ../views/administracion_view.php?seccion=servicios&status=error");
        }
    }
    exit();
}

// EDITAR
if ($accion == 'editar' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = $_POST;
    try {
        if ($modelo->editarServicio($datos)) {
            header("Location: ../views/administracion_view.php?seccion=servicios&status=success");
        }
    } catch (Exception $e) {
        header("Location: ../views/administracion_view.php?seccion=servicios&status=error");
    }
    exit();
}

// ELIMINAR
if ($accion == 'eliminar' && isset($_GET['id'])) {
    if ($modelo->eliminarServicio($_GET['id'])) {
        header("Location: ../views/administracion_view.php?seccion=servicios&status=success");
    }
    exit();
}

// BUSCAR
if ($accion == 'buscar') {
    $q = $_GET['q'] ?? '';
    $resultado = $modelo->buscarServicios($q);
    while ($row = $resultado->fetch_assoc()) {
        echo "<div class='resultado-item'><strong>{$row['tipo_servicio']}</strong><br>$ {$row['precio']}</div>";
    }
    exit();
}


?>