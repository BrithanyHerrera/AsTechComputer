<?php
include __DIR__ . "../../config/conexion.db.php";

$q = isset($_GET['q']) ? $_GET['q'] : '';

$query = "SELECT tipo_servicio, precio 
          FROM servicios 
          WHERE estado = 'activo' 
          AND tipo_servicio LIKE '%$q%' 
          LIMIT 5";

$resultado = mysqli_query($conexion, $query);

while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<div class='resultado-item'>
            <strong>{$row['tipo_servicio']}</strong><br>
            $ {$row['precio']}
          </div>";
}
?>