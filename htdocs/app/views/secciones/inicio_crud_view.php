<?php
include __DIR__ . "/../../config/conexion.db.php";

$edit = $_GET['edit'] ?? 'portada';

// Obtener la info actual
$query = "SELECT * FROM informacion_index WHERE id = 1 LIMIT 1";
$resultado = $conexion->query($query);
$info = $resultado->fetch_assoc();

// Función auxiliar
function es_activo($actual, $objetivo) {
    return $actual == $objetivo ? 'activo' : '';
}
?>

<div class="contenedor-crud">

    <!-- MENÚ -->
    <div class="menu-interno-secciones">
        <button type="button" class="btn-tab activo" onclick="cambiarSeccion('portada')">Portada</button>
        <button type="button" class="btn-tab" onclick="cambiarSeccion('mision')">Misión / Visión</button>
        <button type="button" class="btn-tab" onclick="cambiarSeccion('ceo')">Sección CEO</button>
    </div>

    <div class="caja-formulario-edit">
        <form action="../controllers/inicio_crud_controller.php" method="POST">

            <!-- PORTADA -->
            <div id="seccion-portada" class="seccion-form activa">
                <div class="animacion-entrada">
                    <h3>Configuración de Portada</h3>
                    <div class="grupo-input">
                        <label>¿Quiénes somos?</label>
                        <textarea name="titulo" rows="3"><?= htmlspecialchars($info['quienes_somos'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- MISION -->
            <div id="seccion-mision" class="seccion-form">
                <div class="animacion-entrada">
                    <h3>Misión y Visión</h3>
                    <div class="grupo-input">
                        <label>Nuestra Misión</label>
                        <textarea name="mision" rows="5"><?= htmlspecialchars($info['mision'] ?? '') ?></textarea>
                    </div>
                    <div class="grupo-input">
                        <label>Nuestra Visión</label>
                        <textarea name="vision" rows="5"><?= htmlspecialchars($info['vision'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- CEO -->
            <div id="seccion-ceo" class="seccion-form">
                <div class="animacion-entrada">
                    <h3>Datos del Fundador</h3>
                    <div class="grupo-input">
                        <label>Frase inspiracional</label>
                        <textarea name="frase" rows="3"><?= htmlspecialchars($info['frase_fundador'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="seccion-guardado">
                <input type="hidden" name="seccion_editada" id="seccion_editada" value="portada">
                <button type="submit" class="boton-guardar">Actualizar Sección</button>
            </div>

        </form>
    </div>
</div>
<script>
   function cambiarSeccion(seccion) {

    // Ocultar todas
    document.querySelectorAll('.seccion-form').forEach(div => {
        div.classList.remove('activa');
    });

    // Mostrar la seleccionada
    document.getElementById('seccion-' + seccion).classList.add('activa');

    // Cambiar botón activo
    document.querySelectorAll('.btn-tab').forEach(btn => {
        btn.classList.remove('activo');
    });

    event.target.classList.add('activo');

    // Actualizar input hidden
    document.getElementById('seccion_editada').value = seccion;
} 
</script>