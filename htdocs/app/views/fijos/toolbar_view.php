<script>
    /* TOOLBAR_VIEW */
    /**
     * PÁGINA: Barra de Navegación (Toolbar) - As Tech Computer
     * PROPÓSITO: Proporcionar una interfaz de navegación global y acceso rápido a los servicios y búsqueda.
     * FUNCIONALIDADES: 
     * - Menú principal con enlaces dinámicos a Contacto, Servicios y Agendamiento de citas.
     * - Mega Menú interactivo que organiza los servicios por categorías (tipos) recuperados de la base de datos.
     * - Sección de "Lo más reciente" dentro del menú para destacar los últimos servicios agregados.
     * - Buscador integrado con tecnología de búsqueda en tiempo real y redirección automática al detalle del servicio.
     * - Gestión dinámica de rutas mediante la variable '$ruta_prefijo' para asegurar la navegación entre diferentes niveles de carpetas.
     */
</script>

<?php
/* ========================================================
   1. INYECCIÓN CONDICIONAL DE ANALÍTICAS (PRIVACIDAD)
   ======================================================== */
// El sistema verifica si el usuario ha otorgado el consentimiento 
// explícito para el uso de cookies analíticas antes de incrustar el script.
if ($permitirAnaliticas):
    ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QZJ3DCN18Q"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-QZJ3DCN18Q');
    </script>
<?php endif; ?>

<header class="navbar">

    <div class="logo">
        <a href="<?= BASE_URL ?>index.php">
            <img src="<?= BASE_URL ?>public/img/logo_vertical.png" class="logo-superior" alt="Logo">
        </a>
    </div>

    <div class="menu-toggle" id="mobile-menu">
        <i class="fa-solid fa-bars"></i>
    </div>

    <nav class="menu">
        <ul id="nav-links">
            <li class="botones"><a href="<?= BASE_URL ?>index.php">Inicio</a></li>
            <li class="botones"><a href="<?= BASE_URL ?>app/controllers/contacto_controller.php">Contacto</a></li>

            <li class="servicios-hover botones">
                <a href="<?= BASE_URL ?>app/controllers/servicios_controller.php" class="btn-servicios">Servicios <i
                        class="fa-solid fa-chevron-down hidden-desktop"></i></a>

                <div class="mega-menu">
                    <div class="mega-menu-content">

                        <div class="menu-izquierda">
                           <?php foreach ($tiposServicios ?? [] as $tipo): ?>
                                <div class="acordeon-item">
                                    <button class="titulo-tipo-btn">
                                        <?php echo htmlspecialchars($tipo['nombre_tipo']); ?>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="submenu-desplegable">
                                        <?php
                                        $id_actual = $tipo['id_tipo_servicio'];
                                        if (isset($serviciosPorTipo[$id_actual])):
                                            foreach ($serviciosPorTipo[$id_actual] as $srv): ?>
                                                <a
                                                    href="<?= BASE_URL ?>app/controllers/detalle_servicio_controller.php?id=<?php echo $srv['id_servicio']; ?>">
                                                    <?php echo htmlspecialchars($srv['tipo_servicio']); ?>
                                                </a>
                                            <?php endforeach; endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="menu-derecha">
                            <p class="label-recientes">Lo más reciente</p>
                            <div class="grid-recientes">
                                <?php foreach ($serviciosRecientes  ?? [] as $reciente): ?>
                                    <a href="<?= BASE_URL ?>detalle_servicio.php?id=<?php echo $reciente['id_servicio']; ?>"
                                        style="text-decoration: none; color: inherit;">
                                        <div class="tarjeta">
                                            <span class="badge">Nuevo</span>
                                            <img src="<?php echo $ruta_img . $reciente['imagen_servicio']; ?>"
                                                alt="Servicio">
                                            <h4><?php echo htmlspecialchars($reciente['tipo_servicio']); ?></h4>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="botones"><a href="<?= BASE_URL ?>app/controllers/citas_cliente_controller.php">Agendar cita</a>
            </li>
            <li class="botones">
                <a href="javascript:void(0);" id="btnBuscador" class="enlace-opcion-serv" onclick="abrirBuscador()">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
            </li>
        </ul>
    </nav>
</header>

<div id="contenedorBuscador" class="buscador-oculto">
    <span id="cerrarBuscador" class="btn-cerrar-buscador">
        <i class="fa-solid fa-xmark"></i>
    </span>
    
    <input type="text" id="inputBuscador" placeholder="Buscar servicios...">
    <div id="resultadosBusqueda"></div>
</div>


<script>
    // Se define la ruta base de la aplicación de manera global para que el JS pueda utilizarla
    const APP_BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>public/js/toolbar.js"></script>