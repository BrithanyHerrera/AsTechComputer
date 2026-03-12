<?php
// ==================================================================
// VISTA DE PREVIA - AS TECH COMPUTER (DATOS DE EJEMPLO)
// ==================================================================
// Nota: Se usa un array manual porque la columna 'estado' aún no existe en la DB.

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
        'fecha_ingreso' => '2026-03-12 10:30:00',
        'descripcion_problema' => 'Mantenimiento preventivo y limpieza de ventiladores.',
        'condicion_fisica' => 'Enciende, rayones leves en tapa.',
        'accesorios_entregados' => 'Cargador original',
        'observaciones_recepcion' => 'El cliente reporta calentamiento excesivo.',
        'estado' => 'pendiente'
    ]
];
?>

<div class="contenedor-ingresos">
    <div class="encabezado-crud">
        <h1><i class="fa-solid fa-microchip"></i> Gestión de Equipos Ingresados</h1>
    </div>

    <div class="tabla-responsiva">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>Gabinete</th>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Dispositivo</th>
                    <th>Falla</th>
                    <th>Ingreso</th>
                    <th>Estado</th>
                    <th>Entregado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ingresos_ejemplo as $row): ?>
                <tr>
                    <td><strong><?= $row['id_gabinete'] ?></strong></td>
                    <td><?= $row['folio'] ?></td>
                    <td><strong><?= $row['nombre'] . " " . $row['apellido'] ?></strong><br><small><?= $row['whatsapp'] ?></small></td>
                    <td><?= $row['tipo'] ?> - <?= $row['marca'] ?><br><small><?= $row['modelo'] ?></small></td>
                    <td><span class="falla-txt"><?= substr($row['descripcion_problema'], 0, 25) ?>...</span></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['fecha_ingreso'])) ?></td>
                    
                    <td>
                        <select class="select-estado">
                            <option value="pendiente" selected>Pendiente</option>
                            <option value="en proceso">En proceso</option>
                            <option value="listo">Listo</option>
                        </select>
                    </td>

                    <td style="text-align:center;">
                        <input type="checkbox" class="check-finalizar" onclick="alert('Funcionalidad de entrega activada para: <?= $row['folio'] ?>')">
                    </td>

                    <td class="acciones">
                        <button class="btn-ver" onclick='verDetalles(<?= json_encode($row) ?>)' title="Ver detalles completos">
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
                <h3><i class="fa-solid fa-clipboard-check"></i> Observaciones de Recepción</h3>
                <p id="det_observaciones"></p>
            </div>
        </div>
    </div>
</div>

<script>
function verDetalles(datos) {
    document.getElementById('det_folio').innerText = "Expediente Folio: " + datos.folio;
    document.getElementById('det_nombre').innerText = datos.nombre + " " + datos.apellido;
    document.getElementById('det_wa').innerText = datos.whatsapp;
    document.getElementById('det_serie').innerText = datos.numero_serie;
    document.getElementById('det_condicion').innerText = datos.condicion_fisica;
    document.getElementById('det_accesorios').innerText = datos.accesorios_entregados;
    document.getElementById('det_observaciones').innerText = datos.observaciones_recepcion;
    
    document.getElementById('modalDetalles').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modalDetalles').style.display = 'none';
}

window.onclick = function(e) {
    if(e.target == document.getElementById('modalDetalles')) cerrarModal();
}
</script>

<style>
/* Estilos Base As Tech Computer */
.contenedor-ingresos { padding: 20px; background: #fff; border-radius: 12px; }
.encabezado-crud h1 { color: #52073a; margin-bottom: 20px; font-size: 1.5rem; border-left: 5px solid #e17203; padding-left: 15px; }

.tabla-admin { width: 100%; border-collapse: collapse; }
.tabla-admin th { background: #f8f9fa; padding: 12px; text-align: left; font-size: 0.8rem; color: #666; text-transform: uppercase; border-bottom: 2px solid #eee; }
.tabla-admin td { padding: 12px; border-bottom: 1px solid #f0f0f0; font-size: 0.85rem; vertical-align: middle; }

.select-estado { padding: 5px; border-radius: 6px; border: 1px solid #ddd; font-size: 0.8rem; }
.check-finalizar { transform: scale(1.2); cursor: pointer; accent-color: #28a745; }

.btn-ver { background: #007bff; color: white; border: none; padding: 7px 10px; border-radius: 6px; cursor: pointer; }
.btn-editar { background: #e17203; color: white; border: none; padding: 7px 10px; border-radius: 6px; cursor: pointer; }
.falla-txt { color: #666; font-style: italic; }

/* Estilos Modal */
.modal-personalizado { position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; align-items: center; justify-content: center; }
.contenido-modal { background: white; padding: 25px; border-radius: 15px; width: 90%; max-width: 600px; position: relative; border-top: 5px solid #52073a; }
.grid-detalles { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px; text-align: left; }
.seccion-det-full { grid-column: span 2; margin-top: 10px; }
.seccion-det h3, .seccion-det-full h3 { font-size: 0.9rem; color: #e17203; margin-bottom: 8px; border-bottom: 1px solid #eee; }
.cerrar-modal { position: absolute; right: 15px; top: 10px; font-size: 25px; cursor: pointer; color: #999; }
</style>