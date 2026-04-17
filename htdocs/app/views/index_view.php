<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astech Computer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="public/img/Astech ICO.ico" type="image/x-icon">
    <link rel="stylesheet" href="public/css/toolbar.css">
    <link rel="stylesheet" href="public/css/footer.css">
    <link rel="stylesheet" href="public/css/index.css">
</head>

<body>

    <?php 
    $ruta_prefijo = "";
    include "app/controllers/toolbar_controller.php"; 
    ?>

    <main>
        <section class="hero-wrapper">
            <div class="hero-astech">
                <div class="hero-texto">
                   
                    <h1>Astech Computer</h1>
                    <p class="subtitulo">Mantenimiento integral y reparación especializada.</p>
                    <p class="destacado">Confianza y rapidez.</p>
                    <div class="hero-botones">
                        <a href="app/controllers/citas_cliente_controller.php" class="btn-comprar">Agendar cita</a>
                        <a href="app/controllers/mas_info_controller.php" class="enlace-mas">Más información <i
                                class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="hero-imagen">
                    <img src="public/img/Isologotipo_isotipo color.png" alt="Logo Astech Computer">
                </div>
            </div>
        </section>

        <section class="seccion-about">
            <div class="grid-about">
                <div class="texto-about">
                    <h2>¿Quiénes somos?</h2>
                    <p>Somos una empresa humana y amigable, guiada por los valores de integridad y transparencia para
                        brindar a nuestros clientes servicios de reparación y mantenimiento de calidad.</p>
                    <p>Nuestro compromiso es garantizar que tu tecnología siempre funcione a la perfección, asegurando
                        tu información y extendiendo la vida útil de tus equipos.</p>
                </div>
                <div class="imagen-about">
                    <img src="public/img/trabajado.JPG" alt="Trabajo en Astech">
                </div>
            </div>
        </section>

        <section id="servicios" class="seccion-valores">
            <div class="contenedor-max">
                <h2 class="titulo-seccion">Nuestros Servicios</h2>
                <div class="grid-cards">
                    <div class="astech-card">
                        <img src="public/img/diagnostico.jpg" alt="Diagnóstico">
                        <div class="astech-card-body">
                            <h3>Diagnóstico</h3>
                            <p>Revisión profunda para identificar el origen exacto de la falla en tu equipo.</p>
                            <button class="btn-comprar">Solicitar</button>
                        </div>
                    </div>
                    <div class="astech-card">
                        <img src="public/img/manten.jpg" alt="Mantenimiento">
                        <div class="astech-card-body">
                            <h3>Mantenimiento</h3>
                            <p>Limpieza física y optimización de software para máxima velocidad.</p>
                            <button class="btn-comprar">Solicitar</button>
                        </div>
                    </div>
                    <div class="astech-card">
                        <img src="public/img/reparacion.jpg" alt="Reparación">
                        <div class="astech-card-body">
                            <h3>Reparación</h3>
                            <p>Sustitución de piezas y microelectrónica con garantía extendida.</p>
                            <button class="btn-comprar">Solicitar</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="seccion-about">
            <div class="contenedor-max">
                <h2 class="titulo-seccion">Filosofía Empresarial</h2>

                <div class="grid-cards" style="margin-bottom: 60px;">
                    <div class="astech-card">
                        <img src="public/img/mision.png" alt="Misión">
                        <div class="astech-card-body">
                            <h3>Nuestra Misión</h3>
                            <p>Brindamos una experiencia integral a nuestros clientes con servicios de reparación,
                                mantenimiento, asesoría computacional y soporte a MiPymes de la región, garantizando la
                                privacidad de datos y ofreciendo garantía en todos nuestros servicios, con principios de
                                transparencia, honestidad y respeto para cumplir las expectativas y brindar soluciones
                                confiables y vanguardistas.</p>
                        </div>
                    </div>
                    <div class="astech-card">
                        <img src="public/img/vision.png" alt="Visión">
                        <div class="astech-card-body">
                            <h3>Nuestra Visión</h3>
                            <p>En AsTech Computer soñamos con un 2030 donde seamos la empresa de servicios tecnológicos
                                de referencia en Puerto Vallarta, reconocida por nuestra excelencia, compromiso,
                                innovación y la confianza que nos brinda nuestra comunidad.</p>
                            <p>Creceremos junto a nuestros clientes y aliados estratégicos, compartiendo una misma
                                visión de futuro: desarrollar talento local, promover la tecnología responsable y
                                generar un impacto positivo en nuestro entorno.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid-valores">
                    <div class="valor-item">
                        <i class="fa-solid fa-shield-halved"></i>
                        <h4>Confiabilidad</h4>
                        <p>Seguridad y profesionalismo en cada acción.</p>
                    </div>
                    <div class="valor-item">
                        <i class="fa-solid fa-award"></i>
                        <h4>Garantía</h4>
                        <p>Excelencia en insumos asegurando el respaldo total.</p>
                    </div>
                    <div class="valor-item">
                        <i class="fa-solid fa-handshake-simple"></i>
                        <h4>Transparencia</h4>
                        <p>Honestidad y ética en todas nuestras relaciones.</p>
                    </div>
                    <div class="valor-item">
                        <i class="fa-solid fa-users"></i>
                        <h4>Enfoque al Cliente</h4>
                        <p>Soluciones efectivas que superan expectativas.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="seccion-ceo">
            <div class="caja-ceo">
                <div class="ceo-texto">
                    <img src="public/img/Iso.png" alt="Logo" style="width: 60px; margin-bottom: 20px;">
                    <blockquote>“En nuestra empresa tratamos cada equipo como si fuera propio, porque sabemos que ahí
                        está tu trabajo, tus recuerdos y tu información.”</blockquote>
                    <p style="font-weight: 700; font-size: 1.2rem;">Ferdán Garrigos</p>
                    <p style="color: var(--color-texto-secundario);">Fundador & CEO</p>
                </div>
                <div class="ceo-img">
                    <img src="public/img/ceoo.png" alt="CEO de Astech Computer">
                </div>
            </div>
        </section>
    </main>

    <?php 
    $ruta_prefijo = "";
    include "app/controllers/footer_controller.php"; 
    ?>

    <div id="overlay-bloqueo" class="overlay-cookies"></div>

    <div id="banner-cookies" class="contenedor-cookies">
        <div class="texto-cookies">
            <i class="fa-solid fa-cookie-bite"></i>
            <div>
                <h3 style="margin: 0 0 5px 0; color: #1d1d1f; font-size: 1.2rem; font-weight: 900;">Tu privacidad es
                    importante</h3>
                <p>Utilizamos cookies y tecnologías similares para garantizar que el sitio funcione correctamente,
                    mantener la seguridad y analizar nuestro tráfico. Puedes "Aceptar todas", "Rechazar todas" (excepto
                    las estrictamente necesarias) o personalizar tu configuración.</p>
            </div>
        </div>
        <div class="botones-cookies">
            <button id="btn-configurar-cookies" class="btn-enlace">Ajustes de Cookies</button>

            <div style="display: flex; gap: 10px; width: 100%; justify-content: center;">
                <button id="btn-rechazar-cookies" class="btn-rechazar">Rechazar todas</button>
                <button id="btn-aceptar-cookies" class="btn-aceptar">Aceptar todas</button>
            </div>
        </div>
    </div>

    <div id="modal-ajustes-cookies" class="modal-ajustes" style="display: none;">
        <div class="modal-header-ajustes">
            <h2>Ajustes de Cookies</h2>
            <button id="btn-cerrar-ajustes" class="btn-cerrar"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="modal-body-ajustes">
            <p class="intro-ajustes">Tienes control total sobre las cookies (y otras tecnologías similares) cuando
                utilizas nuestro sitio web. Puedes limitar cierto seguimiento o rechazar las cookies en relación con
                aquellas que no son necesarias, pero ten en cuenta que si rechazas el uso de ciertos tipos de cookies,
                algunas de las funciones de nuestro sitio web podrían verse afectadas. <br><br> Para obtener más
                información, consulta nuestra <a href="app/controllers/politica_cookies_controller.php" target="_blank">"Política de
                    Cookies"</a>.</p>

            <div class="cookie-card">
                <div class="cookie-card-header">
                    <h3>COOKIES NECESARIAS</h3>
                    <span class="badge-fijo">Siempre activas</span>
                </div>
                <div class="cookie-card-body">
                    <p>Las cookies esenciales son necesarias para garantizar la funcionalidad básica y el correcto
                        funcionamiento de nuestro sitio web.</p>
                    <details>
                        <summary><i class="fa-solid fa-caret-right"></i> Ver las cookies necesarias</summary>
                        <p class="texto-oculto">Estas cookies no son opcionales y no se pueden desactivar. Se utilizan
                            para iniciar sesión en la cuenta, identificar el dispositivo, guardar artículos en el
                            carrito, procesar pagos y proteger el sitio web contra ataques maliciosos.</p>
                    </details>
                </div>
            </div>

            <div class="cookie-card">
                <div class="cookie-card-header">
                    <h3>COOKIES FUNCIONALES</h3>
                    <label class="toggle-switch">
                        <input type="checkbox" id="toggle-funcionales">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="cookie-card-body">
                    <p>Las cookies funcionales permiten a nuestro sitio web ofrecer funciones mejoradas y mejorar la
                        experiencia de usuario. No son estrictamente necesarias.</p>
                    <details>
                        <summary><i class="fa-solid fa-caret-right"></i> Configuraciones detalladas</summary>
                        <p class="texto-oculto">Estas cookies se utilizan para proporcionar enlaces de productos,
                            habilitar funciones de visualización, ofrecer asistencia multilingüe y distinguir entre
                            usuarios reales y tráfico automatizado.</p>
                    </details>
                </div>
            </div>

            <div class="cookie-card">
                <div class="cookie-card-header">
                    <h3>COOKIES DE ANÁLISIS</h3>
                    <label class="toggle-switch">
                        <input type="checkbox" id="toggle-analiticas">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="cookie-card-body">
                    <p>Las cookies de análisis realizan un seguimiento de su actividad en nuestro sitio web para
                        comprender cómo utilizan el sitio y mejorar la calidad.</p>
                    <details>
                        <summary><i class="fa-solid fa-caret-right"></i> Configuraciones detalladas</summary>
                        <p class="texto-oculto">Estas cookies están asociadas a Google Analytics y distinguen a los
                            usuarios asignando IDs aleatorios. Recopilan información de forma anónima sobre visitantes y
                            fuentes.</p>
                    </details>
                </div>
            </div>

            <div class="cookie-card">
                <div class="cookie-card-header">
                    <h3>COOKIES PUBLICITARIAS</h3>
                    <label class="toggle-switch">
                        <input type="checkbox" id="toggle-publicidad">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="cookie-card-body">
                    <p>Las cookies publicitarias se utilizan para mostrarle publicidad relevante basada en sus intereses
                        en otras plataformas.</p>
                    <details>
                        <summary><i class="fa-solid fa-caret-right"></i> Configuraciones detalladas</summary>
                        <p class="texto-oculto">Google y Meta realizan un seguimiento del comportamiento para medir
                            conversiones, personalizar contenido y ofrecer promociones basadas en navegación.</p>
                    </details>
                </div>
            </div>
        </div>

        <div class="modal-footer-xiaomi">
            <button id="btn-modal-enviar" class="btn-x-outline">ENVIAR PREFERENCIAS</button>
            <button id="btn-modal-aceptar" class="btn-x-solid">ACEPTAR TODO</button>
            <button id="btn-modal-rechazar" class="btn-x-solid">RECHAZAR TODO</button>
        </div>
    </div>

    <script src="public/js/fuciones.js"></script>
    <script src="public/js/index.js"></script>
</body>

</html>