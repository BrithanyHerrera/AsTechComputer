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
<?php $ruta_prefijo = "../../"; include "../../toolbar_servicios.php"; ?>
<div id="contenedorBuscador" class="buscador-oculto">
    <input type="text" id="inputBuscador" placeholder="Buscar servicios...">
    <div id="resultadosBusqueda"></div>
</div>
<?php 
$id_tipo = isset($_GET['id_tipo_servicio']) ? $_GET['id_tipo_servicio'] : null;

// Valores por defecto (cuando no seleccionan nada)
$titulo = "Nuestros servicios";
$subtitulo = "Soluciones para tu equipo";
$precio = "";
$imagen = "../../public/img/principalAdv.png";


if ($id_tipo == 1) {
    $titulo = "Reparación y reemplazo";
    $subtitulo = "Soluciones rápidas para tu equipo";
    $precio = "Desde: $800 pesos";
    $imagen = "../../public/img/ReparacionGranFond.png";
} elseif ($id_tipo == 2) {
    $titulo = "Mantenimiento preventivo";
    $subtitulo = "para equipos portátiles de alto rendimiento";
    $precio = "Desde: $1350 pesos";
    $imagen = "../../public/img/principalAdv.png";
} elseif ($id_tipo == 3) {
    $titulo = "Instalación de software";
    $subtitulo = "Optimiza el rendimiento de tu equipo";
    $precio = "Desde: $300 pesos";
    $imagen = "../../public/img/SoftwareGranFond.png";
}

elseif ($id_tipo == 4) {
    $titulo = "Servicios especializados";
    $subtitulo = "Soluciones avanzadas para casos complejos";
    $precio = "Desde: $300 pesos";
    $imagen = "../../public/img/EspecialGranFond.png";
}
elseif ($id_tipo == 5) {
    $titulo = "Servicios a domicilio";
    $subtitulo = "Atención profesional en la comodidad de tu hogar";
    $precio = "Desde: $500 pesos";
    $imagen = "../../public/img/DomicilioGranFond.png";
}
elseif ($id_tipo == "") {
    $titulo = "Servicios";
    $subtitulo = "Conoce todas nuestras soluciones tecnológicas";
    $precio = "Desde: $1000 pesos";
    $imagen = "../../public/img/TodoGranFond.png";
}?>
<div class="imagen-principal">
    <img src="<?php echo $imagen; ?>" alt="Imagen de servicios" class="img-p">

    <div class="contenido-imagen">
          <h1><?php echo $titulo; ?></h1>
        <h2><?php echo $subtitulo; ?></h2>
         <p><?php echo $precio; ?></p>
        <button class="boton-servicio">Agendar cita</button>
        <a href="#" class="link-info">Más información     <i class="fa-solid fa-angle-right"></i></a>
    </div>
</div>
<h1 class="titulo-servicios"></h1>
<?php
// Incluir la conexión
require_once('../../app/config/conexion.db.php');
$id_tipo = isset($_GET['id_tipo_servicio']) ? $_GET['id_tipo_servicio'] : null;

if ($id_tipo) {
    $query = "SELECT tipo_servicio, descripcion, precio, imagen_servicio
              FROM servicios 
              WHERE estado = 'activo' AND id_tipo_servicio = '$id_tipo'";
} else {
    $query = "SELECT tipo_servicio, descripcion, precio, imagen_servicio
              FROM servicios 
              WHERE estado = 'activo'";
}

$resultado = mysqli_query($conexion, $query);
?>
<div class="contenedor-servicios">
    <?php while($row = mysqli_fetch_assoc($resultado)): ?>
        <div class="card-servicio">
            <img src="<?php echo $row['imagen_servicio']; ?>" alt="Servicio" class="imagen-url">
            
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
const btn = document.getElementById("btnBuscador");
const contenedor = document.getElementById("contenedorBuscador");
const input = document.getElementById("inputBuscador");
const resultados = document.getElementById("resultadosBusqueda");

function abrirBuscador() {
    const buscador = document.querySelector('.buscador-oculto');
    buscador.classList.toggle('active'); // Esto añade o quita la clase que creamos
}


input.addEventListener("keyup", () => {
    let valor = input.value;

    fetch("acciones/buscar_servicio.php?q=" + valor)
        .then(res => res.text())
        .then(data => {
            resultados.innerHTML = data;
        });
});
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
</script>
</html>