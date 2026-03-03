<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Integral de Equipo | As Tech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/cita.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include '../../toolbar.php'; ?>
<?php
$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;

if($step < 1) $step = 1;
if($step > 4) $step = 4;
?>

  <div class="stepper-container">
  <div class="stepper">
    
    <div class="step <?php if($step == 1) echo 'active'; ?>">
      <div class="step-icon">1</div>
      <div class="step-label">Datos del Solicitante</div>
    </div>
    
    <div class="step-line"></div>

    <div class="step <?php if($step == 2) echo 'active'; ?>">
      <div class="step-icon">2</div>
      <div class="step-label">Detalles del Equipo</div>
    </div>
    
    <div class="step-line"></div>

    <div class="step <?php if($step == 3) echo 'active'; ?>">
      <div class="step-icon">3</div>
      <div class="step-label">Diagnóstico Técnico</div>
    </div>
    
    <div class="step-line"></div>

    <div class="step <?php if($step == 4) echo 'active'; ?>">
      <div class="step-icon">4</div>
      <div class="step-label">Agenda de Servicio</div>
    </div>

  </div>
</div>
</div>
<div class="form">
  <form method="POST">
  <?php if($step == 1): ?>
  <h1>Datos del solicitante</h1>
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
           <button type="submit" class="boton-siguiente" name="step" value="2">Siguiente     <i class="fa-solid fa-angle-right"></i></button>

   
</div>



<?php elseif($step == 2): ?> <h1>Detalles del Equipo</h1>
    <div class="fila-doble">
        <input type="text" name="marca" placeholder="Marca" class="campo-texto">
        <input type="text" name="modelo" placeholder="Modelo" class="campo-texto">
    </div>
    <button type="submit" name="step" value="1" class="boton-anterior">Anterior</button>
    <button type="submit" name="step" value="3" class="boton-sig">Siguiente</button>

  <?php elseif($step == 3): ?>
    <h1>Diagnóstico Técnico</h1>
    <textarea name="diagnostico" placeholder="Descripción" class="campo-texto"></textarea>
    <button type="submit" name="step" value="2" class="boton-anterior">Anterior</button>
    <button type="submit" name="step" value="4" class="boton-sig">Siguiente</button>

  <?php elseif($step == 4): ?>
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