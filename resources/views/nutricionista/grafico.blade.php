<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Citas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="chartCanvas" width="800" height="400"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chartCanvas').getContext('2d');
            
            // Datos dinámicos (estos se pueden pasar desde el backend)
            const asistieron = {{ $asistieron }};
            const noAsistieron = {{ $noAsistieron }};
            
            const chart = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico: barras
                data: {
                    labels: ['Asistieron', 'No Asistieron'], // Etiquetas del eje X
                    datasets: [{
                        label: 'Citas',
                        data: [asistieron, noAsistieron], // Datos del gráfico
                        backgroundColor: ['#28a745', '#dc3545'], // Colores de las barras
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false // Ocultar leyenda
                        },
                        title: {
                            display: true,
                            text: 'Reporte de Citas' // Título del gráfico
                        }
                    }
                }
            });

            // Exportar gráfico como imagen después de cargar
            setTimeout(() => {
                const imgUrl = chart.toDataURL('image/png'); // Generar URL de imagen
                const downloadLink = document.createElement('a');
                downloadLink.href = imgUrl;
                downloadLink.download = 'grafico_citas.png'; // Nombre del archivo
                downloadLink.click(); // Descargar automáticamente
            }, 1000); // Esperar un segundo para generar la imagen
        });
    </script>
</body>
</html>
