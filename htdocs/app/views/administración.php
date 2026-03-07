<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | AS TECH</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/administracion.css">
  <link rel="stylesheet" href="../../public/css/toolbar.css">
  <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<?php 
  // Definimos la sección actual una sola vez al inicio para evitar errores
  $seccion_actual = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';
?>

<nav class="barra-lateral">
  <div class="contenedor-logo">
    <img src="../../public/img/2.png" alt="Logo AS TECH" class="logo-sidebar">
  </div>

  <ul class="menu-navegacion">
    <li>
      <a href="?seccion=dashboard" class="<?= $seccion_actual == 'dashboard' ? 'activo' : '' ?>">
        <i class="fa-solid fa-gears"></i> Dashboard
      </a>
    </li>
    <li>
      <a href="?seccion=servicios" class="<?= $seccion_actual == 'servicios' ? 'activo' : '' ?>">
        <i class="fa-solid fa-microchip"></i>Pagina de Servicios
      </a>
    </li>
    <li>
      <a href="?seccion=inicio" class="<?= $seccion_actual == 'inicio' ? 'activo' : '' ?>">
       <i class="fa-solid fa-house"></i> Pagina de inicio
      </a>
    </li>
    <li>
      <a href="?seccion=citas" class="<?= $seccion_actual == 'citas' ? 'activo' : '' ?>">
        <i class="fa-solid fa-calendar-check"></i> Citas
      </a>
    </li>
    <li>
      <a href="?seccion=contacto" class="<?= $seccion_actual == 'contacto' ? 'activo' : '' ?>">
        <i class="fa-solid fa-address-book"></i> Contacto
      </a>
    </li>
    <li>
        <li>
      <a href="?seccion=ingreso" class="<?= $seccion_actual == 'ingreso' ? 'activo' : '' ?>">
         <i class="fa-solid fa-file"></i>Ingresar servicio
      </a>
    </li>
    <li>
       
      
    </li>
  </ul>

  <div class="seccion-inferior">
    <a href="../../app/views/login.php" class="boton-salir">
      <i class="fa-solid fa-right-from-bracket"></i> Salir
    </a>
  </div>
</nav>

<main class="contenido-principal">
  <?php
    switch ($seccion_actual) {
        case 'dashboard':
            echo "<h1>Bienvenido al panel principal</h1>";
            echo "<div class='usuario'>"; 
            echo "<i class='fa-solid fa-user'></i>"; 
            echo "<p>Usuario - rol</p>";
            echo "</div>"; 
            // Verifica que este archivo exista en esa ruta exacta
            if(file_exists("secciones/dashboard_info.php")) {
                include "secciones/dashboard_info.php";
            }
            break;
            
        case 'servicios':
            echo "<h1>Gestión de Servicios</h1>";
            if(file_exists("secciones/servicios_crud.php")) {
                include "secciones/servicios_crud.php";
            } else {
                echo "<p>Error: No se encontró el archivo de servicios.</p>";
            }
            break;

        case 'inicio':
            echo "<h1>Gestión de la pagina de inicio</h1>";
            if(file_exists("secciones/inicio_crud.php")) {
                include "secciones/inicio_crud.php";
            } else {
                echo "<p>Error: No se encontró el archivo de inicios.</p>";
            }
            break;
            case 'citas':
            echo "<h1>Gestión de Citas </h1>";
            if(file_exists("secciones/citas_crud.php")) {
                include "secciones/citas_crud.php";
            } else {
                echo "<p>Error: No se encontró el archivo de citas.</p>";
            }
            break;
             case 'contacto':
            echo "<h1>Gestión de la pagina de contacto </h1>";
            if(file_exists("secciones/contacto_info.php")) {
                include "secciones/contacto_info.php";
            } else {
                echo "<p>Error: No se encontró el archivo de contacto.</p>";
            }
            break;
            case 'ingreso':
          
            if(file_exists("secciones/ingreso.php")) {
                include "secciones/ingreso.php";
            } else {
                echo "<p>Error: No se encontró el archivo de contacto.</p>";
            }
            break;
        default:
            echo "<h1>404</h1><p>Sección no encontrada.</p>";
            break;
    }
  ?>
</main>

</body>
</html>