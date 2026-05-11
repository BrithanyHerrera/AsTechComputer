<?php
/**
 * PÁGINA: Bandeja de Mensajes de Contacto - As Tech Computer (contacto_crud_view.php)
 * PROPÓSITO: Administrar la comunicación recibida a través del formulario de contacto, 
 * permitiendo la lectura, respuesta y gestión de estados de los mensajes.
 * FUNCIONALIDADES:
 * - Visualización de Mensajes:
 * • Listado tabular de mensajes con truncado de texto para mejorar la legibilidad.
 * • Conversión y formateo de fechas de envío.
 * • Etiquetas visuales (Badges) para identificar estados: Nuevo, Pendiente, Respondido o Finalizado.
 * - Acciones de Comunicación:
 * • Función de envío de correo: Abre automáticamente Gmail con destinatario, asunto y 
 * cuerpo pre-redactado basado en el mensaje recibido.
 * - Gestión de Estados:
 * • Actualización de estado interactiva mediante modales de SweetAlert2 con selectores.
 * - Mantenimiento:
 * • Eliminación de mensajes con confirmación de seguridad vía SweetAlert2.
 * - Feedback al Usuario:
 * • Detección de parámetros de estado en la URL para mostrar alertas de éxito o error 
 * tras realizar acciones.
 */
?>

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
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while ($row = $resultado->fetch_assoc()): ?>

                <tr>
                    <td><?= $row['id_mensaje']; ?></td>

                    <td><strong><?= htmlspecialchars($row['nombre']); ?></strong></td>

                    <td><?= htmlspecialchars($row['correo']); ?></td>

                    <td><?= htmlspecialchars($row['asunto']); ?></td>

                    <td>
                        <div class="mensaje-contenedor"
                             title="<?= htmlspecialchars($row['mensaje']); ?>">
                            <?= htmlspecialchars($row['mensaje']); ?>
                        </div>
                    </td>

                    <td>
                        <?= date('d/m/Y', strtotime($row['fecha_envio'])); ?>
                    </td>

                    <td>
                        <span class="b status<?= $row['estado']; ?>">
                            <?php
                                $nombres_estado = [
                                    'nuevo' => 'Nuevo',
                                    'pendiente' => 'Pendiente de respuesta',
                                    'respondido' => 'Respondido',
                                    'finalizado' => 'Finalizado'
                                ];

                                echo $nombres_estado[$row['estado']] ?? $row['estado'];
                            ?>
                        </span>
                    </td>

                    <td class="acciones">
                        <button class="btn-mensaje"
                            onclick='enviarCorreo(<?= json_encode($row); ?>)'>
                            <i class="fa-solid fa-envelope"></i>
                        </button>

                        <button class="btn-eliminar"
                            onclick="confirmarEliminar(<?= $row['id_mensaje']; ?>)">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                        <button class="btn-editar"
                            onclick="cambiarEstado('<?= $row['id_mensaje']; ?>', '<?= $row['estado']; ?>')">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </td>
                </tr>

                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">
                        No hay mensajes recibidos.
                    </td>
                </tr>
            <?php endif; ?>
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

<script src="../../public/js/contacto_crud.js"></script>

<?php if (isset($_GET['status'])): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let status = "<?php echo $_GET['status']; ?>";
        
        if (status === "success") {
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "Operación realizada correctamente",
                confirmButtonColor: "#52073a"
            });
        } else if (status === "error") {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo completar la operación",
                confirmButtonColor: "#52073a"
            });
        }
        else if (status === "deleted") {
            Swal.fire({
                icon: "success",
                title: "Mensaje Eliminado!",
                text: "este mensaje a sido eliminado",
                confirmButtonColor: "#52073a"
            });
        }
    });
</script>

<?php endif; ?>