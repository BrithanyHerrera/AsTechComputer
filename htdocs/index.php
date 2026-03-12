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

<?php $ruta_prefijo = ""; include "toolbar.php"; ?>
   

    <main>
        <div class="fondo">
            <img src="public/img/logoATC.png" alt="Logo ATC" style="width:30%; margin-left:5%;">
        </div>

        <div class="infoAbUs">
            <div class="texto">
                <h2 class="titulo">¿Quienes somos?</h2>
                <p>En Astech, somos una microempresa orgullosamente mexicana dedicada a transformar la relación de las
                    personas con su tecnología. Entendemos que hoy en día, una computadora no es solo una herramienta;
                    es tu oficina, tu centro de entretenimiento y tu conexión con el mundo.</p>
                <p>Nacimos con la misión de ofrecer soluciones integrales en sistemas de información, combinando la
                    precisión técnica con un trato honesto y transparente.</p>
            </div>
            <div class="imagen">
                <div class="wrapper-irregular">
                    <img src="public/img/trabajado.JPG
                    " alt="" class="Iprincipal">
                </div>
            </div>
        </div>

        <div class="infoMV">
            <div class="mision">
                <img src="public/img/mision.png" alt="Misión" style="width: 100%; height:100%;">
                <div class="wrapperm">
                    <h1>Misión</h1>
                    <p>"Brindar soluciones tecnológicas integrales en sistemas de información, mantenimiento y armado de
                        equipos de cómputo, garantizando un servicio honesto, técnico y personalizado que permita a
                        nuestros clientes optimizar su productividad y mantenerse conectados con lo que más les
                        importa."</p>
                </div>
            </div>
            <div class="vision">
                <img src="public/img/vision.png" alt="Visión" style="width: 100.7%; height:100%;">
                <div class="wrapperv">
                    <h1>Visión</h1>
                    <p>"Consolidarnos como la microempresa líder y de mayor confianza en nuestra región para el soporte
                        técnico y ensamble de computadoras, siendo reconocidos por nuestra innovación constante, la
                        calidad de nuestros procesos y el trato humano que nos distingue de las grandes corporaciones."
                    </p>
                </div>
            </div>
        </div>

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
    “En nuestra empresa tratamos cada equipo como si fuera propio, porque sabemos que ahí está tu trabajo, tus recuerdos y tu información."
      </blockquote>
      <p class="nombre-ceo"><strong>Ferdán Garrigos</strong></p>
      <p class="puesto-ceo">Fundador & CEO</p>
    </div>
    <div class="imagen-ceo">
      <img src="public/img/ceoo.png" alt="CEO de Astech Computer" >
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
          <li><a href="app/views/login.php">Operaciones</a></li>
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
  <hr></hr>

  </ul>
    

</div>
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