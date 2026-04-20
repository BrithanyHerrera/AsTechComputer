<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}require_once '../config/conexion.db.php'; 

// ==========================================
// 1. GUARDADO PROGRESIVO EN MEMORIA
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if ($key !== 'step' && $key !== 'finalizar_registro') {
            $_SESSION['memoria_ingreso'][$key] = $value;
        }
    }
}

// ==========================================
// 2. GUARDADO FINAL EN LAS 5 TABLAS
// ==========================================
if (isset($_POST['finalizar_registro'])) {
    $datos = $_SESSION['memoria_ingreso'];

    $condicion_txt = isset($datos['condicion']) ? implode(", ", $datos['condicion']) : 'Ninguna';
    $accesorios_txt = isset($datos['accesorios']) ? implode(", ", $datos['accesorios']) : 'Ninguno';
    $telefono = $datos['telefono_cliente'] ?? '';
    $recordatorio_pago = isset($datos['claro_pago']) ? 'si' : 'no';

    // Estos mapeos se quedan porque siguen usando botones de radio (texto a ID)
    $map_uso = ['estudio'=>1, 'oficina'=>2, 'disenio_edicion'=>3, 'gaming'=>4];
    $id_uso = $map_uso[$datos['uso_equipo']] ?? 5; 

    $map_frecuencia = ['1_vez_anio'=>1, '2-3_veces_anio'=>2, 'mas_3_anio'=>3, 'descompone'=>4];
    $id_frecuencia = $map_frecuencia[$datos['frecuencia']] ?? 6;

    $map_origen = ['recomendacion'=>1, 'redes_sociales'=>2, 'google_web'=>3, 'cartel'=>4, 'cucosta'=>4, 'recurrente'=>4];
    $id_origen = $map_origen[$datos['origen']] ?? 4;

    // NUEVO: Asignación directa de IDs desde los select
    $id_tipo_equipo = $datos['tipo_equipo']; 
    $id_marca = $datos['marca'];             
    $id_tecnico = $datos['tecnico_asignado'] ?? 1; 

    try {
        // TABLA 1: CLIENTES
        $stmt1 = $conexion->prepare("INSERT INTO clientes (nombre, apellido, telefono, correo) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("ssss", $datos['nombre_cliente'], $datos['apellido_cliente'], $telefono, $datos['correo_cliente']);
        $stmt1->execute();
        $id_cliente = $conexion->insert_id;

        // TABLA 2: EQUIPOS (Actualizado con tu nueva consulta)
        $stmt2 = $conexion->prepare("INSERT INTO equipos (id_cliente, id_marca, id_tipo_equipo, modelo, numero_serie) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("iiiss", $id_cliente, $id_marca, $id_tipo_equipo, $datos['modelo'], $datos['numero_serie']);
        $stmt2->execute();
        $id_equipo = $conexion->insert_id;

        // TABLA 3: ORDENES DE INGRESO
        $stmt3 = $conexion->prepare("INSERT INTO ordenes_ingreso (folio, id_equipo, id_tecnico, id_gabinete, fecha_ingreso, condicion_fisica, accesorios_entregados, descripcion_problema, observaciones_recepcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param("siissssss", $datos['folio'], $id_equipo, $id_tecnico, $datos['espacio_almacenamiento'], $datos['fecha_ingreso'], $condicion_txt, $accesorios_txt, $datos['motivo_ingreso'], $datos['observaciones_equipo']);
        $stmt3->execute();

        // TABLA 4: CONDICIONES DE SERVICIO
        $stmt4 = $conexion->prepare("INSERT INTO condiciones_servicio (folio_orden, autoriza_revision_costo, tiempo_estimado, recordatorio_anticipo, dudas_cliente) VALUES (?, ?, ?, ?, ?)");
        $stmt4->bind_param("sssss", $datos['folio'], $datos['autoriza_revision'], $datos['tiempo_estimado'], $recordatorio_pago, $datos['dudas_cliente']);
        $stmt4->execute();

        // TABLA 5: MARKETING
        $stmt5 = $conexion->prepare("INSERT INTO marketing (folio_orden, id_medio_contacto, recibir_promociones, id_tipo_uso, es_primera_vez, id_frecuencia_servicio) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param("sisisi", $datos['folio'], $id_origen, $datos['promociones'], $id_uso, $datos['primera_vez'], $id_frecuencia);
        $stmt5->execute();

        // ==========================================
        // 6. ACTUALIZAR ESTADO DEL GABINETE
        // ==========================================
        $stmt6 = $conexion->prepare("UPDATE gabinetes SET estado = 'ocupado' WHERE id_gabinete = ?");
        $stmt6->bind_param("s", $datos['espacio_almacenamiento']);
        $stmt6->execute();

        // Limpiamos memoria y terminamos
        unset($_SESSION['memoria_ingreso']);
        
        $ruta_actual = $_SERVER['PHP_SELF'];
        echo "<script>alert('¡Registro completado! El equipo y el cliente han sido guardados en la base de datos.'); window.location.href='$ruta_actual';</script>";
        exit;

    } catch (Exception $e) {
        echo "<script>alert('Error de Base de Datos: " . $e->getMessage() . "');</script>";
    }
}

// ==========================================
// 3. CONTROL DE LA NAVEGACIÓN (PASOS)
// ==========================================
$paso = isset($_POST['step']) ? (int) $_POST['step'] : 1;
if ($paso < 1) $paso = 1;
if ($paso > 5) $paso = 5;

// ==========================================
// 4. CONSULTAS DINÁMICAS (TÉCNICOS Y GABINETES)
// ==========================================
$query_tecnicos = $conexion->query("SELECT id_empleado, nombre, apellido FROM empleados WHERE id_puesto = 1");

// Nueva consulta para Marcas
$query_marcas = $conexion->query("SELECT id_marca, marca FROM marcas ORDER BY marca ASC");

// Nueva consulta para Tipos de Equipo
$query_tipos = $conexion->query("SELECT id_tipo_equipo, tipo FROM tipos_equipo ORDER BY tipo ASC");

// Consulta de Relaciones Equipo-Marca
$query_relaciones = $conexion->query("SELECT id_tipo_equipo, id_marca FROM relacion_equipo_marca");
$relaciones = [];
if ($query_relaciones) {
    while ($row = $query_relaciones->fetch_assoc()) {
        $relaciones[$row['id_tipo_equipo']][] = $row['id_marca'];
    }
}
$json_relaciones = json_encode($relaciones);

// Consulta de gabinetes (la que ya tenías...)
$query_gabinetes = $conexion->query("SELECT id_gabinete, tipo_espacio FROM gabinetes WHERE estado = 'disponible' ORDER BY id_gabinete ASC");$gabinetes_disponibles = [
    'laptop' => [],
    'computadora_escritorio' => [],
    'otro' => [] 
];
if ($query_gabinetes) {
    while ($row = $query_gabinetes->fetch_assoc()) {
        $gabinetes_disponibles[$row['tipo_espacio']][] = $row['id_gabinete'];
    }
}
$json_gabinetes = json_encode($gabinetes_disponibles);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>As Tech Computer - Registro de Ingreso</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/ingreso.css">
  <link rel="stylesheet" href="../../public/css/toolbar.css">
  <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        <h1>Datos del cliente</h1>
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

      <?php elseif ($paso == 2): ?>
        <h1>Revisión física y control interno</h1>
        <div class="fila-doble" style="max-height: none; grid-template-columns: 1fr 1fr;">
          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Fecha de ingreso</label>
            <p class="nota-formulario">Fecha en la que se entregó el dispositivo</p>
            <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="campo-texto" value="<?php echo date('Y-m-d'); ?>" required>
          </div>

          <div class="grupo-entrada">
            <label class="etiqueta-formulario">Tipo para Almacenaje</label>
            <p class="nota-formulario">Define si usará nomenclatura numérica o de letras</p>
            <select name="tipo_almacenamiento" id="tipo_almacenamiento" class="campo-texto" required>
              <option value="">Seleccione tipo...</option>
              <option value="laptop">Laptop (Numéricos)</option>
              <option value="computadora_escritorio">PC de Escritorio (Letras)</option>
              <option value="otro">Consola (Letras)</option>
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
            <input type="text" name="folio" id="folio_auto" class="campo-texto" readonly required>
          </div>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Condición física al ingreso</label>
          <p class="nota-formulario">Condición (problemas) que presentaba el dispositivo al ser entregado</p>
          <div class="plano-checkboxs">
            <label class="check-item"><input type="checkbox" name="condicion[]" value="enciende"> Enciende correctamente</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="pantalla_rota"> Pantalla rota o dañada</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="rayones"> Rayones o golpes visibles</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="sucio"> Sucio / con polvo</label>
            <label class="check-item"><input type="checkbox" name="condicion[]" value="faltan_piezas"> Falta de piezas / tornillos</label>
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
            <?php
            if ($query_tecnicos && $query_tecnicos->num_rows > 0) {
                $query_tecnicos->data_seek(0); 
                while ($tecnico = $query_tecnicos->fetch_assoc()) {
                    echo '<option value="' . $tecnico['id_empleado'] . '">' . htmlspecialchars($tecnico['nombre'] . ' ' . $tecnico['apellido']) . '</option>';
                }
            }
            ?>
          </select>
        </div>

        <div class="grupo-entrada">
          <label class="etiqueta-formulario">Observaciones del equipo</label>
          <p class="nota-formulario">Observaciones de recepción: fallas, detalles de funcionamiento, características únicas.</p>
          <textarea name="observaciones_equipo" class="campo-texto" rows="3" required></textarea>
        </div>

        <div class="form-acciones">
          <button type="submit" name="step" value="1" class="boton-anterior">Anterior</button>
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
          <button type="submit" name="step" value="2" class="boton-anterior">Anterior</button>
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
          <button type="submit" name="step" value="3" class="boton-anterior">Anterior</button>
          <button type="submit" name="step" value="5" class="boton-sig">Siguiente</button>
        </div>
      <?php elseif ($paso == 5): ?>
        <h1>Información esencial del equipo</h1>
        <p class="nota-formulario" style="text-align: center;">Esta sección se puede llenar en ausencia del cliente</p>

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
          <button type="submit" name="step" value="4" class="boton-anterior">Anterior</button>
          <button type="submit" name="finalizar_registro" class="boton-sig" style="width: 200px;">Finalizar Registro</button>
        </div>
      <?php endif; ?>
    </form>
  </div>

  <script>
      const espaciosDB = <?php echo isset($json_gabinetes) ? $json_gabinetes : '{}'; ?>;
      const relacionesEquipoMarca = <?php echo isset($json_relaciones) ? $json_relaciones : '{}'; ?>;
  </script>
  
  <script src="../../public/js/ingreso.js"></script>
</body>
</html>