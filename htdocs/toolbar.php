<header class="barra-herramientas">
    <div class="contenedor-logo">
        <a href="<?php echo $ruta_prefijo; ?>index.php">
    <img src="<?php echo $ruta_prefijo; ?>public/img/Iso.png" class="logo-superior">
</a>
    
        </div>
    </a>
    <nav class="navegacion-principal">
        <ul class="lista-opciones">
            <li><a  href="<?php echo $ruta_prefijo; ?>app/controllers/contacto_controller.php" class="enlace-opcion">Contacto</a></li>
            <li><a  href="<?php echo $ruta_prefijo; ?>app/controllers/servicios_controller.php" class="enlace-opcion">Servicios</a></li>
            <li><a href="<?php echo $ruta_prefijo; ?>app/controllers/citas_cliente_controller.php" class="enlace-opcion boton-subrayado">Agendar Cita</a></li>
            <li><a href="<?php echo $ruta_prefijo; ?>app/controllers/politica_cookies_controller.php" class="enlace-opcion">Cookies</a></li>
        </ul>
    </nav>
</header>