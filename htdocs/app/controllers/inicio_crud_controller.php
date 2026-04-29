<?php
/**
 * PÁGINA: Procesador de Actualización de Inicio - As Tech Computer (controlador de edición)
 * PROPÓSITO: Gestionar de forma centralizada la actualización de los textos informativos 
 * de la página principal (index) mediante peticiones POST.
 * FUNCIONALIDADES:
 * - Carga de dependencias: Incluye la conexión a la base de datos y la configuración global (BASE_URL).
 * - Control de acceso: Procesa la información únicamente si el método de solicitud es POST.
 * - Validación de Datos: Captura y limpia las variables enviadas (quienes somos, misión, visión, frase) 
 * utilizando el operador de fusión de nulidad (??) para evitar errores de variables no definidas.
 * - Lógica Modular (Switch): Identifica qué sección específica se desea editar ('portada', 'mision' o 'ceo') 
 * para ejecutar actualizaciones quirúrgicas en la tabla 'informacion_index'.
 * - Seguridad SQL: Implementa Consultas Preparadas (Prepared Statements) con 'bind_param' para 
 * blindar la base de datos contra ataques de Inyección SQL.
 * - Persistencia: Actualiza registros específicos vinculados al ID 1, asegurando la integridad 
 * de la información institucional.
 * - Gestión de Flujo: Redirecciona automáticamente al panel de administración tras completar la 
 * operación para evitar el reenvío duplicado de formularios al recargar la página.
 */
?>


<?php
require_once __DIR__ . "/../config/conexion.db.php";
require_once dirname(__DIR__) . '/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $seccion = $_POST['seccion_editada'];

    // Valores (evitar undefined)
    $quienes = $_POST['titulo'] ?? null;
    $mision = $_POST['mision'] ?? null;
    $vision = $_POST['vision'] ?? null;
    $frase = $_POST['frase'] ?? null;

    // Dependiendo de la sección, actualizas SOLO lo necesario
    switch ($seccion) {

        case 'portada':
            $stmt = $conexion->prepare("UPDATE informacion_index SET quienes_somos=? WHERE id=1");
            $stmt->bind_param("s", $quienes);
            break;

        case 'mision':
            $stmt = $conexion->prepare("UPDATE informacion_index SET mision=?, vision=? WHERE id=1");
            $stmt->bind_param("ss", $mision, $vision);
            break;

        case 'ceo':
            $stmt = $conexion->prepare("UPDATE informacion_index SET frase_fundador=? WHERE id=1");
            $stmt->bind_param("s", $frase);
            break;
    }

    $stmt->execute();

    // Redirigir para evitar reenvío de formulario
    header("Location: " . BASE_URL . "app/views/administracion_view.php?seccion=inicio");
    exit;
}