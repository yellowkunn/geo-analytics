<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Grafik</title>

    <style>
        .chart-canvas {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            height: 400px;
        }

        .d-none {
            display: none;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <h3>Statistik Prasarana Jalan</h3>

        <form method="GET" class="mb-4">
            <label for="kabupaten">Pilih Kabupaten/Kota:</label>
            <select name="kabupaten" onchange="this.form.submit()" class="form-select">
                <option value="">Semua Kabupaten/Kota</option>
                @foreach ($kabupatenList as $k)
                    <option value="{{ $k }}" {{ $kabupaten == $k ? 'selected' : '' }}>{{ $k }}
                    </option>
                @endforeach
            </select>
        </form>

        <div class="mb-3">
            <select id="chartSelector" class="form-select w-50">
                <option value="kondisiChart">Kondisi Jalan (km)</option>
                <option value="perkerasanChart">Jenis Perkerasan</option>
                <option value="persentaseChart">Persentase Kondisi Jalan</option>
            </select>
        </div>

        <div>
            <canvas id="kondisiChart" class="chart-canvas"></canvas>
            <canvas id="perkerasanChart" class="chart-canvas d-none"></canvas>
            <canvas id="persentaseChart" class="chart-canvas d-none"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const chartData = @json($grafik);

    let chartInstance = null;

    function renderChart(chartId, type, labels, data, colors) {
        const ctx = document.getElementById(chartId).getContext('2d');
        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: chartId === 'persentaseChart' ? 'Persentase (%)' : 'Panjang Jalan (km)',
                    data: data,
                    backgroundColor: colors
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    const chartSelector = document.getElementById('chartSelector');

    const chartConfigs = {
        kondisiChart: {
            type: 'bar',
            labels: chartData.kondisi.labels,
            data: chartData.kondisi.values,
            colors: ['#28a745', '#ffc107', '#fd7e14', '#dc3545']
        },
        perkerasanChart: {
            type: 'pie',
            labels: chartData.perkerasan.labels,
            data: chartData.perkerasan.values,
            colors: ['#007bff', '#6c757d', '#17a2b8', '#ffc107', '#dc3545']
        },
        persentaseChart: {
            type: 'doughnut',
            labels: chartData.persentase.labels,
            data: chartData.persentase.values,
            colors: ['#28a745', '#ffc107', '#fd7e14', '#dc3545']
        }
    };

    // Awal load default
    renderChart('kondisiChart', chartConfigs.kondisiChart.type, chartConfigs.kondisiChart.labels, chartConfigs.kondisiChart.data, chartConfigs.kondisiChart.colors);

    chartSelector.addEventListener('change', function () {
        const selected = this.value;

        // Hide all canvases
        document.querySelectorAll('.chart-canvas').forEach(el => el.classList.add('d-none'));

        // Show selected canvas
        document.getElementById(selected).classList.remove('d-none');

        // Render ulang grafik dengan animasi
        const config = chartConfigs[selected];
        renderChart(selected, config.type, config.labels, config.data, config.colors);
    });
</script>

</body>

</html>
