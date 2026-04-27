<?php
 require_once __DIR__ . "/../config/config.php"; 
/* ADMINISTRACION_CONTROLLER.PHP */
/*
Este archivo actúa como el Controlador Maestro (Front Controller) del panel de administración. Su responsabilidad dentro del patrón arquitectónico MVC es centralizar el enrutamiento del sistema. Captura la solicitud del usuario mediante la URL, ejecuta en segundo plano los controladores secundarios (para preparar datos como registros de base de datos o variables de estado) y, finalmente, despliega la Vista Maestra, inyectándole toda la información previamente procesada de manera limpia y segura.
*/
/* ========================================================
   GESTIÓN DE ENRUTAMIENTO PRINCIPAL (GET)
   ======================================================== */
/*

El sistema captura el parámetro 'seccion' a través de la URL (método GET).
Si no se especifica ninguna ruta, establece 'dashboard' como valor 
predeterminado para garantizar la carga correcta del panel de inicio.
 */
$seccion_actual = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';

/* ========================================================
   EJECUCIÓN DINÁMICA DE CONTROLADORES SECUNDARIOS
   ======================================================== */
/*
El controlador maestro actúa como un gestor de tráfico, delegando 
responsabilidades y ejecutando la lógica de negocio específica 
(operaciones de base de datos, preparación de variables) antes del HTML.
*/
if ($seccion_actual === 'citas') {
    require_once 'citas_crud_controller.php';
} elseif ($seccion_actual === 'ingreso') {
    // Al cargarse aquí, ejecuta las consultas de la BD y crea variables vitales
    // (como $paso) para que la vista pueda consumirlas de la memoria posteriormente.
    require_once 'ingreso_controller.php'; 
}

/* ========================================================
   ESPACIO PARA VALIDACIONES DE SEGURIDAD (FUTURO)
   ======================================================== */
/*
En este bloque, el sistema podrá incorporar posteriormente las validaciones
de sesión y controles de acceso, garantizando que el usuario se encuentre
autenticado antes de continuar con la ejecución de la vista.
*/

/* ========================================================
   RENDERIZACIÓN DE LA VISTA MAESTRA
   ======================================================== */
/*
Una vez preparada toda la lógica y los datos en segundo plano, el sistema 
invoca la carga de la interfaz gráfica principal. Se utiliza la constante
de directorio absoluto para asegurar la portabilidad y seguridad de la ruta.
*/
require_once dirname(__DIR__) . '/views/administracion_view.php';
?>