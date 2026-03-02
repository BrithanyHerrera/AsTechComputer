<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astech Computer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="public/css/static.css">
    <link rel="icon" href="public/img/logoATC.ico" type="image/x-icon">
</head>

<body>

    <header>
        <nav>
            <ul>
                <li class="nav-link"><a href="servicios.php">Servicios</a></li>
                <li class="nav-link"><a href="contacto.php">Contacto</a></li>
                <li class="nav-link-P"><a href="cita.php">Agendar cita</a></li>
            </ul>
        </nav>
    </header>

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
                    <img src="public/img/revisandoCompu.jpg" alt="" class="Iprincipal">
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
                        <img src="public/img/revisandoCompu.jpg" alt="Diagnóstico">
                        <button class="btn-servicio">Diagnostico</button>
                    </div>
                </div>

                <div class="servicio-tarjeta">
                    <div class="contenido-tarjeta">
                        <img src="public/img/mantenimiento.jpg" alt="Mantenimiento">
                        <button class="btn-servicio">Mantenimiento</button>
                    </div>
                </div>

                <div class="servicio-tarjeta">
                    <div class="contenido-tarjeta">
                        <img src="public/img/reparando.jpg" alt="Reparación">
                        <button class="btn-servicio">Reparación</button>
                    </div>
                </div>
            </div>
        </section>
    </main>



    <script src="public/js/fuciones.js"></script>
</body>
</html>