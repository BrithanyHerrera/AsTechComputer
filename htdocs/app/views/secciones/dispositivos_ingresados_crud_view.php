<?php
// ========================================================
// VISTA: dispositivos_ingresados_crud_view.php
// UBICACIÓN: app/views/secciones/dispositivos_ingresados_crud_view.php
//
// Responsabilidad: SOLO dibuja el HTML.
// Todas las variables vienen preparadas desde el controlador:
//   $lista_registros  → array con todos los registros del JOIN
//   $puesto_usuario   → id_puesto del empleado logueado
//                       (controla qué columnas y botones se muestran)
// ========================================================
require_once __DIR__ . "/../../controllers/dispositivos_ingresados_crud_controller.php";
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../../public/css/registros_crud.css?v=3.0">

<div class="contenedor-ingresos">

    <!-- ====================================================
         ENCABEZADO: Título + barra de filtros
         Los filtros funcionan en el cliente (JavaScript),
         no recargan la página.
    ==================================================== -->
    <div class="encabezado-crud">
        <h1><i class="fa-solid fa-microchip"></i> Dispositivos Ingresados</h1>
        <div class="barra-filtros">

            <!-- Filtro por nombre del cliente o folio -->
            <div class="filtro-grupo">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorGlobal"
                       placeholder="Buscar por Nombre o Folio..."
                       onkeyup="filtrarTabla()">
            </div>

            <!-- Selector de cuántos registros mostrar por página -->
            <div class="filtro-grupo">
                <label>Mostrar:</label>
                <select id="filtroPaginacion" onchange="cambiarFilasPorPagina()">
                    <option value="10">10 registros</option>
                    <option value="25">25 registros</option>
                    <option value="50">50 registros</option>
                    <option value="todos">Todos</option>
                </select>
            </div>

            <!-- Filtro por estado de la orden -->
            <div class="filtro-grupo">
                <label>Estado:</label>
                <select id="filtroEstado" onchange="filtrarTabla()">
                    <option value="todos">Todos los estados</option>
                    <option value="recibido">Recibido</option>
                    <option value="entregado">Entregado</option>
                </select>
            </div>

            <!-- Filtro por fecha de ingreso + botón para limpiar todos los filtros -->
            <div class="filtro-grupo">
                <label>Fecha:</label>
                <input type="date" id="filtroFecha" onchange="filtrarTabla()">
                <button class="btn-limpiar" onclick="limpiarFiltros()" title="Limpiar filtros">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- ====================================================
         TABLA PRINCIPAL
         Cada fila tiene atributos data-* para que el JS
         pueda filtrar y paginar sin recargar la página.
    ==================================================== -->
    <div class="tabla-responsiva">
        <table class="tabla-admin" id="tablaRegistros">
            <thead>
                <tr>
                    <th>Con.</th>       <!-- Contenedor/Gabinete -->
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Dispositivo</th>
                    <th>Falla</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <?php if ($puesto_usuario != 1): ?>
                        <!-- La columna "Entregado" se oculta a los técnicos (puesto 1) -->
                        <th>Entregado</th>
                    <?php endif; ?>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_registros as $row):
                    // Preparar fecha solo (sin hora) para el atributo data-fecha del filtro
                    $solo_fecha = date('Y-m-d', strtotime($row['fecha_ingreso']));

                    // Los técnicos (puesto 1) ven datos de clientes limitados por privacidad
                    $esTecnico = ($puesto_usuario == 1);
                    $nombre_mostrar = $esTecnico
                        ? '<span style="color:red; font-weight:bold;">Confidencial</span>'
                        : "<strong>{$row['nombre']} {$row['apellido']}</strong>";

                    // Preparar objeto para el JS: si es técnico, ocultamos datos sensibles
                    $datos_js = $row;
                    if ($esTecnico) {
                        $datos_js['nombre']   = 'Confidencial';
                        $datos_js['apellido'] = '';
                        $datos_js['whatsapp'] = '***';
                    }
                ?>
                <tr class="fila-registro"
                    data-nombre="<?= strtolower($row['nombre'] . ' ' . $row['apellido']) ?>"
                    data-folio="<?= strtolower($row['folio']) ?>"
                    data-estado="<?= $row['estado'] ?>"
                    data-fecha="<?= $solo_fecha ?>">

                    <td><strong><?= $row['id_gabinete'] ?></strong></td>
                    <td><span class="badge-folio"><?= $row['folio'] ?></span></td>
                    <td><?= $nombre_mostrar ?></td>
                    <td><?= $row['marca'] ?> <?= $row['modelo'] ?></td>
                    <td><span class="falla-txt"><?= $row['descripcion_problema'] ?></span></td>
                    <td><?= date('d/m/Y', strtotime($row['fecha_ingreso'])) ?></td>
                    <td>
                        <span class="status-pill <?= str_replace(' ', '-', $row['estado']) ?>">
                            <?= ucfirst($row['estado']) ?>
                        </span>
                    </td>

                    <?php if (!$esTecnico): ?>
                    <td style="text-align:center;">
                        <?php if ($row['estado'] != 'entregado'): ?>
                            <!-- Checkbox que abre el modal de confirmación de entrega -->
                            <input type="checkbox" class="check-finalizar"
                                   onchange="abrirModalEntregar('<?= $row['folio'] ?>', '<?= $row['id_gabinete'] ?>', this)">
                        <?php else: ?>
                            <!-- Ya entregado: solo ícono visual, no hay acción -->
                            <i class="fa-solid fa-check" style="color:green;"></i>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>

                    <td class="acciones">
                        <!-- Botón Ver: abre modal de solo lectura con todos los detalles -->
                        <button class="btn-ver"
                                onclick='verDetalles(<?= json_encode($datos_js) ?>)'
                                title="Ver detalles">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <?php if (!$esTecnico && $row['estado'] != 'entregado'): ?>
                            <!-- Botón Editar: redirige al formulario de ingreso en modo edición -->
                            <a href="administracion_controller.php?seccion=ingreso&editar=<?= $row['folio'] ?>"
                               class="btn-editar" title="Editar"
                               style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Contenedor donde el JS dibuja los botones de paginación -->
    <div id="controlesPaginacion" class="paginacion-crud"></div>
</div>


<!-- ========================================================
     MODAL: VER DETALLES (solo lectura)
     Se llena dinámicamente por verDetalles() en el JS
======================================================== -->
<div id="modalDetalles" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModal()">&times;</span>
        <h2 id="det_folio">Detalles del Ingreso</h2>
        <div class="grid-detalles">
            <div class="seccion-det">
                <h3><i class="fa-solid fa-user"></i> Información</h3>
                <p><strong>Cliente:</strong> <span id="det_nombre"></span></p>
                <p><strong>WhatsApp:</strong> <span id="det_wa"></span></p>
            </div>
            <div class="seccion-det">
                <h3><i class="fa-solid fa-laptop"></i> Equipo</h3>
                <p><strong>Dispositivo:</strong> <span id="det_equipo"></span></p>
                <p><strong>No. Serie:</strong>   <span id="det_serie"></span></p>
                <p><strong>Falla:</strong>        <span id="det_falla"></span></p>
            </div>
            <div class="seccion-det-full">
                <h3><i class="fa-solid fa-clipboard-check"></i> Revisión Física</h3>
                <p><strong>Condición:</strong>      <span id="det_condicion"></span></p>
                <p><strong>Accesorios:</strong>     <span id="det_accesorios"></span></p>
                <p><strong>Observaciones:</strong>  <span id="det_observaciones"></span></p>
            </div>
        </div>
    </div>
</div>


<!-- ========================================================
     MODAL: EDITAR REGISTRO
     Formulario que envía al controlador con accion=editar.
     Se pre-llena por editarRegistro() en el JS.
======================================================== -->
<div id="modalEditar" class="modal-personalizado" style="display: none;">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModalEditar()">&times;</span>
        <h2 style="color: #e17203; margin-bottom: 20px;">
            <i class="fa-solid fa-pen-to-square"></i> Editar Registro
        </h2>
        <form action="../controllers/dispositivos_ingresados_crud_controller.php?accion=editar" method="POST">
            <!-- Campos ocultos de referencia (no visibles al usuario) -->
            <input type="hidden" name="folio"      id="edit_folio">
            <input type="hidden" name="id_cliente" id="edit_id_cliente">

            <h3 style="color: #4a148c; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                <i class="fa-solid fa-user-pen"></i> Datos del Cliente
            </h3>
            <div class="grid-detalles" style="margin-top: 10px;">
                <div class="grupo-input">
                    <label>Nombre(s):</label>
                    <input type="text" name="nombre_cliente" id="edit_nombre" required>
                </div>
                <div class="grupo-input">
                    <label>Apellido(s):</label>
                    <input type="text" name="apellido_cliente" id="edit_apellido" required>
                </div>
                <div class="grupo-input seccion-det-full">
                    <label>WhatsApp / Teléfono:</label>
                    <input type="text" name="telefono_cliente" id="edit_telefono" required>
                </div>
            </div>

            <h3 style="color: #4a148c; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 10px;">
                <i class="fa-solid fa-laptop-medical"></i> Datos del Ingreso
            </h3>
            <div class="grid-detalles" style="margin-top: 10px;">
                <div class="grupo-input seccion-det-full">
                    <label>Estado de la Orden:</label>
                    <select name="estado" id="edit_estado" required>
                        <option value="recibido">Recibido</option>
                        <option value="entregado">Entregado</option>
                    </select>
                </div>
                <div class="grupo-input seccion-det-full">
                    <label>Condición Física:</label>
                    <input type="text" name="condicion_fisica" id="edit_condicion">
                </div>
                <div class="grupo-input seccion-det-full">
                    <label>Accesorios Entregados:</label>
                    <input type="text" name="accesorios_entregados" id="edit_accesorios">
                </div>
                <div class="grupo-input seccion-det-full">
                    <label>Observaciones de Recepción:</label>
                    <textarea name="observaciones_recepcion" id="edit_observaciones" rows="2"></textarea>
                </div>
            </div>

            <button type="submit" style="width:100%; background:#e17203; color:white; padding:12px; border:none; border-radius:5px; cursor:pointer; font-weight:bold; margin-top:15px; font-size:1rem;">
                Guardar Cambios
            </button>
        </form>
    </div>
</div>


<!-- ========================================================
     MODAL: CONFIRMAR ENTREGA
     Se activa al marcar el checkbox de la columna "Entregado".
     Envía al controlador con accion=entregar.
======================================================== -->
<div id="modalEntregar" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModalEntregar()">&times;</span>
        <h2 style="color: #155724; border-bottom: 2px solid #d4edda; padding-bottom: 10px;">
            <i class="fa-solid fa-check-double"></i> Confirmar Entrega
        </h2>
        <p style="margin-top: 15px; font-size: 1.1rem;">
            ¿Estás seguro de marcar el folio
            <strong id="txt_folio_entregar" class="badge-folio"></strong>
            como ENTREGADO al cliente?
        </p>

        <form action="../controllers/dispositivos_ingresados_crud_controller.php?accion=entregar" method="POST">
            <input type="hidden" id="input_folio_entregar"    name="folio">
            <input type="hidden" id="input_gabinete_entregar" name="id_gabinete">
            <button type="submit" style="width:100%; background:#28a745; color:white; padding:12px; border:none; border-radius:8px; font-weight:bold; font-size:1.1rem; cursor:pointer; margin-top:15px;">
                Sí, Registrar Entrega
            </button>
        </form>
    </div>
</div>

<!-- JS externo: maneja filtros, paginación, modales y alertas -->
<script src="../../public/js/registros_crud.js"></script>