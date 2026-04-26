<?php
include __DIR__ . "/../../config/conexion.db.php";

if (!isset($conexion)) {
    die("Error: No se pudo cargar la variable de conexión \$pdo. Verifica el archivo conexion.db.php");
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<div class="contenedor-crud">
    <div class="buscador-container">
<form method="GET" class="buscador-form">
    <input type="hidden" name="seccion" value="servicios">

    <input 
        type="text" 
        name="busqueda" 
        class="buscador-input"
        placeholder="Buscar servicio..."
        value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>"
    >

    <button type="submit" class="buscador-btn">Buscar</button>
    </div>
</form>
    <div class="encabezado-seccion">
        <button class="boton-primario" onclick="abrirFormulario()">
            <i class="fa-solid fa-plus"></i> Nuevo Servicio
        </button>
    </div>
<div id="formulario-servicio" class="modal-formulario" style="display: none;">
    <div class="contenido-modal modal-purpura">
    
        <h3>Registrar Nuevo Servicio</h3>
        <form action="../controllers/servicios_crud_controller.php?accion=agregar" method="POST">
            <div class="grupo-input">
                <label>Nombre del Servicio:</label>
                <input type="text" name="tipo_servicio" required placeholder="Ej. Reparación de Laptop">
            </div>
            <div class="grupo-input">
                <label>Codigo</label>
                <input type="text" name="codigo_servicio" required placeholder="Ej. AG-001">
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
                <textarea name="descripcion" required></textarea>
            </div>
            <div class="grupo-input">
                <label>Procedimiento:</label>
                <textarea name="procedimiento" required></textarea>
            </div>
             <div class="grupo-input">
                <label>Beneficios:</label>
                <textarea name="beneficios" required></textarea>
            </div>
             <div class="grupo-input">
                <label>Indicaciones:</label>
                <textarea name="indicaciones" required></textarea>
            </div>
             <div class="grupo-input">
                <label>Exclusiones:</label>
                <textarea name="exclusiones" required></textarea>
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

    <div class="tabla-responsiva">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                     <th>Nombre del servicio</th>
                    <th>Tipo de servicio</th>
                    <th>Descripcion</th>
                    <th>Tiempo estimado del servicio</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                     <tr>
<?php
$busqueda = $_GET['busqueda'] ?? '';

if (!empty($busqueda)) {

    $like = "%" . $conexion->real_escape_string($busqueda) . "%";

    $query = "SELECT 
                s.id_servicio,
                s.tipo_servicio,
                s.descripcion,
                s.procedimiento,
                s.beneficios,
                s.indicaciones,
                s.exclusiones,
                s.imagen_servicio,
                s.tiempo_estimado,
                s.precio,
                s.estado,
                t.nombre_tipo
              FROM servicios s
              LEFT JOIN tipos_servicios t 
              ON s.id_tipo_servicio = t.id_tipo_servicio
              WHERE s.tipo_servicio LIKE '$like'
              OR s.codigo_servicio LIKE '$like'
              OR s.descripcion LIKE '$like'
              OR s.procedimiento LIKE '$like'
              OR s.beneficios LIKE '$like'
              OR s.indicaciones LIKE '$like'
              OR s.exclusiones LIKE '$like'";

} else {

    $query = "SELECT 
                s.id_servicio,
                s.tipo_servicio,
                s.descripcion,
                s.procedimiento,
                s.beneficios,
                s.indicaciones,
                s.exclusiones,
                s.imagen_servicio,
                s.tiempo_estimado,
                s.precio,
                s.estado,
                t.nombre_tipo
              FROM servicios s
              LEFT JOIN tipos_servicios t 
              ON s.id_tipo_servicio = t.id_tipo_servicio";
}
$resultado = $conexion->query($query);

if (!$resultado) {
    echo "<tr><td colspan='7'>Error en la consulta: " . $conexion->error . "</td></tr>";
} else {
    while ($row = $resultado->fetch_assoc()) {
        // Preparar los datos para el modal de edición (escapando comillas)
        $datosJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
        
        echo "<tr>
                <td>{$row['id_servicio']}</td>
                <td>" . htmlspecialchars($row['tipo_servicio']) . "</td>
                <td>{$row['nombre_tipo']}</td>
                <td><strong>" . htmlspecialchars($row['descripcion']) . "</strong></td>
                 
                <td>{$row['tiempo_estimado']}</td>
                <td>$" . number_format($row['precio'], 2) . "</td>
                <td>
                    <span style='padding: 4px 8px; border-radius: 12px; font-size: 0.8em; background: " . ($row['estado'] == 'activo' ? '#d4edda' : '#f8d7da') . "; color: " . ($row['estado'] == 'activo' ? '#155724' : '#721c24') . ";'>
                        " . ucfirst($row['estado']) . "
                    </span>
                </td>
                <td class='acciones'>
                    <button class='btn-editar' title='Editar' onclick='abrirEditarServicio(event, $datosJson)'>
                        <i class='fa-solid fa-pen-to-square'></i>
                    </button>
                      <button class='btn-eliminar' onclick='confirmarEliminacion({$row['id_servicio']})'>
    <i class='fa-solid fa-trash'></i>
</button>
              <button class='btn-ver' type='button' onclick='abrirModalVerServicio($datosJson)'>
    <i class='fa-solid fa-eye'></i>
</button>
                </td>
              </tr>";
    }
}
?>
            </tbody>
        </table>
    </div>
</div>
<div id="modal-editar-servicio" class="modal-formulario" style="display: none;">
    <div class="contenido-modal modal-purpura">
 
        <h3><i class="fa-solid fa-pen-to-square"></i> Editar Servicio</h3>
        
        <form action="../controllers/servicios_crud_controller.php?accion=editar" method="POST" id="form-editar">
            <input type="hidden" name="id_servicio" id="edit-id">

            <div class="grupo-input">
                <label>Nombre del Servicio:</label>
                <input type="text" name="tipo_servicio" id="edit-tipo" required>
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
                <textarea name="descripcion" id="edit-descripcion" required></textarea>
            </div>
            <div class="grupo-input">
                <label>Procedimiento:</label>
               <textarea name="procedimiento" id="edit-procedimiento"></textarea>
            </div>
            <div class="grupo-input">
                <label>Beneficios:</label>
               <textarea name="beneficios" id="edit-beneficios"></textarea>
            </div>
            <div class="grupo-input">
                <label>Indicaciones:</label>
                <textarea name="indicaciones" id="edit-indicaciones"></textarea>
            </div>
             <div class="grupo-input">
                <label>Exclusiones:</label>
               <textarea name="exclusiones" id="edit-exclusiones"></textarea>
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
  <div id="modalVerServicio" class="modal-formulario" style="display: none;">
    <div class="contenido-modal modal-purpura" style="max-height: 90vh; overflow-y: auto; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <span class="cerrar-modal" onclick="cerrarModalVerServicio()" style="float:right; cursor:pointer; font-size:28px;">&times;</span>
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
<script src="../../public/js/servicios_crud.js"></script>

