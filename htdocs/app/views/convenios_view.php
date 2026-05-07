<?php 
/* CONVENIOS_VIEW.PHP */
/*
 * Vista que muestra alianzas, proveedores y convenios de As Tech Computer.
 * Incluye diseño responsive con toolbar, footer y loader.
 * Presenta:
 * - Carrusel de marcas tecnológicas.
 * - Tarjetas en grid de proveedores, partners y alianzas.
 * - Convenios educativos con beneficios y estado (activo/próximo).
 * Usa HTML, CSS, JavaScript, Font Awesome y Google Fonts.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convenios | AS TECH</title>
    
<link rel="icon" href="<?= BASE_URL ?>public/img/astech_icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/convenios.css">
    <link rel="stylesheet" href="../../public/css/carousel.css">
</head>
<body>
    <?php 
    // El sistema incluye la pantalla de carga y procesa el enrutamiento del menú global
    include_once __DIR__ . "/fijos/loader_view.php"; 
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
          <h2 class="titulo-bloque">Marcas</h2>
        <?php require_once __DIR__ . '/carousel_marcas.php'; ?>

        <div class="bloque">
            <h2 class="titulo-bloque">Proveedores</h2>
            <div class="grid-convenios">
<div class="card-convenio tema-naranja">
    <span class="badge-convenio">Activo</span>
    <div class="logo-empresa" id="dark">
        <img src="../../public/img/powe.png" alt="Logo CCS">
    </div>

    <div class="contenido-card">

        <h3 >POWE</h3>

        <h2>
            Proveedor de cargadores y baterías compatible de calidad premium con garantía
        </h2>
        <p class="texto-beneficios"><span class="texto-naranja">Beneficios:</span>
       Equipos confiables con tiempos de entrega eficientes.
 </p>
<div class="detalles-convenio">
        <div class="seccion-card">

            <p class="titulo-seccion">Aportaciones:</p>

            <ul class="beneficios-lista">
                <li>Suministro de refacciones</li>
                <li>Disponibilidad de componentes</li>
                <li>Soporte en adquisición</li>
            </ul>

        </div>
        <div class="info-empresa">

            <div class="info-item">
                <span class="info-label" >Convenio</span>
                <span class="info-value"></span>3+ Años</span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    <i class="fa-solid fa-location-dot"></i>
                    Ubicación
                </span>

                <span class="info-value">Tlaquepaque, Jalisco</span>
            </div>

        </div>
        </div>
        <div class="palabras-clave">
            <span class="tag-palabra">Suministro</span>
            <span class="tag-palabra">Hardware</span>
            <span class="tag-palabra">Tecnologia</span>
        </div>
    </div>
</div>
 <div class="card-convenio tema-naranja">
    <span class="badge-convenio">Activo</span>
    <div class="logo-empresa" id="dark">
        <img src="../../public/img/rumbafierro.png" alt="Logo CCS">
    </div>

    <div class="contenido-card">

        <h3 >Recicladora Rumba Fierro</h3>
        <h2>
          Empresa especializada en reciclaje y gestión responsable de residuos.
        </h2>
   <p class="texto-beneficios"><span class="texto-naranja">Beneficios:</span>
Servicios responsables con el medio ambiente.
</p>

<div class="detalles-convenio">
        <div class="seccion-card">

            <p class="titulo-seccion">Aportaciones:</p>

            <ul class="beneficios-lista">
                <li>Manejo de residuos electronivos</li>
                <li>Procesos sustentables</li>
                <li>Apoyo en reciclaje</li>
            </ul>

        </div>
        <div class="info-empresa">

            <div class="info-item">
                <span class="info-label" >Convenio</span>
                <span class="info-value">1+ Año</span>
            </div>

            <div class="info-item">
                <span class="info-label" >
                    <i class="fa-solid fa-location-dot"></i>
                    Ubicación
                </span>

                <span class="info-value">Puerto Vallarta, Jalisco</span>
            </div>
     

        </div>
        </div>
        <div class="palabras-clave">
            <span class="tag-palabra">Sustenabilidad</span>
            <span class="tag-palabra">Reciclaje</span>
            <span class="tag-palabra">Responsabilidad ambiental</span>

        </div>
    </div>
</div>
            </div>
        </div>


        <div class="bloque">
            <h2 class="titulo-bloque">Alianzas estrategicas</h2>
            <div class="grid-convenios">
<div class="card-convenio tema-morado">
    <span class="badge-convenio">Activo</span>
    <div class="logo-empresa">
        <img src="../../public/img/ccs_logo.png" alt="Logo CCS">
    </div>

    <div class="contenido-card">

        <h3>Centro de Copiadoras y Servicios</h3>

        <h2>
            Empresa especializada en renta de equipos de copiado,
            mantenimiento y suministro de consumibles para entornos empresariales.
        </h2>
        <p class="texto-beneficios"><span class="texto-naranja">Beneficios:</span> Soluciones más completas e integradas.
 </p>
<div class="detalles-convenio">
        <div class="seccion-card">

            <p class="titulo-seccion">Aportaciones:</p>

            <ul class="beneficios-lista">
                <li>Renta de equipos de copiado</li>
                <li>Mantenimiento técnico especializado</li>
                <li>Suministro de consumibles</li>
            </ul>

        </div>
        <div class="info-empresa">

            <div class="info-item">
                <span class="info-label">Convenio</span>
                <span class="info-value">3+ Años</span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    <i class="fa-solid fa-location-dot"></i>
                    Ubicación
                </span>

                <span class="info-value">Puerto Vallarta, Jalisco</span>
            </div>

        </div>
        </div>
        <div class="palabras-clave">
            <span class="tag-palabra">Copiadoras</span>
            <span class="tag-palabra">Mantenimiento</span>
            <span class="tag-palabra">Consumibles</span>
            <span class="tag-palabra">Soporte técnico</span>

        </div>
    </div>
</div>
 <div class="card-convenio tema-morado">
    <span class="badge-convenio">Activo</span>
    <div class="logo-empresa">
        <img src="../../public/img/dr_game_pad.png" alt="Logo CCS">
    </div>

    <div class="contenido-card">

        <h3>Dr. Gamepad</h3>
        <h2>
          Especialistas en reparación de controles y videoconsolas
        </h2>
   <p class="texto-beneficios"><span >Beneficios:</span>
   Atención especializada para equipos y accesorios gaming.</p>

<div class="detalles-convenio">
        <div class="seccion-card">

            <p class="titulo-seccion">Aportaciones:</p>

            <ul class="beneficios-lista">
                <li>Reparación de video consolas</li>
                <li>Reparación de perifericos</li>
                <li>Servicios técnicos especificos</li>
            </ul>

        </div>
        <div class="info-empresa">

            <div class="info-item">
                <span class="info-label">Convenio</span>
                <span class="info-value">3+ Años</span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    <i class="fa-solid fa-location-dot"></i>
                    Ubicación
                </span>

                <span class="info-value">Puerto Vallarta, Jalisco</span>
            </div>
     

        </div>
        </div>
        <div class="palabras-clave">
            <span class="tag-palabra">Gaming</span>
            <span class="tag-palabra">Reparación</span>
            <span class="tag-palabra">Especializado</span>
        </div>
    </div>
</div>
            </div>
        </div>
                <div class="bloque">
            <h2 class="titulo-bloque">Partners</h2>
            <div class="grid-convenios">
        <div class="card-convenio tema-naranja">
    <span class="badge-convenio">Activo</span>
    <div class="logo-empresa" id="dark">
        <img src="../../public/img/hey.png" alt="Logo CCS">
    </div>
    <div class="contenido-card">
        <h3>Hey Network</h3>
        <h2>
Agencia creativa enfocada en marketing estratégico, desarrollo de identidad visual y crecimiento en redes sociales.
        </h2>
   <p class="texto-beneficios"><span >Beneficios:</span>
   Servicios fortalecidos mediante conexiones y colaboración empresarial.
</p>


<div class="detalles-convenio">
        <div class="seccion-card">

            <p class="titulo-seccion">Aportaciones:</p>

            <ul class="beneficios-lista">
                <li>Desarrollo de estrategias de marketing</li>
                <li>Diseño y fortalecimiento de identidad visual</li>
                <li>Gestión y crecimiento en redes sociales</li>
            </ul>

        </div>
        <div class="info-empresa">

            <div class="info-item">
                <span class="info-label">Convenio</span>
                <span class="info-value">1+ Año</span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    <i class="fa-solid fa-location-dot"></i>
                    Ubicación
                </span>

                <span class="info-value">Puerto Vallarta, Jalisco</span>
            </div>
     

        </div>
        </div>
        <div class="palabras-clave">
            <span class="tag-palabra">Consultorias</span>
            <span class="tag-palabra">Marca</span>
            <span class="tag-palabra">Diseño</span>
        </div>
    </div>
</div>
        <div class="card-convenio tema-naranja">
    <span class="badge-convenio">Activo</span>
    <div class="logo-empresa" id="dark">
        <img src="../../public/img/syscom.png" alt="Logo CCS">
    </div>
    <div class="contenido-card">
        <h3>SYSCOM</h3>
        <h2>
Distribuidor líder en tecnología, especializado en telecomunicaciones, seguridad y redes.
        </h2>
   <p class="texto-beneficios"><span >Beneficios:</span>
Acceso a tecnología de nivel empresarial con mayor disponibilidad y confiabilidad.

</p>


<div class="detalles-convenio">
        <div class="seccion-card">

            <p class="titulo-seccion">Aportaciones:</p>

            <ul class="beneficios-lista">
                <li>Acceso a catálogo empresarial</li>
                <li>Equipamiento profesional</li>
                <li>Soporte técnico y capacitación</li>
            </ul>

        </div>
        <div class="info-empresa">

            <div class="info-item">
                <span class="info-label">Convenio</span>
                <span class="info-value">1+ Año</span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    <i class="fa-solid fa-location-dot"></i>
                    Ubicación
                </span>

                <span class="info-value">México</span>
            </div>
     

        </div>
        </div>
        <div class="palabras-clave">
            <span class="tag-palabra">Tecnologia</span>
            <span class="tag-palabra">Infraestructura</span>
            <span class="tag-palabra">Redes</span>
            <span class="tag-palabra">Seguridad</span>
        </div>
    </div>
</div>
            </div>
    </div>

           
  

<div class="bloque bloque-educativo">
    <h2 class="titulo-bloque">Convenios Educativos</h2>
    <div class="grid-convenios-full">
        
        <article class="card-educativa">
            <div class="imagen-institucion">
                <img src="../../public/img/cucosta.png" alt="Centro Universitario de la Costa">
            </div>
            
            <div class="body-convenio-edu">
                <span class="badge-edu">Activo</span>
                <h3>Universidad de Guadalajara</h3>
                <small>Centro Universitario de la Costa (CUCosta)</small>
                
                <p>Colaboración académica para el desarrollo de talento mediante proyecto y practicas profesionales
</p>
                
                <ul class="beneficios-lista-edu">
                    <li><i class="fa-solid fa-circle-check"></i>Prácticas Profesionales</li>
                    <li><i class="fa-solid fa-circle-check"></i>Formación</li>
                    <li><i class="fa-solid fa-circle-check"></i>Vinculación academica</li>
                </ul>
            </div>
            
            <div class="footer-convenio">
                <i class="fa-solid fa-location-dot"></i> Av. Universidad 203, Puerto Vallarta, Jal.
            </div>
        </article>

        <article class="card-educativa-prox">
            <div class="body-convenio-edu" id="proximamente" >
                <i class="fa-solid fa-handshake-angle" ></i>
                <h3>Próximamente</h3>
                <p>Estamos gestionando nuevas alianzas con el sector educativo para seguir impulsando el talento local.</p>
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