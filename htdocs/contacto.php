<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Proyecto en InfinityFree</title>
    
    <link rel="stylesheet" href="css/estilos.css">
    
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>

    <header>
        <h1>Bienvenido a Astech Computer</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Estado del Servidor</h2>
            <p>
                <?php 
                    // Ejemplo sencillo de PHP: Mostrar fecha y hora actual
                    date_default_timezone_set('America/Mexico_City');
                    echo "Hoy es: " . date("d/m/Y") . "<br>";
                    echo "La hora del servidor es: " . date("H:i:s");
                ?>
            </p>
        </section>

        <section>
            <p>Este es el contenido principal de tu sitio alojado en htdocs.</p>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Astech Computer - Todos los derechos reservados.</p>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>