<?php
/* FOOTER_VIEW.PHP */
/*
 * PÁGINA: Pie de Página y Sistema de Cookies (Footer View) - As Tech Computer
 * PROPÓSITO: Proporcionar la estructura HTML global (Partial View) que cierra todas las páginas del sistema web, incluyendo navegación secundaria, redes sociales y el motor de privacidad.
 * FUNCIONALIDADES:
 * - Renderización de enlaces corporativos, servicios y documentos legales mediante el uso de la constante dinámica BASE_URL para evitar rutas rotas.
 * - Integración de íconos interactivos de redes sociales y un botón flotante persistente de contacto vía WhatsApp.
 * - Inyección del sistema modular de privacidad: Despliega el "Banner de Cookies" inicial y el "Modal de Ajustes Detallados", gestionando sus estilos de visibilidad iniciales (ocultos por defecto).
 * - Carga final del script (footer.js) encargado de controlar el comportamiento asíncrono y de almacenamiento local de las preferencias de privacidad del usuario.
 */
?>

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
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/convenios_controller.php">Convenios</a></li>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/registro_marca_controller.php">Registro de marca</a></li>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/login_controller.php">Operaciones</a></li>
                </ul>
            </div>
            <div class="fila-links">
                <h4>Legal</h4>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/aviso_privacidad_controller.php">Aviso de privacidad</a></li>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/politica_cookies_controller.php">Política de Cookies</a></li>
                    <li><a href="<?php echo BASE_URL; ?>app/controllers/politica_servicios_controller.php">Política de servicios</a></li>
                </ul>
            </div>
        </div>
        <div class="redes-sociales">
            <h4>Síguenos</h4>
            <ul>
                <a href="https://www.facebook.com/AstechComputer" target="_blank">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/AsTechComputer" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@astechcomputer" target="_blank">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="https://www.youtube.com/@Astech_Computer" target="_blank">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </ul>
        </div>
        <a href="https://wa.me/523222362505?text=Hola,%20vengo%20de%20la%20página%20web%20y%20necesito%20soporte%20técnico."
            class="btn-whatsapp-flotante" target="_blank" rel="noopener noreferrer">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div>
    <div class="barra-derechos">
        <c>&copy; 2026 AS TECH COMPUTER. Todos los derechos reservados.</c>
    </div>
</footer>

<div id="overlay-bloqueo" class="overlay-cookies"></div>

<div id="banner-cookies" class="contenedor-cookies">
    <div class="texto-cookies">
        <i class="fa-solid fa-cookie-bite"></i>
        <div>
            <h3 style="margin: 0 0 5px 0; color: #1d1d1f; font-size: 1.2rem; font-weight: 900;">Tu privacidad es importante</h3>
            <p>Utilizamos cookies para mejorar tu experiencia y analizar nuestro tráfico. Al continuar, también aceptas los términos sobre el manejo de tus datos descritos en nuestro aviso de privacidad. Puedes aceptar todo, rechazar o conocer más detalles en nuestro panel informativo.</p>
        </div>
    </div>
    <div class="botones-cookies">
        <button id="btn-configurar-cookies" class="btn-enlace">Más información</button>
        <div style="display: flex; gap: 10px; width: 100%; justify-content: center;">
            <button id="btn-rechazar-cookies" class="btn-rechazar">Rechazar todas</button>
            <button id="btn-aceptar-cookies" class="btn-aceptar">Aceptar todas</button>
        </div>
    </div>
</div>

<div id="modal-ajustes-cookies" class="modal-ajustes" style="display: none;">
    <div class="modal-header-ajustes">
        <h2>Información de Privacidad</h2>
        <button id="btn-cerrar-ajustes" class="btn-cerrar"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="modal-body-ajustes">
        <div class="cookie-card">
            <div class="cookie-card-header">
                <h3>AVISO DE PRIVACIDAD</h3>
            </div>
            <div class="cookie-card-body">
                <p>En <strong>AsTech Computer</strong>, protegemos tus datos personales conforme a la LFPDPPP. Recabamos tu nombre, contacto y detalles de tu equipo únicamente para gestionar tus servicios técnicos y citas.</p>
                <a href="<?php echo BASE_URL; ?>app/controllers/aviso_privacidad_controller.php" target="_blank" style="color: #e06c00; font-weight: bold; text-decoration: underline;">Ver Aviso de Privacidad Completo</a>
            </div>
        </div>

        <div class="cookie-card">
            <div class="cookie-card-header">
                <h3>USO DE COOKIES</h3>
            </div>
            <div class="cookie-card-body">
                <p><strong>Necesarias:</strong> Permiten el funcionamiento básico de seguridad y acceso al sitio.</p>
                <p><strong>Análisis:</strong> Utilizamos <strong>Google Analytics</strong> para entender cómo interactúas con nuestra web y mejorar nuestros servicios técnicos.</p>
                <a href="<?php echo BASE_URL; ?>app/controllers/politica_cookies_controller.php" target="_blank" style="color: #e06c00; font-weight: bold; text-decoration: underline;">Ver Política de Cookies Completa</a>
            </div>
        </div>

        <p style="font-size: 0.85rem; color: #666; margin-top: 15px;">Al presionar "Aceptar Todo", consientes el uso de todas estas tecnologías.</p>
    </div>

    <div class="modal-footer">
        <button id="btn-modal-rechazar" class="btn-x-outline">RECHAZAR TODO</button>
        <button id="btn-modal-aceptar" class="btn-x-solid">ACEPTAR TODO</button>
    </div>
</div>

<script src="<?php echo BASE_URL; ?>public/js/footer.js"></script>