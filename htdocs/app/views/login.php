<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Panel de control</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/login.css">
  <link rel="stylesheet" href="../../public/css/toolbar.css">
  <link rel="icon" href="../../public/img/Astech ICO.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
</head>
<body>
    <div class="pantalla-login">
  <div class="tarjeta-login">
    
    <div class="lado-imagen">
         <a href="../../index.php" style="text-decoration: none;">
  <button type="button" class="boton-regresar">
       <i class="fa-solid fa-arrow-left"></i>      Regresar      
  </button>
</a>
      <img src="../../public/img/1.png" alt="AS TECH Admin">
      <div class="capa-texto">
  
      </div>
    </div>

    <div class="lado-formulario">
      <form>
        <h2>Iniciar Sesión</h2>
        <div class="grupo-entrada">
          <label>Usuario</label>
          <input type="text" placeholder="Ingresa tu usuario">
        </div>
        <div class="grupo-entrada">
          <label>Contraseña</label>
          <input type="password" placeholder="••••••••">
        </div>
        <a href="../../app/views/administración.php" style="text-decoration: none;">
  <button type="button" class="boton-ingresar">
    Entrar al Sistema
  </button>
</a>
        <a href="#" class="link-olvido">¿Olvidaste tu contraseña?</a>
      </form>
    </div>

  </div>
</div>
    
</body>
</html>