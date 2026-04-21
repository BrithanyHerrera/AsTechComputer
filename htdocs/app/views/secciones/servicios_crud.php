<?php
include __DIR__ . "/../../config/conexion.db.php";

if (!isset($conexion)) {
    die("Error: No se pudo cargar la variable de conexión \$pdo. Verifica el archivo conexion.db.php");
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="contenedor-crud">
    <div class="encabezado-seccion">
        <button class="boton-primario" onclick="abrirFormulario()">
            <i class="fa-solid fa-plus"></i> Nuevo Servicio
        </button>
    </div>
<div id="formulario-servicio" class="modal-formulario" style="display: none;">
    <div class="contenido-modal modal-purpura">
    
        <h3>Registrar Nuevo Servicio</h3>
        <form action="../controllers/servicios_controller.php?accion=agregar" method="POST">
            <div class="grupo-input">
                <label>Nombre del Servicio:</label>
                <input type="text" name="tipo_servicio" required placeholder="Ej. Reparación de Laptop">
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
// Consulta limpia para tu estructura actual
$query = "SELECT 
            s.id_servicio,
            s.tipo_servicio,
            s.descripcion,
              s.procedimiento,
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
        
        <form action="../controllers/servicios_controller.php?accion=editar" method="POST" id="form-editar">
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
            <div><strong>Indicaciones:</strong> <p id="v_indicaciones" style="background:#f4f4f4; padding:10px; border-radius:5px; margin:5px 0; white-space:pre-wrap;"></p></div>
            <div><strong>Exclusiones:</strong> <p id="v_exclusiones" style="background:#f4f4f4; padding:10px; border-radius:5px; margin:5px 0; white-space:pre-wrap;"></p></div>
        </div>
    </div>
</div>

<script>
    function convertirABase64(idHidden, idInput) {
    const elementoFile = document.getElementById(idInput);
    if (!elementoFile || !elementoFile.files[0]) return;

    const archivo = elementoFile.files[0];
    const reader = new FileReader();

    reader.onloadend = function() {
        document.getElementById(idHidden).value = reader.result;
        console.log("Imagen cargada en: " + idHidden);
    };

    reader.readAsDataURL(archivo);
}

function abrirFormulario() {
    document.getElementById('formulario-servicio').style.display = 'block';
}
function cerrarFormulario() {
    document.getElementById('formulario-servicio').style.display = 'none';
}
// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    if (event.target == document.getElementById('formulario-servicio')) {
        cerrarFormulario();
    }
}

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar servicio?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#52073a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviamos la petición al controlador unificado
            window.location.href = `../controllers/servicios_controller.php?accion=eliminar&id=${id}`;
        }
    });
}


function abrirEditarServicio(event, datos) {
    const modal = document.getElementById('modal-editar-servicio');

    document.getElementById('edit-id').value = datos.id_servicio;
    document.getElementById('edit-tipo').value = datos.tipo_servicio;
    document.getElementById('edit-descripcion').value = datos.descripcion;
    document.getElementById('edit-precio').value = datos.precio;
    document.getElementById('edit-tiempo').value = datos.tiempo_estimado;
    document.getElementById('edit-estado').value = datos.estado;
    document.getElementById('edit-tipo-servicio').value = datos.id_tipo_servicio;
    
    // CAMBIO CLAVE: Asignar el nombre del archivo al input de texto
    document.getElementById('edit-imagen').value = datos.imagen_servicio;

    modal.style.display = 'block';
}
function cerrarModalEditar() {
    document.getElementById('modal-editar-servicio').style.display = 'none';
}
function cerrarModalEditar() {
    document.getElementById('modal-editar-servicio').style.display = 'none';
}
// Detectar parámetros en la URL al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        Swal.fire({
            icon: 'success',
            title: '¡Actualizado!',
            text: 'Los datos del servicio se guardaron correctamente.',
            confirmButtonColor: '#52073a' // Tu color púrpura
        });
    } 
    else if (status === 'duplicate') {
        Swal.fire({
            icon: 'error',
            title: 'Dato Duplicado',
            text: 'El correo o nombre de usuario ya está registrado por otro servicio.',
            confirmButtonColor: '#52073a'
        });
    } 
    else if (status === 'error') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un problema al procesar la solicitud.',
            confirmButtonColor: '#52073a'
        });
    }
    

    // Limpiar la URL para que no repita la alerta al recargar
    window.history.replaceState({}, document.title, window.location.pathname);
});
function abrirModalVerServicio(datos) {
    const modal = document.getElementById('modalVerServicio');
    const rutaImg = "../../public/img/servicios/";

    document.getElementById('v_imagen').src = rutaImg + (datos.imagen_servicio || 'default.png');
    document.getElementById('v_descripcion').textContent = datos.descripcion || 'N/A';
    document.getElementById('v_procedimiento').textContent = datos.procedimiento || 'No especificado';
    document.getElementById('v_indicaciones').textContent = datos.indicaciones || 'No especificado';
    document.getElementById('v_exclusiones').textContent = datos.exclusiones || 'No especificado';

    modal.style.display = 'block';
}

function cerrarModalVerServicio() {
    document.getElementById('modalVerServicio').style.display = 'none';
}

window.onclick = function(event) {
    const modalVer = document.getElementById('modalVerServicio');
    const modalForm = document.getElementById('formulario-servicio');
    const modalEdit = document.getElementById('modal-editar-servicio');
    
    // Solo cierra si el clic es en el contenedor oscuro (el target es el modal mismo)
    if (event.target == modalVer) cerrarModalVerServicio();
    if (event.target == modalForm) cerrarFormulario();
    if (event.target == modalEdit) cerrarModalEditar();
}
</script>