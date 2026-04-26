<?php 
/**
 * PÁGINA: Convenios - As Tech Computer
 * PROPÓSITO: Mostrar las alianzas estratégicas, marcas, proveedores y convenios institucionales 
 *            de la empresa para fortalecer la confianza del usuario y destacar su red de colaboración.
 * FUNCIONALIDADES:
 * - Estructura HTML responsive con configuración de viewport y codificación UTF-8.
 * - Integración de recursos externos como:
 *      • Google Fonts (tipografía Lato).
 *      • Font Awesome (iconografía visual).
 * - Inclusión de estilos personalizados para toolbar, footer y diseño específico de convenios.
 * - Implementación de loader inicial para mejorar la experiencia de carga.
 * - Integración dinámica de la barra de navegación (toolbar) mediante controlador.
 * - Sección principal con título y subtítulo que introduce el propósito de los convenios.
 * - Carrusel interactivo de marcas:
 *      • Navegación mediante botones (anterior/siguiente).
 *      • Visualización de logos de marcas reconocidas (Dell, Lenovo, HP, etc.).
 *      • Control dinámico mediante JavaScript externo (carousel.js).
 * - Sección de proveedores:
 *      • Tarjetas informativas con nombre de empresa y beneficios.
 *      • Presentación en formato de grid adaptable.
 * - Sección de alianzas estratégicas:
 *      • Tarjetas con beneficios como capacitaciones y eventos conjuntos.
 * - Sección de partners:
 *      • Visualización de empresas colaboradoras con integración de servicios.
 * - Sección de convenios educativos:
 *      • Tarjetas destacadas con diseño enriquecido (iconos, badges, descripción).
 *      • Información de instituciones (ej. Universidad de Guadalajara CUCosta).
 *      • Beneficios como prácticas profesionales y colaboraciones académicas.
 *      • Indicadores de estado (activo / próximamente).
 * - Uso de iconografía para reforzar la comunicación visual (graduación, ubicación, checks).
 * - Inclusión de footer dinámico mediante controlador.
 * - Organización modular del código para facilitar mantenimiento y escalabilidad.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convenios | AS TECH</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/convenios.css">
</head>
<body>
    <?php include_once __DIR__ . "/fijos/loader_view.php"; ?>
    
    <?php
    $ruta_prefijo = "../../../"; 
 
    require_once __DIR__ . "/../config/config.php"; 
    include __DIR__ . "/../controllers/toolbar_controller.php";
   

    ?>
    
    <section class="seccion-convenios">
        <h1 class="titulo-convenios">Convenios</h1>
        <p class="subtitulo-convenios">
            Conectamos con empresas, marcas y aliados estratégicos para ofrecer mejores servicios.
        </p>
    </section>

    <div class="contenedor-convenios">

        <div class="bloque">
            <h2 class="titulo-bloque">Marcas</h2>

            <div class="carousel">
                <button class="btn prev">&#10094;</button>

                <div class="carousel-track" id="carouselTrack">
                    <div class="logo"><img src="../../public/img/dell.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/lenovo.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/hp.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/acer.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/samsung.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/asus.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/huawei.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/msi.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/kingston.png" style="width:100%;"></div>
                    <div class="logo"><img src="../../public/img/xpg.jfif" style="width:100%;"></div>
                </div>

                <button class="btn next">&#10095;</button>
            </div>
        </div>

        <div class="bloque">
            <h2 class="titulo-bloque">Proveedores</h2>
            <div class="grid-convenios">
                <div class="card-convenio">
                    <span class="badge-convenio">Proveedor</span>
                    <h3>Empresa X</h3>
                    <ul class="beneficios-lista">
                        <li>Descuentos especiales</li>
                        <li>Entrega rápida</li>
                    </ul>
                </div>

                <div class="card-convenio">
                    <span class="badge-convenio">Proveedor</span>
                    <h3>Empresa Y</h3>
                    <ul class="beneficios-lista">
                        <li>Soporte técnico</li>
                        <li>Garantía extendida</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bloque">
            <h2 class="titulo-bloque">Alianzas Estratégicas</h2>
            <div class="grid-convenios">
                <div class="card-convenio">
                    <span class="badge-convenio">Alianza</span>
                    <h3>Organización A</h3>
                    <ul class="beneficios-lista">
                        <li>Capacitaciones</li>
                        <li>Eventos conjuntos</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bloque">
            <h2 class="titulo-bloque">Partners</h2>
            <div class="grid-convenios">
                <div class="card-convenio">
                    <span class="badge-convenio">Partner</span>
                    <h3>Empresa Partner</h3>
                    <ul class="beneficios-lista">
                        <li>Integración de servicios</li>
                        <li>Soporte dedicado</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bloque">
            <h2 class="titulo-bloque">Convenios Educativos</h2>
            <div class="grid-convenios">
                <article class="card-convenio">
                    <div class="header-convenio">
                        <i class="fa-solid fa-graduation-cap" style="font-size: 4rem; color: #e17203;"></i>
                    </div>
                    <div class="body-convenio">
                        <span class="badge-convenio">Activo</span>
                        <h3>Universidad de Guadalajara <br><small>CUCosta</small></h3>
                        <p>Convenio de colaboración académica y beneficios en servicios tecnológicos para la comunidad universitaria.</p>
                        
                        <ul class="beneficios-lista">
                            <li><i class="fa-solid fa-circle-check"></i> Practicas profesionales.</li>
                            <li><i class="fa-solid fa-circle-check"></i> .....</li>
                            <li><i class="fa-solid fa-circle-check"></i> .....</li>
                            <li><i class="fa-solid fa-circle-check"></i> .....</li>
                        </ul>
                    </div>
                    <div class="footer-convenio">
                        <i class="fa-solid fa-location-dot"></i> Puerto Vallarta, Jalisco.
                    </div>
                </article>

                <article class="card-convenio" style="border-top-color: #ccc; opacity: 0.7;">
                    <div class="header-convenio" style="background: #eee;">
                        <i class="fa-solid fa-handshake" style="font-size: 4rem; color: #999;"></i>
                    </div>
                    <div class="body-convenio">
                        <h3>Próximamente</h3>
                        <p>Estamos trabajando para expandir nuestras alianzas con más instituciones de la región.</p>
                        <div style="height: 120px;"></div> 
                    </div>
                </article>
            </div>
        </div>
        
    </div>

    <script src="../../public/js/carousel.js"></script>

    <?php
    $ruta_prefijo = "../../../"; 
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>
</body>
</html>