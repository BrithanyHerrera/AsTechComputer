<?php
/* REGISTRO_MARCA_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de Registro de Marca - As Tech Computer
 * PROPÓSITO: Gestionar el acceso a la sección informativa sobre el registro legal de la marca, actuando como enlace operativo dentro de la arquitectura MVC.
 * FUNCIONALIDADES:
 * - Invocación directa y segura de la Vista correspondiente a los detalles del registro de marca.
 * - Implementación de rutas absolutas blindadas mediante dirname(__DIR__) para garantizar el despliegue del contenido independientemente de la ubicación del usuario en la estructura de directorios del servidor, eliminando fallos por reubicación.
 */

/* ========================================================
   1. RENDERIZACIÓN DE LA VISTA
   ======================================================== */
/**
 * El sistema intercepta la petición del usuario y procesa la carga 
 * de la interfaz gráfica correspondiente utilizando una ruta absoluta 
 * dinámica. Esto asegura que el archivo visual se localice de manera 
 * precisa y se integre de forma segura en la plataforma.
 */
require_once dirname(__DIR__) . '/views/registro_marca_view.php';
?>