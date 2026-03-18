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
            <i class="fa-solid fa-plus"></i> Nuevo contenedor
        </button>
    </div>
    <div id="formulario-gabinete" class="modal-formulario" style="display: none;">
        <div class="contenido-modal">
            <span class="cerrar" onclick="cerrarFormulario()">&times;</span>
            <h3>Registrar Nuevo Gabinete</h3>

<form action="../views/acciones/agregar_gabinete.php" method="POST">

<div class="grupo-input">
<label>ID Gabinete:</label>
<input type="text" name="id_gabinete" required placeholder="Ej. G01">
</div>

<div class="grupo-input">
<label>Tipo de espacio:</label>
<select name="tipo_espacio" required>
<option value="laptop">Laptop</option>
<option value="computadora_escritorio">Computadora de escritorio</option>
<option value="otro">Otro</option>
</select>
</div>

<div class="grupo-input">
<label>Estado:</label>
<select name="estado">
<option value="disponible">Disponible</option>
<option value="ocupado">Ocupado</option>
<option value="clausurado">Clausurado</option>
</select>
</div>

<div class="botones-form">
<button type="submit" class="btn-guardar">Guardar Gabinete</button>
<button type="button" class="btn-cancelar" onclick="cerrarFormulario()">Cancelar</button>
</div>

</form>
        </div>
    </div>
    <div class="tabla-responsiva">
        <table>
           <thead>
<tr>
<th>ID Gabinete</th>
<th>Tipo espacio</th>
<th>Folio</th>
<th>Estado</th>
</tr>
</thead>
<tbody>
                    <tr>
                <?php
              $resultado = $conexion->query("SELECT * FROM gabinetes");

while ($row = $resultado->fetch_assoc()) {
$estado = $row['estado'];

echo "<tr>
<td>{$row['id_gabinete']}</td>
<td>{$row['tipo_espacio']}</td>
<td>{$row['folio']}</td>
<td><span class='badge status-{$estado}'>
            " . ucfirst($estado) . "
        </span></td>
 <td class='acciones'>
                                  <button class='btn-editar' onclick='abrirEditar(".json_encode($row).")'>
    <i class='fa-solid fa-pen-to-square'></i>
</button>
<button class='btn-eliminar' onclick=\"confirmarEliminacion('{$row['id_gabinete']}')\">
    <i class='fa-solid fa-trash'></i>
</button>
                           
</td>
</tr>";

}
?>
               
            </tbody>
        </table>
    </div>
</div>
<div id="modal-editar-gabinete" class="modal-formulario" style="display: none;">
    <div class="contenido-modal modal-purpura">
        <span class="cerrar" onclick="cerrarModalEditar()">&times;</span>
        <h3><i class="fa-solid fa-box-open"></i> Editar Gabinete</h3>
        <form action="../views/acciones/editar_contenedor.php" method="POST" id="form-editar">
            <input type="hidden" name="id_gabinete" id="edit-id">
            <div class="grupo-input">
                <label>ID Gabinete (Lectura):</label>
                <input type="text" id="display-id" disabled>
            </div>
            <div class="grupo-input">
                <label>Tipo de espacio:</label>
                <select name="tipo_espacio" id="edit-tipo" required>
                    <option value="laptop">Laptop</option>
                    <option value="computadora_escritorio">Computadora de escritorio</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="grupo-input">
                <label>Folio Asociado (Opcional):</label>
                <input type="text" name="folio" id="edit-folio" placeholder="Número de folio">
            </div>
            <div class="grupo-input">
                <label>Estado:</label>
                <select name="estado" id="edit-estado" required>
                    <option value="disponible">Disponible</option>
                    <option value="ocupado">Ocupado</option>
                    <option value="clausurado">Clausurado</option>
                </select>
            </div>
            <div class="botones-form">
                <button type="submit" class="btn-actualizar">Actualizar Cambios</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModalEditar()">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function abrirFormulario() {
    document.getElementById('formulario-gabinete').style.display = 'flex';
}
function cerrarFormulario() {
    document.getElementById('formulario-gabinete').style.display = 'none';
}
// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    if (event.target == document.getElementById('formulario-gabinete')) {
        cerrarFormulario();
    }
}
function confirmarEliminacion(id) {
    if (confirm("¿Estás seguro?")) {
        
        window.location.href = "../../app/views/acciones/eliminar_contenedor.php?id=" + id;
    }}
// --- FUNCIONES PARA EDITAR ---
function abrirEditar(datos) {
 
    document.getElementById('edit-id').value = datos.id_gabinete;
    document.getElementById('display-id').value = datos.id_gabinete;
    document.getElementById('edit-tipo').value = datos.tipo_espacio;
    document.getElementById('edit-folio').value = datos.folio ? datos.folio : "";
    document.getElementById('edit-estado').value = datos.estado;


    document.getElementById('modal-editar-gabinete').style.display = 'flex';
}
function cerrarModalEditar() {
    document.getElementById('modal-editar-gabinete').style.display = 'none';
}

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará el gabinete " + id,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#52073a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../views/acciones/eliminar_contenedor.php?id=" + id;
        }
    })
}

// Cerrar modales al hacer clic fuera
window.onclick = function(event) {
    if (event.target.className === 'modal-formulario') {
        cerrarFormulario();
        cerrarModalEditar();
    }
}

// --- ALERTAS SWEETALERT ---
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const seccion = urlParams.get('seccion');

    // Solo mostrar si estamos en la sección de contenedor
    if (seccion === 'contenedor' || !seccion) {
        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Operación Exitosa!',
                text: 'Los cambios se han guardado correctamente.',
                confirmButtonColor: '#52073a'
            });
        } 
        else if (status === 'duplicate') {
            Swal.fire({
                icon: 'error',
                title: 'Dato Duplicado',
                text: 'Ese gabinete ya existe o el folio está ocupado.',
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
    }
});

    window.history.replaceState({}, document.title, window.location.pathname + (seccion ? "?seccion=" + seccion : ""));




</script>