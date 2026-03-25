<?php

include __DIR__ . "/../../config/conexion.db.php"; 


$query = "SELECT * FROM mensajes_contacto ORDER BY fecha_envio DESC";
$resultado = $conexion->query($query);
?>

<div class="contenedor-crud">
    <div class="tabla-responsiva">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id_mensaje']; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['correo']); ?></td>
                            <td><?php echo htmlspecialchars($row['asunto']); ?></td>
                            <td>
                                <div style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($row['mensaje']); ?>">
                                    <?php echo htmlspecialchars($row['mensaje']); ?>
                                </div>
                            </td>
                      
                            <td>
                                
                                    <?php echo date('d/m/Y', strtotime($row['fecha_envio'])); ?>

                            </td>
                            <td><span class="badge status-<?php echo $row['estado']; ?>">
        <?php 
            // Mapeo de nombres para mostrar texto bonito
            $nombres_estado = [
                'nuevo' => 'Nuevo',
                'pendiente' => 'Pendiente de respuesta',
                'respondido' => 'Respondido',
                'finalizado' => 'Finalizado'
            ];
            echo $nombres_estado[$row['estado']];
        ?>
    </span></td>
                            <td class="acciones">
                                <button class="btn-mensaje" onclick="enviarCorreo(<?php echo htmlspecialchars(json_encode($row)); ?>)">
    <i class="fa-solid fa-envelope"></i>
</button>
                                <button class="btn-eliminar" onclick="confirmarEliminarMensaje(<?php echo $row['id_mensaje']; ?>)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                 <button class="btn-editar" onclick="cambiarEstado('<?php echo $row['id_mensaje']; ?>', '<?php echo $row['estado']; ?>')" title="Cambiar Estado">
    <i class="fa-solid fa-arrows-rotate"></i>
</button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center;'>No hay mensajes recibidos.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<div id="modal-editar-estado" class="modal-formulario" style="display: none;">
    <div class="contenido-modal">
        <span class="cerrar" onclick="cerrarModalEstado()">&times;</span>
        <h3><i class="fa-solid fa-arrows-rotate"></i> Actualizar Estado</h3>
        
        <form action="../views/acciones/actualizar_estado.php" method="POST">
            <input type="hidden" name="id_mensaje" id="edit-mensaje-id"></input>
            
            <div class="grupo-input">
                <label>Seleccionar nuevo estado:</label>
                <select name="estado" id="edit-mensaje-estado" required>
                    <option value="nuevo">Nuevo</option>
                    <option value="pendiente">Pendiente de respuesta</option>
                    <option value="respondido">Respondido</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </div>

            <div class="botones-form">
                <button type="submit" class="btn-actualizar">Guardar Cambios</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModalEstado()">Cancelar</button>
            </div>
        </form>
    </div>
</div> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Función para ver el mensaje completo
function verMensaje(datos) {
    Swal.fire({
        title: 'Asunto: ' + datos.asunto,
        html: `
            <div style="text-align: left;">
                <p><strong>De:</strong> ${datos.nombre} (${datos.correo})</p>
                <p><strong>Mensaje:</strong></p>
                <p style="background: #f9f9f9; padding: 10px; border-radius: 5px;">${datos.mensaje}</p>
            </div>
        `,
        confirmButtonColor: '#52073a'
    });
}
function enviarCorreo(datos) {

    const correo = datos.correo;
    const asunto = "Respuesta a tu mensaje: " + datos.asunto;

    const mensaje = `Hola ${datos.nombre},

Gracias por contactarnos.

Respecto a tu mensaje:
"${datos.mensaje}"

Aquí puedes escribir tu respuesta...

Saludos.`;

    // Codificar para URL
    const url = `https://mail.google.com/mail/?view=cm&to=${encodeURIComponent(correo)}&su=${encodeURIComponent(asunto)}&body=${encodeURIComponent(mensaje)}`;

    // Abrir en nueva pestaña
    window.open(url, '_blank');
}
// Función para confirmar eliminación
function confirmarEliminarMensaje(id) {
    Swal.fire({
        title: '¿Eliminar mensaje?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../views/acciones/eliminar_mensaje.php?id=" + id;
        }
    });
}


function cambiarEstado(id, estadoActual) {
    if (typeof Swal === 'undefined') {
        console.error("SweetAlert2 no está cargado");
        return;
    }

    Swal.fire({
        title: 'Actualizar Estado del Mensaje',
        icon: 'info',
        html: `
            <select id="nuevo-estado-select" class="swal2-input" style="width: 80%;">
                <option value="nuevo" ${estadoActual === 'nuevo' ? 'selected' : ''}>Nuevo</option>
                <option value="pendiente" ${estadoActual === 'pendiente' ? 'selected' : ''}>Pendiente de respuesta</option>
                <option value="respondido" ${estadoActual === 'respondido' ? 'selected' : ''}>Respondido</option>
                <option value="finalizado" ${estadoActual === 'finalizado' ? 'selected' : ''}>Finalizado</option>
            </select>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar Cambios',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#52073a',
        preConfirm: () => {
            const select = document.getElementById('nuevo-estado-select');
            return select.value;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const nuevoEstado = result.value;
            // Redirección al proceso PHP
window.location.href = `../controllers/mensaje_controller.php?id=${id}&estado=${nuevoEstado}`;        }
    });


}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_GET['status'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let status = "<?php echo $_GET['status']; ?>";

    if (status === "success") {
        Swal.fire({
            icon: "success",
            title: "¡Éxito!",
            text: "El estado del mensaje se actualizó correctamente",
            confirmButtonColor: "#6a0dad"
        });
    } else if (status === "error") {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo actualizar el estado",
            confirmButtonColor: "#6a0dad"
        });
    }
});
</script>
<?php endif; ?>