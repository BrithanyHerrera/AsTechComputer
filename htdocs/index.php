<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astech Computer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="public/css/static.css">
    <link rel="icon" href="public/img/Astech ICO.ico" type="image/x-icon">
    <link rel="stylesheet" href="public/css/toolbar.css">
</head>

<body>

    <?php $ruta_prefijo = "";
    include "toolbar.php"; ?>

    <main>
        <div class="fondo">
            <img src="public/img/logoATC.png" alt="Logo ATC" style="width:30%; margin-left:5%;">
        </div>

        <div class="infoAbUs">
            <div class="texto">
                <h2 class="titulo">¿Quiénes somos?</h2>
                <p style="font-size: 1.1rem; color: #444; line-height: 1.8;">Somos una empresa humana y amigable, guiada por los valores de integridad y transparencia para brindar a nuestros clientes servicios de reparación y mantenimiento de calidad. Nuestro compromiso es garantizar que tu tecnología siempre funcione a la perfección.</p>
            </div>
            <div class="imagen">
                <div class="wrapper-irregular">
                    <img src="public/img/trabajado.JPG" alt="" class="Iprincipal">
                </div>
            </div>
        </div>

        <div class="infoMV">
            <div class="mision">
                <img src="public/img/mision.png" alt="Misión" style="width: 100%; height:100%;">
                <div class="wrapperm">
                    <h1>Misión</h1>
                    <p>"Brindamos una experiencia integral a nuestros clientes con servicios de reparación, mantenimiento, asesoría computacional y soporte a MiPymes de la región, garantizando la privacidad de datos y ofreciendo garantía en todos nuestros servicios, con principios de transparencia, honestidad y respeto para cumplir las expectativas y brindar soluciones confiables y vanguardistas."</p>
                </div>
            </div>
            <div class="vision">
                <img src="public/img/vision.png" alt="Visión" style="width: 100.7%; height:100%;">
                <div class="wrapperv">
                    <h1>Visión</h1>
                    <p>"En AsTech Computer soñamos con un 2030 donde seamos la empresa de servicios tecnológicos de referencia en Puerto Vallarta, reconocida por nuestra excelencia, compromiso, innovación y la confianza que nos brinda nuestra comunidad.</p>
                    <p>Creceremos junto a nuestros clientes y aliados estratégicos, compartiendo una misma visión de futuro: desarrollar talento local, promover la tecnología responsable y generar un impacto positivo en nuestro entorno."</p>
                </div>
            </div>
        </div>

        <section class="seccion-valores">
            <h2 class="titulo titulo-centrado">Nuestros Valores</h2>
            
            <div class="lista-valores">
                <div class="item-valor">
                    <div class="icono-valor">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="textos-valor">
                        <h4>Confiabilidad</h4>
                        <p>Nos comprometemos a ofrecer servicios y soluciones tecnológicas en los que nuestros clientes puedan confiar, reflejando seguridad y profesionalismo en cada acción.</p>
                    </div>
                </div>

                <div class="item-valor">
                    <div class="icono-valor">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div class="textos-valor">
                        <h4>Calidad y Garantía</h4>
                        <p>Cuidamos la excelencia de nuestro trabajo, los insumos y refacciones que utilizamos, asegurando la satisfacción y respaldo total en cada servicio.</p>
                    </div>
                </div>

                <div class="item-valor">
                    <div class="icono-valor">
                        <i class="fa-solid fa-handshake-simple"></i>
                    </div>
                    <div class="textos-valor">
                        <h4>Integridad y Transparencia</h4>
                        <p>Actuamos con honestidad, ética y responsabilidad en todas nuestras relaciones, fomentando la confianza y el respeto mutuo dentro y fuera de la organización.</p>
                    </div>
                </div>

                <div class="item-valor">
                    <div class="icono-valor">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="textos-valor">
                        <h4>Enfoque en el Cliente</h4>
                        <p>Ponemos al cliente en el centro de nuestras decisiones, comprendiendo sus necesidades y brindando soluciones efectivas y personalizadas que superen sus expectativas.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="seccion-servicios">
            <h2 class="servicios-titulo">Nuestros servicios</h2>

            <div class="servicios-contenedor">
                <div class="servicio-tarjeta">
                    <div class="contenido-tarjeta">
                        <img src="public/img/diagnostico.jpg" alt="Diagnóstico">
                        <button class="btn-servicio">Diagnostico</button>
                    </div>
                </div>

                <div class="servicio-tarjeta">
                    <div class="contenido-tarjeta">
                        <img src="public/img/manten.jpg" alt="Mantenimiento">
                        <button class="btn-servicio">Mantenimiento</button>
                    </div>
                </div>

                <div class="servicio-tarjeta">
                    <div class="contenido-tarjeta">
                        <img src="public/img/reparacion.jpg" alt="Reparación">
                        <button class="btn-servicio">Reparación</button>
                    </div>
                </div>

            </div>
        </section>

        <section class="seccion-ceo">
            <div class="contenedor-ceo">
                <div class="contenido-texto">
                    <img src="public/img/Iso.png" alt="Logo" class="logo-empresa">
                    <blockquote class="frase-ceo">
                        “En nuestra empresa tratamos cada equipo como si fuera propio, porque sabemos que ahí está tu
                        trabajo, tus recuerdos y tu información."
                    </blockquote>
                    <p class="nombre-ceo"><strong>Ferdán Garrigos</strong></p>
                    <p class="puesto-ceo">Fundador & CEO</p>
                </div>
                <div class="imagen-ceo">
                    <img src="public/img/ceoo.png" alt="CEO de Astech Computer">
                </div>
            </div>
        </section>

        <footer class="pie-pagina">
            <div class="contenedor-pie">

                <div class="seccion-logo">
                    <img src="public/img/logoATC.png" alt="AS TECH Logo" class="logo-footer">
                </div>

                <div class="filas-enlaces">
                    <div class="fila-links">
                        <h4>Servicios</h4>
                        <ul>
                            <li><a href="#">Reparacion y remplazo</a></li>
                            <li><a href="#">Mantenimiento preventivo</a></li>
                            <li><a href="#">Instalación de software</a></li>
                            <li><a href="#">Servicios especializados</a></li>
                            <li><a href="#">Servicios a domicilio</a></li>
                        </ul>
                    </div>

                    <div class="fila-links">
                        <h4>Empresa</h4>
                        <ul>
                            <li><a href="#">Sobre Nosotros</a></li>
                            <li><a href="#">Contacto</a></li>
                            <li><a href="#">Ubicación</a></li>
                            <li><a href="app/controllers/convenios_controller.php">Convenios</a></li>
                            <li><a href="app/controllers/login_controller.php">Operaciones</a></li>
                        </ul>
                    </div>
                </div>
                <div class="fila-links">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Politica de privacidad</a></li>
                        <li><a href="#">Aviso de privacidad</a></li>
                        <li><a href="#">Preferencias</a></li>
                    </ul>
                </div>
                <div class="redes-sociales">
                    <h4>Siguenos en</h4>
                    <ul>
                        <li><button class="btn-Whatsapp"><i class="fa-brands fa-square-whatsapp"></i></button></li>
                        <li><button class="btn-ig"><i class="fa-brands fa-square-instagram"></i></button></li>
                        <li><button class="btn-facebook"><i class="fa-brands fa-square-facebook"></i></button></li>
                        <li><button class="btn-tiktok"><i class="fa-brands fa-tiktok"></i></button></li>
                        <li><button class="btn-yo"><i class="fa-brands fa-square-youtube"></i></button></li>
                    </ul>
                    <hr>
                </div>
            </div>

            <div class="barra-derechos">
                <p>&copy; 2026 AS TECH COMPUTER. Todos los derechos reservados.</p>
            </div>
        </footer>
    </main>

    <script src="public/js/fuciones.js"></script>
</body>

</html>