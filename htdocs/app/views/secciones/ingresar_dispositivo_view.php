<?php
// =============================================================
// ingresar_dispositivo_view.php — La Vista
// Solo dibuja el HTML. Todas las variables que necesita
// vienen ya preparadas por el controlador.
// =============================================================
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/ingreso.css">
  <link rel="stylesheet" href="../../public/css/toolbar.css">
  <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <div class="contenedorPorPasos">
    <div class="pasos">
      <div class="paso <?php if ($paso == 1) echo 'active'; ?>">
        <div class="icono-paso">1</div>
        <div class="etiqueta-paso">Datos del Cliente</div>
      </div>
      <div class="step-line"></div>
      <div class="paso <?php if ($paso == 2) echo 'active'; ?>">
        <div class="icono-paso">2</div>
        <div class="etiqueta-paso">Revisión</div>
      </div>
      <div class="step-line"></div>
      <div class="paso <?php if ($paso == 3) echo 'active'; ?>">
        <div class="icono-paso">3</div>
        <div class="etiqueta-paso">Condiciones y preguntas</div>
      </div>
      <div class="step-line"></div>
      <div class="paso <?php if ($paso == 4) echo 'active'; ?>">
        <div class="icono-paso">4</div>
        <div class="etiqueta-paso">Análisis de mercado</div>
      </div>
      <div class="step-line"></div>
      <div class="paso <?php if ($paso == 5) echo 'active'; ?>">
        <div class="icono-paso">5</div>
        <div class="etiqueta-paso">Información esencial del equipo</div>
      </div>
    </div>
  </div>

  <div class="formulario">
    <form method="POST" action="">
      <?php if ($paso == 1): ?>

        <div class="formulario">
          <?php if(isset($_SESSION['modo_edicion'])): ?>
            <div style="background:#e0e7ff; color:#3730a3; padding:10px; text-align:center; font-weight:bold; margin-bottom:15px; border-radius:8px; border:2px dashed #818cf8;">
              <i class="fa-solid fa-pen-to-square"></i> MODO EDICIÓN ACTIVO: Folio <?php echo $_SESSION['modo_edicion']; ?>
            </div>
          <?php endif; ?>

        <h1>Datos del cliente</h1>
        <div class="grupo-entrada" style="background: #eef2ff; border: 1px solid #c7d2fe; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
          <label class="etiqueta-formulario" style="color: #4f46e5; font-weight: bold;">
            <i class="fas fa-calendar-check"></i> ¿El cliente tiene cita previa?
          </label>
          <select id="importar_cita" name="id_cita_importada" class="campo-texto" style="border-color: #a5b4fc; cursor: pointer;">
            <option value="">No, es un cliente sin cita (Llenado manual)</option>
            <?php foreach ($citas_agendadas as $cita): ?>
              <?php
                $fecha_formt = date("d/m/Y", strtotime($cita['fecha_cita']));
                $hora_formt  = date("H:i",   strtotime($cita['hora_cita']));
              ?>
              <option value="<?php echo $cita['id_cita']; ?>">
                <?php echo htmlspecialchars($cita['nombre_cliente'] . ' ' . $cita['apellido_cliente']); ?> - <?php echo $fecha_formt; ?> a las <?php echo $hora_formt; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="fila-doble">
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Nombre</label>
            <input type="text" name="nombre_cliente" class="campo-texto" value="<?php echo $_SESSION['memoria_ingreso']['nombre_cliente'] ?? ''; ?>" required>
          </div>
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Apellido</label>
            <input type="text" name="apellido_cliente" class="campo-texto" value="<?php echo $_SESSION['memoria_ingreso']['apellido_cliente'] ?? ''; ?>" required>
          </div>
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Número de telefono</label>
            <div class="input-icon-wrapper">
              <i class="fas fa-phone"></i>
              <input type="tel" name="telefono_cliente" class="campo-texto" value="<?php echo $_SESSION['memoria_ingreso']['telefono_cliente'] ?? ''; ?>" required>
            </div>
          </div>
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Correo</label>
            <div class="input-icon-wrapper">
              <i class="fas fa-envelope"></i>
              <input type="email" name="correo_cliente" class="campo-texto" value="<?php echo $_SESSION['memoria_ingreso']['correo_cliente'] ?? ''; ?>" required>
            </div>
          </div>
        </div>
        <button type="submit" class="boton-siguiente" name="step" value="2">Siguiente <i class="fa-solid fa-angle-right"></i></button>
        </div>

      <?php elseif ($paso == 2): ?>
        <h1>Revisión física y control interno</h1>

        <?php if (isset($_SESSION['error_espacio'])): ?>
          <div class="mensaje-error" style="background:#fee2e2;border:1px solid #f87171;color:#b91c1c;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.9rem;">
            <i class="fas fa-triangle-exclamation"></i>
            <?php echo $_SESSION['error_espacio']; unset($_SESSION['error_espacio']); ?>
          </div>
        <?php endif; ?>

        <div class="fila-doble" style="max-height: none; grid-template-columns: 1fr 1fr;">
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Fecha de ingreso</label>
            <p class="nota-formulario">Fecha en la que se entregó el dispositivo</p>
            <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="campo-texto" value="<?php echo $_SESSION['memoria_ingreso']['fecha_ingreso'] ?? date('Y-m-d'); ?>" required>
          </div>

          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Tipo para Almacenaje</label>
            <p class="nota-formulario">Define si usará nomenclatura numérica o de letras</p>
            <select name="tipo_almacenamiento" id="tipo_almacenamiento" class="campo-texto" required>
              <option value="">Seleccione tipo...</option>
              <option value="laptop" <?php echo (isset($_SESSION['memoria_ingreso']['tipo_almacenamiento']) && $_SESSION['memoria_ingreso']['tipo_almacenamiento'] == 'laptop') ? 'selected' : ''; ?>>Laptop (Numéricos)</option>
              <option value="computadora_escritorio" <?php echo (isset($_SESSION['memoria_ingreso']['tipo_almacenamiento']) && $_SESSION['memoria_ingreso']['tipo_almacenamiento'] == 'computadora_escritorio') ? 'selected' : ''; ?>>PC de Escritorio (Letras)</option>
              <option value="otro" <?php echo (isset($_SESSION['memoria_ingreso']['tipo_almacenamiento']) && $_SESSION['memoria_ingreso']['tipo_almacenamiento'] == 'otro') ? 'selected' : ''; ?>>Consola (Letras)</option>
            </select>
          </div>

          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Espacio disponible</label>
            <p class="nota-formulario">Lugar físico donde se guardará el equipo</p>
            <select name="espacio_almacenamiento" id="espacio_almacenamiento" class="campo-texto" required>
              <option value="">Primero elija tipo...</option>
            </select>
          </div>

          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Folio</label>
            <p class="nota-formulario">Formato: DDMMAAAA-Espacio</p>
            <input type="text" name="folio" id="folio_auto" class="campo-texto" value="<?php echo $_SESSION['memoria_ingreso']['folio'] ?? ''; ?>" readonly required>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Condición física al ingreso</label>
          <p class="nota-formulario">Condición (problemas) que presentaba el dispositivo al ser entregado</p>
          <div class="plano-checkboxs">
            <label class="check-item"><input type="checkbox" name="condicion[]" value="enciende" <?php echo (isset($_SESSION['memoria_ingreso']['condicion']) && in_array('enciende', (array)$_SESSION['memoria_ingreso']['condicion'])) ? 'checked' : ''; ?>> Enciende correctamente</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="pantalla_rota" <?php echo (isset($_SESSION['memoria_ingreso']['condicion']) && in_array('pantalla_rota', (array)$_SESSION['memoria_ingreso']['condicion'])) ? 'checked' : ''; ?>> Pantalla rota o dañada</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="rayones" <?php echo (isset($_SESSION['memoria_ingreso']['condicion']) && in_array('rayones', (array)$_SESSION['memoria_ingreso']['condicion'])) ? 'checked' : ''; ?>> Rayones o golpes visibles</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="sucio" <?php echo (isset($_SESSION['memoria_ingreso']['condicion']) && in_array('sucio', (array)$_SESSION['memoria_ingreso']['condicion'])) ? 'checked' : ''; ?>> Sucio / con polvo</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="faltan_piezas" <?php echo (isset($_SESSION['memoria_ingreso']['condicion']) && in_array('faltan_piezas', (array)$_SESSION['memoria_ingreso']['condicion'])) ? 'checked' : ''; ?>> Falta de piezas / tornillos</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="no_enciende" <?php echo (isset($_SESSION['memoria_ingreso']['condicion']) && in_array('no_enciende', (array)$_SESSION['memoria_ingreso']['condicion'])) ? 'checked' : ''; ?>> No enciende</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="desarmado" <?php echo (isset($_SESSION['memoria_ingreso']['condicion']) && in_array('desarmado', (array)$_SESSION['memoria_ingreso']['condicion'])) ? 'checked' : ''; ?>> Desarmado</label>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Accesorios entregados</label>
          <p class="nota-formulario">Que otras cosas se entregaron A PARTE del equipo</p>
          <div class="plano-checkboxs">
            <label class="check-item"><input type="checkbox" name="accesorios[]" value="cargador" <?php echo (isset($_SESSION['memoria_ingreso']['accesorios']) && in_array('cargador', (array)$_SESSION['memoria_ingreso']['accesorios'])) ? 'checked' : ''; ?>> Cargador</label>
            <label class="check-item"><input type="checkbox" name="accesorios[]" value="mouse" <?php echo (isset($_SESSION['memoria_ingreso']['accesorios']) && in_array('mouse', (array)$_SESSION['memoria_ingreso']['accesorios'])) ? 'checked' : ''; ?>> Mouse</label>
            <label class="check-item"><input type="checkbox" name="accesorios[]" value="cable_poder" <?php echo (isset($_SESSION['memoria_ingreso']['accesorios']) && in_array('cable_poder', (array)$_SESSION['memoria_ingreso']['accesorios'])) ? 'checked' : ''; ?>> Cable de poder</label>
            <label class="check-item"><input type="checkbox" name="accesorios[]" value="funda" <?php echo (isset($_SESSION['memoria_ingreso']['accesorios']) && in_array('funda', (array)$_SESSION['memoria_ingreso']['accesorios'])) ? 'checked' : ''; ?>> Funda</label>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Descripción del problema o motivo de ingreso</label>
          <p class="nota-formulario">Que problemas son los que presenta su equipo</p>
          <textarea name="motivo_ingreso" class="campo-texto" rows="3" required><?php echo htmlspecialchars($_SESSION['memoria_ingreso']['motivo_ingreso'] ?? ''); ?></textarea>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Técnico asignado</label>
          <p class="nota-formulario">Nombre del técnico que se le asignó</p>
          <select name="tecnico_asignado" class="campo-texto" required>
            <option value="">Seleccione un técnico...</option>
            <?php
            if ($query_tecnicos && $query_tecnicos->num_rows > 0) {
                $query_tecnicos->data_seek(0);
                while ($tecnico = $query_tecnicos->fetch_assoc()) {
                    $selected = (isset($_SESSION['memoria_ingreso']['tecnico_asignado']) && $_SESSION['memoria_ingreso']['tecnico_asignado'] == $tecnico['id_empleado']) ? 'selected' : '';
                    echo '<option value="' . $tecnico['id_empleado'] . '" ' . $selected . '>' . htmlspecialchars($tecnico['nombre'] . ' ' . $tecnico['apellido']) . '</option>';
                }
            }
            ?>
          </select>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Observaciones del equipo</label>
          <p class="nota-formulario">Observaciones de recepción: fallas, detalles de funcionamiento, características únicas.</p>
          <textarea name="observaciones_equipo" class="campo-texto" rows="3" required><?php echo htmlspecialchars($_SESSION['memoria_ingreso']['observaciones_equipo'] ?? ''); ?></textarea>
        </div>

        <div class="form-acciones">
          <button type="submit" name="step" value="1" class="boton-anterior" formnovalidate>Anterior</button>
          <button type="submit" name="step" value="3" class="boton-sig">Siguiente</button>
        </div>

      <?php elseif ($paso == 3): ?>
        <h1>Condiciones generales y preguntas</h1>
        <div class="grupo-entrada">
          <label class="etiqueta-formulario">¿Se autoriza revisión técnica con posible costo? *</label>
          <p class="nota-formulario">El costo del diagnóstico se toma a cuenta de la cotización. Si el cliente cancela el servicio durante el proceso, se aplicarán cargos por "Operación mínima".</p>
          <div class="plano-checkboxs">
            <label class="check-item">
              <input type="radio" name="autoriza_revision" value="si" <?php echo (isset($_SESSION['memoria_ingreso']['autoriza_revision']) && $_SESSION['memoria_ingreso']['autoriza_revision'] == 'si') ? 'checked' : ''; ?> required> Sí 
            </label>
            <label class="check-item">
              <input type="radio" name="autoriza_revision" value="no" <?php echo (isset($_SESSION['memoria_ingreso']['autoriza_revision']) && $_SESSION['memoria_ingreso']['autoriza_revision'] == 'no') ? 'checked' : ''; ?> required> No 
            </label>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Tiempo estimado de reparación (Días)</label>
          <p class="nota-formulario">Notificar al cliente que se le contactará por medios digitales. El servicio express tiene un costo extra del 30%.</p>
          <input type="number" name="tiempo_estimado" class="campo-texto" min="1" value="<?php echo $_SESSION['memoria_ingreso']['tiempo_estimado'] ?? ''; ?>">
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Recordatorio de Anticipo / Pago</label>
          <p class="nota-formulario">Recordarle al cliente que el pago de nuestros servicios es contra entrega del servicio proporcionado y solo requerimos anticipó total de las refacciones (en caso de requerirlas).</p>
          <div class="plano-checkboxs">
            <label class="check-item">
              <input type="checkbox" name="claro_pago" <?php echo isset($_SESSION['memoria_ingreso']['claro_pago']) ? 'checked' : ''; ?> required> Se informó al cliente sobre el pago de refacciones
            </label>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Dudas adicionales</label>
          <p class="nota-formulario">¿El cliente tiene alguna duda adicional relacionada con el servicio?</p>
          <textarea name="dudas_cliente" class="campo-texto" rows="2"><?php echo $_SESSION['memoria_ingreso']['dudas_cliente'] ?? ''; ?></textarea>
        </div>

        <div class="form-acciones">
          <button type="submit" name="step" value="2" class="boton-anterior" formnovalidate>Anterior</button>
          <button type="submit" name="step" value="4" class="boton-sig">Siguiente</button>
        </div>

      <?php elseif ($paso == 4): ?>
        <h1>Información para análisis de mercado</h1>
        <div class="grupo-entrada">
          <label class="etiqueta-formulario">¿Cómo se enteró de nosotros?</label>
          <p class="nota-formulario">Pregunta dirigida al cliente</p>
          <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="origen" value="recomendacion" <?php echo (isset($_SESSION['memoria_ingreso']['origen']) && $_SESSION['memoria_ingreso']['origen'] == 'recomendacion') ? 'checked' : ''; ?> required> Recomendación</label>
            <label class="check-item"><input type="radio" name="origen" value="redes_sociales" <?php echo (isset($_SESSION['memoria_ingreso']['origen']) && $_SESSION['memoria_ingreso']['origen'] == 'redes_sociales') ? 'checked' : ''; ?>> Redes sociales (FB, IG, etc.)</label>
            <label class="check-item"><input type="radio" name="origen" value="google_web" <?php echo (isset($_SESSION['memoria_ingreso']['origen']) && $_SESSION['memoria_ingreso']['origen'] == 'google_web') ? 'checked' : ''; ?>> Google / Sitio web</label>
            <label class="check-item"><input type="radio" name="origen" value="cartel" <?php echo (isset($_SESSION['memoria_ingreso']['origen']) && $_SESSION['memoria_ingreso']['origen'] == 'cartel') ? 'checked' : ''; ?>> Cartel afuera del local</label>
            <label class="check-item"><input type="radio" name="origen" value="cucosta" <?php echo (isset($_SESSION['memoria_ingreso']['origen']) && $_SESSION['memoria_ingreso']['origen'] == 'cucosta') ? 'checked' : ''; ?>> Universidad CUCOSTA</label>
            <label class="check-item"><input type="radio" name="origen" value="recurrente" <?php echo (isset($_SESSION['memoria_ingreso']['origen']) && $_SESSION['memoria_ingreso']['origen'] == 'recurrente') ? 'checked' : ''; ?>> Cliente recurrente</label>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">¿Es su primera vez con nosotros?</label>
          <p class="nota-formulario">Pregunta dirigida al cliente</p>
          <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="primera_vez" value="si" <?php echo (isset($_SESSION['memoria_ingreso']['primera_vez']) && $_SESSION['memoria_ingreso']['primera_vez'] == 'si') ? 'checked' : ''; ?> required> Sí</label>
            <label class="check-item"><input type="radio" name="primera_vez" value="no" <?php echo (isset($_SESSION['memoria_ingreso']['primera_vez']) && $_SESSION['memoria_ingreso']['primera_vez'] == 'no') ? 'checked' : ''; ?>> No</label>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">¿Con qué frecuencia solicita servicios técnicos?</label>
          <p class="nota-formulario">Frecuencia con la que da mantenimiento a su equipo o solicita reparaciones</p>
          <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="frecuencia" value="1_vez_anio" <?php echo (isset($_SESSION['memoria_ingreso']['frecuencia']) && $_SESSION['memoria_ingreso']['frecuencia'] == '1_vez_anio') ? 'checked' : ''; ?> required> 1 vez al año o menos</label>
            <label class="check-item"><input type="radio" name="frecuencia" value="2-3_veces_anio" <?php echo (isset($_SESSION['memoria_ingreso']['frecuencia']) && $_SESSION['memoria_ingreso']['frecuencia'] == '2-3_veces_anio') ? 'checked' : ''; ?>> 2–3 veces al año</label>
            <label class="check-item"><input type="radio" name="frecuencia" value="mas_3_anio" <?php echo (isset($_SESSION['memoria_ingreso']['frecuencia']) && $_SESSION['memoria_ingreso']['frecuencia'] == 'mas_3_anio') ? 'checked' : ''; ?>> Más de 3 veces al año</label>
            <label class="check-item"><input type="radio" name="frecuencia" value="descompone" <?php echo (isset($_SESSION['memoria_ingreso']['frecuencia']) && $_SESSION['memoria_ingreso']['frecuencia'] == 'descompone') ? 'checked' : ''; ?>> Cuando se descompone mi equipo</label>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">¿Qué tipo de uso le da al equipo?</label>
          <p class="nota-formulario">Pregunta dirigida al cliente</p>
          <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="uso_equipo" value="estudio" <?php echo (isset($_SESSION['memoria_ingreso']['uso_equipo']) && $_SESSION['memoria_ingreso']['uso_equipo'] == 'estudio') ? 'checked' : ''; ?> required> Estudio</label>
            <label class="check-item"><input type="radio" name="uso_equipo" value="oficina" <?php echo (isset($_SESSION['memoria_ingreso']['uso_equipo']) && $_SESSION['memoria_ingreso']['uso_equipo'] == 'oficina') ? 'checked' : ''; ?>> Trabajo de oficina</label>
            <label class="check-item"><input type="radio" name="uso_equipo" value="disenio_edicion" <?php echo (isset($_SESSION['memoria_ingreso']['uso_equipo']) && $_SESSION['memoria_ingreso']['uso_equipo'] == 'disenio_edicion') ? 'checked' : ''; ?>> Diseño / Arquitectura / Edición</label>
            <label class="check-item"><input type="radio" name="uso_equipo" value="gaming" <?php echo (isset($_SESSION['memoria_ingreso']['uso_equipo']) && $_SESSION['memoria_ingreso']['uso_equipo'] == 'gaming') ? 'checked' : ''; ?>> Gaming</label>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">¿Desea recibir promociones, recordatorios y novedades?</label>
          <p class="nota-formulario">Pregunta dirigida al cliente</p>
          <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="promociones" value="si por whatsapp" <?php echo (isset($_SESSION['memoria_ingreso']['promociones']) && $_SESSION['memoria_ingreso']['promociones'] == 'si por whatsapp') ? 'checked' : ''; ?> required> Sí, por WhatsApp</label>
            <label class="check-item"><input type="radio" name="promociones" value="si por correo" <?php echo (isset($_SESSION['memoria_ingreso']['promociones']) && $_SESSION['memoria_ingreso']['promociones'] == 'si por correo') ? 'checked' : ''; ?>> Sí, por correo electrónico</label>
            <label class="check-item"><input type="radio" name="promociones" value="ambos" <?php echo (isset($_SESSION['memoria_ingreso']['promociones']) && $_SESSION['memoria_ingreso']['promociones'] == 'ambos') ? 'checked' : ''; ?>> Ambos</label>
            <label class="check-item"><input type="radio" name="promociones" value="no" <?php echo (isset($_SESSION['memoria_ingreso']['promociones']) && $_SESSION['memoria_ingreso']['promociones'] == 'no') ? 'checked' : ''; ?>> No</label>
          </div>
        </div>

        <div class="form-acciones">
          <button type="submit" name="step" value="3" class="boton-anterior" formnovalidate>Anterior</button>
          <button type="submit" name="step" value="5" class="boton-sig">Siguiente</button>
        </div>

      <?php elseif ($paso == 5): ?>
        <h1>Información esencial del equipo</h1>
        <p class="nota-formulario" style="text-align: center;">Esta sección se puede llenar en ausencia del cliente</p>

        <?php if (isset($_SESSION['error_db'])): ?>
          <div class="mensaje-error" style="background:#fee2e2;border:1px solid #f87171;color:#b91c1c;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.9rem;">
            <i class="fas fa-triangle-exclamation"></i>
            <?php echo $_SESSION['error_db']; unset($_SESSION['error_db']); ?>
          </div>
        <?php endif; ?>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Tipo de equipo</label>
          <p class="nota-formulario">¿Qué tipo de dispositivo es?</p>
          <select id="selector_tipo_equipo" name="tipo_equipo" class="campo-texto" required>
            <option value="">Seleccione tipo...</option>
            <?php
            if ($query_tipos && $query_tipos->num_rows > 0) {
                while ($tipo = $query_tipos->fetch_assoc()) {
                    $selected = (isset($_SESSION['memoria_ingreso']['tipo_equipo']) && $_SESSION['memoria_ingreso']['tipo_equipo'] == $tipo['id_tipo_equipo']) ? 'selected' : '';
                    echo '<option value="' . $tipo['id_tipo_equipo'] . '" ' . $selected . '>' . htmlspecialchars($tipo['tipo']) . '</option>';
                }
            }
            ?>
          </select>
        </div>

        <div class="fila-doble">
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Marca</label>
            <p class="nota-formulario">Seleccione la marca del equipo</p>
            <select id="selector_marca" name="marca" class="campo-texto" required>
              <option value="">Seleccione marca...</option>
              <?php
              if ($query_marcas && $query_marcas->num_rows > 0) {
                  while ($marca = $query_marcas->fetch_assoc()) {
                      $selected = (isset($_SESSION['memoria_ingreso']['marca']) && $_SESSION['memoria_ingreso']['marca'] == $marca['id_marca']) ? 'selected' : '';
                      echo '<option value="' . $marca['id_marca'] . '" ' . $selected . '>' . htmlspecialchars($marca['marca']) . '</option>';
                  }
              }
              ?>
            </select>
          </div>
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Modelo</label>
            <p class="nota-formulario">Suele estar en la parte inferior</p>
            <input type="text" name="modelo" class="campo-texto" value="<?php echo $_SESSION['memoria_ingreso']['modelo'] ?? ''; ?>" required>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Número de Serie (SN) o Service Tag (ST)</label>
          <p class="nota-formulario">Identificador único del fabricante</p>
          <div class="input-icon-wrapper">
            <i class="fas fa-barcode"></i>
            <input type="text" name="numero_serie" class="campo-texto" style="padding-left: 35px;" value="<?php echo $_SESSION['memoria_ingreso']['numero_serie'] ?? ''; ?>" required>
          </div>
        </div>

        <div class="form-acciones">
          <button type="submit" name="step" value="4" class="boton-anterior" formnovalidate>Anterior</button>
          <button type="submit" name="finalizar_registro" class="boton-sig" style="width: 200px;">Finalizar Registro</button>
        </div>
      <?php endif; ?>
    </form>
  </div>

  <script>
      const espaciosDB = <?php echo isset($json_gabinetes) ? $json_gabinetes : '{}'; ?>;
      const relacionesEquipoMarca = <?php echo isset($json_relaciones) ? $json_relaciones : '{}'; ?>;
      const citasDB = <?php echo isset($json_citas) ? $json_citas : '{}'; ?>;
      const modoEdicion = <?php echo isset($_SESSION['modo_edicion']) ? 'true' : 'false'; ?>;
      const savedTipoAlmacenamiento = "<?php echo htmlspecialchars($_SESSION['memoria_ingreso']['tipo_almacenamiento'] ?? ''); ?>";
      const savedEspacioAlmacenamiento = "<?php echo htmlspecialchars($_SESSION['memoria_ingreso']['espacio_almacenamiento'] ?? ''); ?>";
      
      <?php 
        // Si el controlador guardó un mensaje de éxito, le avisamos a JS de forma elegante
        echo isset($_SESSION['mensaje_exito']) ? "const registroExitoso = true;" : "const registroExitoso = false;"; 
        unset($_SESSION['mensaje_exito']); 
      ?>
  </script>

  <script src="../../public/js/ingresar_dispositivo.js"></script>

</body>
</html>