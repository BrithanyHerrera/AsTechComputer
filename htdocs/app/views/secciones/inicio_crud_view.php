
<?php
//  PAGINA:index_crud_view
// seccion de la pagina de el panel de administracion 
//que se encarga de cambiar el texto de las secciones de la pagina principal
//SECCIONES:
//mision y vision
//Frase del CEO
//acerca de nosotros


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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="contenedor-crud">

    <div class="menu-interno-secciones">
        <button type="button" class="btn-tab activo" onclick="cambiarSeccion(event, 'portada')">Portada</button>
        <button type="button" class="btn-tab" onclick="cambiarSeccion(event, 'mision')">Misión / Visión</button>
        <button type="button" class="btn-tab" onclick="cambiarSeccion(event, 'ceo')">Sección CEO</button>
    </div>

    <div class="caja-formulario-edit">
        <form id="form-inicio" action="../controllers/inicio_crud_controller.php" method="POST">

            <div id="seccion-portada" class="seccion-form activa">
                <div class="animacion-entrada">
                    <h3>Configuración de Portada</h3>
                    <div class="grupo-input">
                        <label>¿Quiénes somos?</label>
                        <textarea name="titulo" rows="3"><?= htmlspecialchars($info['quienes_somos'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

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
                <button type="button" class="boton-primario" onclick="confirmarGuardado()">Actualizar Sección</button>
            </div>

        </form>
    </div>
</div>
<div class="bloque-informativo">
    <div class="info-header">
        <i class="fas fa-info-circle"></i> 
        <h4>Guía de Formato de Texto</h4>
    </div>
    <div class="info-cuerpo">
        <p>Este panel utiliza un sistema de <strong>auto-párrafos</strong> para mejorar la lectura en la página principal:</p>
        
        <ul>
            <li>
                <strong>¿Cómo crear un párrafo?</strong> 
                Cada vez que escribas un punto <code>.</code> y sigas escribiendo, el sistema creará automáticamente un salto de línea en la web.
            </li>
            <li>
                <strong>El punto final:</strong> No te preocupes por poner punto al final del último enunciado; el sistema lo agregará automáticamente en la vista pública.
            </li>
            <li>
                <strong>Evita errores:</strong> No utilices el formato <code>."</code> (punto y comillas pegadas sin espacio), ya que el sistema podría interpretar mal la separación. Siempre deja un espacio después del punto si vas a continuar.
            </li>
        </ul>
        
        <div class="info-ejemplo">
            <span>Ejemplo:</span>
            <code>Texto primer párrafo. Texto segundo párrafo</code>
        </div>
    </div>
</div>
<script src="../../public/js/inicio_crud.js"></script>