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
            <div class="hero-xiaomi">
                <div class="hero-texto">
                    <span class="badge-premium">Astech Premium</span>
                    <h1>Astech Computer</h1>
                    <p class="subtitulo">Mantenimiento integral y reparación especializada.</p>
                    <p class="destacado">Confianza y rapidez.</p>
                    <div class="hero-botones">
                        <a href="app/views/agendar_cita.php" class="btn-comprar">Agendar cita</a>
                        <a href="#servicios" class="enlace-mas">Más información <i class="fa-solid fa-angle-right"></i></a>
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
                    <p>Somos una empresa humana y amigable, guiada por los valores de integridad y transparencia para brindar a nuestros clientes servicios de reparación y mantenimiento de calidad.</p>
                    <p>Nuestro compromiso es garantizar que tu tecnología siempre funcione a la perfección, asegurando tu información y extendiendo la vida útil de tus equipos.</p>
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
                    <div class="xiaomi-card">
                        <img src="public/img/diagnostico.jpg" alt="Diagnóstico">
                        <div class="xiaomi-card-body">
                            <h3>Diagnóstico</h3>
                            <p>Revisión profunda para identificar el origen exacto de la falla en tu equipo.</p>
                            <button class="btn-comprar">Solicitar</button>
                        </div>
                    </div>
                    <div class="xiaomi-card">
                        <img src="public/img/manten.jpg" alt="Mantenimiento">
                        <div class="xiaomi-card-body">
                            <h3>Mantenimiento</h3>
                            <p>Limpieza física y optimización de software para máxima velocidad.</p>
                            <button class="btn-comprar">Solicitar</button>
                        </div>
                    </div>
                    <div class="xiaomi-card">
                        <img src="public/img/reparacion.jpg" alt="Reparación">
                        <div class="xiaomi-card-body">
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
                    <div class="xiaomi-card">
                        <img src="public/img/mision.png" alt="Misión">
                        <div class="xiaomi-card-body">
                            <h3>Nuestra Misión</h3>
                            <p>Brindamos una experiencia integral a nuestros clientes con servicios de reparación, mantenimiento, asesoría computacional y soporte a MiPymes de la región, garantizando la privacidad de datos y ofreciendo garantía en todos nuestros servicios, con principios de transparencia, honestidad y respeto para cumplir las expectativas y brindar soluciones confiables y vanguardistas.</p>
                        </div>
                    </div>
                    <div class="xiaomi-card">
                        <img src="public/img/vision.png" alt="Visión">
                        <div class="xiaomi-card-body">
                            <h3>Nuestra Visión</h3>
                            <p>En AsTech Computer soñamos con un 2030 donde seamos la empresa de servicios tecnológicos de referencia en Puerto Vallarta, reconocida por nuestra excelencia, compromiso, innovación y la confianza que nos brinda nuestra comunidad.</p> <p>Creceremos junto a nuestros clientes y aliados estratégicos, compartiendo una misma visión de futuro: desarrollar talento local, promover la tecnología responsable y generar un impacto positivo en nuestro entorno.
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
                    <blockquote>“En nuestra empresa tratamos cada equipo como si fuera propio, porque sabemos que ahí está tu trabajo, tus recuerdos y tu información.”</blockquote>
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
                    <img src="public/img/logoATC.png" alt="AS TECH Logo" style="width: 160px; filter: brightness(0) invert(1);">
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

    <script src="public/js/fuciones.js"></script>

    <div id="overlay-bloqueo" class="overlay-cookies"></div>
    <div id="banner-cookies" class="contenedor-cookies">
        <div class="texto-cookies">
            <i class="fa-solid fa-cookie-bite"></i>
            <div>
                <h3 style="margin: 0 0 5px 0; color: #52073a; font-size: 1.1rem;">Tu privacidad es importante</h3>
                <p>En <strong>Astech Computer</strong> utilizamos cookies propias y de terceros para mejorar tu experiencia, garantizar el agendamiento de citas y analizar el tráfico de la web. Puedes aceptar todas las cookies o rechazarlas. Conoce más en nuestra <a href="app/views/politica_cookies.php" target="_blank">Política de Cookies</a>.</p>
            </div>
        </div>
        <div class="botones-cookies">
            <button id="btn-rechazar-cookies" class="btn-rechazar">Rechazar</button>
            <button id="btn-aceptar-cookies" class="btn-aceptar">Aceptar</button>
        </div>
    </div>

    <style>
        .bloquear-scroll { overflow: hidden; }
        .overlay-cookies { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); z-index: 999998; display: none; }
        .contenedor-cookies { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90%; max-width: 600px; background-color: #ffffff; box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.2); border-radius: 20px; display: none; flex-direction: column; padding: 40px; z-index: 999999; text-align: center; }
        .texto-cookies { display: flex; flex-direction: column; align-items: center; gap: 15px; margin-bottom: 30px; }
        .texto-cookies i { font-size: 55px; color: #e06c00; }
        .texto-cookies p { margin: 0; font-size: 1rem; color: #444; line-height: 1.6; }
        .texto-cookies a { color: #e06c00; font-weight: bold; text-decoration: none; border-bottom: 2px solid transparent; transition: border-color 0.3s; }
        .texto-cookies a:hover { border-color: #e06c00; }
        .botones-cookies { display: flex; justify-content: center; gap: 20px; width: 100%; }
        .btn-aceptar { background-color: #52073a; color: white; border: 2px solid #52073a; padding: 14px 30px; border-radius: 30px; cursor: pointer; font-weight: bold; transition: all 0.3s; flex: 1; font-size: 1rem;}
        .btn-aceptar:hover { background-color: #e06c00; border-color: #e06c00; }
        .btn-rechazar { background-color: transparent; color: #52073a; border: 2px solid #52073a; padding: 14px 30px; border-radius: 30px; cursor: pointer; font-weight: bold; transition: all 0.3s; flex: 1; font-size: 1rem;}
        .btn-rechazar:hover { background-color: #f5f5f7; color: #e06c00; border-color: #e06c00; }
        @media (max-width: 600px) { .botones-cookies { flex-direction: column; } }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const banner = document.getElementById("banner-cookies");
            const overlay = document.getElementById("overlay-bloqueo");
            const btnAceptar = document.getElementById("btn-aceptar-cookies");
            const btnRechazar = document.getElementById("btn-rechazar-cookies");

            if (!document.cookie.split('; ').find(row => row.startsWith('astech_cookies_estado='))) {
                banner.style.display = "flex";
                overlay.style.display = "block";
                document.body.classList.add("bloquear-scroll");
            }

            function procesarDecision(decision) {
                banner.style.display = "none";
                overlay.style.display = "none";
                document.body.classList.remove("bloquear-scroll");
                let fechaExpiracion = new Date();
                fechaExpiracion.setTime(fechaExpiracion.getTime() + (365 * 24 * 60 * 60 * 1000));
                document.cookie = "astech_cookies_estado=" + decision + "; expires=" + fechaExpiracion.toUTCString() + "; path=/";
            }

            btnAceptar.addEventListener("click", function() { procesarDecision("aceptadas"); });
            btnRechazar.addEventListener("click", function() { procesarDecision("rechazadas"); });
        });
    </script>
</body>
</html>