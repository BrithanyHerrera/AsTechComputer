<?php
// Asegúrate de tener la conexión a la BD disponible aquí
require_once '../config/conexion.db.php';
require_once '../models/dashboard_model.php';

class DashboardController {
    private $model;

    public function __construct($conexion) {
        $this->model = new DashboardModel($conexion);
    }

    public function cargarDashboard() {
        // ASUMIMOS QUE TIENES EL ID DEL EMPLEADO EN LA SESIÓN (Iniciada en tu login)
        // session_start();
        // $id_empleado_actual = $_SESSION['id_empleado']; 
        
        // Para pruebas, forzaremos el ID 1 (Carlos López - Gerente)
        $id_empleado_actual = $_SESSION['id_empleado'] ?? 1; 

        // 1. Obtener info del usuario
        $usuario = $this->model->obtenerInfoUsuario($id_empleado_actual);
        
        // 2. Verificar si es Gerente/Administrador (id_puesto == 3)
        $es_admin = ($usuario['id_puesto'] == 3);

        // 3. Si es admin, cargar la bitácora
        $actividad_reciente = [];
        if ($es_admin) {
            $actividad_reciente = $this->model->obtenerConexiones();
        }

        // 4. Cargar la Vista pasándole los datos
        require_once '../views/secciones/dashboard_info.php';
    }
}

// Ejecutar el controlador (Dependiendo de tu enrutador, esto puede ir en otro archivo)
$controller = new DashboardController($conexion);
$controller->cargarDashboard();
?>