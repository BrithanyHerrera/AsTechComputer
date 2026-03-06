<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Servicio | As Tech Computer</title>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/cita_cliente.css">

</head>

<body>
    <?php include '../../toolbar.php'; ?>

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
                    <select name="tipo_dispositivo" class="control" onchange="toggleOtro(this, 'otro_tipo_box')"
                        required>
                        <option value="">Selecciona...</option>
                        <option value="Laptop">Laptop</option>
                        <option value="PC">PC de Escritorio</option>
                        <option value="Consola">Consola de Videojuegos</option>
                        <option value="Otro">Otro...</option>
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
                        <option value="Dell">Dell</option>
                        <option value="HP">HP</option>
                        <option value="Lenovo">Lenovo</option>
                        <option value="Acer">Acer</option>
                        <option value="Asus">Asus</option>
                        <option value="Otro">Otra marca...</option>
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
                <select name="problema_lista" class="control" onchange="toggleOtro(this, 'otro_problema_box')" required>
                    <option value="">¿Cuál es el fallo principal?</option>
                    <option value="mantenimiento">Mantenimiento preventivo (Limpieza)</option>
                    <option value="lento">Equipo lento / Se traba</option>
                    <option value="pantalla">Pantalla rota o dañada</option>
                    <option value="virus">Eliminación de Virus / Software</option>
                    <option value="bisagras">Reparación de bisagras</option>
                    <option value="Otro">Otro problema...</option>
                </select>
                <div id="otro_problema_box" class="campo-otro">
                    <textarea name="problema_detalle" class="control" rows="3"
                        placeholder="Describe brevemente el fallo que presenta tu equipo"></textarea>
                </div>
            </div>

            <div class="fila-doble">
                <div class="grupo-campo">
                    <label>Fecha Sugerida</label>
                    <input type="date" name="fecha_cita" class="control" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="grupo-campo">
                    <label>Hora (Abierto 10:00 - 16:00)</label>
                    <input type="time" name="hora_cita" class="control" required min="10:00" max="16:00">
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

                    <button onclick="cerrarYEnviar()" class="boton-agendar">Entendido</button>
                </div>
            </div>

            <button type="submit" class="boton-agendar">Confirmar Solicitud</button>
        </form>
    </div>

    <script src="../../public/js/cita_cliente.js"></script>

</body>

</html>