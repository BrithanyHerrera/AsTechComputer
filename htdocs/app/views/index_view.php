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
    <link rel="stylesheet" href="public/css/index.css">
</head>

<body>

    <?php $ruta_prefijo = "";
    include "toolbar.php"; ?>

    <main>
        <section class="hero-wrapper">
            <div class="hero-astech">
                <div class="hero-texto">
                    <span class="badge-premium">Astech Premium</span>
                    <h1>Astech Computer</h1>
                    <p class="subtitulo">Mantenimiento integral y reparación especializada.</p>
                    <p class="destacado">Confianza y rapidez.</p>
                    <div class="hero-botones">
                        <a href="app/views/agendar_cita.php" class="btn-comprar">Agendar cita</a>
                        <a href="#servicios" class="enlace-mas">Más información <i
                                class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="hero-imagen">
                    <img src="public/img/logoATC.png" alt="Logo Astech Computer">
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

        <footer class="pie-pagina">
            <div class="contenedor-pie">
                <div class="seccion-logo">
                    <img src="public/img/logoATC.png" alt="AS TECH Logo"
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
                            <li><a href="#">Sobre Nosotros</a></li>
                            <li><a href="app/controllers/convenios_controller.php">Convenios</a></li>
                            <li><a href="app/controllers/login_controller.php">Operaciones</a></li>
                        </ul>
                    </div>
                    <div class="fila-links">
                        <h4>Legal</h4>
                        <ul>
                            <li><a href="#">Política de privacidad</a></li>
                            <li><a href="app/views/politica_cookies.php">Política de Cookies</a></li>
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
            </div>
            <div class="barra-derechos">
                <p>&copy; 2026 AS TECH COMPUTER. Todos los derechos reservados.</p>
            </div>
        </footer>
    </main>

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

    <style>
        .bloquear-scroll {
            overflow: hidden;
        }

        .overlay-cookies {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999998;
            display: none;
        }

        .contenedor-cookies {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 700px;
            background-color: #ffffff;
            box-shadow: 0px 20px 50px rgba(0, 0, 0, 0.2);
            border-radius: 24px;
            display: none;
            flex-direction: column;
            padding: 30px;
            z-index: 999999;
            text-align: center;
        }

        .texto-cookies {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .texto-cookies i {
            font-size: 45px;
            color: #e06c00;
        }

        .texto-cookies p {
            margin: 0;
            font-size: 0.95rem;
            color: #86868b;
            line-height: 1.5;
        }

        .botones-cookies {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            width: 100%;
        }

        .btn-aceptar,
        .btn-rechazar {
            padding: 12px 25px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s;
            flex: 1;
            border: none;
            font-size: 0.95rem;
        }

        .btn-aceptar {
            background-color: #e06c00;
            color: white;
        }

        .btn-aceptar:hover {
            background-color: #cc6200;
            transform: scale(1.02);
        }

        .btn-rechazar {
            background-color: #f5f5f7;
            color: #1d1d1f;
        }

        .btn-rechazar:hover {
            background-color: #e8e8ed;
        }

        .btn-enlace {
            background: none;
            border: none;
            color: #86868b;
            text-decoration: underline;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .btn-enlace:hover {
            color: #1d1d1f;
        }

        .modal-ajustes {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 95%;
            max-width: 650px;
            height: 85vh;
            background-color: #f7f7f7;
            border-radius: 12px;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            box-shadow: 0px 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            font-family: 'Lato', sans-serif;
        }

        .modal-header-ajustes {
            padding: 20px 30px;
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .modal-header-ajustes h2 {
            font-size: 1.3rem;
            font-weight: 900;
            color: #000;
            margin: 0;
        }

        .btn-cerrar {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #000;
            cursor: pointer;
            font-weight: bold;
        }

        .modal-body-ajustes {
            padding: 25px 30px;
            overflow-y: auto;
            text-align: left;
            flex: 1;
            max-height: 55vh;
        }

        .intro-ajustes {
            font-size: 0.9rem;
            color: #444;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .intro-ajustes a {
            color: #e06c00;
            font-weight: bold;
            text-decoration: none;
        }

        .cookie-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .cookie-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .cookie-card-header h3 {
            font-size: 1.05rem;
            color: #000;
            margin: 0;
            font-weight: 900;
            letter-spacing: 0.5px;
        }

        .badge-fijo {
            font-size: 0.8rem;
            color: #888;
            font-weight: 700;
            background: #f0f0f0;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .cookie-card-body p {
            font-size: 0.85rem;
            color: #555;
            margin: 0 0 15px 0;
            line-height: 1.5;
        }

        details {
            border-top: 1px solid #eee;
            padding-top: 12px;
        }

        details summary {
            cursor: pointer;
            color: #e06c00;
            font-size: 0.85rem;
            list-style: none;
            display: flex;
            align-items: center;
            gap: 8px;
            outline: none;
        }

        details summary::-webkit-details-marker {
            display: none;
        }

        details[open] summary i {
            transform: rotate(90deg);
            transition: transform 0.2s;
        }

        .texto-oculto {
            margin-top: 15px !important;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            border-left: 3px solid #e06c00;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 28px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #d1d1d6;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        input:checked+.slider {
            background-color: #e06c00;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .modal-footer-xiaomi {
            padding: 20px 30px;
            border-top: 1px solid #e0e0e0;
            background: #fff;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 10;
        }

        .btn-x-outline {
            background: white;
            border: 1px solid #e06c00;
            color: #e06c00;
            padding: 14px;
            border-radius: 6px;
            font-weight: 900;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .btn-x-outline:hover {
            background: #fff3e0;
        }

        .btn-x-solid {
            background: #e06c00;
            border: 1px solid #e06c00;
            color: white;
            padding: 14px;
            border-radius: 6px;
            font-weight: 900;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .btn-x-solid:hover {
            background: #cc6200;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const overlay = document.getElementById("overlay-bloqueo");
            const banner = document.getElementById("banner-cookies");
            const modalAjustes = document.getElementById("modal-ajustes-cookies");

            // Botones del Banner
            const btnAceptarBanner = document.getElementById("btn-aceptar-cookies");
            const btnRechazarBanner = document.getElementById("btn-rechazar-cookies");
            const btnConfigurar = document.getElementById("btn-configurar-cookies");

            // Botones del Modal
            const btnCerrarModal = document.getElementById("btn-cerrar-ajustes");
            const btnModalEnviar = document.getElementById("btn-modal-enviar");
            const btnModalAceptar = document.getElementById("btn-modal-aceptar");
            const btnModalRechazar = document.getElementById("btn-modal-rechazar");

            // Switches
            const tgFuncionales = document.getElementById("toggle-funcionales");
            const tgAnaliticas = document.getElementById("toggle-analiticas");
            const tgPublicidad = document.getElementById("toggle-publicidad");

            function obtenerCookie(nombre) {
                let match = document.cookie.match(new RegExp('(^| )' + nombre + '=([^;]+)'));
                if (match) return decodeURIComponent(match[2]);
                return null;
            }

            if (!obtenerCookie('astech_preferencias_cookies')) {
                banner.style.display = "flex";
                overlay.style.display = "block";
                document.body.classList.add("bloquear-scroll");
            }

            function guardarPreferencias(preferencias) {
                preferencias.necesarias = true;
                let fechaExpiracion = new Date();
                fechaExpiracion.setTime(fechaExpiracion.getTime() + (365 * 24 * 60 * 60 * 1000));
                document.cookie = "astech_preferencias_cookies=" + encodeURIComponent(JSON.stringify(preferencias)) + "; expires=" + fechaExpiracion.toUTCString() + "; path=/";

                banner.style.display = "none";
                modalAjustes.style.display = "none";
                overlay.style.display = "none";
                document.body.classList.remove("bloquear-scroll");
            }

            // Eventos Banner
            btnAceptarBanner.addEventListener("click", function () {
                guardarPreferencias({ funcionales: true, analiticas: true, publicidad: true });
            });
            btnRechazarBanner.addEventListener("click", function () {
                guardarPreferencias({ funcionales: false, analiticas: false, publicidad: false });
            });
            btnConfigurar.addEventListener("click", function () {
                banner.style.display = "none";
                modalAjustes.style.display = "flex";
            });

            // Eventos Modal
            btnCerrarModal.addEventListener("click", function () {
                modalAjustes.style.display = "none";
                banner.style.display = "flex";
            });
            btnModalEnviar.addEventListener("click", function () {
                guardarPreferencias({ funcionales: tgFuncionales.checked, analiticas: tgAnaliticas.checked, publicidad: tgPublicidad.checked });
            });
            btnModalAceptar.addEventListener("click", function () {
                guardarPreferencias({ funcionales: true, analiticas: true, publicidad: true });
            });
            btnModalRechazar.addEventListener("click", function () {
                guardarPreferencias({ funcionales: false, analiticas: false, publicidad: false });
            });
        });
    </script>
    <script src="public/js/fuciones.js"></script>
</body>

</html>