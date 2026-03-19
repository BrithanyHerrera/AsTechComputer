<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">

    <style>
    :root {
        --color-primario: #52073a;
        --color-secundario: #2c041f;
        --color-acento: #e9ecef;
        --texto-oscuro: #333;
        --texto-claro: #fff;
    }

    /* CAMBIO AQUÍ: Aumentamos el padding superior para librar la Toolbar */
    .seccion-convenios {
        padding: 100px 20px 60px 20px; /* 100px arriba para que no se corte */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        text-align: center;
        min-height: 100vh; /* Asegura que el fondo cubra toda la pantalla */
    }

    .contenedor-convenios {
        max-width: 1000px;
        margin: 0 auto;
    }

    .titulo-convenios {
        color: var(--color-primario);
        font-size: 2.5rem;
        margin-bottom: 10px;
        text-transform: uppercase;
        font-weight: 800;
        /* Un pequeño margen extra opcional */
        margin-top: 20px; 
    }

    .subtitulo-convenios {
        color: #666;
        margin-bottom: 40px;
        font-size: 1.1rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    /* ... El resto de tu CSS de tarjetas se mantiene igual ... */
    .grid-convenios {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 20px;
    }

    .card-convenio {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        border-top: 5px solid var(--color-primario);
    }

    .card-convenio:hover { transform: translateY(-10px); }

    .header-convenio {
        padding: 30px;
        background: linear-gradient(135deg, #fff 0%, var(--color-acento) 100%);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .body-convenio { padding: 25px; }
    .body-convenio h3 { color: var(--color-primario); margin-bottom: 15px; font-size: 1.4rem; }
    .beneficios-lista { list-style: none; padding: 0; text-align: left; margin: 20px 0; }
    .beneficios-lista li { margin-bottom: 10px; color: var(--texto-oscuro); display: flex; align-items: center; gap: 10px; }
    .beneficios-lista i { color: #28a745; }
    .badge-convenio { background: var(--color-primario); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; display: inline-block; margin-bottom: 10px; }
    .footer-convenio { background: #f1f1f1; padding: 15px; font-size: 0.9rem; color: #777; }

    @media (max-width: 768px) {
        .seccion-convenios { padding-top: 120px; } /* Más espacio en móvil si la toolbar es más alta */
        .titulo-convenios { font-size: 2rem; }
    }
</style>
</head>
<body>
    <?php 
    // Mantenemos tu toolbar original
    $ruta_prefijo = "../../";
    @include "../../toolbar.php"; 
    ?>

<section class="seccion-convenios">
    <div class="contenedor-convenios">
        <h2 class="titulo-convenios">Nuestros Convenios</h2>
        <p class="subtitulo-convenios">En <strong>ASTECH COMPUTER</strong>, apoyamos a la comunidad académica brindando beneficios exclusivos en servicios de reparación y mantenimiento.</p>

        <div class="grid-convenios">
            <article class="card-convenio">
                <div class="header-convenio">
                    <i class="fa-solid fa-graduation-cap" style="font-size: 4rem; color: var(--color-primario);"></i>
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
                    <div style="height: 120px;"></div> </div>
            </article>
        </div>
    </div>
</section>

</body>
</html>