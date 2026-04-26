<script>
/* FOOTER_VIEW.PHP */
/*
Este archivo actúa como la Vista Parcial (Partial View) que contiene la estructura HTML del pie de página global de ASTECH COMPUTER. Su objetivo es ser incluido al final de todas las páginas del sitio web para proporcionar una navegación secundaria uniforme. Incluye el logotipo corporativo, enlaces directos a los servicios principales, accesos a páginas legales (Políticas de Cookies, Privacidad y Términos y Condiciones), y a la sección operativa (Login). Además, integra las redes sociales de la empresa y un botón flotante persistente de WhatsApp diseñado para facilitar el contacto inmediato del cliente desde cualquier punto de la página.
*/

</script>

<footer class="pie-pagina">
    <div class="contenedor-pie">
        <div class="seccion-logo">
            <img src="<?php echo $ruta_prefijo; ?>../../public/img/logoATC.png" alt="AS TECH Logo"
                style="width: 160px; filter: brightness(0) invert(1);">
        </div>
        <div style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px;">
            <div class="fila-links">
                <h4>Servicios</h4>
                <ul>
                    <li><a href="#">Reparación y reemplazo</a></li>
                    <li><a href="#">Mantenimiento preventivo</a></li>
                    <li><a href="#">Instalación de software</a></li>
                    <li><a href="#">Servicios especializados</a></li>
                </ul>
            </div>
            <div class="fila-links">
                <h4>Empresa</h4>
                <ul>

                    <li><a href="<?php echo $ruta_prefijo; ?>sobre_nosotros_controller.php">Sobre Nosotros</a></li>
                    <li><a href="<?php echo $ruta_prefijo; ?>convenios_controller.php">Convenios</a>

                    <li><a href="<?php echo $ruta_prefijo; ?>app/controllers/registro_marca_controller.php">Registro de marca</a></li>
                    <li><a href="<?php echo $ruta_prefijo; ?>app/controllers/sobre_nosotros_controller.php">Sobre Nosotros</a></li>
                   <li><a href="<?php echo $ruta_prefijo; ?>app/controllers/convenios_controller.php">Convenios</a>

                    </li>
                    <li><a href="<?php echo $ruta_prefijo; ?>login_controller.php">Operaciones</a></li>
                </ul>
            </div>
            <div class="fila-links">
                <h4>Legal</h4>
                <ul>

                    <li><a href="<?php echo $ruta_prefijo; ?>politica_privacidad_controller.php">Política de privacidad</a></li>
                    <li><a href="<?php echo $ruta_prefijo; ?>terminos_y_condiciones_controller.php">Términos y Condiciones</a></li>
                    <li><a href="<?php echo $ruta_prefijo; ?>politica_cookies_controller.php">Política de Cookies</a>
                    <li><a href="<?php echo $ruta_prefijo; ?>politica_servicios_controller.php">Política de servicios</a></li>

                    </li>
                </ul>
            </div>
        </div>
        <div class="redes-sociales">
            <h4>Síguenos</h4>
            <ul>
                <li><i class="fa-brands fa-whatsapp"></i></li>
                <li><i class="fa-brands fa-instagram"></i></li>
                <li><i class="fa-brands fa-facebook"></i></li>
                <li><i class="fa-brands fa-tiktok"></i></li>
            </ul>
        </div>
        <a href="https://wa.me/523221234567?text=Hola,%20vengo%20de%20la%20página%20web%20y%20necesito%20soporte%20técnico."
            class="btn-whatsapp-flotante" target="_blank" rel="noopener noreferrer">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div>
    <div class="barra-derechos">
        <p>&copy; 2026 AS TECH COMPUTER. Todos los derechos reservados.</p>
    </div>
</footer>