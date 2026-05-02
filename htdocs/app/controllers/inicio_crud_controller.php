<?php
/**
 * PÁGINA: Procesador de Actualización de Inicio - As Tech Computer
 * PROPÓSITO: Actualizar la información de la página principal mediante solicitudes POST.
 * FUNCIONALIDADES:
 * - Carga de conexión y configuración.
 * - Validación y captura de datos enviados.
 * - Uso de switch para actualizar secciones específicas.
 * - Consultas preparadas para seguridad SQL.
 * - Actualización de datos en la base de datos.
 * - Redirección al panel para evitar reenvío de formularios.
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