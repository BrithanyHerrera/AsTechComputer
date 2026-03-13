<?php
// 1. CONEXIÓN A LA BASE DE DATOS
// Ruta corregida apuntando a la carpeta config
require_once '../config/conexion.db.php';

// 2. CONSULTAS PARA LLENAR LOS CATÁLOGOS AUTOMÁTICAMENTE
// Traemos todos los equipos excepto el ID 7 (Otro), ordenados alfabéticamente
$query_tipos = $conexion->query("SELECT id_tipo_equipo, tipo FROM tipos_equipo WHERE id_tipo_equipo != 7 ORDER BY tipo ASC");

// Traemos todas las marcas excepto el ID 12 (Otro), ordenadas alfabéticamente
$query_marcas = $conexion->query("SELECT id_marca, marca FROM marcas WHERE id_marca != 12 ORDER BY marca ASC");

// 3. TRAER LAS RELACIONES PARA LOS SELECTS ANIDADOS
$query_relaciones = $conexion->query("SELECT id_tipo_equipo, id_marca FROM relacion_equipo_marca");
$relaciones = [];
if ($query_relaciones) {
    while ($row = $query_relaciones->fetch_assoc()) {
        $relaciones[$row['id_tipo_equipo']][] = $row['id_marca'];
    }
}
$json_relaciones = json_encode($relaciones);

// =======================================================
// 4. NUEVO: TRAER LAS CITAS OCUPADAS PARA BLOQUEAR HORARIOS
// =======================================================
$query_ocupadas = $conexion->query("SELECT fecha_cita, hora_cita FROM citas_web WHERE fecha_cita >= CURDATE()");
$citas_ocupadas = [];
if ($query_ocupadas) {
    while ($row = $query_ocupadas->fetch_assoc()) {
        // Cortamos los segundos (de "10:20:00" a "10:20") para que coincida con JS
        $hora_corta = substr($row['hora_cita'], 0, 5);
        $citas_ocupadas[$row['fecha_cita']][] = $hora_corta;
    }
}
$json_ocupadas = json_encode($citas_ocupadas);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Servicio | As Tech Computer</title>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="../../public/img/Astech ICO.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/cita_cliente.css">

    <script>
        const relacionesEquipoMarca = <?php echo $json_relaciones; ?>;
        const citasOcupadas = <?php echo $json_ocupadas; ?>;
    </script>
</head>

<body>
    <?php $ruta_prefijo = "../../";
    include "../../toolbar.php"; ?>

    <div class="contenedor-cita">
        <div class="encabezado">
            <h1 class="titulo-seccion">Agendar mi Servicio</h1>
            <div class="separador"></div>
        </div>

        <div class="alerta-restriccion">
            <i class="fas fa-exclamation-circle"></i>
            <span><strong>Aviso importante:</strong> Por normatividad técnica, no recibimos equipos de la marca
                <strong>Apple (MacBook, iMac, etc.)</strong>.</span>
        </div>

        <form action="procesar_cita.php" method="POST">

            <div class="fila-doble">
                <div class="grupo-campo">
                    <label>Nombre(s)</label>
                    <input type="text" name="nombre_cliente" class="control" required>
                </div>
                <div class="grupo-campo">
                    <label>Apellido(s)</label>
                    <input type="text" name="apellido_cliente" class="control" required>
                </div>
            </div>

            <div class="grupo-campo">
                <label>WhatsApp de Contacto (Número de Teléfono)</label>
                <input type="tel" name="whatsapp" class="control" required>
            </div>

            <div class="fila-doble">
                <div class="grupo-campo">
                    <label>Tipo de Dispositivo</label>
                    <select name="tipo_dispositivo" class="control" id="selector_tipo"
                        onchange="toggleOtro(this, 'otro_tipo_box')" required>
                        <option value="">Selecciona...</option>
                        <?php
                        // CICLO PARA DIBUJAR LOS EQUIPOS DESDE LA BASE DE DATOS
                        if ($query_tipos && $query_tipos->num_rows > 0) {
                            while ($fila = $query_tipos->fetch_assoc()) {
                                echo '<option value="' . $fila['id_tipo_equipo'] . '">' . htmlspecialchars($fila['tipo']) . '</option>';
                            }
                        }
                        ?>
                        <option value="7">Otro...</option>
                    </select>
                    <div id="otro_tipo_box" class="campo-otro">
                        <input type="text" name="otro_tipo_texto" class="control" placeholder="¿Qué equipo es?">
                    </div>
                </div>

                <div class="grupo-campo">
                    <label>Marca (No Apple)</label>
                    <select name="marca" class="control" id="selector_marca"
                        onchange="toggleOtro(this, 'otra_marca_box')" required>
                        <option value="">Selecciona...</option>
                        <?php
                        // CICLO PARA DIBUJAR LAS MARCAS DESDE LA BASE DE DATOS
                        if ($query_marcas && $query_marcas->num_rows > 0) {
                            while ($fila = $query_marcas->fetch_assoc()) {
                                echo '<option value="' . $fila['id_marca'] . '">' . htmlspecialchars($fila['marca']) . '</option>';
                            }
                        }
                        ?>
                        <option value="12">Otra marca...</option>
                    </select>
                    <div id="otra_marca_box" class="campo-otro">
                        <input type="text" name="otra_marca_texto" class="control" placeholder="Escribe la marca">
                    </div>
                </div>
            </div>

            <div class="fila-doble">
                <div class="grupo-campo">
                    <label>Modelo</label>
                    <input type="text" name="modelo" class="control" required>
                </div>
                <div class="grupo-campo">
                    <label>
                        No. Serie (Opcional)
                        <span class="ayuda-serie" tabindex="0" title="Click para ayuda">?</span>
                    </label>
                    <input type="text" name="numero_serie" class="control">
                </div>
            </div>

            <div class="grupo-campo">
                <label>Problema o Falla</label>
                <p class="nota-formulario">Puedes seleccionar una opción rápida y/o detallar el problema abajo.</p>

                <select name="problema_lista" class="control" style="margin-bottom: 10px;">
                    <option value="">Opciones rápidas...</option>
                    <option value="mantenimiento">Mantenimiento preventivo (Limpieza)</option>
                    <option value="lento">Equipo lento / Se traba</option>
                    <option value="pantalla">Pantalla rota o dañada</option>
                    <option value="virus">Eliminación de Virus / Software</option>
                    <option value="bisagras">Reparación de bisagras</option>
                </select>

                <div id="detalle_falla_box">
                    <label> Descripción de detalles: </label>
                    <input type="text" name="problema_detalle" class="control" rows="3" placeholder="(Marcas, ruidos, errores, etc.)">
                </div>
            </div>

            <div class="fila-doble">
                <div class="grupo-campo">
                    <label>Fecha Sugerida</label>
                    <input type="date" name="fecha_cita" id="fecha_cita" class="control" required
                        min="<?php echo date('Y-m-d'); ?>" onchange="actualizarHorarios()">
                </div>
                <div class="grupo-campo">
                    <label>Hora (Intervalos 20 min)</label>
                    <select name="hora_cita" id="selector_hora" class="control" required>
                        <option value="">Selecciona una fecha primero...</option>
                    </select>
                </div>
            </div>

            <div id="modalConfirmacion" class="modal-confirm">
                <div class="modal-contenido">
                    <div class="modal-icono">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2>¡Solicitud Recibida!</h2>
                    <div class="separador"></div>
                    <p>Estamos procesando tu cita en nuestro calendario oficial.</p>

                    <div class="resumen-cita">
                        <p><strong>Cliente:</strong> <span id="res-nombre"></span></p>
                        <p><strong>Equipo:</strong> <span id="res-equipo"></span></p>
                        <p><strong>Fecha:</strong> <span id="res-fecha"></span> a las <span id="res-hora"></span></p>
                    </div>

                    <p class="nota-espera">En breve recibirás un mensaje de confirmación por WhatsApp.</p>

                    <button type="button" onclick="cerrarYEnviar()" class="boton-agendar">Entendido</button>
                </div>
            </div>

            <button type="submit" class="boton-agendar">Confirmar Solicitud</button>
        </form>
    </div>

    <script src="../../public/js/cita_cliente.js"></script>

</body>

</html>