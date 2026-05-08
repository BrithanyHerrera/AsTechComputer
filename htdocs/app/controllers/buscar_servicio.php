<?php
require_once "../config/conexion.db.php";

$q = $_GET['q'];

// 1. ASEGÚRATE DE PEDIR id_servicio EN EL SELECT
$query = "SELECT id_servicio, tipo_servicio FROM servicios 
          WHERE tipo_servicio LIKE ? AND estado = 'activo' LIMIT 5";

$stmt = $conexion->prepare($query);
$buscar = "%$q%";
$stmt->bind_param("s", $buscar);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        // 2. AQUÍ ESTABA EL ERROR (Línea 22): 
        // Asegúrate de que el nombre coincida con el SELECT de arriba
        echo '<div class="resultado-item" data-id="' . $row['id_servicio'] . '">';
        echo '   ' . htmlspecialchars($row['tipo_servicio']);
        echo '</div>';
    }
} else {
    echo '<div class="no-resultados">No se encontraron servicios</div>';
}
?>