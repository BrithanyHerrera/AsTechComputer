<?php
// 
// include "../../config/conexion.php"; 
?>

<div class="contenedor-crud">
    <div class="encabezado-seccion">
        <button class="boton-primario" onclick="abrirFormulario()">
            <i class="fa-solid fa-plus"></i> Nuevo Servicio
        </button>
    </div>

    <div id="formulario-servicio" class="tarjeta-formulario" style="display: none;">
        <h3>Registrar / Editar Servicio</h3>
        <form action="procesar_servicio.php" method="POST">
            <div class="fila-input">
                <div class="grupo-input">
                    <label>Nombre del Servicio</label>
                    <input type="text" name="nombre" placeholder="Ej. Mantenimiento Preventivo" required>
                </div>
                <div class="grupo-input">
                    <label>Precio (MXN)</label>
                    <input type="number" name="precio" step="0.01" placeholder="0.00" required>
                </div>
            </div>
            <div class="grupo-input">
                <label>Descripción</label>
                <textarea name="descripcion" rows="3" placeholder="Describe brevemente el servicio..."></textarea>
            </div>
            <div class="botones-form">
                <button type="submit" class="boton-guardar">Guardar Servicio</button>
                <button type="button" class="boton-cancelar" onclick="cerrarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>

    <div class="tabla-responsiva">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Tipo de Servicio</th>
                    <th>Descripción</th>
                    <th>Tiempo estimado del servicio</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td><img src="../../public/img/manten.jpg" alt="AS TECH Admin" style="width:50px; height:50px;"></img></td>
                    <td><strong>Limpieza de Hardware</strong></td>
                    <td>Limpieza interna profunda y cambio de pasta térmica.</td>
                    <td>1 dia</td>
                    <td>$250.00</td>
                    <td><span class="etiqueta activo">Activo</span></td>
                    <td class="acciones">
                        <button class="btn-editar"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn-eliminar"><i class="fa-solid fa-trash"></i></button>
                        <button class="btn-mostrar"><i class="fa-solid fa-eye-slash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
function abrirFormulario() {
    document.getElementById('formulario-servicio').style.display = 'block';
}
function cerrarFormulario() {
    document.getElementById('formulario-servicio').style.display = 'none';
}
</script>