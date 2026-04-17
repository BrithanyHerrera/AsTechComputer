<?php
// Subimos dos niveles para salir de 'secciones' y 'views', luego entramos a 'config'
include __DIR__ . "/../../config/conexion.db.php";

// Obtenemos los puestos directamente de la base de datos de manera dinámica
$queryPuestos = $conexion->query("SELECT * FROM puestos ORDER BY id_puesto ASC");
$listaPuestos = "";
while ($fila = $queryPuestos->fetch_assoc()) {
    $listaPuestos .= "<option value='{$fila['id_puesto']}'>{$fila['nombre_puesto']}</option>";
}
?>

<div class="contenedor-crud">
    <div class="encabezado-seccion">
        <button class="boton-primario" onclick="abrirFormulario()">
            <i class="fa-solid fa-plus"></i> Nuevo empleado
        </button>
    </div>

    <div id="formulario-empleado" class="modal-formulario" style="display: none;">
        <div class="contenido-modal">
            <span class="cerrar" onclick="cerrarFormulario()">&times;</span>
            <h3>Registrar Nuevo Empleado</h3>
            <form action="../controllers/empleado_controller.php?accion=agregar" method="POST">
                <div class="grupo-input">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" required placeholder="Ej. Carlos">
                </div>
                <div class="grupo-input">
                    <label>Apellido:</label>
                    <input type="text" name="apellido" required placeholder="Ej. Martinez">
                </div>
                <div class="grupo-input">
                    <label>Telefono:</label>
                    <input type="text" name="telefono" >
                </div>
                 <div class="grupo-input">
                    <label>Correo electronico:</label>
                    <input type="email" name="correo" required placeholder="carlos@astech.com" >
                </div>
                <div class="grupo-input">
                    <label>Nombre Usuario:</label>
                    <input type="text" name="nombre_usuario" required placeholder="carlos-01" >
                </div>
                <div class="grupo-input">
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" required placeholder="***********" >
                </div>
                <div class="grupo-input">
                    <label>Puesto:</label>
                    <select name="id_puesto" required>
                        <?php echo $listaPuestos; ?>
                    </select>
                </div>
                <div class="botones-form">
                    <button type="submit" class="btn-guardar">Guardar Empleado</button>
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
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th>Puesto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = $conexion->query("SELECT e.*, p.nombre_puesto FROM empleados e JOIN puestos p ON e.id_puesto = p.id_puesto");

                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_empleado']}</td>
                            <td><strong>{$row['nombre']}</strong></td>
                            <td>{$row['apellido']}</td>
                            <td>{$row['telefono']}</td>
                            <td>{$row['correo']}</td>
                            <td>{$row['nombre_usuario']}</td>
                            <td>{$row['nombre_puesto']}</td> <td class='acciones'>
                                <button class='btn-editar' onclick='abrirEditar(".json_encode($row).")'><i class='fa-solid fa-pen-to-square'></i></button>
                                <button class='btn-eliminar' onclick='confirmarEliminacion({$row['id_empleado']})'><i class='fa-solid fa-trash'></i></button>
                                <button class='btn-contactar'><i class='fa-brands fa-whatsapp'></i></button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal-editar-empleado" class="modal-formulario" style="display: none;">
    <div class="contenido-modal modal-purpura">
        <span class="cerrar" onclick="cerrarModalEditar()">&times;</span>
        <h3><i class="fa-solid fa-user-pen"></i> Editar Empleado</h3>
        
         <form action="../controllers/empleado_controller.php?accion=editar" method="POST" id="form-editar">
            <input type="hidden" name="id_empleado" id="edit-id">

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
                    <?php echo $listaPuestos; ?>
                </select>
            </div>

            <?php if (isset($_SESSION['id_puesto']) && $_SESSION['id_puesto'] == 4): ?>
            <div class="grupo-input" style="background: #fdf2f8; padding: 10px; border-radius: 5px; border-left: 4px solid #8e44ad; margin-top: 15px;">
                <label style="color: #4a148c; font-weight: bold;"><i class="fa-solid fa-shield-halved"></i> Cambio de Contraseña (Solo Admin)</label>
                <input type="password" name="contrasena" placeholder="Deja en blanco para no modificar">
            </div>
            <?php endif; ?>
            
            <div class="botones-form" style="margin-top: 20px;">
                <button type="submit" class="btn-actualizar">Actualizar Cambios</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModalEditar()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirFormulario() {
    document.getElementById('formulario-empleado').style.display = 'flex';
}
function cerrarFormulario() {
    document.getElementById('formulario-empleado').style.display = 'none';
}
// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    if (event.target == document.getElementById('formulario-empleado')) {
        cerrarFormulario();
    }
}
function confirmarEliminacion(id) {
    if (confirm("¿Estás seguro de eliminar a este empleado?")) {
        window.location.href = `../controllers/empleado_controller.php?accion=eliminar&id=${id}`;
    }
}
function abrirEditar(datos) {
    // Llenar los campos
    document.getElementById('edit-id').value = datos.id_empleado;
    document.getElementById('edit-nombre').value = datos.nombre;
    document.getElementById('edit-apellido').value = datos.apellido;
    document.getElementById('edit-telefono').value = datos.telefono;
    document.getElementById('edit-correo').value = datos.correo;
    document.getElementById('edit-usuario').value = datos.nombre_usuario;
    document.getElementById('edit-puesto').value = datos.id_puesto;

    // Mostrar el modal
    document.getElementById('modal-editar-empleado').style.display = 'flex';
}

function cerrarModalEditar() {
    document.getElementById('modal-editar-empleado').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        Swal.fire({
            icon: 'success', title: '¡Actualizado!', text: 'Los datos se guardaron correctamente.', confirmButtonColor: '#52073a'
        });
    } else if (status === 'duplicate') {
        Swal.fire({
            icon: 'error', title: 'Dato Duplicado', text: 'El correo o nombre de usuario ya existe.', confirmButtonColor: '#52073a'
        });
    } else if (status === 'error') {
        Swal.fire({
            icon: 'error', title: 'Error', text: 'Ocurrió un problema al procesar la solicitud.', confirmButtonColor: '#52073a'
        });
    }
    window.history.replaceState({}, document.title, window.location.pathname);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>