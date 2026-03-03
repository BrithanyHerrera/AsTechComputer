<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Integral de Equipo | As Tech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/registro_equipo.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
</head>
<body>
<?php include '../../toolbar.php'; ?>
<div class="contenedor-registro">
    <div class="encabezado-logo">
        <h1 class="titulo-pagina">ASTECH COMPUTER</h1>
        <div class="separador"></div>
        <p class="subtitulo">Mantenimiento integral</p>
    </div>

    <form action="../../app/controllers/procesar_registro.php" method="POST">
        
        <h3 class="seccion-titulo">I. Datos de Recepción</h3>
        
        <div class="fila-doble">
            <div class="grupo-entrada">
                <label class="etiqueta-formulario">Nombre del Cliente</label>
                <input type="text" name="nombre_cliente" class="campo-texto">
            </div>
            <div class="grupo-entrada">
                <label class="etiqueta-formulario">Apellido del Cliente</label>
                <input type="text" name="apellido_cliente" class="campo-texto">
            </div>
        </div>

        <div class="fila-doble">
            <div class="grupo-entrada">
                <label class="etiqueta-formulario">Contacto</label>
                <input type="text" name="contacto" class="campo-texto">
            </div>
            <div class="grupo-entrada">
                <label class="etiqueta-formulario">Fecha de Recepción</label>
                <input type="date" name="fecha_recepcion" class="campo-texto" required>
            </div>
        </div>

        <h3 class="seccion-titulo">II. Identificación del Equipo</h3>

        <div class="fila-doble">
            <div class="grupo-entrada">
                <label class="etiqueta-formulario">No. de Activo Fijo (AF°)</label>
                <input type="text" name="af_numero" class="campo-texto">
            </div>
            <div class="grupo-entrada">
                <label class="etiqueta-formulario">Password / PIN</label>
                <input type="text" name="password_equipo" class="campo-texto">
            </div>
        </div>

        <div class="grupo-entrada">
            <label class="etiqueta-formulario">Contenedor Padre</label>
            <input type="text" name="contenedor_padre" class="campo-texto">
        </div>

        <h3 class="seccion-titulo">III. Estado y Operación</h3>

        <div class="grupo-entrada">
            <label class="etiqueta-formulario">Diagnóstico inicial (Diag)</label>
            <textarea name="diagnostico" class="campo-texto" rows="3"></textarea>
        </div>

        <div class="grupo-entrada">
            <label class="etiqueta-formulario">Acción a realizar</label>
            <input type="text" name="accion_tecnica" class="campo-texto">
        </div>

        <div class="fila-doble">
            <div class="grupo-entrada">
                <label class="etiqueta-formulario">Anticipo ($)</label>
                <input type="number" name="anticipo" class="campo-texto" value="0">
            </div>
            <div class="grupo-entrada">
                <label class="etiqueta-formulario">Realizado por:</label>
                <input type="text" name="tecnico_responsable" class="campo-texto">
            </div>
        </div>

        <button type="submit" class="boton-enviar">FINALIZAR REGISTRO</button>
    </form>

    <footer>
        © 2024 As Tech Computer PV <br>
    </footer>
</div>

</body>
</html>