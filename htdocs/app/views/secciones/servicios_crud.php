<?php
// Subimos dos niveles para salir de 'secciones' y 'views', luego entramos a 'config'
include __DIR__ . "/../../config/conexion.db.php";

// Verificación de seguridad (opcional pero recomendada)
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
        <span class="cerrar" onclick="cerrarForm()">&times;</span>
        <h3>Registrar Nuevo Servicio</h3>
        <form action="../views/acciones/agregar_servicio.php" method="POST">
            <div class="grupo-input">
                <label>Tipo de Servicio:</label>
                <input type="text" name="tipo_servicio" required placeholder="Ej. Reparación de Laptop">
            </div>
            <div class="grupo-input">
                <label>Descripción:</label>
                <textarea name="descripcion" required></textarea>
            </div>
            <div class="grupo-input">
                <label>URL de Imagen:</label>
                <input type="file" name="imagen_url" placeholder="http://ruta-de-la-imagen.jpg">
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
$query = "SELECT id_servicio, tipo_servicio, descripcion, imagen_url, tiempo_estimado, precio, estado FROM servicios";

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
                <td><strong>" . htmlspecialchars($row['descripcion']) . "</strong></td>
                <td>
                    <img src='" . htmlspecialchars($row['imagen_url'] ?? '../../img/default-servicio.png') . "' 
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
                    <button class='btn-editar' title='Editar' onclick='abrirEditarServicio($datosJson)'>
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
        <span class="cerrar" onclick="cerrarModalEditar()">&times;</span>
        <h3><i class="fa-solid fa-user-pen"></i> Editar servicio</h3>
        
        <form action="../views/acciones/editar_servicio.php" method="POST" id="form-editar">
            <input type="hidden" name="id_servicio" id="edit-id">

            <div class="grupo-input">
                <label>Nombre:</label>
                <input type="text" name="nombre" id="edit-nombre" required>
            </div>
            <div class="grupo-input">
                <label>Apellido:</label>
                <input type="text" name="apellido" id="edit-apellido" required>
            </div>
            <div class="grupo-input">
                <label>Teléfono:</label>
                <input type="text" name="telefono" id="edit-telefono">
            </div>
            <div class="grupo-input">
                <label>Correo electrónico:</label>
                <input type="email" name="correo" id="edit-correo" required>
            </div>
            <div class="grupo-input">
                <label>Nombre Usuario:</label>
                <input type="text" name="nombre_usuario" id="edit-usuario" required>
            </div>
            <div class="grupo-input">
                <label>Puesto:</label>
                <select name="id_puesto" id="edit-puesto" required>
                    <option value="1">Soporte Técnico</option>
                    <option value="2">Recepción</option>
                    <option value="3">Gerente</option>
                </select>
            </div>
            
            <div class="botones-form">
                <button type="submit" class="btn-actualizar">Actualizar Cambios</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModalEditar()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
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
    if (confirm("¿Estás seguro?")) {
        
        window.location.href = "../../app/views/acciones/eliminar_servicio.php?id=" + id;
    }
}function abrirEditar(datos) {
    // Llenar los campos del formulario con los datos del servicio
    document.getElementById('edit-id').value = datos.id_servicio;
    document.getElementById('edit-nombre').value = datos.nombre;
    document.getElementById('edit-apellido').value = datos.apellido;
    document.getElementById('edit-telefono').value = datos.telefono;
    document.getElementById('edit-correo').value = datos.correo;
    document.getElementById('edit-usuario').value = datos.nombre_usuario;
    document.getElementById('edit-puesto').value = datos.id_puesto;

    // Mostrar el modal
    document.getElementById('modal-editar-servicio').style.display = 'flex';
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