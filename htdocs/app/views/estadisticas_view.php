<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas | As Tech</title>
    <link rel="stylesheet" href="../../public/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="contenedor-admin">
        <main class="contenido-principal">
            <h1>Análisis de Negocio As Tech</h1>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
                <div class="tarjeta-grafica" style="background:white; padding:20px; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <h3>Distribución de Equipos</h3>
                    <canvas id="chartEquipos"></canvas>
                </div>

                <div class="tarjeta-grafica" style="background:white; padding:20px; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <h3>Efectividad de Marketing</h3>
                    <canvas id="chartMarketing"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script>
        const colorATC = ['#e17203', '#4a148c', '#8e44ad', '#34495e', '#bdc3c7'];

        // Gráfica de Equipos (Dona)
        new Chart(document.getElementById('chartEquipos'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($datosDispositivos, 'etiqueta')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($datosDispositivos, 'total')); ?>,
                    backgroundColor: colorATC
                }]
            }
        });

        // Gráfica de Marketing (Barras)
        new Chart(document.getElementById('chartMarketing'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($datosMarketing, 'etiqueta')); ?>,
                datasets: [{
                    label: 'Cantidad de Clientes',
                    data: <?php echo json_encode(array_column($datosMarketing, 'total')); ?>,
                    backgroundColor: '#4a148c'
                }]
            }
        });
    </script>
</body>
</html>