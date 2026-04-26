<script>
/* SOBRE_NOSOTROS_VIEW.PHP */
/*
Este archivo representa la Vista (View) encargada de mostrar la identidad corporativa de ASTECH COMPUTER. Su objetivo es consolidar en una página exclusiva la misión, visión, valores y el mensaje del fundador (CEO). Para conservar la estética y evitar la duplicidad de código, esta vista importa directamente la hoja de estilos index.css, además de integrar los controladores correspondientes para la barra de navegación (Toolbar) y el pie de página (Footer). Tras los ajustes solicitados, se redujo el espacio superior debajo de la barra de navegación y se unificaron las secciones de "Quiénes somos" y "Filosofía Empresarial" dentro de un mismo bloque, logrando una transición visual más fluida.
*/
</script>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - AsTech Computer</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="../../public/img/Astech%20ICO.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/index.css">
</head>

<body style="background-color: #f9f9fb;">

    <?php
    require_once __DIR__ . "/../config/config.php"; 
    $ruta_prefijo = "../../../";
    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>

    <main style="padding-top: 20px;">
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
                    <img src="../../public/img/trabajado.JPG" alt="Trabajo en Astech">
                </div>
            </div>

            <div class="contenedor-max" style="margin-top: 50px;">
                <h2 class="titulo-seccion" style="text-align: center; margin-bottom: 40px;">Filosofía Empresarial</h2>

                <div class="grid-cards" style="margin-bottom: 60px;">
                    <div class="astech-card">
                        <img src="../../public/img/mision.png" alt="Misión">
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
                        <img src="../../public/img/vision.png" alt="Visión">
                        <div class="astech-card-body">
                            <h3>Nuestra Visión</h3>
                            <p>En AsTech Computer soñamos con un 2030 donde seamos la empresa de servicios tecnológicos
                                de referencia en Puerto Vallarta, reconocida por nuestra excelencia, compromiso,
                                innovación y la confianza que nos brinda nuestra comunidad.</p>
                            <p>Creceremos junto a nuestros clientes y aliados estratégicos, compartiendo una misma
                                visión de futuro: desarrollar talento local, promover la tecnología responsable y
                                generar un impacto positivo en nuestro entorno.</p>
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
                    <img src="../../public/img/Iso.png" alt="Logo" style="width: 60px; margin-bottom: 20px;">
                    <blockquote>“En nuestra empresa tratamos cada equipo como si fuera propio, porque sabemos que ahí
                        está tu trabajo, tus recuerdos y tu información.”</blockquote>
                    <p style="font-weight: 700; font-size: 1.2rem;">Ferdán Garrigos</p>
                    <p style="color: var(--color-texto-secundario);">Fundador & CEO</p>
                </div>
                <div class="ceo-img">
                    <img src="../../public/img/ceoo.png" alt="CEO de Astech Computer">
                </div>
            </div>
        </section>
    </main>

    <?php
    $ruta_prefijo = "../../../";
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

</body>

</html>