<?php
require_once __DIR__ . "/../../controllers/empleado_controller.php";
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <form action="../controllers/empleado_controller.php?accion=agregar" method="POST" onsubmit="confirmarAccion(event, this, '¿Estás seguro de registrar a este nuevo empleado?')">
                
                <div class="grupo-input">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" placeholder="Ej. Carlos" required
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                           title="Solo se permiten letras y espacios." 
                           oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                </div>
                
                <div class="grupo-input">
                    <label>Apellido:</label>
                    <input type="text" name="apellido" placeholder="Ej. Martinez" required
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                           title="Solo se permiten letras y espacios." 
                           oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                </div>
                
                <div class="grupo-input">
                    <label>Teléfono:</label>
                    <input type="tel" name="telefono" placeholder="3221234567" required
                           pattern="[0-9]{10}" maxlength="10" 
                           title="Debe contener exactamente 10 números."
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                
                <div class="grupo-input">
                    <label>Correo electrónico:</label>
                    <input type="email" name="correo" placeholder="carlos@astech.com" required
                           pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                           oninput="this.value = this.value.replace(/\s/g, '')" 
                           title="Ingresa un correo válido con dominio (ejemplo: usuario@dominio.com)">
                </div>
                
                <div class="grupo-input">
                    <label>Nombre Usuario:</label>
                    <input type="text" name="nombre_usuario" placeholder="carlos-01" required
                           pattern="[a-zA-Z0-9\-_]+" 
                           title="Solo letras, números, guiones y guiones bajos. Sin espacios."
                           oninput="this.value = this.value.replace(/[^a-zA-Z0-9\-_]/g, '')">
                </div>
                
                <div class="grupo-input">
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" placeholder="***********" required minlength="8">
                </div>
                
                <div class="grupo-input">
                    <label>Puesto:</label>
                    <select name="id_puesto" required>
                        <?php foreach ($puestos as $fila): ?>
                            <option value="<?= $fila['id_puesto'] ?>"><?= $fila['nombre_puesto'] ?></option>
                        <?php endforeach; ?>
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
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_empleado'] ?></td>
                        <td><strong><?= $row['nombre'] ?></strong></td>
                        <td><?= $row['apellido'] ?></td>
                        <td><?= $row['telefono'] ?></td>
                        <td><?= $row['correo'] ?></td>
                        <td><?= $row['nombre_usuario'] ?></td>
                        <td><?= $row['nombre_puesto'] ?></td>
                        <td class='acciones'>
                            <button class='btn-editar' onclick='abrirEditar(<?= json_encode($row) ?>)'><i class='fa-solid fa-pen-to-square'></i></button>
                            <button class='btn-eliminar' onclick='confirmarEliminacion(<?= $row['id_empleado'] ?>)'><i class='fa-solid fa-trash'></i></button>
                            <button class='btn-contactar'><i class='fa-brands fa-whatsapp'></i></button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal-editar-empleado" class="modal-formulario" style="display: none;">
    <div class="contenido-modal modal-purpura">
        <span class="cerrar" onclick="cerrarModalEditar()">&times;</span>
        <h3><i class="fa-solid fa-user-pen"></i> Editar Empleado</h3>

        <form action="../controllers/empleado_controller.php?accion=editar" method="POST" id="form-editar" onsubmit="confirmarAccion(event, this, '¿Estás seguro de guardar los cambios de este empleado?')">
            <input type="hidden" name="id_empleado" id="edit-id">

            <div class="grupo-input">
                <label>Nombre:</label>
                <input type="text" name="nombre" id="edit-nombre" required
                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                       title="Solo se permiten letras y espacios."
                       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
            </div>
            
            <div class="grupo-input">
                <label>Apellido:</label>
                <input type="text" name="apellido" id="edit-apellido" required
                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                       title="Solo se permiten letras y espacios."
                       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
            </div>
            
            <div class="grupo-input">
                <label>Teléfono:</label>
                <input type="tel" name="telefono" id="edit-telefono" required
                       pattern="[0-9]{10}" maxlength="10" 
                       title="Debe contener exactamente 10 números."
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
            
            <div class="grupo-input">
                <label>Correo electrónico:</label>
                <input type="email" name="correo" id="edit-correo" required
                       pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                       oninput="this.value = this.value.replace(/\s/g, '')"
                       title="Ingresa un correo válido con dominio (ejemplo: usuario@dominio.com)">
            </div>
            
            <div class="grupo-input">
                <label>Nombre Usuario:</label>
                <input type="text" name="nombre_usuario" id="edit-usuario" required
                       pattern="[a-zA-Z0-9\-_]+" 
                       title="Solo letras, números, guiones y guiones bajos. Sin espacios."
                       oninput="this.value = this.value.replace(/[^a-zA-Z0-9\-_]/g, '')">
            </div>
            
            <div class="grupo-input">
                <label>Puesto:</label>
                <select name="id_puesto" id="edit-puesto" required>
                    <?php foreach ($puestos as $fila): ?>
                        <option value="<?= $fila['id_puesto'] ?>"><?= $fila['nombre_puesto'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (isset($_SESSION['id_puesto']) && $_SESSION['id_puesto'] == 4): ?>
                <div class="grupo-input"
                    style="background: #fdf2f8; padding: 10px; border-radius: 5px; border-left: 4px solid #8e44ad; margin-top: 15px;">
                    <label style="color: #4a148c; font-weight: bold;"><i class="fa-solid fa-shield-halved"></i> Cambio de
                        Contraseña (Solo Admin)</label>
                    <input type="password" name="contrasena" placeholder="Deja en blanco para no modificar" minlength="8">
                </div>
            <?php endif; ?>

            <div class="botones-form" style="margin-top: 20px;">
                <button type="submit" class="btn-actualizar">Actualizar Cambios</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModalEditar()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<style>
    .swal2-container {
        z-index: 999999 !important;
    }
</style>

<script src="../../public/js/empleado_crud.js"></script>