<link rel="stylesheet" href="../../public/css/registros_crud.css">

<div class="contenedor-ingresos">
    <div class="encabezado-crud">
        <h1><i class="fa-solid fa-microchip"></i> Registros Ingresados </h1>
        
        <div class="barra-filtros">
            <div class="filtro-grupo">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorGlobal" placeholder="Buscar por Nombre o Folio..." onkeyup="filtrarTabla()">
            </div>
            
            <div class="filtro-grupo">
                <label>Estado:</label>
                <select id="filtroEstado" onchange="filtrarTabla()">
                    <option value="todos">Todos los estados</option>
                    <option value="recibido">Recibido</option>
                    <option value="entregado">Entregado</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <label>Fecha:</label>
                <input type="date" id="filtroFecha" onchange="filtrarTabla()">
                <button class="btn-limpiar" onclick="limpiarFiltros()" title="Limpiar filtros"><i class="fa-solid fa-rotate-left"></i></button>
            </div>
        </div>
    </div>

    <div class="tabla-responsiva">
        <table class="tabla-admin" id="tablaRegistros">
            <thead>
                <tr>
                    <th>Con.</th>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Dispositivo</th>
                    <th>Falla</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Entregado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_registros as $row): ?>
                <tr class="fila-registro" 
                    data-nombre="<?= strtolower($row['nombre'] . ' ' . $row['apellido']) ?>" 
                    data-folio="<?= strtolower($row['folio']) ?>"
                    data-estado="<?= $row['estado'] ?>"
                    data-fecha="<?= $row['fecha_ingreso'] ?>">
                    
                    <td><strong><?= $row['id_gabinete'] ?></strong></td>
                    <td><span class="badge-folio"><?= $row['folio'] ?></span></td>
                    <td><strong><?= $row['nombre'] . " " . $row['apellido'] ?></strong></td>
                    <td><?= $row['marca'] ?> <?= $row['modelo'] ?></td>
                    <td><span class="falla-txt"><?= $row['descripcion_problema'] ?></span></td>
                    <td><?= date('d/m/Y', strtotime($row['fecha_ingreso'])) ?></td>
                    
                    <td>
                        <span class="status-pill <?= str_replace(' ', '-', $row['estado']) ?>">
                            <?= ucfirst($row['estado']) ?>
                        </span>
                    </td>

                    <td style="text-align:center;">
                        <input type="checkbox" class="check-finalizar">
                    </td>

                    <td class="acciones">
                        <button class="btn-ver" onclick='verDetalles(<?= json_encode($row) ?>)' title="Ver detalles">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn-editar" title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modalDetalles" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModal()">&times;</span>
        <h2 id="det_folio">Detalles del Ingreso</h2>
        <div class="grid-detalles">
            <div class="seccion-det">
                <h3><i class="fa-solid fa-user"></i> Información</h3>
                <p><strong>Cliente:</strong> <span id="det_nombre"></span></p>
                <p><strong>WhatsApp:</strong> <span id="det_wa"></span></p>
                <p><strong>No. Serie:</strong> <span id="det_serie"></span></p>
            </div>
            <div class="seccion-det">
                <h3><i class="fa-solid fa-box"></i> Revisión</h3>
                <p><strong>Condición:</strong> <span id="det_condicion"></span></p>
                <p><strong>Accesorios:</strong> <span id="det_accesorios"></span></p>
            </div>
            <div class="seccion-det-full">
                <h3><i class="fa-solid fa-clipboard-check"></i> Observaciones</h3>
                <p id="det_observaciones"></p>
            </div>
        </div>
    </div>
</div>

<script src="../../public/js/registros_crud.js"></script>