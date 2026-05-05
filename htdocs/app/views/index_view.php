<?php
/**
 * PÁGINA: Página Principal (Inicio) - As Tech Computer
 * PROPÓSITO: Presentar la identidad de la empresa, sus servicios principales y generar confianza en el usuario.
 * FUNCIONALIDADES: 
 * - Sección "Hero" con imagen, eslogan y accesos rápidos (agendar cita y más información).
 * - Integración dinámica de barra de navegación (toolbar) y footer mediante controladores.
 * - Sección informativa "¿Quiénes somos?" con descripción e imagen representativa.
 * - Visualización de servicios principales mediante tarjetas interactivas (Diagnóstico, Mantenimiento, Reparación).
 * - Presentación de la filosofía empresarial: misión, visión y valores corporativos.
 * - Sección destacada del CEO con mensaje institucional y branding.
 * - Sistema de gestión de cookies trasladado al Footer global.
 * - Inclusión de loader inicial para mejorar la experiencia de carga.
 * - Uso de recursos externos como Google Fonts y Font Awesome para mejorar el diseño visual.
 */

?>
<?php
/** @var array $info Contiene 'quienes_somos', 'mision', 'vision', 'frase_fundador' */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsTech Computer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="<?= BASE_URL ?>public/img/Astech ICO.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/toolbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/footer.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/carousel.css">
</head>

<body>

    <?php include_once __DIR__ . "/fijos/loader_view.php"; ?>

    <?php
    $ruta_prefijo = "";
    $ruta_img = "../../public/img/servicios/";

    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>

    <main>
        <section class="hero-wrapper">
            <div class="hero-astech">
                <div class="hero-texto">

                    <div class="hero-imagen">
                        <img src="<?= BASE_URL ?>public/img/logo_horizontal.png" alt="Logo AsTech Computer">
                    </div>

                    <p class="destacado"> Confiabilidad, garantia y transparencia </p>
                    <div class="hero-botones">
                        <a href="app/controllers/citas_cliente_controller.php" class="btn-comprar">Agendar cita</a>
                        <a href="app/controllers/mas_info_controller.php" class="enlace-mas">Más información <i
                                class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>

            </div>
        </section>

        <section class="seccion-about">
            <div class="grid-about">
                <div class="texto-about">
                    <h2>¿Quiénes somos?</h2>
                    <p><?= htmlspecialchars($info['quienes_somos']) ?></p>
                </div>
                <div class="imagen-about">
                    <img src="<?= BASE_URL ?>public/img/quienes_somos.JPG" alt="Trabajo en Astech">
                </div>
            </div>
        </section>

        <section id="servicios" class="seccion-valores">
            <div class="contenedor-max">
                <h2 class="titulo-seccion">Nuestros Servicios</h2>
                <div class="grid-cards">
                    <div class="astech-card">
                        <img src="<?= BASE_URL ?>public/img/diagnostico.JPG" alt="Diagnóstico">
                        <div class="astech-card-body">
                            <h3>Reparación y reemplazo</h3>
                            <p>Restauración técnica y cambio de componentes dañados con piezas de alta calidad</p>
                             <a href="<?php echo BASE_URL; ?>app/controllers/servicios_controller.php#reparación-y-reemplazo">
                            <button class="btn-comprar">Ver mas</button>
                            </a>
                        </div>
                    </div>
                    <div class="astech-card">
                        <img src="<?= BASE_URL ?>public/img/manten.jpg" alt="Mantenimiento">
                        <div class="astech-card-body">
                            <h3>Mantenimiento </h3>
                            <p>Limpieza física y optimización de software para máxima velocidad</p>
                            <a href="<?php echo BASE_URL; ?>app/controllers/servicios_controller.php#mantenimiento-preventivo">
                            <button class="btn-comprar">Ver mas</button>
                            </a>
                        </div>
                    </div>
                    <div class="astech-card">
                        <img src="<?= BASE_URL ?>public/img/reparacion.jpg" alt="Reparación">
                        <div class="astech-card-body">
                            <h3>Servicios especializados</h3>
                            <p>Asesoria profesional, diagnostico avanzado y asistencia remota, soluciones expertas a tu medida</p>
                            <a href="<?php echo BASE_URL; ?>app/controllers/servicios_controller.php#servicios-especializados">
                             <button class="btn-comprar">Ver mas</button>
                            </a>
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
                        <img src="<?= BASE_URL ?>public/img/mision.png" alt="Misión">
                        <div class="astech-card-body">
                            <h3>Nuestra Misión</h3>
                            <p><?= htmlspecialchars($info['mision']) ?></p>
                        </div>
                    </div>
                    <div class="astech-card">
                        <img src="<?= BASE_URL ?>public/img/vision.png" alt="Visión">
                        <div class="astech-card-body">
                            <h3>Nuestra Visión</h3>
                            <p><?= htmlspecialchars($info['vision']) ?></p>
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
                    <img src="<?= BASE_URL ?>public/img/isologotipo.png" alt="Logo" style="width: 60px; margin-bottom: 20px;">
                    <blockquote><?= htmlspecialchars($info['frase_fundador']) ?></blockquote>
                    <p style="font-weight: 700; font-size: 1.2rem;">Ferdán Garrigos</p>
                    <p style="color: var(--color-texto-secundario);">Fundador & CEO</p>
                </div>
                <div class="ceo-img">
                    <img src="<?= BASE_URL ?>public/img/ceoo.png" alt="CEO de AsTech Computer">
                </div>
            </div>
        </section>

        

    <h2 class="titulo-seccion">Marcas</h2>
    <?php require_once __DIR__ . '/carousel_marcas.php'; ?>
    </main>
    <?php
    $ruta_prefijo = "";
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

    <script src="<?= BASE_URL ?>public/js/index.js"></script>
    
    <script src="<?= BASE_URL ?>public/js/Carousel.js"></script>
</body>

</html>