<?php
// Conexión a la base de datos
require_once __DIR__ . '/app/config/conexion.db.php';

// 1. Obtener los nombres de las categorías desde la tabla correcta (tipos_servicios)
$queryTipos = "
    SELECT id_tipo_servicio, nombre_tipo 
    FROM tipos_servicios 
    ORDER BY id_tipo_servicio ASC
";
$resultTipos = $conexion->query($queryTipos);

// 2. Obtener servicios agrupados por su ID de tipo
$serviciosPorTipo = [];
$queryServicios = "SELECT * FROM servicios WHERE estado = 'activo'";
$resServicios = $conexion->query($queryServicios);
while ($row = $resServicios->fetch_assoc()) {
    $serviciosPorTipo[$row['id_tipo_servicio']][] = $row;
}

// 3. Obtener los más recientes para el panel derecho
$queryRecientes = "
    SELECT s.*, t.nombre_tipo 
    FROM servicios s
    JOIN tipos_servicios t ON s.id_tipo_servicio = t.id_tipo_servicio
    WHERE s.estado = 'activo' 
    ORDER BY s.id_servicio DESC 
    LIMIT 4
";
$resultRecientes = $conexion->query($queryRecientes);
?>

<header class="navbar">
    <div class="logo">
        <img src="<?php echo $ruta_prefijo; ?>public/img/Iso.png" class="logo-superior">

    </div>

    <nav class="menu">
        <ul>
            <li class="botones"><a href="<?php echo $ruta_prefijo; ?>app/controllers/contacto_controller.php" >Contacto</a></li>
            <li class="servicios-hover botones">
                <a href="<?php echo $ruta_prefijo; ?>app/controllers/servicios_controller.php" class="btn-servicios">Servicios</a>
                
                <div class="mega-menu">
                    <div class="mega-menu-content">
                        
                        <div class="menu-izquierda">
                            <?php while($tipo = $resultTipos->fetch_assoc()): ?>
                                <div class="acordeon-item">
                                    <button class="titulo-tipo-btn">
                                        <?php echo $tipo['nombre_tipo']; ?>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    
                                    <div class="submenu-desplegable">
                                        <?php 
                                        $id_actual = $tipo['id_tipo_servicio'];
                                        if(isset($serviciosPorTipo[$id_actual])):
                                            foreach($serviciosPorTipo[$id_actual] as $srv): ?>
                                                <a href="detalle_servicio.php?id=<?php echo $srv['id_servicio']; ?>">
                                                    <?php echo $srv['tipo_servicio']; ?>
                                                </a>
                                        <?php endforeach; endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="menu-derecha">
                            <p class="label-recientes">Lo más reciente</p>
                            <div class="grid-recientes">
                                <?php while($reciente = $resultRecientes->fetch_assoc()): ?>
                                    <div class="tarjeta">
                                        <span class="badge">Nuevo</span>
                                        <img src="<?php echo $reciente['imagen_servicio']; ?>" alt="Servicio">
                                        <h4><?php echo $reciente['nombre_tipo']; ?></h4>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </li>
            <li class="botones"><a href="<?php echo $ruta_prefijo; ?>app/controllers/citas_cliente_controller.php" >Agendar cita</a></li>
            <li class="botones">
                <a href="#" id="btnBuscador" class="enlace-opcion-serv" onclick="abrirBuscador()">
            <i class="fa-solid fa-magnifying-glass"></i>
        </a>
        </li>
        </ul>
    </nav>
</header>


<script>
document.querySelectorAll('.titulo-tipo-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        const submenu = button.nextElementSibling;
        
        // Alternar clase active
        submenu.classList.toggle('active');
        button.classList.toggle('active');
        
        // Opcional: Rotar el icono si tienes uno
        const icon = button.querySelector('i');
        if(icon) {
            icon.style.transform = submenu.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
            icon.style.transition = 'transform 0.3s ease';
        }
    });
});
</script>