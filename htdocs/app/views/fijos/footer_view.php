<script>
/* FOOTER_VIEW.PHP */
/*
Este archivo actúa como la Vista Parcial (Partial View) que contiene la estructura HTML del pie de página global de ASTECH COMPUTER. Su objetivo es ser incluido al final de todas las páginas del sitio web para proporcionar una navegación secundaria uniforme. Incluye el logotipo corporativo, enlaces directos a los servicios principales, accesos a páginas legales (Políticas de Cookies, Privacidad y Términos y Condiciones), y a la sección operativa (Login). Además, integra las redes sociales de la empresa y un botón flotante persistente de WhatsApp diseñado para facilitar el contacto inmediato del cliente desde cualquier punto de la página.
*/

</script>

<footer class="pie-pagina">
    <div class="contenedor-pie">
        <div class="seccion-logo">
            <img src="<?php echo BASE_URL; ?>public/img/logoATC.png" alt="AS TECH Logo"
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

                    <li><a href="<?php echo BASE_URL; ?>app/controllers/sobre_nosotros_controller.php">Sobre Nosotros</a></li>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/convenios_controller.php">Convenios</a>

                    <li><a href="<?php echo BASE_URL; ?>app/controllers/registro_marca_controller.php">Registro de marca</a></li>


                    </li>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/login_controller.php">Operaciones</a></li>
                </ul>
            </div>
            <div class="fila-links">
                <h4>Legal</h4>
                <ul>

                    <li><a href="<?php echo BASE_URL; ?>app/controllers/aviso_privacidad_controller.php">Aviso de privacidad</a></li>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/terminos_y_condiciones_controller.php">Términos y Condiciones</a></li>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/politica_cookies_controller.php">Política de Cookies</a>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/politica_servicios_controller.php">Política de servicios</a></li>

                    </li>
                </ul>
            </div>
        </div>
        <div class="redes-sociales">
            <h4>Síguenos</h4>
            <ul>
                <a href="https://www.facebook.com/astechcomputer" target="_blank">
        <i class="fa-brands fa-facebook"></i>
    </a>

    <a href="https://www.instagram.com/astechcomputer" target="_blank">
        <i class="fa-brands fa-instagram"></i>
    </a>

    <a href="https://www.tiktok.com/@astechcomputer" target="_blank">
        <i class="fa-brands fa-tiktok"></i>
    </a>

    <a href="https://www.youtube.com/@astechcomputer" target="_blank">
        <i class="fa-brands fa-youtube"></i>
    </a>

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