<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | AS TECH</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../../public/css/administracion.css">
  <link rel="stylesheet" href="../../public/css/toolbar.css">
  <link rel="icon" href="../../public/img/Astech ICO.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
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
          <i class="fa-solid fa-microchip"></i> Pagina de Servicios
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
        <a href="?seccion=ingreso" class="<?= $seccion_actual == 'ingreso' ? 'activo' : '' ?>">
          <i class="fa-solid fa-file"></i> Ingresar servicio
        </a>
      </li>
      <li>
        <a href="?seccion=registrosCRUD" class="<?= $seccion_actual == 'registrosCRUD' ? 'activo' : '' ?>">
          <i class="fa-solid fa-save"></i> Registros Ingresados
        </a>
      </li>
      <li>
        <a href="?seccion=empleado" class="<?= $seccion_actual == 'empleado' ? 'activo' : '' ?>">
          <i class="fa-solid fa-user"></i> Agregar empleado
        </a>
      </li>
      <li>
        <a href="?seccion=contenedor" class="<?= $seccion_actual == 'contenedor' ? 'activo' : '' ?>">
          <i class="fa-solid fa-box"></i> Contenedores
        </a>
      </li>
    </ul>

    <div class="seccion-inferior">
      <a href="../../app/controllers/logout_controller.php" class="boton-salir">
        <i class="fa-solid fa-right-from-bracket"></i> Salir
      </a>
    </div>
  </nav>

  <main class="contenido-principal">



    <?php
    // Recoger la sección de la URL, si no existe, usar 'dashboard' por defecto
$seccion_actual = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';
    // Usamos __DIR__ para asegurar que siempre busque dentro de app/views/secciones/
    $ruta_secciones = __DIR__ . '/secciones/';

    switch ($seccion_actual) {
      case 'dashboard':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        echo "<h1>Bienvenido al panel principal</h1>";
        echo "<div class='usuario'></div>";
        if (file_exists($ruta_secciones . "panel_info.php")) {
          include $ruta_secciones . "panel_info.php";
        }
        break;

      case 'servicios':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        echo "<h1>Gestión de Servicios</h1>";
        if (file_exists($ruta_secciones . "servicios_crud.php")) {
          include $ruta_secciones . "servicios_crud.php";
        } else {
          echo "<p>Error: No se encontró el archivo de servicios.</p>";
        }
        break;

      case 'inicio':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        echo "<h1>Gestión de la pagina de inicio</h1>";
        if (file_exists($ruta_secciones . "inicio_crud.php")) {
          include $ruta_secciones . "inicio_crud.php";
        } else {
          echo "<p>Error: No se encontró el archivo de inicios.</p>";
        }
        break;

      case 'citas':
        // Nota: Si usas MVC completo para citas, este case podría sobrar pronto,
        // pero lo dejamos intacto para respetar tu lógica actual.
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "citas_crud_view.php")) {
          include $ruta_secciones . "citas_crud_view.php";
        } else {
          echo "<p>Error: No se encontró el archivo de citas.</p>";
        }
        break;

      case 'contacto':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        echo "<h1>Gestión de la pagina de contacto </h1>";
        if (file_exists($ruta_secciones . "contacto_info.php")) {
          include $ruta_secciones . "contacto_info.php";
        } else {
          echo "<p>Error: No se encontró el archivo de contacto.</p>";
        }
        break;

      case 'ingreso':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "ingreso.php")) {
          include $ruta_secciones . "ingreso.php";
        } else {
          echo "<p>Error: No se encontró el archivo de ingreso.</p>";
        }
        break;

      case 'registrosCRUD':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "registrosCRUD.php")) {
          include $ruta_secciones . "registrosCRUD.php";
        } else {
          echo "<p>Error: No se encontró el archivo de registrosCRUD.</p>";
        }
        break;

      case 'empleado':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "empleado.php")) {
          include $ruta_secciones . "empleado.php";
        } else {
          echo "<p>Error: No se encontró el archivo de empleado.</p>";
        }
        break;

      case 'contenedor':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "crud_contenedores.php")) {
          include $ruta_secciones . "crud_contenedores.php";
        } else {
          echo "<p>Error: No se encontró el archivo de contenedores.</p>";
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