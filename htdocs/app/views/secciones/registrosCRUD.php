<?php
// ==================================================================
// VISTA DE GESTIÓN - AS TECH COMPUTER (CON FILTROS DINÁMICOS)
// ==================================================================
session_start();

// 1. Conexión a la base de datos (ajusta la ruta según tu estructura de carpetas)
require_once dirname(__DIR__, 2) . '/config/conexion.db.php';

// 2. Consulta SQL con JOINs para unir Órdenes, Equipos, Clientes, Marcas y Tipos
$sql = "SELECT 
            o.folio,
            o.id_gabinete,
            o.fecha_ingreso,
            o.descripcion_problema,
            o.condicion_fisica,
            o.accesorios_entregados,
            o.observaciones_recepcion,
            o.estado,
            c.nombre,
            c.apellido,
            c.telefono AS whatsapp,
            e.modelo,
            e.numero_serie,
            m.marca,
            t.tipo
        FROM ordenes_ingreso o
        INNER JOIN equipos e ON o.id_equipo = e.id_equipo
        INNER JOIN clientes c ON e.id_cliente = c.id_cliente
        INNER JOIN marcas m ON e.id_marca = m.id_marca
        INNER JOIN tipos_equipo t ON e.id_tipo_equipo = t.id_tipo_equipo
        ORDER BY o.fecha_ingreso DESC";

$resultado = $conexion->query($sql);
$ingresos = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $ingresos[] = $fila;
    }
}
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
                <?php foreach ($ingresos as $row): 
                    // Separamos la fecha y la hora que vienen juntas de la base de datos
                    $solo_fecha = date('Y-m-d', strtotime($row['fecha_ingreso']));
                    $solo_hora = date('H:i', strtotime($row['fecha_ingreso']));
                ?>
                <tr class="fila-registro" 
                    data-nombre="<?= strtolower($row['nombre'] . ' ' . $row['apellido']) ?>" 
                    data-folio="<?= strtolower($row['folio']) ?>"
                    data-estado="<?= $row['estado'] ?>"
                    data-fecha="<?= $solo_fecha ?>">
                    
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
                        <input type="checkbox" class="check-finalizar" 
                            onchange="abrirModalEntregar('<?= $row['folio'] ?>', '<?= $row['id_gabinete'] ?>', this)">
                    </td>

                    <td class="acciones">
                        <button class="btn-ver" onclick='verDetalles(<?= json_encode($row) ?>)' title="Ver detalles">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn-editar" onclick='editarRegistro(<?= json_encode($row) ?>)' title="Editar">
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

<div id="modalEntregar" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModalEntregar()">&times;</span>
        <h2 style="color: #155724; border-bottom: 2px solid #d4edda; padding-bottom: 10px;">
            <i class="fa-solid fa-check-double"></i> Confirmar Entrega
        </h2>
        
        <p style="margin-top: 15px; font-size: 1.1rem;">¿Estás seguro de marcar el folio <strong id="txt_folio_entregar" class="badge-folio"></strong> como ENTREGADO al cliente?</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-left: 4px solid #e17203; margin: 15px 0;">
            <p style="margin: 0; color: #555; font-size: 0.9rem;">
                <i class="fa-solid fa-circle-info"></i> Esta acción registrará la fecha y hora exacta de salida y <strong>liberará el espacio en el gabinete <span id="txt_gabinete_entregar" style="font-weight: bold; color: #333;"></span></strong> de forma automática.
            </p>
        </div>

        <form action="/Astech/AsTechComputer/htdocs/app/views/acciones/entregar_equipo.php" method="POST">
            <input type="hidden" id="input_folio_entregar" name="folio">
            <input type="hidden" id="input_gabinete_entregar" name="id_gabinete">
            
            <button type="submit" style="width: 100%; background: #28a745; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold; font-size: 1.1rem; cursor: pointer; margin-top: 10px;">
                Sí, Registrar Entrega
            </button>
        </form>
    </div>
</div>

<script>

function abrirModalEntregar(folio, gabinete, checkbox) {
    if (checkbox.checked) {
        // Llenar textos visuales
        document.getElementById('txt_folio_entregar').innerText = folio;
        document.getElementById('txt_gabinete_entregar').innerText = gabinete;
        
        // Llenar inputs ocultos del formulario
        document.getElementById('input_folio_entregar').value = folio;
        document.getElementById('input_gabinete_entregar').value = gabinete;
        
        // Mostrar Modal
        document.getElementById('modalEntregar').style.display = 'flex';
    }
}

function cerrarModalEntregar() {
    document.getElementById('modalEntregar').style.display = 'none';
    // Si cierran el modal (cancelan), desmarcamos el checkbox para evitar confusiones visuales
    const checkboxes = document.querySelectorAll('.check-finalizar');
    checkboxes.forEach(cb => cb.checked = false);
}

// Actualizar el evento para cerrar al hacer clic afuera
window.onclick = function(e) { 
    if(e.target == document.getElementById('modalDetalles')) cerrarModal(); 
    if(e.target == document.getElementById('modalEntregar')) cerrarModalEntregar(); 
}

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

function editarRegistro(datos) {
    // Por ahora pondremos una alerta para comprobar que el botón ya tiene vida
    alert("Vamos a editar el equipo con folio: " + datos.folio);
    
    // Aquí es donde mandaremos llamar al modal de edición cuando lo construyamos
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

/* Pills de Estado Actualizados */
.status-pill { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; }
.recibido { background: #e2e3e5; color: #383d41; }
.en-revision { background: #fff3cd; color: #856404; }
.esperando-refacciones { background: #f8d7da; color: #721c24; }
.reparado { background: #cce5ff; color: #004085; }
.entregado { background: #d4edda; color: #155724; }

.btn-ver { background: #52073a; color: white; border: none; padding: 8px; border-radius: 6px; cursor: pointer; }
.btn-editar { background: #e17203; color: white; border: none; padding: 8px; border-radius: 6px; cursor: pointer; }

/* Modal */
.modal-personalizado { position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: none; align-items: center; justify-content: center; }
.contenido-modal { background: white; padding: 30px; border-radius: 20px; width: 90%; max-width: 650px; position: relative; }
.seccion-det h3 { color: #e17203; font-size: 1rem; margin-bottom: 10px; border-bottom: 2px solid #f9f9f9; }
.cerrar-modal { position: absolute; right: 20px; top: 15px; font-size: 28px; cursor: pointer; color: #bbb; }
</style>