<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Integral de Equipo | As Tech Computer</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/cita.css">
  <link rel="stylesheet" href="../../public/css/toolbar.css">
  <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
  <?php include '../../toolbar.php'; ?>
  <?php
  $step = isset($_POST['step']) ? (int) $_POST['step'] : 1;

  if ($step < 1)
    $step = 1;
  if ($step > 4)
    $step = 4;
  ?>

  <div class="stepper-container">
    <div class="stepper">

      <div class="step <?php if ($step == 1)
        echo 'active'; ?>">
        <div class="step-icon">1</div>
        <div class="step-label">Datos del Cliente</div>
      </div>

      <div class="step-line"></div>

      <div class="step <?php if ($step == 2)
        echo 'active'; ?>">
        <div class="step-icon">2</div>
        <div class="step-label">Revisión física y control interno </div>
      </div>

      <div class="step-line"></div>

      <div class="step <?php if ($step == 3)
        echo 'active'; ?>">
        <div class="step-icon">3</div>
        <div class="step-label">Condiciones generales y preguntas</div>
      </div>

      <div class="step-line"></div>

      <div class="step <?php if ($step == 4)
        echo 'active'; ?>">
        <div class="step-icon">4</div>
        <div class="step-label">Información para análisis de mercado</div>
      </div>

    </div>
  </div>
  </div>
  <div class="form">
    <form method="POST">
      <?php if ($step == 1): ?>
        <h1>Datos del cliente</h1>
        <div class="fila-doble">
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Nombre</label>
            <input type="text" name="nombre_cliente" class="campo-texto">
          </div>
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Apellido</label>
            <input type="text" name="apellido_cliente" class="campo-texto">
          </div>

          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Número de telefono</label>
            <div class="input-icon-wrapper">
              <i class="fas fa-phone"></i>
              <input type="text" name="nombre_cliente" class="campo-texto">
            </div>
          </div>
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Correo</label>
            <div class="input-icon-wrapper">
              <i class="fas fa-envelope"></i>

              <input type="text" name="nombre_cliente" class="campo-texto">
            </div>
          </div>

        </div>
        <button type="submit" class="boton-siguiente" name="step" value="2">Siguiente <i
            class="fa-solid fa-angle-right"></i></button>

    </div>

  <?php elseif ($step == 2): ?>
    <h1>Revisión física y control interno</h1>

    <div class="fila-doble">
      <div class="grupo-entrada">
        <label class="etiqueta-formulario">Fecha de ingreso</label>
        <p class="nota-formulario">Fecha en la que se entregó el dispositivo</p>
        <input type="date" name="fecha_ingreso" class="campo-texto" required>
      </div>
      <div class="grupo-entrada">
        <label class="etiqueta-formulario">Folio</label>
        <p class="nota-formulario">Fecha de hoy en formato: DDMMAA + Numero de equipo recibido en el día: Ej. "250720254"</p>
        <input type="text" name="folio" class="campo-texto" required>
      </div>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Condición física al ingreso</label>
      <p class="nota-formulario">Condición (problemas) que presentaba el dispositivo al ser entregado</p>
      <div class="plano-checkboxs">
        <label class="check-item"><input type="checkbox" name="condicion[]" value="enciende"> Enciende
          correctamente</label>
        <label class="check-item"><input type="checkbox" name="condicion[]" value="pantalla_rota"> Pantalla rota o
          dañada</label>
        <label class="check-item"><input type="checkbox" name="condicion[]" value="rayones"> Rayones o golpes
          visibles</label>
        <label class="check-item"><input type="checkbox" name="condicion[]" value="sucio"> Sucio / con polvo</label>
        <label class="check-item"><input type="checkbox" name="condicion[]" value="faltan_piezas"> Falta de piezas /
          tornillos</label>
        <label class="check-item"><input type="checkbox" name="condicion[]" value="no_enciende"> No enciende</label>
        <label class="check-item"><input type="checkbox" name="condicion[]" value="desarmado"> Desarmado</label>
      </div>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Accesorios entregados</label>
      <p class="nota-formulario">Que otras cosas se entregaron A PARTE del equipo</p>
      <div class="plano-checkboxs">
        <label class="check-item"><input type="checkbox" name="accesorios[]" value="cargador"> Cargador</label>
        <label class="check-item"><input type="checkbox" name="accesorios[]" value="mouse"> Mouse</label>
        <label class="check-item"><input type="checkbox" name="accesorios[]" value="cable_poder"> Cable de poder</label>
        <label class="check-item"><input type="checkbox" name="accesorios[]" value="funda"> Funda</label>
      </div>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Descripción del problema o motivo de ingreso</label>
      <p class="nota-formulario">Que problemas son los que presenta su equipo</p>
      <textarea name="motivo_ingreso" class="campo-texto" rows="3" required></textarea>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Técnico asignado</label>
      <p class="nota-formulario">Nombre del técnico que se le asignó</p>
      <select name="tecnico_asignado" class="campo-texto" required>
        <option value="">Seleccione un técnico...</option>
        <option value="Ferdán Garrigós">Ferdán Garrigós</option>
        <option value="Lino Gonzalez">Lino Gonzalez</option>
      </select>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Observaciones del equipo</label>
      <p class="nota-formulario">Observaciones del dispositivo de parte del equipo de recepción: fallas de algún tipo, golpes, detalles de funcionamiento, características únicas del equipo.</p>
      <textarea name="observaciones_equipo" class="campo-texto" rows="3" required></textarea>
    </div>

    <div class="form-acciones">
      <button type="submit" name="step" value="1" class="boton-anterior">Anterior</button>
      <button type="submit" name="step" value="3" class="boton-sig">Siguiente</button>
    </div>

  <?php elseif ($step == 3): ?>
    <h1>Condiciones generales y preguntas</h1>
    <div class="grupo-entrada">
      <label class="etiqueta-formulario">¿Se autoriza revisión técnica con posible costo? *</label>
      <p class="nota-formulario">El costo del diagnóstico se toma a cuenta de la cotización. Si el cliente cancela el
        servicio durante el proceso, se aplicarán cargos por "Operación mínima".</p>
      <div class="plano-checkboxs">
        <label class="check-item"><input type="radio" name="autoriza_revision" value="si" required> Sí </label>
        <label class="check-item"><input type="radio" name="autoriza_revision" value="no" required> No </label>
      </div>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Tiempo estimado de reparación (Días)</label>
      <p class="nota-formulario">Notificar al cliente que se le contactará por medios digitales. El servicio express tiene
        un costo extra del 30%.</p>
      <input type="number" name="tiempo_estimado" class="campo-texto" min="1">
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Recordatorio de Anticipo / Pago</label>
      <p class="nota-formulario">Recordarle al cliente que el pago de nuestros servicios es contra entrega del servicio proporcionado y solo requerimos anticipó total de las refacciones (en caso de requerirlas).</p>
      <div class="plano-checkboxs">
        <label class="check-item"><input type="checkbox" name="claro_pago" required> Se informó al cliente sobre el pago
          de refacciones</label>
      </div>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Dudas adicionales</label>
      <p class="nota-formulario">¿El cliente tiene alguna duda adicional relacionada con el servicio?</p>
      <textarea name="dudas_cliente" class="campo-texto" rows="2"></textarea>
    </div>

    <div class="form-acciones">
      <button type="submit" name="step" value="2" class="boton-anterior">Anterior</button>
      <button type="submit" name="step" value="4" class="boton-sig">Siguiente</button>
    </div>

  <?php elseif ($step == 4): ?>
    <h1>Información para análisis de mercado</h1>

    <div class="grupo-entrada">
        <label class="etiqueta-formulario">¿Cómo se enteró de nosotros?</label>
        <p class="nota-formulario">Pregunta dirigida al cliente</p>
        <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="origen" value="recomendacion" required> Recomendación</label>
            <label class="check-item"><input type="radio" name="origen" value="redes_sociales"> Redes sociales (FB, IG, etc.)</label>
            <label class="check-item"><input type="radio" name="origen" value="google_web"> Google / Sitio web</label>
            <label class="check-item"><input type="radio" name="origen" value="cartel"> Cartel afuera del local</label>
            <label class="check-item"><input type="radio" name="origen" value="cucosta"> Universidad CUCOSTA</label> <label class="check-item"><input type="radio" name="origen" value="recurrente"> Cliente recurrente</label>
        </div>
    </div>

    <div class="grupo-entrada">
        <label class="etiqueta-formulario">¿Es su primera vez con nosotros?</label>
        <p class="nota-formulario">Pregunta dirigida al cliente</p>
        <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="primera_vez" value="si" required> Sí</label>
            <label class="check-item"><input type="radio" name="primera_vez" value="no"> No</label>
        </div>
    </div>

    <div class="grupo-entrada">
        <label class="etiqueta-formulario">¿Con qué frecuencia solicita servicios técnicos?</label>
        <p class="nota-formulario">Frecuencia con la que da mantenimiento a su equipo o solicita reparaciones</p>
        <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="frecuencia" value="1_vez_anio" required> 1 vez al año o menos</label>
            <label class="check-item"><input type="radio" name="frecuencia" value="2-3_veces_anio"> 2–3 veces al año</label>
            <label class="check-item"><input type="radio" name="frecuencia" value="mas_3_anio"> Más de 3 veces al año</label>
            <label class="check-item"><input type="radio" name="frecuencia" value="descompone"> Cuando se descompone mi equipo</label> </div>
    </div>

    <div class="grupo-entrada">
        <label class="etiqueta-formulario">¿Qué tipo de uso le da al equipo?</label>
        <p class="nota-formulario">Pregunta dirigida al cliente</p>
        <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="uso_equipo" value="estudio" required> Estudio</label>
            <label class="check-item"><input type="radio" name="uso_equipo" value="oficina"> Trabajo de oficina</label>
            <label class="check-item"><input type="radio" name="uso_equipo" value="disenio_edicion"> Diseño / Arquitectura / Edición</label>
            <label class="check-item"><input type="radio" name="uso_equipo" value="gaming"> Gaming</label> </div>
    </div>

    <div class="grupo-entrada">
        <label class="etiqueta-formulario">¿Desea recibir promociones, recordatorios y novedades?</label>
        <p class="nota-formulario">Pregunta dirigida al cliente</p>
        <div class="plano-checkboxs">
            <label class="check-item"><input type="radio" name="promociones" value="whatsapp" required> Sí, por WhatsApp</label>
            <label class="check-item"><input type="radio" name="promociones" value="correo"> Sí, por correo electrónico</label>
            <label class="check-item"><input type="radio" name="promociones" value="ambos"> Ambos</label>
            <label class="check-item"><input type="radio" name="promociones" value="no"> No</label> </div>
    </div>

    <div class="form-acciones">
        <button type="submit" name="step" value="3" class="boton-anterior">Anterior</button>
        <button type="submit" name="step" value="5" class="boton-sig">Siguiente</button> 
    </div>
  <?php endif; ?>
  </form>
  </div>
</body>

</html>