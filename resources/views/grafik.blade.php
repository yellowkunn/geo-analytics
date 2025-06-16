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
            min-height: 400px;
            height: 400px;
            position: relative;
        }

        .d-none {
            display: none;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>

    <div class="container">
        <a href="{{ url('/') }}" class="btn btn-primary my-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
    </script>

    <script>
        const chartData = @json($grafik);

        let chartInstance = null;

        function renderChart(chartId, type, labels, data, colors) {
            const canvas = document.getElementById(chartId);
            const ctx = canvas.getContext('2d');

            canvas.width = canvas.clientWidth;
            canvas.height = canvas.clientHeight;

            if (chartInstance) {
                chartInstance.destroy();
                chartInstance = null;
            }

            const isPieOrDoughnut = type === 'pie' || type === 'doughnut';

            // Tentukan satuan untuk formatter
            let formatterSuffix = '';
            if (chartId === 'persentaseChart') {
                formatterSuffix = '%';
            } else if (chartId === 'perkerasanChart') {
                formatterSuffix = ' km';
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
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        // Aktifkan data labels hanya untuk pie/doughnut
                        datalabels: isPieOrDoughnut ? {
                            color: 'auto',
                            font: function(context) {
                                // Ukuran font disesuaikan dengan ukuran slice
                                let value = context.dataset.data[context.dataIndex];
                                let fontSize = value > 20 ? 16 : (value > 5 ? 12 : 10);
                                return {
                                    weight: 'bold',
                                    size: fontSize
                                };
                            },
                            formatter: (value) => {
                                return value.toFixed(1) + formatterSuffix;
                            },
                            clamp: true,
                            anchor: 'center',
                            align: 'center',
                            display: (context) => context.dataset.data[context.dataIndex] >
                                0 // hanya tampil jika ada datanya
                        } : false
                    }
                },
                plugins: isPieOrDoughnut ? [ChartDataLabels] : []
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
        renderChart('kondisiChart', chartConfigs.kondisiChart.type, chartConfigs.kondisiChart.labels, chartConfigs
            .kondisiChart.data, chartConfigs.kondisiChart.colors);

        chartSelector.addEventListener('change', function() {
            const selected = this.value;

            document.querySelectorAll('.chart-canvas').forEach(el => el.classList.add('d-none'));
            document.getElementById(selected).classList.remove('d-none');

            const config = chartConfigs[selected];
            renderChart(selected, config.type, config.labels, config.data, config.colors);
        });
    </script>

</body>

</html>
