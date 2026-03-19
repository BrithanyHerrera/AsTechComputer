<?php
// ==================================================================
// VISTA DE GESTIÓN - AS TECH COMPUTER (CON FILTROS DINÁMICOS)
// ==================================================================

$ingresos_ejemplo = [
    [
        'folio' => '120326-01',
        'id_gabinete' => '10',
        'nombre' => 'Brithany',
        'apellido' => 'Herrera',
        'whatsapp' => '3227790871',
        'modelo' => 'TUF GAMING F15',
        'marca' => 'Asus',
        'tipo' => 'Laptop',
        'numero_serie' => 'SN-98765X',
        'fecha_ingreso' => '2026-03-12',
        'hora_ingreso' => '10:30',
        'descripcion_problema' => 'Mantenimiento preventivo.',
        'condicion_fisica' => 'Enciende perfectamente.',
        'accesorios_entregados' => 'Cargador',
        'observaciones_recepcion' => 'Calentamiento.',
        'estado' => 'pendiente'
    ],
    [
        'folio' => '130326-A',
        'id_gabinete' => 'A',
        'nombre' => 'Ferdán',
        'apellido' => 'Garrigós',
        'whatsapp' => '3221234567',
        'modelo' => 'Xbox Series X',
        'marca' => 'Microsoft',
        'tipo' => 'Consola',
        'numero_serie' => 'XBX-5544',
        'fecha_ingreso' => '2026-03-13',
        'hora_ingreso' => '14:20',
        'descripcion_problema' => 'No da imagen.',
        'condicion_fisica' => 'Buen estado.',
        'accesorios_entregados' => 'Control y HDMI',
        'observaciones_recepcion' => 'Posible puerto dañado.',
        'estado' => 'en proceso'
    ]
];
?>

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
                    <option value="pendiente">Pendiente</option>
                    <option value="en proceso">En proceso</option>
                    <option value="listo">Listo</option>
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
                <?php foreach ($ingresos_ejemplo as $row): ?>
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

<script>
function filtrarTabla() {
    const busqueda = document.getElementById('buscadorGlobal').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const fecha = document.getElementById('filtroFecha').value;
    const filas = document.querySelectorAll('.fila-registro');

    filas.forEach(fila => {
        const txtNombre = fila.getAttribute('data-nombre');
        const txtFolio = fila.getAttribute('data-folio');
        const txtEstado = fila.getAttribute('data-estado');
        const txtFecha = fila.getAttribute('data-fecha');

        const coincideBusqueda = txtNombre.includes(busqueda) || txtFolio.includes(busqueda);
        const coincideEstado = estado === 'todos' || txtEstado === estado;
        const coincideFecha = !fecha || txtFecha === fecha;

        if (coincideBusqueda && coincideEstado && coincideFecha) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
}

function limpiarFiltros() {
    document.getElementById('buscadorGlobal').value = '';
    document.getElementById('filtroEstado').value = 'todos';
    document.getElementById('filtroFecha').value = '';
    filtrarTabla();
}

function verDetalles(datos) {
    document.getElementById('det_folio').innerText = "Folio: " + datos.folio;
    document.getElementById('det_nombre').innerText = datos.nombre + " " + datos.apellido;
    document.getElementById('det_wa').innerText = datos.whatsapp;
    document.getElementById('det_serie').innerText = datos.numero_serie;
    document.getElementById('det_condicion').innerText = datos.condicion_fisica;
    document.getElementById('det_accesorios').innerText = datos.accesorios_entregados;
    document.getElementById('det_observaciones').innerText = datos.observaciones_recepcion;
    document.getElementById('modalDetalles').style.display = 'flex';
}

function cerrarModal() { document.getElementById('modalDetalles').style.display = 'none'; }
window.onclick = function(e) { if(e.target == document.getElementById('modalDetalles')) cerrarModal(); }
</script>

<style>
/* Estilos CRUD y Filtros */
.contenedor-ingresos { padding: 25px; background: #fff; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
.encabezado-crud h1 { color: #52073a; margin-bottom: 20px; font-size: 1.6rem; border-left: 5px solid #e17203; padding-left: 15px; }

.barra-filtros { 
    display: flex; 
    gap: 20px; 
    background: #f9f9f9; 
    padding: 15px; 
    border-radius: 10px; 
    margin-bottom: 20px;
    align-items: center;
    flex-wrap: wrap;
}

.filtro-grupo { display: flex; align-items: center; gap: 10px; }
.filtro-grupo label { font-weight: bold; color: #555; font-size: 0.9rem; }
.filtro-grupo input, .filtro-grupo select { 
    padding: 8px 12px; 
    border: 1px solid #ddd; 
    border-radius: 8px; 
    outline: none;
    font-size: 0.85rem;
}

.btn-limpiar { background: #666; color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: 0.3s; }
.btn-limpiar:hover { background: #333; }

/* Tabla y Badges */
.tabla-admin { width: 100%; border-collapse: collapse; }
.tabla-admin th { background: #f4f4f4; padding: 15px 12px; text-align: left; font-size: 0.85rem; color: #444; text-transform: uppercase; }
.tabla-admin td { padding: 15px 12px; border-bottom: 1px solid #eee; font-size: 0.9rem; }

.badge-folio { background: #eee; padding: 4px 8px; border-radius: 5px; font-family: monospace; font-weight: bold; }

/* Pills de Estado */
.status-pill { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; }
.pendiente { background: #fff3cd; color: #856404; }
.en-proceso { background: #cce5ff; color: #004085; }
.listo { background: #d4edda; color: #155724; }

.btn-ver { background: #52073a; color: white; border: none; padding: 8px; border-radius: 6px; cursor: pointer; }
.btn-editar { background: #e17203; color: white; border: none; padding: 8px; border-radius: 6px; cursor: pointer; }

/* Modal */
.modal-personalizado { position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: none; align-items: center; justify-content: center; }
.contenido-modal { background: white; padding: 30px; border-radius: 20px; width: 90%; max-width: 650px; position: relative; }
.seccion-det h3 { color: #e17203; font-size: 1rem; margin-bottom: 10px; border-bottom: 2px solid #f9f9f9; }
.cerrar-modal { position: absolute; right: 20px; top: 15px; font-size: 28px; cursor: pointer; color: #bbb; }
</style>