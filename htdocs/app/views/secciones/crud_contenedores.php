<?php
require_once __DIR__ . "/../../controllers/contenedor_controller.php";
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

<form action="../controllers/contenedor_controller.php?accion=agregar" method="POST">

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
<th>Acciones</th>
</tr>
</thead>
<tbody>
                    <tr>
                <?php
                while ($row = $resultado->fetch_assoc()) {
                    $estado = $row['estado'];
                    $folio_mostrar = !empty($row['folio']) ? $row['folio'] : 'N/A';
                    $tipo_limpio = ucfirst(str_replace('_', ' ', $row['tipo_espacio']));

                    echo "<tr>
                            <td><strong>{$row['id_gabinete']}</strong></td>
                            <td>{$tipo_limpio}</td>
                            <td><strong>{$folio_mostrar}</strong></td>
                            <td>
                                <span class='b status-{$estado}'>
                                    " . ucfirst($estado) . "
                                </span>
                            </td>
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
        <form action="../controllers/contenedor_controller.php?accion=editar" method="POST" id="form-editar">
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
                <label>Folio Asociado:</label>
                <input type="text" id="edit-folio" readonly style="background-color: #f4f4f4; color: #666;">
                <p style="font-size: 0.8em; color: #888; margin-top: 5px; margin-bottom: 0;">* El folio se gestiona automáticamente desde la sección de Ingresos.</p>
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
<script src="../../public/js/contenedor_crud.js"></script>