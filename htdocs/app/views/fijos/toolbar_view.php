<?php 
/**
 * VISTA: toolbar_view.php
 */
/**
 * VISTA: toolbar_view.php
 */
/**
 * VISTA: toolbar_view.php
 */
/**
 * VISTA: toolbar_view.php
 */

if (isset($permitirAnaliticas) && $permitirAnaliticas): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-862PM8JVQD"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-862PM8JVQD');
    </script>
<?php endif; ?>

<?php
if (!isset($conexion)) {
    require_once __DIR__ . "/../../config/conexion.db.php";
}

// 1. Obtener tipos de servicios
$queryTipos = "SELECT id_tipo_servicio, nombre_tipo FROM tipos_servicios ORDER BY id_tipo_servicio ASC";
$resultTipos = $conexion->query($queryTipos);

// 2. Obtener servicios activos
$serviciosPorTipo = [];
$queryServicios = "SELECT * FROM servicios WHERE estado = 'activo'";
$resServicios = $conexion->query($queryServicios);
while ($row = $resServicios->fetch_assoc()) {
    $serviciosPorTipo[$row['id_tipo_servicio']][] = $row;
}

// 3. Obtener los más recientes
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
        <a href="<?php echo $ruta_prefijo; ?>index.php">
            <img src="<?php echo $ruta_prefijo; ?>public/img/Isologotipo_horizontal color.png" class="logo-superior" alt="Logo">
        </a>
    </div>

    <nav class="menu">
        <ul>
            <li class="botones"><a href="<?php echo $ruta_prefijo; ?>app/controllers/contacto_controller.php">Contacto</a></li>
            <li class="servicios-hover botones">
                <a href="<?php echo $ruta_prefijo; ?>app/controllers/servicios_controller.php" class="btn-servicios">Servicios</a>
                
                <div class="mega-menu">
                    <div class="mega-menu-content">
                        <div class="menu-izquierda">
                            <?php 
                            $resultTipos->data_seek(0); // Reiniciar puntero
                            while($tipo = $resultTipos->fetch_assoc()): 
                            ?>
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
                                                <a href="<?php echo $ruta_prefijo; ?>detalle_servicio.php?id=<?php echo $srv['id_servicio']; ?>">
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
            <li class="botones"><a href="<?php echo $ruta_prefijo; ?>app/controllers/citas_cliente_controller.php">Agendar cita</a></li>
            <li class="botones">
                <a href="javascript:void(0);" id="btnBuscador" class="enlace-opcion-serv" onclick="abrirBuscador()">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
            </li>
        </ul>
    </nav>
</header>

<div id="contenedorBuscador" class="buscador-oculto">
    <div class="buscador-content">
        <input type="text" id="inputBuscador" placeholder="Buscar servicios...">
        <div id="resultadosBusqueda"></div>
    </div>
</div>

<script>
(function() {
    // Selectores
    const buscadorContainer = document.getElementById('contenedorBuscador');
    const inputBusqueda = document.getElementById('inputBuscador');
    const resultadosDiv = document.getElementById('resultadosBusqueda');

    // 1. Lógica para abrir/cerrar buscador
    window.abrirBuscador = function() {
        if(buscadorContainer) {
            buscadorContainer.classList.toggle('active');
            if(buscadorContainer.classList.contains('active')) {
                setTimeout(() => inputBusqueda.focus(), 300);
            }
        }
    };

    // 2. Lógica de búsqueda en tiempo real
    if (inputBusqueda) {
        inputBusqueda.addEventListener("keyup", () => {
            let valor = inputBusqueda.value;
            if(valor.length < 2) {
                resultadosDiv.innerHTML = "";
                return;
            }

            // IMPORTANTE: Verifica que la ruta al controlador de búsqueda sea correcta
            fetch("<?php echo $ruta_prefijo; ?>app/controllers/buscar_servicio.php?q=" + valor)
                .then(res => res.text())
                .then(data => {
                    resultadosDiv.innerHTML = data;
                })
                .catch(err => console.error("Error en búsqueda:", err));
        });
    }

    // 3. LOGICA CLAVE: Click en un resultado para ir al detalle
    if (resultadosDiv) {
        resultadosDiv.addEventListener("click", (e) => {
            // Buscamos el elemento con la clase .resultado-item más cercano al click
            const item = e.target.closest(".resultado-item");
            
            if(item){
                // Obtenemos el ID que el controlador puso en el atributo data-id
                let id = item.getAttribute("data-id");
                
                if(id) {
                    // Redirigimos a la página de detalle con el ID correspondiente
                    // Ajustamos la ruta para que siempre use detalle_servicio.php en la raíz
                    window.location.href = "<?php echo $ruta_prefijo; ?>detalle_servicio.php?id=" + id;
                }
            }
        });
    }

    // 4. Acordeones del Mega Menu
    document.querySelectorAll('.titulo-tipo-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const submenu = button.nextElementSibling;
            submenu.classList.toggle('active');
            button.classList.toggle('active');
            
            const icon = button.querySelector('i');
            if(icon) {
                icon.style.transform = submenu.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
    });

    // Cerrar buscador al hacer click fuera
    window.addEventListener('click', (e) => {
        if (e.target == buscadorContainer) {
            buscadorContainer.classList.remove('active');
        }
    });
})();

// Función auxiliar global por si la usas en onlick="verServicio(id)"
function verServicio(id){
    window.location.href = "<?php echo $ruta_prefijo; ?>detalle_servicio.php?id=" + id;
}
</script>