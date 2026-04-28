<?php
/* aviso_privacidad_controller.php */

/*
Este archivo actúa como el Controlador (Controller) encargado de gestionar el acceso a la sección legal del Aviso de Privacidad. Su responsabilidad dentro de la arquitectura MVC consiste en servir de enlace operativo, invocando la carga de la Vista correspondiente mediante el uso de rutas absolutas blindadas. Esto asegura que el contenido legal se despliegue correctamente de manera independiente a la ubicación del usuario dentro de la estructura de directorios del servidor.
*/

// Cargamos la vista usando la ruta absoluta blindada
require_once dirname(__DIR__) . '/views/aviso_privacidad_view.php';
?>