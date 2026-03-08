<?php
// Subimos dos niveles para salir de 'secciones' y 'views', luego entramos a 'config'
include __DIR__ . "/../../config/conexion.db.php";

// Verificación de seguridad (opcional pero recomendada)
if (!isset($conexion)) {
    die("Error: No se pudo cargar la variable de conexión \$pdo. Verifica el archivo conexion.db.php");
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
            <form action="../views/agregar_empleado.php" method="POST">
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
                    <input type="text" name="nombre_usuario" required placeholder="carlos@astech.com" >
                </div>
                <div class="grupo-input">
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" required placeholder="***********" >
                </div>
                <div class="grupo-input">
                    <label>Puesto:</label>
                    <select name="id_puesto" required>
                        <option value="1">Soporte Técnico</option>
                        <option value="2">Recepción</option>
                        <option value="3">Gerente</option>
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
                   
                </tr>
            </thead>
            <tbody>
                    <tr>
                <?php
                // Consulta para traer empleados y el nombre de su puesto
               $resultado = $conexion->query("SELECT e.*, p.nombre_puesto 
FROM empleados e 
JOIN puestos p ON e.id_puesto = p.id_puesto");

while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_empleado']}</td>
                            <td><strong>{$row['nombre']}</strong></td>
                            <td>{$row['apellido']}</td>
                            <td>{$row['telefono']}</td>
                             <td>{$row['correo']}</td>
                            <td>{$row['nombre_usuario']}</td>
                             <td>{$row['id_puesto']}</td>
                            <td class='acciones'>
                                <button class='btn-editar'><i class='fa-solid fa-pen-to-square'></i></button>
                                <button class='btn-eliminar' onclick='confirmarEliminacion({$row['id_empleado']})'>
    <i class='fa-solid fa-trash'></i>
</button>
                            
                                <button class='btn-contactar'><i class='fa-brands fa-whatsapp'></i></button>
                            </td>
                          </tr>";
                }
                ?>
               
            </tbody>
        </table>
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
    if (confirm("¿Estás seguro?")) {
        
        window.location.href = "../../app/views/eliminar_empleado.php?id=" + id;
    }
}
</script>