<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 | As Tech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* CSS Responsivo Moderno */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Lato', sans-serif;
            background-color: #f8f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100dvh; /* Se adapta incluso si hay barra de direcciones en el celular */
            text-align: center;
            color: #333;
        }
        
        .contenedor-error {
            background: white;
            padding: clamp(30px, 5vw, 50px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            width: 90%;
            max-width: 500px;
            border-top: 5px solid #e17203; /* Acento Naranja */
        }
        
        .icono-error {
            font-size: clamp(60px, 10vw, 80px);
            color: #4a148c; /* Morado Institucional */
            margin-bottom: 20px;
            animation: flotar 3s ease-in-out infinite; /* Efecto suave de flotación */
        }
        
        h1 {
            color: #e17203;
            font-size: clamp(40px, 8vw, 60px);
            margin: 0;
            font-weight: 900;
        }
        
        h2 {
            color: #4a148c;
            font-size: clamp(20px, 4vw, 26px);
            margin: 10px 0;
        }
        
        p {
            color: #666;
            font-size: clamp(14px, 3vw, 16px);
            margin: 20px 0 30px;
            line-height: 1.6;
        }
        
        .btn-regresar {
            display: inline-block;
            background-color: #4a148c;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 20, 140, 0.3);
        }
        
        .btn-regresar:hover {
            background-color: #e17203;
            box-shadow: 0 4px 15px rgba(225, 114, 3, 0.3);
            transform: translateY(-2px);
        }
        
        @keyframes flotar {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <div class="contenedor-error">
        <i class="fa-solid fa-plug-circle-xmark icono-error"></i>
        <h1>404</h1>
        <h2>¡Ups! Te saliste del mapa</h2>
        <p>La página que buscas parece haber sufrido un cortocircuito o fue movida a otra ubicación. No te preocupes, tu información está a salvo.</p>
        
        <a href="/" class="btn-regresar"><i class="fa-solid fa-house"></i> Volver al Inicio</a>
    </div>
</body>
</html>