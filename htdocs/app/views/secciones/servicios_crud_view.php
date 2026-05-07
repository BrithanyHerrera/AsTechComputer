<?php
/**
 * PÁGINA: Gestión de Servicios CRUD - As Tech Computer
 * NOMBRE: servicios_crud_view.php
 * MODELO: servicios_crud_model.php
 * CONTROLADOR: servicios_crud_controller.php
 * PROPÓSITO: Interfaz administrativa para buscar, visualizar, agregar, editar y eliminar servicios,
 * incluyendo formularios modales, integración con base de datos y manejo dinámico con JavaScript.
 */
?>
<?php
/* CONFIGURACIÓN E INICIALIZACIÓN */

include __DIR__ . "/../../config/conexion.db.php";

if (!isset($conexion)) {
    die("Error: No se pudo cargar la variable de conexión \$pdo. Verifica el archivo conexion.db.php");
}

// 1. Capturamos los nuevos filtros del GET
$busqueda   = $_GET['busqueda'] ?? '';
$filtro_tipo = $_GET['filtro_tipo'] ?? '';
$precio_max  = $_GET['precio_max'] ?? '';

// 2. Base de la consulta
$query = "SELECT 
            s.*, 
            t.nombre_tipo
          FROM servicios s
          LEFT JOIN tipos_servicios t ON s.id_tipo_servicio = t.id_tipo_servicio
          WHERE 1=1"; // El 1=1 es para facilitar la concatenación de ANDs

// 3. Filtro por palabra clave (Buscador original)
if (!empty($busqueda)) {
    $like = "%" . $conexion->real_escape_string($busqueda) . "%";
    $query .= " AND (s.tipo_servicio LIKE '$like' 
                OR s.codigo_servicio LIKE '$like' 
                OR s.descripcion LIKE '$like'
                OR s.procedimiento LIKE '$like')";
}

// 4. Filtro por Categoría (ID Tipo Servicio)
if (!empty($filtro_tipo)) {
    $tipo_id = (int)$filtro_tipo;
    $query .= " AND s.id_tipo_servicio = $tipo_id";
}

// 5. Filtro por Precio Máximo
if (!empty($precio_max)) {
    $p_max = (float)$precio_max;
    $query .= " AND s.precio <= $p_max";
}

// 6. Ejecutar la consulta
$resultado = $conexion->query($query);
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- BUSCADOR DE SERVICIOS -->

<div class="contenedor-crud" id="contenedor-principal-servicios">
    <div class="buscador-container" id="buscador-container-servicios">
        <form method="GET" class="buscador-form" id="buscador-form-servicios" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end;">
            <input type="hidden" name="seccion" value="servicios">

            <div class="grupo-filtro">
                <label><small>Palabra clave:</small></label>
                <input type="text" name="busqueda" class="buscador-input" placeholder="Buscar..." value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
            </div>

            <div class="grupo-filtro">
                <label><small>Categoría:</small></label>
                <select name="filtro_tipo" class="buscador-input">
                    <option value="">Todos los tipos</option>
                    <?php
                    $tipos = $conexion->query("SELECT * FROM tipos_servicios");
                    while($t = $tipos->fetch_assoc()): ?>
                        <option value="<?= $t['id_tipo_servicio'] ?>" <?= (isset($_GET['filtro_tipo']) && $_GET['filtro_tipo'] == $t['id_tipo_servicio']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['nombre_tipo']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="grupo-filtro">
                <label><small>Precio Máx:</small></label>
                <input type="number" name="precio_max" class="buscador-input" style="width: 100px;" placeholder="Max $" value="<?= htmlspecialchars($_GET['precio_max'] ?? '') ?>">
            </div>

            <button type="submit" class="buscador-btn">Filtrar</button>
           <a href="?seccion=servicios" class="btn-limpiar">
            <i class="fa-solid fa-eraser"></i> Limpiar
        </a>
        </form>
    </div>

</form>
   <!-- FORMULARIO PARA AGREGAR UN NUEVO SERVICIO  -->
    <div class="encabezado-seccion">
        <button class="boton-primario" onclick="abrirFormulario()">
            <i class="fa-solid fa-plus"></i> Nuevo Servicio
        </button>
    </div>
<div id="formulario-servicio" class="modal-formulario" style="display: none;" >
    <div class="contenido-modal modal-purpura">
     <span class="cerrar-modal" onclick="cerrarFormulario()" >&times;</span>
        <h3>Registrar Nuevo Servicio</h3>
        <form action="../controllers/servicios_crud_controller.php?accion=agregar" method="POST" id="form-agregar">
            <div class="grupo-input">
                <label>Nombre del Servicio:</label>
                <input type="text" name="tipo_servicio" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$" placeholder="Ej. Reparación de Laptop">
            </div>
            <div class="grupo-input">
                <label>Codigo</label>
                <input type="text" name="codigo_servicio" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$" placeholder="Ej. AG-001">
            </div>
            <div class="grupo-input">
    <label> Tipo de Servicio:</label>
    <select name="id_tipo_servicio" required>
        <option value="">Selecciona un tipo</option>
        <?php
        $tipos = $conexion->query("SELECT * FROM tipos_servicios");
        while($tipo = $tipos->fetch_assoc()){
            echo "<option value='{$tipo['id_tipo_servicio']}'>
                    {$tipo['nombre_tipo']}
                  </option>";
        }
        ?>
    </select>
</div>
            <div class="grupo-input">
                <label>Descripción:</label>
                <textarea name="descripcion"required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
            <div class="grupo-input">
                <label>Procedimiento:</label>
                <textarea name="procedimiento" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
             <div class="grupo-input">
                <label>Beneficios:</label>
                <textarea name="beneficios" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
             <div class="grupo-input">
                <label>Indicaciones:</label>
                <textarea name="indicaciones" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
             <div class="grupo-input">
                <label>Exclusiones:</label>
                <textarea name="exclusiones" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
          <div class="flex-form-ayuda">
    <div class="campos-principales">
        <div class="grupo-input">
            <label>Nombre del Archivo de Imagen:</label>
            <input type="text" name="imagen_servicio" required placeholder="ejemplo_imagen.png">
        </div>
        
        </div>
    <div class="guia-url">
        <h4><i class="fa-solid fa-circle-info"></i> Formato Requerido</h4>
        <p>Escribe el nombre exacto del archivo con su extensión:</p>
        <code>Miniaturas_500px_Recuperacion_De_Info.png</code>
        <p><small>* Usa guiones bajos (_) en lugar de espacios.</small></p>
    </div>
</div>
            <div class="grupo-input">
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" required>
            </div>
            <div class="grupo-input">
                <label>Tiempo Estimado:</label>
                <input type="text" name="tiempo_estimado" placeholder="Ej. 2 horas">
            </div>
            <div class="grupo-input">
                <label>Estado:</label>
                <select name="estado">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="botones-form">
                <button type="submit" class="btn-guardar" style="background-color: #52073a; color: white;">Guardar Servicio</button>
                <button type="button" class="btn-cancelar" onclick="cerrarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<!-- Tabla que muestra los servicios -->
    <div >
<div class="tabla-contenedor" id="tabla-servicios-wrapper">
    <table id="tabla-listado-servicios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del servicio</th>
                <th>Tipo de servicio</th>
                <th>Descripcion</th>
                <th>Tiempo estimado</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        <?php
            if (!$resultado) {
                echo "<tr><td colspan='8'>Error en la consulta: " . $conexion->error . "</td></tr>";
            } else {
                if ($resultado->num_rows == 0) {
                    echo "<tr><td colspan='8' style='text-align:center;'>No se encontraron servicios con esos filtros.</td></tr>";
                }
                
                // UN SOLO BUCLE: Limpio y responsivo
                while ($row = $resultado->fetch_assoc()) {
                    $datosJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                    ?>
                    <tr>
                        <td data-label="ID"><?= $row['id_servicio'] ?></td>
                        <td data-label="Nombre del servicio"><?= htmlspecialchars($row['tipo_servicio']) ?></td>
                        <td data-label="Tipo de servicio"><?= $row['nombre_tipo'] ?></td>
                        <td data-label="Descripcion"><strong><?= htmlspecialchars($row['descripcion']) ?></strong></td>
                        <td data-label="Tiempo estimado"><?= $row['tiempo_estimado'] ?></td>
                        <td data-label="Precio">$<?= number_format($row['precio'], 2) ?></td>
                        <td data-label="Estado">
                            <span class="badge-status" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8em; background: <?= ($row['estado'] == 'activo' ? '#d4edda' : '#f8d7da') ?>; color: <?= ($row['estado'] == 'activo' ? '#155724' : '#721c24') ?>;">
                                <?= ucfirst($row['estado']) ?>
                            </span>
                        </td>
                        <td data-label="Acciones" class="acciones">
                            <button class="btn-editar" title="Editar" onclick="abrirEditarServicio(event, <?= $datosJson ?>)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-eliminar" title="Eliminar" onclick="confirmarEliminacion(<?= $row['id_servicio'] ?>)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <button class="btn-ver" type="button" title="Ver detalles" onclick="abrirModalVerServicio(<?= $datosJson ?>)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
        
    </div>
</div>
<!-- FORMULARIO PARA EDITAR SERVICIO -->
<div id="modal-editar-servicio" class="modal-formulario" id="form-editar" style="display: none; ">
    <div class="contenido-modal modal-purpura">
  <span class="cerrar-modal" onclick="cerrarModalEditar()" >&times;</span>
        <h3><i class="fa-solid fa-pen-to-square"></i> Editar Servicio</h3>
        
        <form action="../controllers/servicios_crud_controller.php?accion=editar" method="POST" id="form-editar">
            <input type="hidden" name="id_servicio" id="edit-id">

            <div class="grupo-input">
                <label>Nombre del Servicio:</label>
                <input type="text" name="tipo_servicio" id="edit-tipo" required     
           pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]+$" 
           title="Solo se permiten letras, números y espacios." 
           placeholder="Ej. Reparación de Laptop">
            </div>
            <div class="grupo-input">
    <label>Tipo de Servicio:</label>
    <select name="id_tipo_servicio" id="edit-tipo-servicio" required>
        <?php
        $tipos = $conexion->query("SELECT * FROM tipos_servicios");
        while($tipo = $tipos->fetch_assoc()){
            echo "<option value='{$tipo['id_tipo_servicio']}'>
                    {$tipo['nombre_tipo']}
                  </option>";
        }
        ?>
    </select>
</div>
            <div class="grupo-input">
                <label>Descripción:</label>
                <textarea name="descripcion" id="edit-descripcion" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$" title="No se permiten signos especiales."></textarea>
            </div>
            <div class="grupo-input">
                <label>Procedimiento:</label>
               <textarea name="procedimiento" id="edit-procedimiento" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
            <div class="grupo-input">
                <label>Beneficios:</label>
               <textarea name="beneficios" id="edit-beneficios"required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
            <div class="grupo-input">
                <label>Indicaciones:</label>
                <textarea name="indicaciones" id="edit-indicaciones" required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
             <div class="grupo-input">
                <label>Exclusiones:</label>
               <textarea name="exclusiones" id="edit-exclusiones"required pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
            </div>
            <div class="flex-form-ayuda">
    <div class="campos-principales">
        <div class="grupo-input">
            <label>Nombre del Archivo de Imagen:</label>
            <input type="text" name="imagen_servicio" id="edit-imagen" required>
        </div>
    </div>
    
    <div class="guia-url">
        <h4><i class="fa-solid fa-pen-to-square"></i> Editar URL</h4>
        <p>Si cambias la imagen, asegúrate de que el nombre coincida con el archivo en el servidor.</p>
        <code>nuevo_archivo.jpg</code>
    </div>
</div>
            <div class="grupo-input">
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" id="edit-precio" required>
            </div>
            <div class="grupo-input">
                <label>Tiempo Estimado:</label>
                <input type="text" name="tiempo_estimado" id="edit-tiempo">
            </div>
           <div class="grupo-input">
    <label>Estado:</label>
    <select name="estado" id="edit-estado">
        <option value="activo">Activo</option>
        <option value="inactivo">Inactivo</option>
    </select>
</div>
            
            <div class="botones-form">
                <button type="submit" class="btn-actualizar" style="background-color: #52073a; color: white;">Actualizar Cambios</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModalEditar()">Cancelar</button>
            </div>
        </form>
    </div>
  
</div>
<!-- MODAL PARA VER INFRORMACION EXTRA DEL SERVICIO -->
  <div id="modalVerServicio" class="modal-formulario" style="display: none;">
    <div class="contenido-modal modal-purpura" style="max-height: 90vh; overflow-y: auto; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <span class="cerrar-modal" onclick="cerrarModalVerServicio()" >&times;</span>
        <h3><i class="fa-solid fa-circle-info"></i> Detalles del Servicio</h3>
        
        <div style="text-align:center; margin: 20px 0;">
            <img id="v_imagen" src="" style="width:100%; max-width:250px; border-radius:10px; border: 3px solid #52073a;">
        </div>

        <div class="info-detalle" style="text-align: left; display: flex; flex-direction: column; gap: 15px;">

            <div><strong>Descripción:</strong> <p id="v_descripcion" style="background:#f4f4f4; padding:10px; border-radius:5px; margin:5px 0;"></p></div>
            <div><strong>Procedimiento:</strong> <p id="v_procedimiento" style="background:#f4f4f4; padding:10px; border-radius:5px; margin:5px 0; white-space:pre-wrap;"></p></div>
             <div><strong>Beneficios:</strong> <p id="v_beneficios" style="background:#f4f4f4; padding:10px; border-radius:5px; margin:5px 0; white-space:pre-wrap;"></p></div>
            <div><strong>Indicaciones:</strong> <p id="v_indicaciones" style="background:#f4f4f4; padding:10px; border-radius:5px; margin:5px 0; white-space:pre-wrap;"></p></div>
            <div><strong>Exclusiones:</strong> <p id="v_exclusiones" style="background:#f4f4f4; padding:10px; border-radius:5px; margin:5px 0; white-space:pre-wrap;"></p></div>
        </div>
    </div>
</div>
<!-- SCRIPT DE JAVASCRIPT -->
<script src="../../public/js/servicios_crud.js"></script>
