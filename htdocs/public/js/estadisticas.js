// ========================================================
// estadisticas.js
// UBICACIÓN: public/js/estadisticas.js
//
// Inicializa las 5 gráficas de Chart.js usando los datos
// que el controlador PHP inyecta en la página como variables
// globales de JavaScript (dentro de un bloque <script> en
// la vista, justo antes de incluir este archivo).
//
// Variables esperadas desde la vista:
//   dataDispositivos  → { labels, data }
//   dataMarketing     → { labels, data }
//   dataFrecuencia    → { labels, data }
//   dataUso           → { labels, data }
//   dataNuevos        → { labels, data }
// ========================================================


// ----------------------------------------------------------
// PALETAS DE COLOR INSTITUCIONALES
// colorPrimario: para gráficas con múltiples categorías
// colorSecundario: para gráficas de solo 2 categorías
// ----------------------------------------------------------
const colorPrimario   = ['#e17203', '#4a148c', '#8e44ad', '#34495e', '#bdc3c7', '#f39c12'];
const colorSecundario = ['#8e44ad', '#bdc3c7'];


// ----------------------------------------------------------
// GRÁFICA 1: Equipos Recibidos (Dona)
// Muestra qué tipos de dispositivos llegan más al taller
// ----------------------------------------------------------
new Chart(document.getElementById('chartEquipos'), {
    type: 'doughnut',
    data: {
        labels: dataDispositivos.labels,
        datasets: [{
            data: dataDispositivos.data,
            backgroundColor: colorPrimario
        }]
    }
});


// ----------------------------------------------------------
// GRÁFICA 2: Tipo de Uso (Pastel)
// Muestra para qué usan sus equipos los clientes
// (Gaming, Trabajo, Diseño, etc.)
// ----------------------------------------------------------
new Chart(document.getElementById('chartUso'), {
    type: 'pie',
    data: {
        labels: dataUso.labels,
        datasets: [{
            data: dataUso.data,
            backgroundColor: colorPrimario
        }]
    }
});


// ----------------------------------------------------------
// GRÁFICA 3: Frecuencia de Servicio (Dona)
// Muestra con qué regularidad los clientes traen sus equipos
// ----------------------------------------------------------
new Chart(document.getElementById('chartFrecuencia'), {
    type: 'doughnut',
    data: {
        labels: dataFrecuencia.labels,
        datasets: [{
            data: dataFrecuencia.data,
            backgroundColor: colorPrimario
        }]
    }
});


// ----------------------------------------------------------
// GRÁFICA 4: ¿Cómo nos conocieron? (Barras)
// Muestra la efectividad de cada canal de marketing.
// Usamos barras para facilitar la comparación entre medios.
// ----------------------------------------------------------
new Chart(document.getElementById('chartMarketing'), {
    type: 'bar',
    data: {
        labels: dataMarketing.labels,
        datasets: [{
            label: 'Clientes',
            data: dataMarketing.data,
            backgroundColor: '#e17203'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                // stepSize: 1 para que el eje Y muestre solo enteros
                ticks: { stepSize: 1 }
            }
        }
    }
});


// ----------------------------------------------------------
// GRÁFICA 5: Fidelidad de Clientes (Pastel)
// Muestra la proporción entre clientes nuevos y recurrentes
// ----------------------------------------------------------
new Chart(document.getElementById('chartNuevos'), {
    type: 'pie',
    data: {
        labels: dataNuevos.labels,
        datasets: [{
            data: dataNuevos.data,
            backgroundColor: colorSecundario
        }]
    }
});