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
$query = "SELECT id_servicio, tipo_servicio, descripcion, precio, imagen_servicio
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
                    <button class="boton-servicio">Agendar cita</button>
                    <a href="#" class="link-info">Más información <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="contenedor-servicios">
    <?php while($row = mysqli_fetch_assoc($resultado)): ?>
        <div class="card-servicio"  onclick="verServicio(<?php echo $row['id_servicio']; ?>)">
            <img src="<?php echo $ruta_img . $row['imagen_servicio']; ?>" alt="Servicio" class="imagen-url">
            <button class="btn-ver-mas">Ver mas <i class="fa-solid fa-angles-right"></i></button>
            <div class="info-basica">
                <h3><?php echo $row['tipo_servicio']; ?></h3>
                <span class="precio">$<?php echo number_format($row['precio'], 2); ?></span>
            </div>

            <div class="overlay-descripcion">
                <h3><?php echo $row['tipo_servicio']; ?></h3>
                <p><?php echo $row['descripcion']; ?></p>
            </div>
        </div>
    <?php endwhile; ?>
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
    setInterval(nextSlide, 9000);

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

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
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
window.addEventListener("click", (e) => {
    if(e.target === modal){
        modal.style.display = "none";
    }
});
    }
});

function verServicio(id){
    
    window.location.href = "../../app/controllers/detalle_servicio_controller.php?id=" + id;
}

</script>
</html>