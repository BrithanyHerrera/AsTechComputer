<?php
require_once '../config/conexion.db.php';
require_once '../models/panel_info_model.php';

class DashboardController {
    private $model;

    public function __construct($conexion) {
        $this->model = new DashboardModel($conexion);
    }

    public function cargarDashboard() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        $id_empleado_actual = $_SESSION['id_empleado'] ?? 1; 

        $usuario = $this->model->obtenerInfoUsuario($id_empleado_actual);
        $es_admin = ($usuario['id_puesto'] == 3 || $usuario['id_puesto'] == 4);

        $actividad_reciente = [];
        if ($es_admin) {
            // NUEVO: Capturar los filtros de la URL (si existen)
            $filtros = [
                'nombre' => $_GET['filtro_nombre'] ?? '',
                'puesto' => $_GET['filtro_puesto'] ?? '',
                'fecha'  => $_GET['filtro_fecha'] ?? ''
            ];
            
            // Pasamos los filtros al modelo
            $actividad_reciente = $this->model->obtenerConexiones($filtros);
        }

        require_once '../views/secciones/panel_info.php';
    }
}

$controller = new DashboardController($conexion);
$controller->cargarDashboard();
?>