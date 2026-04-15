<?php 
/**
 * VISTA: toolbar_view.php
 * Se encarga de mostrar la barra de navegación y el código de seguimiento (Google Analytics)
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

<header class="barra-herramientas">
    <div class="contenedor-logo">
        <a href="<?php echo $ruta_prefijo; ?>index.php">
            <img src="<?php echo $ruta_prefijo; ?>public/img/Iso.png" class="logo-superior" alt="AsTech Logo">
        </a>
    </div>

    <nav class="navegacion-principal">
        <ul class="lista-opciones">
            <li><a href="<?php echo $ruta_prefijo; ?>app/controllers/contacto_controller.php" 
                   class="enlace-opcion">Contacto</a></li>
            <li><a href="<?php echo $ruta_prefijo; ?>app/controllers/servicios_controller.php" 
                   class="enlace-opcion">Servicios</a></li>
            <li><a href="<?php echo $ruta_prefijo; ?>app/controllers/citas_cliente_controller.php" 
                   class="enlace-opcion boton-subrayado">Agendar Cita</a></li>
        </ul>
    </nav>
</header>