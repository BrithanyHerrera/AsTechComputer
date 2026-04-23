<?php
/* POLÍTICA_SERVICIOS_CONTROLLER.PHP */
/* 
Este archivo funge como el Controlador (Controller) designado para gestionar el despliegue de la Política de Servicios. Su responsabilidad técnica se limita a procesar la solicitud de la página e invocar la Vista correspondiente mediante el uso de una ruta absoluta blindada. Esto asegura que el texto legal se cargue de manera segura y precisa, independientemente del entorno de alojamiento del sistema.
*/

// Cargamos la vista usando la ruta absoluta blindada
require_once dirname(__DIR__) . '/views/politica_servicios_view.php';
?>