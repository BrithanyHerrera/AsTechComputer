<?php
// 
// include "../../config/conexion.php"; 
?>

<div class="contenedor-crud">
    <div class="encabezado-seccion">
        

    <div class="tabla-responsiva">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Contacto</th>
                    <th>Dispisitivo</th>
                    <th>Modelo</th>
                    <th>Falla</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td><strong>Joceline</strong></td>
                     <td>De la torre</td>
                    <td>3317018100</td>
                    <td>Laptop</td>
                    <td>XPG Xenia</td>
                    <td>Pantalla no funciona</td>
                    <td>06/03/26</td>
                    <td><span class="etiqueta activo">Activo</span></td>
                    <td class="acciones">
                        <button class="btn-editar"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn-eliminar"><i class="fa-solid fa-trash"></i></button>
                         <button class="btn-contactar"><i class="fa-brands fa-whatsapp"></i></button>
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