<?php
// Capturamos qué parte de la página de inicio queremos editar
// Si no hay ninguna seleccionada, por defecto mostramos 'portada'
$edit = isset($_GET['edit']) ? $_GET['edit'] : 'portada';

// Función auxiliar para marcar el botón como activo
function es_activo($actual, $objetivo) {
    return $actual == $objetivo ? 'activo' : '';
}
?>

<div class="contenedor-crud">


    <div class="menu-interno-secciones">
        <a href="?seccion=editar_inicio&edit=portada" class="btn-tab <?= es_activo($edit, 'portada') ?>">Portada</a>
        <a href="?seccion=editar_inicio&edit=mision" class="btn-tab <?= es_activo($edit, 'mision') ?>">Misión / Visión</a>
        <a href="?seccion=editar_inicio&edit=ceo" class="btn-tab <?= es_activo($edit, 'ceo') ?>">Sección CEO</a>
        <a href="?seccion=editar_inicio&edit=servicios" class="btn-tab <?= es_activo($edit, 'servicios') ?>">Servicios</a>
    </div>

    <div class="caja-formulario-edit">
        <form action="app/controllers/procesar_inicio.php" method="POST" enctype="multipart/form-data">
            
            <?php switch($edit): 
                case 'portada': ?>
                    <div class="animacion-entrada">
                        <h3> Configuración de Portada</h3>
                        <div class="grupo-input">
                            <label>Título de Bienvenida</label>
                            <input type="text" name="titulo" placeholder="Ej. Bienvenidos a AS TECH">
                        </div>
                        <div class="grupo-input">
                            <label>Imagen de Fondo / Logo</label>
                            <input type="file" name="img_portada">
                        </div>
                    </div>
                <?php break; ?>

                <?php case 'mision': ?>
                    <div class="animacion-entrada">
                        <h3><i class="fa-solid fa-bullseye"></i> Misión y Visión</h3>
                        <div class="grupo-input">
                            <label>Nuestra Misión</label>
                            <textarea name="mision" rows="5">"Brindar soluciones..."</textarea>
                        </div>
                        <div class="grupo-input">
                            <label>Nuestra Visión</label>
                            <textarea name="vision" rows="5">"Consolidarnos como..."</textarea>
                        </div>
                    </div>
                <?php break; ?>

                <?php case 'ceo': ?>
                    <div class="animacion-entrada">
                        <h3><i class="fa-solid fa-user-tie"></i> Datos del Fundador</h3>
                        <div class="fila-input">
                            <div class="grupo-input">
                                <label>Nombre del CEO</label>
                                <input type="text" name="nombre_ceo" value="Ferdán Garrigos">
                            </div>
                            <div class="grupo-input">
                                <label>Puesto</label>
                                <input type="text" name="puesto" value="Fundador & CEO">
                            </div>
                        </div>
                        <div class="grupo-input">
                            <label>Frase inspiracional</label>
                            <textarea name="frase" rows="3">“Tratamos cada equipo como si fuera propio...”</textarea>
                        </div>
                    </div>
                <?php break; ?>

                <?php default: ?>
                    <p>Selecciona una sección para editar.</p>
                <?php break; ?>
            <?php endswitch; ?>

            <div class="seccion-guardado">
                <input type="hidden" name="seccion_editada" value="<?= $edit ?>">
                <button type="submit" class="boton-guardar">
                    <i class="fa-solid fa-check"></i> Actualizar Sección <?= ucfirst($edit) ?>
                </button>
            </div>
        </form>
    </div>
</div>