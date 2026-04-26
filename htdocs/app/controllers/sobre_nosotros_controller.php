<?php
/* SOBRE_NOSOTROS_CONTROLLER.PHP */
/*
Este archivo constituye el componente Controlador dentro del patrón de diseño MVC para la sección institucional. Su responsabilidad principal es actuar como el gestor de tráfico que procesa la solicitud de acceso a la información corporativa. En lugar de contener código visual, su lógica se limita a realizar la llamada técnica a la Vista correspondiente mediante una ruta absoluta protegida. Este enfoque garantiza que la estructura del servidor permanezca organizada y que la presentación de la "Misión, Visión y Valores" se despliegue de manera eficiente y segura.
*/
require_once dirname(__DIR__) . '/views/sobre_nosotros_view.php';
    require_once __DIR__ . "/../config/config.php"; 
?>