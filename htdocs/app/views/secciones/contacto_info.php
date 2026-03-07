<?php
// 
// include "../../config/conexion.php"; 
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
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td><strong>Joceline Noemi</strong></td>
                    <td>joceline@gmail.com</td>
                    <td>Hola mi compu no prende</td>
                    <td>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</td>
                    <td><span class="etiqueta activo">Activo</span></td>
                    <td class="acciones">
                   <button class="btn-mensaje"><i class="fa-solid fa-envelope"></i></button>
                        <button class="btn-eliminar"><i class="fa-solid fa-trash"></i></button>
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