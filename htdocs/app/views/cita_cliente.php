<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Servicio | As Tech Computer</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    
    <style>
        :root {
            --naranja-principal: #e17203;
            --purpura-oscuro: #52073a;    
            --blanco: #FFFFFF;           
            --negro: #000000;            
            --gris-suave: #656464;      
            --fondo-gris: #fcfcfc;
            --borde: #e0e0e0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Lato', sans-serif;
            background-color: var(--fondo-gris);
            color: var(--negro);
            line-height: 1.6;
            padding-top: 90px;
        }

        .contenedor-cita {
            background: var(--blanco);
            max-width: 650px;
            margin: 0 auto 50px;
            padding: 50px;
            border-radius: 2px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        }

        .encabezado { text-align: center; margin-bottom: 40px; }
        .titulo-seccion { font-size: 28px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; }
        .separador { height: 3px; width: 50px; background-color: var(--naranja-principal); margin: 0 auto 20px; }

        .alerta-restriccion {
            background-color: #fff5eb;
            border: 1px solid #ffe8cc;
            color: #af5b00;
            padding: 15px;
            font-size: 13px;
            margin-bottom: 35px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 4px;
        }

        .grupo-campo { margin-bottom: 25px; text-align: left; }

        label {
            display: flex;
            align-items: center;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--gris-suave);
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .control {
            width: 100%;
            padding: 14px;
            border: 1px solid var(--borde);
            background-color: #fafafa;
            font-size: 15px;
            font-family: 'Lato', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .control:focus {
            border-color: var(--naranja-principal);
            background-color: var(--blanco);
            box-shadow: 0 0 0 4px rgba(225, 114, 3, 0.05);
        }

        .fila-doble { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .campo-otro { display: none; margin-top: 12px; animation: slideDown 0.3s ease; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .ayuda-serie {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 16px;
            height: 16px;
            background-color: var(--borde);
            color: var(--gris-suave);
            border-radius: 50%;
            font-size: 10px;
            margin-left: 8px;
            cursor: pointer;
            position: relative;
            transition: 0.3s;
        }

        .ayuda-serie:hover {
            background-color: var(--purpura-oscuro);
            color: white;
        }

        .ayuda-serie::after {
            content: "El número de serie suele situarse en la parte inferior del equipo como una etiqueta o grabado. Si no es visible, puedes dejarlo en blanco.";
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            background-color: var(--purpura-oscuro);
            color: white;
            padding: 10px;
            border-radius: 4px;
            font-size: 11px;
            text-transform: none;
            font-weight: 400;
            letter-spacing: 0;
            visibility: hidden;
            opacity: 0;
            transition: 0.3s;
            z-index: 10;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .ayuda-serie:hover::after, .ayuda-serie:focus::after {
            visibility: visible;
            opacity: 1;
        }

        .ayuda-serie::before {
            content: "";
            position: absolute;
            bottom: 110%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: var(--purpura-oscuro) transparent transparent transparent;
            visibility: hidden;
            opacity: 0;
            transition: 0.3s;
        }

        .ayuda-serie:hover::before {
            visibility: visible;
            opacity: 1;
        }

        .boton-agendar {
            background-color: var(--naranja-principal);
            color: white;
            padding: 18px;
            border: none;
            width: 100%;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            margin-top: 20px;
        }

        .boton-agendar:hover {
            background-color: var(--purpura-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(82, 7, 58, 0.2);
        }

        @media (max-width: 600px) {
            .fila-doble { grid-template-columns: 1fr; }
            .contenedor-cita { padding: 30px; }
        }
    </style>
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
        <span><strong>Aviso importante:</strong> Por normatividad técnica, no recibimos equipos de la marca <strong>Apple (MacBook, iMac, etc.)</strong>.</span>
    </div>

    <form action="procesar_cita.php" method="POST">
        
        <div class="grupo-campo">
            <label>Nombre</label>
            <input type="text" name="nombre_cliente" class="control" required placeholder="Nombre y apellido">
        </div>

        <div class="grupo-campo">
            <label>WhatsApp de Contacto</label>
            <input type="tel" name="whatsapp" class="control" required placeholder="Ej. 322 236 2505">
        </div>

        <div class="fila-doble">
            <div class="grupo-campo">
                <label>Tipo de Dispositivo</label>
                <select name="tipo_dispositivo" class="control" onchange="toggleOtro(this, 'otro_tipo_box')" required>
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
                <select name="marca" class="control" id="selector_marca" onchange="toggleOtro(this, 'otra_marca_box')" required>
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
                <input type="text" name="modelo" class="control" required placeholder="Ej. Inspiron 3501">
            </div>
            <div class="grupo-campo">
                <label>
                    No. Serie (Opcional) 
                    <span class="ayuda-serie" tabindex="0" title="Click para ayuda">?</span>
                </label>
                <input type="text" name="numero_serie" class="control" placeholder="S/N o Service Tag">
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
                <textarea name="problema_detalle" class="control" rows="3" placeholder="Describe brevemente el fallo que presenta tu equipo"></textarea>
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

        <button type="submit" class="boton-agendar">Confirmar Solicitud</button>
    </form>
</div>

<script>
    function toggleOtro(select, idContenedor) {
        const contenedor = document.getElementById(idContenedor);
        const inputInterno = contenedor.querySelector('input, textarea');
        
        if (select.value === "Otro" || select.value === "otra_marca") {
            contenedor.style.display = "block";
            inputInterno.required = true;
            inputInterno.focus();
        } else {
            contenedor.style.display = "none";
            inputInterno.required = false;
        }
    }

    document.querySelector('input[name="otra_marca_texto"]').addEventListener('input', function(e) {
        const valor = e.target.value.toLowerCase();
        if(valor.includes('apple') || valor.includes('mac')) {
            alert('Lo sentimos, por el momento no trabajamos con la arquitectura de Apple.');
            e.target.value = '';
        }
    });
</script>

</body>
</html>