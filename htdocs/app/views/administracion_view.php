<?php
/**
 * PÁGINA: Panel de Administración - As Tech Computer
 * PROPÓSITO: Controlar el acceso y la navegación del sistema según el rol del usuario autenticado.
 * FUNCIONALIDADES:
 * - Validación de sesión y redirección si no hay acceso válido.
 * - Gestión de permisos por rol para mostrar secciones autorizadas.
 * - Navegación interna por parámetro GET y carga dinámica de vistas.
 * - Registro en bitácora de accesos evitando duplicados.
 * - Interfaz con menú lateral dinámico y opción de cierre de sesión.
 * - Manejo básico de errores (404) y verificación de archivos antes de incluirlos.
 */
?>

<?php
require_once dirname(__DIR__) . '/config/config.php'; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_puesto'])) {
    header("Location: ../../index.php"); 
    exit;
}

$puesto_usuario = $_SESSION['id_puesto']; 
$seccion_actual = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';
$permisos = [
    1 => ['dashboard', 'registros_ingresados_crud_view', 'contenedor'], // Técnico
    2 => ['dashboard', 'citas', 'ingreso', 'registros_ingresados_crud_view'], // Atención al Cliente
    3 => ['dashboard', 'servicios', 'inicio', 'citas', 'contacto', 'ingreso', 'registros_ingresados_crud_view', 'empleado', 'contenedor', 'estadisticas'], // Gerente
    4 => ['dashboard', 'servicios', 'inicio', 'citas', 'contacto', 'ingreso', 'registros_ingresados_crud_view', 'empleado', 'contenedor', 'estadisticas']  // Administrador
];

if (!in_array($seccion_actual, $permisos[$puesto_usuario])) {
    $seccion_actual = 'acceso_denegado';
}

// ==========================================
// 3. RASTREO DE ACTIVIDAD (AUDIT TRAIL)
// ==========================================
require_once dirname(__DIR__) . '/config/conexion.db.php'; 

$id_empleado_log = $_SESSION['id_empleado'];
$accion_log      = "Navegación"; 
$detalle_log     = "Ingresó a la sección: " . strtoupper($seccion_actual);

// Evitamos registrar clics duplicados si solo están recargando la página
if (!isset($_SESSION['ultima_seccion']) || $_SESSION['ultima_seccion'] != $seccion_actual) {
    try {
        $stmt_log = $conexion->prepare("INSERT INTO bitacora_movimientos (id_empleado, accion, detalle, fecha_hora) VALUES (?, ?, ?, NOW())");
        $stmt_log->bind_param("iss", $id_empleado_log, $accion_log, $detalle_log);
        $stmt_log->execute();
        
        $_SESSION['ultima_seccion'] = $seccion_actual;
    } catch (Exception $e) { /* Silencioso */ }
}
// ==========================================
?>
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
  <?php include_once __DIR__ . "/fijos/loader_view.php"; ?>

  <!-- Botón hamburguesa (visible solo en móvil) -->
  <button class="btn-hamburguesa" id="btnHamburguesa" aria-label="Abrir menú" aria-expanded="false">
    <i class="fa-solid fa-bars" id="iconoHamburguesa"></i>
  </button>

  <!-- Overlay oscuro detrás del sidebar en móvil -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <nav class="barra-lateral" id="barraSidebar">
    <div class="contenedor-logo">
      <img src="../../public/img/2.png" alt="Logo AS TECH" class="logo-sidebar">
    </div>
    <ul class="menu-navegacion">
        
      <?php if ($puesto_usuario == 3 || $puesto_usuario == 4): ?>
      <li>
        <a href="?seccion=dashboard" class="<?= $seccion_actual == 'dashboard' ? 'activo' : '' ?>">
          <i class="fa-solid fa-gears"></i> <span>Dashboard</span>
        </a>
      </li>
      <?php endif; ?>

      <?php if ($puesto_usuario == 3 || $puesto_usuario == 4): ?>
      <li>
        <a href="?seccion=estadisticas" class="<?= $seccion_actual == 'estadisticas' ? 'activo' : '' ?>">
          <i class="fa-solid fa-chart-pie"></i> <span>Estadísticas</span>
        </a>
      </li>
      <?php endif; ?>

      <?php if ($puesto_usuario == 3 || $puesto_usuario == 4): ?>
      <li>
        <a href="?seccion=servicios" class="<?= $seccion_actual == 'servicios' ? 'activo' : '' ?>">
          <i class="fa-solid fa-microchip"></i> <span>Pagina de Servicios</span>
        </a>
      </li> 
      <li>
        <a href="?seccion=inicio" class="<?= $seccion_actual == 'inicio' ? 'activo' : '' ?>">
          <i class="fa-solid fa-house"></i> <span>Pagina de inicio</span>
        </a>
      </li>
      <li>
        <a href="?seccion=contacto" class="<?= $seccion_actual == 'contacto' ? 'activo' : '' ?>">
          <i class="fa-solid fa-address-book"></i> <span>Contacto</span>
        </a>
      </li>
      <?php endif; ?>

      <?php if ($puesto_usuario == 2 || $puesto_usuario == 3 || $puesto_usuario == 4): ?>
      <li>
        <a href="?seccion=citas" class="<?= $seccion_actual == 'citas' ? 'activo' : '' ?>">
          <i class="fa-solid fa-calendar-check"></i> <span>Citas</span>
        </a>
      </li>
      <li>
        <a href="?seccion=ingreso" class="<?= $seccion_actual == 'ingreso' ? 'activo' : '' ?>">
          <i class="fa-solid fa-file"></i> <span>Ingresar dispositivo</span>
        </a>
      </li>
      <?php endif; ?>

      <li>
        <a href="?seccion=registros_ingresados_crud_view" class="<?= $seccion_actual == 'registros_ingresados_crud_view' ? 'activo' : '' ?>">
          <i class="fa-solid fa-save"></i> <span>Dispositivos Ingresados</span>
        </a>
      </li>

      <?php if ($puesto_usuario == 3 || $puesto_usuario == 4): ?>
      <li>
        <a href="?seccion=empleado" class="<?= $seccion_actual == 'empleado' ? 'activo' : '' ?>">
          <i class="fa-solid fa-user"></i> <span>Agregar empleado</span>
        </a>
      </li>
      <?php endif; ?>

      <?php if ($puesto_usuario == 1 || $puesto_usuario == 3 || $puesto_usuario == 4): ?>
      <li>
        <a href="?seccion=contenedor" class="<?= $seccion_actual == 'contenedor' ? 'activo' : '' ?>">
          <i class="fa-solid fa-box"></i> <span>Contenedores</span>
        </a>
      </li>
      <?php endif; ?>

    </ul>

    <div class="seccion-inferior">
      <a href="../../app/controllers/logout_controller.php" class="boton-salir">
        <i class="fa-solid fa-right-from-bracket"></i> <span>Salir</span>
      </a>
    </div>
  </nav>

  <main class="contenido-principal">
    <?php
    $ruta_secciones = __DIR__ . '/secciones/';

    switch ($seccion_actual) {
      case 'dashboard':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        echo "<h1>Bienvenido al panel principal</h1>";
        if (file_exists($ruta_secciones . "panel_info_view.php")) { include $ruta_secciones . "panel_info_view.php"; }
        break;

      case 'estadisticas':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "estadisticas.php")) { include $ruta_secciones . "estadisticas.php"; }
        break;

      case 'servicios':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "servicios_crud_view.php")) { include $ruta_secciones . "servicios_crud_view.php"; }
        break;

      case 'inicio':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "inicio_crud_view.php")) { include $ruta_secciones . "inicio_crud_view.php"; }
        break;

      case 'citas':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "citas_crud_view.php")) { include $ruta_secciones . "citas_crud_view.php"; }
        break;

      case 'contacto':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "contacto_crud_view.php")) { include $ruta_secciones . "contacto_crud_view.php"; }
        break;

      case 'ingreso':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "ingresar_dispositivo_view.php")) { include $ruta_secciones . "ingresar_dispositivo_view.php"; }
        break;

      case 'registros_ingresados_crud_view':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "dispositivos_ingresados_crud_view.php")) { include $ruta_secciones . "dispositivos_ingresados_crud_view.php"; }
        break;

      case 'empleado':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "empleado_crud_view.php")) { include $ruta_secciones . "empleado_crud_view.php"; }
        break;

      case 'contenedor':
        echo '<link rel="stylesheet" href="../../public/css/secciones.css">';
        if (file_exists($ruta_secciones . "contenedor_crud_view.php")) { include $ruta_secciones . "contenedor_crud_view.php"; }
        break;

      default:
        echo "<h1>404</h1><p>Sección no encontrada.</p>";
        break;
    }
    ?>
  </main>

  <script>
    (function () {
      const btnHamburguesa = document.getElementById('btnHamburguesa');
      const sidebar        = document.getElementById('barraSidebar');
      const overlay        = document.getElementById('sidebarOverlay');
      const icono          = document.getElementById('iconoHamburguesa');

      function abrirSidebar() {
        sidebar.classList.add('abierto');
        overlay.classList.add('activo');
        icono.className = 'fa-solid fa-xmark';
        btnHamburguesa.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden'; // Evita scroll del fondo
      }

      function cerrarSidebar() {
        sidebar.classList.remove('abierto');
        overlay.classList.remove('activo');
        icono.className = 'fa-solid fa-bars';
        btnHamburguesa.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }

      btnHamburguesa.addEventListener('click', function () {
        sidebar.classList.contains('abierto') ? cerrarSidebar() : abrirSidebar();
      });

      // Cerrar al hacer clic en el overlay
      overlay.addEventListener('click', cerrarSidebar);

      // Cerrar al hacer clic en un enlace del menú (navegación SPA-like)
      sidebar.querySelectorAll('.menu-navegacion a').forEach(function (enlace) {
        enlace.addEventListener('click', function () {
          if (window.innerWidth <= 768) cerrarSidebar();
        });
      });

      // Cerrar con la tecla Escape
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar.classList.contains('abierto')) {
          cerrarSidebar();
        }
      });

      // Si se redimensiona a escritorio, asegurarse de limpiar estado móvil
      window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
          cerrarSidebar();
          document.body.style.overflow = '';
        }
      });
    })();
  </script>

</body>
</html>