<?php
// Requerimos el modelo de estadísticas
require_once dirname(__DIR__, 2) . '/models/estadisticas_model.php';
$modeloEstadisticas = new EstadisticasModel($conexion);

// 1. Dispositivos
$datosDispositivos = [];
$res = $modeloEstadisticas->obtenerDispositivos();
if ($res) { while($f = $res->fetch_assoc()) { $datosDispositivos[] = $f; } }

// 2. Marketing (Medios)
$datosMarketing = [];
$resM = $modeloEstadisticas->obtenerMedios();
if ($resM) { while($f = $resM->fetch_assoc()) { $datosMarketing[] = $f; } }

// 3. Frecuencia
$datosFrecuencia = [];
$resF = $modeloEstadisticas->obtenerFrecuencia();
if ($resF) { while($f = $resF->fetch_assoc()) { $datosFrecuencia[] = $f; } }

// 4. Uso del equipo
$datosUso = [];
$resU = $modeloEstadisticas->obtenerUso();
if ($resU) { while($f = $resU->fetch_assoc()) { $datosUso[] = $f; } }

// 5. Nuevos vs Recurrentes
$datosNuevos = [];
$resN = $modeloEstadisticas->obtenerNuevosRecurrentes();
if ($resN) { 
    while($f = $resN->fetch_assoc()) { 
        // Cambiamos "si/no" por etiquetas legibles
        $f['etiqueta'] = ($f['etiqueta'] == 'si') ? 'Primera vez' : 'Cliente frecuente';
        $datosNuevos[] = $f; 
    } 
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="contenedor-seccion">
    <h2><i class="fa-solid fa-chart-pie"></i> Inteligencia de Negocios</h2>
    <p>Visualización de datos recolectados de los clientes.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-top: 30px;">
        
        <div style="background:white; padding:20px; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h3 style="text-align:center; color:#4a148c; margin-bottom:15px; font-size: 1.1rem;">Equipos Recibidos</h3>
            <canvas id="chartEquipos"></canvas>
        </div>

        <div style="background:white; padding:20px; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h3 style="text-align:center; color:#4a148c; margin-bottom:15px; font-size: 1.1rem;">Tipo de Uso</h3>
            <canvas id="chartUso"></canvas>
        </div>

        <div style="background:white; padding:20px; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h3 style="text-align:center; color:#4a148c; margin-bottom:15px; font-size: 1.1rem;">Frecuencia de Servicio</h3>
            <canvas id="chartFrecuencia"></canvas>
        </div>

        <div style="background:white; padding:20px; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h3 style="text-align:center; color:#4a148c; margin-bottom:15px; font-size: 1.1rem;">¿Cómo nos conocieron?</h3>
            <canvas id="chartMarketing"></canvas>
        </div>

        <div style="background:white; padding:20px; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h3 style="text-align:center; color:#4a148c; margin-bottom:15px; font-size: 1.1rem;">Fidelidad de Clientes</h3>
            <canvas id="chartNuevos"></canvas>
        </div>

    </div>
</div>

<script>
    // Paletas de colores institucionales
    const colorPrimario = ['#e17203', '#4a148c', '#8e44ad', '#34495e', '#bdc3c7', '#f39c12'];
    const colorSecundario = ['#8e44ad', '#bdc3c7'];

    // 1. Equipos (Dona)
    new Chart(document.getElementById('chartEquipos'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_column($datosDispositivos, 'etiqueta')); ?>,
            datasets: [{ data: <?php echo json_encode(array_column($datosDispositivos, 'total')); ?>, backgroundColor: colorPrimario }]
        }
    });

    // 2. Tipo de Uso (Pastel)
    new Chart(document.getElementById('chartUso'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_column($datosUso, 'etiqueta')); ?>,
            datasets: [{ data: <?php echo json_encode(array_column($datosUso, 'total')); ?>, backgroundColor: colorPrimario }]
        }
    });

    // 3. Frecuencia (Dona)
    new Chart(document.getElementById('chartFrecuencia'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_column($datosFrecuencia, 'etiqueta')); ?>,
            datasets: [{ data: <?php echo json_encode(array_column($datosFrecuencia, 'total')); ?>, backgroundColor: colorPrimario }]
        }
    });

    // 4. Marketing (Barras)
    new Chart(document.getElementById('chartMarketing'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($datosMarketing, 'etiqueta')); ?>,
            datasets: [{ label: 'Clientes', data: <?php echo json_encode(array_column($datosMarketing, 'total')); ?>, backgroundColor: '#e17203' }]
        },
        options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });

    // 5. Fidelidad (Pastel)
    new Chart(document.getElementById('chartNuevos'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_column($datosNuevos, 'etiqueta')); ?>,
            datasets: [{ data: <?php echo json_encode(array_column($datosNuevos, 'total')); ?>, backgroundColor: colorSecundario }]
        }
    });
</script>