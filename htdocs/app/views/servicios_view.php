<?php
/**
 * PÁGINA: Vista de Catálogo de Servicios - As Tech Computer
 * PROPÓSITO: Mostrar de forma visual y atractiva todos los servicios activos.
 * FUNCIONALIDADES: 
 * - Carrusel informativo de categorías principales.
 * - Filtrado dinámico por tipo de servicio mediante parámetros GET.
 * - Grid de tarjetas interactivas con efecto "hover" para mostrar descripciones.
 * - Redirección detallada para agendar o conocer más sobre cada servicio.
 */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Integral de Equipo | As Tech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/servicios.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
</head>
<body>

<?php
require_once __DIR__ . "/../config/config.php"; // Carga el config
    $ruta_img = "../../public/img/servicios/";
    $ruta_prefijo = "../../"; 
    include_once __DIR__ . "/fijos/loader_view.php";
    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>
<div id="contenedorBuscador" class="buscador-oculto">
    <input type="text" id="inputBuscador" placeholder="Buscar servicios...">
    <div id="resultadosBusqueda"></div>
</div>
<?php
require_once('../../app/config/conexion.db.php');
$query = "SELECT id_servicio, codigo_servicio, tipo_servicio, descripcion, precio, imagen_servicio
          FROM servicios 
          WHERE estado = 'activo'";

$resultado = mysqli_query($conexion, $query);
?>
<?php
// Preparamos los datos para el carousel basándonos en tus categorías
$slides = [
    ["img" => "../../public/img/ReparacionGranFond.png", "t" => "Reparación y reemplazo", "s" => "Soluciones rápidas para tu equipo", "p" => "Desde: $800 pesos"],
    ["img" => "../../public/img/principalAdv.png", "t" => "Mantenimiento preventivo", "s" => "Para equipos portátiles de alto rendimiento", "p" => "Desde: $1350 pesos"],
    ["img" => "../../public/img/SoftwareGranFond.png", "t" => "Instalación de software", "s" => "Optimiza el rendimiento de tu equipo", "p" => "Desde: $300 pesos"],
    ["img" => "../../public/img/EspecialGranFond.png", "t" => "Servicios especializados", "s" => "Soluciones avanzadas para casos complejos", "p" => "Desde: $300 pesos"],
    ["img" => "../../public/img/DomicilioGranFond.png", "t" => "Servicios a domicilio", "s" => "Atención profesional en tu hogar", "p" => "Desde: $500 pesos"]
];
?>

<div class="carousel-container">
    <div class="carousel-track">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>">
                <img src="<?php echo $slide['img']; ?>" alt="Banner">
                <div class="contenido-imagen">
                    <h1><?php echo $slide['t']; ?></h1>
                    <h2><?php echo $slide['s']; ?></h2>
                    <p><?php echo $slide['p']; ?></p>
                                <a href="citas_cliente_controller.php" class="boton-servicio">
  Agendar cita
</a>
                    <a href="mas_info_controller.php" class="link-info">Más información <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="contenedor-servicios">
    <?php if (!empty($servicios_agrupados)): ?>
        <?php foreach ($servicios_agrupados as $titulo_seccion => $lista_servicios): ?>
            
            <!-- HEADER DE SECCIÓN -->
            <div class="seccion-header">
                <h2 class="titulo-categoria"><?php echo $titulo_seccion; ?></h2>
                <hr class="linea-separadora">
            </div>

            <!-- GRID DE TARJETAS -->
            <div class="servicios-grid">
                <?php foreach ($lista_servicios as $servicio): ?>
                    
                    <div class="card-servicio" onclick="verServicio(<?php echo $servicio['id_servicio']; ?>)">
                        
                        <!-- IMAGEN (no la tenías en el primero) -->
                        <img src="<?php echo $ruta_img . $servicio['imagen_servicio']; ?>" alt="Servicio" class="imagen-url">

                        <!-- BOTÓN -->
                        <button class="btn-ver-mas">
                            Más información <i class="fa-solid fa-angles-right"></i>
                        </button>

                        <!-- INFO BÁSICA -->
                        <div class="info-basica">
                            
                            <h3><?php echo $servicio['tipo_servicio']; ?></h3>
                             <span class="precio">
    <?php 
        echo ($servicio['precio'] > 0) 
            ? '$' . number_format($servicio['precio'], 2) 
            : 'Bajo cotización'; 
    ?>
</span>
<span class="codigo-tag"><?php echo $servicio['codigo_servicio']; ?></span>
                        </div>

                        <!-- OVERLAY (clave para tu efecto) -->
                        <div class="overlay-descripcion">
                            <h3><?php echo $servicio['tipo_servicio']; ?></h3>
                            <p><?php echo $servicio['descripcion']; ?></p>
                        </div>

                    </div>

                <?php endforeach; ?>
            </div>
            
        <?php endforeach; ?>
    <?php else: ?>
        <p>No se encontraron servicios disponibles.</p>
    <?php endif; ?>
</div>
<div id="modalServicio" class="modal">
    <div class="modal-contenido">
        <span class="cerrar">&times;</span>
        <div id="contenidoModal"></div>
    </div>
</div>
</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- LÓGICA DEL CAROUSEL ---
    const slides = document.querySelectorAll(".carousel-slide");
    let currentSlide = 0;

    function nextSlide() {
        if (slides.length === 0) return;
        
        slides[currentSlide].classList.remove("active");
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add("active");
    }

    // Cambia cada 5 segundos
    setInterval(nextSlide, 7000);

    // --- LÓGICA DEL BUSCADOR Y MODAL ---
    const resultados = document.getElementById("resultadosBusqueda");
    const modal = document.getElementById("modalServicio");
    const contenidoModal = document.getElementById("contenidoModal");
    const cerrar = document.querySelector(".cerrar");

    if (resultados) {
        resultados.addEventListener("click", (e) => {
            const item = e.target.closest(".resultado-item");
            if (item) {
                let id = item.getAttribute("data-id");
                fetch("acciones/obtener_servicio.php?id=" + id)
                    .then(res => res.text())
                    .then(data => {
                        contenidoModal.innerHTML = data;
                        modal.style.display = "block";
                    })
                    .catch(err => console.error("Error al cargar servicio:", err));
            }
        });
    }

    if (cerrar) {
        cerrar.addEventListener("click", () => {
            modal.style.display = "none";
        });
    }

   
});

// Función global para las cards
function verServicio(id) {
    window.location.href = "../../app/controllers/detalle_servicio_controller.php?id=" + id;
}
resultados.addEventListener("click", (e) => {
    if(e.target.closest(".resultado-item")){
        let texto = e.target.innerText;
        const modal = document.getElementById("modalServicio");
const contenidoModal = document.getElementById("contenidoModal");
const cerrar = document.querySelector(".cerrar");

resultados.addEventListener("click", (e) => {
    const item = e.target.closest(".resultado-item");

    if(item){
        let id = item.getAttribute("data-id");

        fetch("acciones/obtener_servicio.php?id=" + id)
            .then(res => res.text())
            .then(data => {
                contenidoModal.innerHTML = data;
                modal.style.display = "block";
            });
    }
});

// cerrar modal
cerrar.addEventListener("click", () => {
    modal.style.display = "none";
});

// cerrar dando click afuera

    }
});

function verServicio(id){
    
    window.location.href = "../../app/controllers/detalle_servicio_controller.php?id=" + id;
}

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modalServicio");
    const contenidoModal = document.getElementById("contenidoModal");
    const cerrar = document.querySelector(".cerrar");
    const resultados = document.getElementById("resultados"); // <-- Esto evita el ReferenceError

    // Manejar clics en los resultados de búsqueda (si existen)
    if (resultados) {
        resultados.addEventListener("click", (e) => {
            const item = e.target.closest(".resultado-item");
            if (item) {
                let id = item.getAttribute("data-id");
                cargarDetalleServicio(id);
            }
        });
    }

    // Cerrar modal
    if (cerrar) {
        cerrar.addEventListener("click", () => {
            modal.style.display = "none";
        });
    }

    // Cerrar modal al hacer clic fuera
    window.addEventListener("click", (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
});

// Función global para cargar el servicio (usada por las cards y el buscador)
function cargarDetalleServicio(id) {
    const modal = document.getElementById("modalServicio");
    const contenidoModal = document.getElementById("contenidoModal");

    fetch("acciones/obtener_servicio.php?id=" + id)
        .then(res => res.text())
        .then(data => {
            if (contenidoModal && modal) {
                contenidoModal.innerHTML = data;
                modal.style.display = "block";
            }
        })
        .catch(err => console.error("Error al cargar servicio:", err));
}

// Función para redirección de cards (si prefieres ir a otra página en lugar de modal)
function verServicio(id) {
    window.location.href = "../../app/controllers/detalle_servicio_controller.php?id=" + id;
}

</script>
</html>