<?php
/* REGISTRO_MARCA_CONTROLLER.PHP */
/*
Este archivo actúa como el Controlador (Controller) responsable de gestionar el acceso a la sección de registro de marcas de ASTECH COMPUTER. Su tarea principal dentro del patrón arquitectónico MVC consiste en interceptar la petición del usuario e invocar la carga de la Vista correspondiente. Al utilizar una ruta absoluta generada dinámicamente, se asegura que el sistema localice el archivo visual de manera precisa, eliminando fallos por reubicación de carpetas y manteniendo una estructura de navegación robusta y profesional.
*/

// Cargamos la vista usando la ruta absoluta blindada
require_once dirname(__DIR__) . '/views/registro_marca_view.php';
?>