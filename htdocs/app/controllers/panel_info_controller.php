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
        $total_paginas = 1;
        $pagina_actual = 1;

        if ($es_admin) {
            $filtros = [
                'nombre'       => $_GET['filtro_nombre'] ?? '',
                'puesto'       => $_GET['filtro_puesto'] ?? '',
                'fecha_inicio' => $_GET['filtro_fecha_inicio'] ?? '',
                'fecha_fin'    => $_GET['filtro_fecha_fin'] ?? ''
            ];
            
            // Lógica de Paginación
            $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 50; // Por defecto 50
            $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            if ($pagina_actual < 1) $pagina_actual = 1;
            
            $offset = ($pagina_actual - 1) * $limite;

            $total_registros = $this->model->contarConexiones($filtros);
            $total_paginas = ceil($total_registros / $limite);

            $actividad_reciente = $this->model->obtenerConexiones($filtros, $limite, $offset);
        }

        require_once '../views/secciones/panel_info.php';
    }
}

$controller = new DashboardController($conexion);
$controller->cargarDashboard();
?>