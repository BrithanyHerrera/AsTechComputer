<?php
// ========================================================
// VISTA: estadisticas.php
// UBICACIÓN: app/views/secciones/estadisticas.php
//
// Responsabilidad: SOLO dibuja el HTML de las gráficas.
// Variables disponibles desde el controlador:
//   $json_dispositivos / $json_dispositivos_total
//   $json_marketing    / $json_marketing_total
//   $json_frecuencia   / $json_frecuencia_total
//   $json_uso          / $json_uso_total
//   $json_nuevos       / $json_nuevos_total
// ========================================================
require_once __DIR__ . "/../../controllers/estadisticas_controller.php";
?>

<!-- Librería de gráficas (Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Estilos propios de esta sección -->
<link rel="stylesheet" href="../../public/css/estadisticas.css">

<div class="contenedor-estadisticas">
    <h2><i class="fa-solid fa-chart-pie"></i> Inteligencia de Negocios</h2>
    <p>Visualización de datos recolectados de los clientes.</p>

    <!-- Grid responsive de tarjetas, una por gráfica -->
    <div class="grid-graficas">

        <!-- Tarjeta 1: Tipos de dispositivos recibidos -->
        <div class="tarjeta-grafica">
            <h3>Equipos Recibidos</h3>
            <canvas id="chartEquipos"></canvas>
        </div>

        <!-- Tarjeta 2: Para qué usan sus equipos -->
        <div class="tarjeta-grafica">
            <h3>Tipo de Uso</h3>
            <canvas id="chartUso"></canvas>
        </div>

        <!-- Tarjeta 3: Con qué frecuencia hacen servicio -->
        <div class="tarjeta-grafica">
            <h3>Frecuencia de Servicio</h3>
            <canvas id="chartFrecuencia"></canvas>
        </div>

        <!-- Tarjeta 4: Cómo conocieron el taller -->
        <div class="tarjeta-grafica">
            <h3>¿Cómo nos conocieron?</h3>
            <canvas id="chartMarketing"></canvas>
        </div>

        <!-- Tarjeta 5: Clientes nuevos vs recurrentes -->
        <div class="tarjeta-grafica">
            <h3>Fidelidad de Clientes</h3>
            <canvas id="chartNuevos"></canvas>
        </div>

    </div>
</div>

<!--
    Puente de datos PHP → JavaScript
    El controlador preparó variables $json_* con los datos
    de cada gráfica. Aquí las pasamos como objetos JS globales
    para que estadisticas.js pueda leerlas sin hacer fetch.
-->
<script>
    const dataDispositivos = {
        labels: <?= $json_dispositivos ?>,
        data:   <?= $json_dispositivos_total ?>
    };
    const dataMarketing = {
        labels: <?= $json_marketing ?>,
        data:   <?= $json_marketing_total ?>
    };
    const dataFrecuencia = {
        labels: <?= $json_frecuencia ?>,
        data:   <?= $json_frecuencia_total ?>
    };
    const dataUso = {
        labels: <?= $json_uso ?>,
        data:   <?= $json_uso_total ?>
    };
    const dataNuevos = {
        labels: <?= $json_nuevos ?>,
        data:   <?= $json_nuevos_total ?>
    };
</script>

<!-- JS externo: inicializa las 5 gráficas con los datos de arriba -->
<script src="../../public/js/estadisticas.js"></script>