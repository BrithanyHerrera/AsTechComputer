<?php
// Subimos dos niveles para salir de 'secciones' y 'views', luego entramos a 'config'
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
        <form action="acciones/agregar_servicio.php" method="POST">
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
        
            <div class="grupo-input">
                <label>URL de Imagen:</label>
                <input type="file" id="seleccionador" accept="image/*" onchange="convertirABase64('imagen_servicio', 'seleccionador')">
                    <input type="hidden" name="imagen_servicio" id="imagen_servicio">
               
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
                    <th>Imagen</th>
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
                <td>
                    <img src='" . htmlspecialchars($row['imagen_servicio'] ?? '../../img/default-servicio.png') . "' 
                         alt='Servicio' 
                         style='width:50px; height:50px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;'>
                </td>
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
        
        <form action="../views/acciones/editar_servicio.php" method="POST" id="form-editar">
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
                <label>Actualizar Imagen (Opcional):</label>
                <input type="file" id="seleccionador-edit" accept="image/*" onchange="convertirABase64('edit-imagen', 'seleccionador-edit')">
                <input type="hidden" name="imagen_servicio" id="edit-imagen">
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
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#52073a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../../app/views/acciones/eliminar_servicio.php?id=" + id;
        }
    });
}
function abrirEditarServicio(event, datos) {
    const modal = document.getElementById('modal-editar-servicio');
    const contenido = modal.querySelector('.contenido-modal');

    // llenar datos
    document.getElementById('edit-id').value = datos.id_servicio;
    document.getElementById('edit-tipo').value = datos.tipo_servicio;
    document.getElementById('edit-descripcion').value = datos.descripcion;
    document.getElementById('edit-precio').value = datos.precio;
    document.getElementById('edit-tiempo').value = datos.tiempo_estimado;
    document.getElementById('edit-estado').value = datos.estado;
    document.getElementById('edit-tipo-servicio').value = datos.id_tipo_servicio;

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
</script>