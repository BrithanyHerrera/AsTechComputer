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
        <div class="step-label">Diagnóstico Técnico</div>
      </div>

      <div class="step-line"></div>

      <div class="step <?php if ($step == 4)
        echo 'active'; ?>">
        <div class="step-icon">4</div>
        <div class="step-label">Agenda de Servicio</div>
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
        <input type="date" name="fecha_ingreso" class="campo-texto" required>
      </div>
      <div class="grupo-entrada">
        <label class="etiqueta-formulario">Folio (DDMMAA + N° Equipo) *</label>
        <input type="text" name="folio" class="campo-texto" placeholder="Ej. 250720254" required>
      </div>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Condición física al ingreso</label>
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
      <div class="plano-checkboxs">
        <label class="check-item"><input type="checkbox" name="accesorios[]" value="cargador"> Cargador</label>
        <label class="check-item"><input type="checkbox" name="accesorios[]" value="mouse"> Mouse</label>
        <label class="check-item"><input type="checkbox" name="accesorios[]" value="cable_poder"> Cable de poder</label>
        <label class="check-item"><input type="checkbox" name="accesorios[]" value="funda"> Funda</label>
      </div>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Descripción del problema o motivo de ingreso</label>
      <textarea name="motivo_ingreso" class="campo-texto" rows="3"
        placeholder="Descripción de los problemas que presenta el equipo..." required></textarea>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Técnico asignado</label>
      <select name="tecnico_asignado" class="campo-texto" required>
        <option value="">Seleccione un técnico...</option>
        <option value="Ferdán Garrigós">Ferdán Garrigós</option>
        <option value="Lino Gonzalez">Lino Gonzalez</option>
      </select>
    </div>

    <div class="grupo-entrada">
      <label class="etiqueta-formulario">Observaciones del equipo</label>
      <textarea name="observaciones_equipo" class="campo-texto" rows="3"
        placeholder="Observaciones del dispositivo de parte del equipo de recepción: fallas de algún tipo, golpes, detalles de funcionamiento, características únicas del equipo." required></textarea>
    </div>

    <button type="submit" name="step" value="3" class="boton-anterior">Anterior</button>
    <button type="submit" name="guardar" class="boton-sig">Finalizar</button>

  <?php elseif ($step == 3): ?>
    <h1>Diagnóstico Técnico</h1>
    <textarea name="diagnostico" placeholder="Descripción" class="campo-texto"></textarea>
    <button type="submit" name="step" value="2" class="boton-anterior">Anterior</button>
    <button type="submit" name="step" value="4" class="boton-sig">Siguiente</button>

  <?php elseif ($step == 4): ?>
    <h1>Agenda de Servicio</h1>
    <input type="date" name="fecha" class="campo-texto">
    <input type="time" name="hora" class="campo-texto">
    <button type="submit" name="step" value="3" class="boton-anterior">Anterior</button>
    <button type="submit" name="guardar" class="boton-sig">Finalizar</button>
  <?php endif; ?>
  </form>
  </div>
</body>

</html>