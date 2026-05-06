<?php
// ========================================================
// PAGINA: servicios_crud_controller.php
// UBICACIÓN: app/controllers/servicios_crud_controller.php
// VISTA:servicios_crud_view.php
// MODELO: servicios_crud_model.php
//esta pagina controla el crud de la seccionde servicios de el panel
//hace las acciones de guardar, eliminar y editar en la base de datos
// ========================================================

//conexion
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/servicios_crud_model.php'; 
require_once dirname(__DIR__) . '/config/config.php'; 

$modelo = new ServicioCrudModel($conexion); 
$modeloServicios = $modelo;

$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';
$id_tipo = isset($_GET['id_tipo_servicio']) ? $_GET['id_tipo_servicio'] : null;



// Reemplaza la lógica de búsqueda actual por esta:
$filtros = [
    'busqueda'   => $_GET['busqueda'] ?? '',
    'id_tipo'    => $_GET['filtro_tipo'] ?? '',
    'precio_max' => $_GET['precio_max'] ?? ''
];

// Si hay cualquier filtro activo, usamos la búsqueda avanzada
if (!empty($filtros['busqueda']) || !empty($filtros['id_tipo']) || !empty($filtros['precio_max'])) {
    $resultado = $modelo->buscarServiciosAvanzado($filtros);
} else {
    // Si no hay filtros, podrías usar obtenerServicios() o el mismo avanzado vacío
    $resultado = $modelo->buscarServiciosAvanzado([]); 
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
        header("Location: " . BASE_URL . "app/views/administracion_view.php?seccion=servicios&status=error&msg=campos_vacios");
    } else {
        try {
            if ($modelo->agregarServicio($datos)) {
                header("Location: " . BASE_URL . "app/views/administracion_view.php?seccion=servicios&status=success");
            }
        } catch (Exception $e) {
            header("Location: " . BASE_URL . "app/views/administracion_view.php?seccion=servicios&status=error");
        }
    }
    exit();
}

// EDITAR
if ($accion == 'editar' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = $_POST;
    try {
        if ($modelo->editarServicio($datos)) {
            header("Location: " . BASE_URL . "app/views/administracion_view.php?seccion=servicios&status=success");
        }
    } catch (Exception $e) {
        header("Location: " . BASE_URL . "app/views/administracion_view.php?seccion=servicios&status=error");
    }
    exit();
}

// ELIMINAR
if ($accion == 'eliminar' && isset($_GET['id'])) {
    if ($modelo->eliminarServicio($_GET['id'])) {
        header("Location: " . BASE_URL . "app/views/administracion_view.php?seccion=servicios&status=success");
    }
    exit();
}




?>