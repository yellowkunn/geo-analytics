<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prasarana Jalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 1rem;
        }

        .card-header {
            background: linear-gradient(135deg, #0d6efd, #3b82f6);
            color: white;
            font-weight: bold;
            border-radius: 1rem 1rem 0 0;
        }

        .btn i {
            margin-right: 0.4rem;
        }

        .table thead th {
            background-color: #e9ecef;
            text-align: center;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
            text-align: center;
        }

        .table-responsive {
            max-height: 70vh;
            overflow-y: auto;
        }

        .filter-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .export-group .dropdown-menu {
            min-width: auto;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="card shadow-lg">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa fa-road"></i> Prasarana Jalan - Import & Export</h4>
            </div>
            <div class="card-body">
                @session('success')
                    <div class="alert alert-success">{{ $value }}</div>
                @endsession

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('prasarana-jalan.import') }}" method="POST" enctype="multipart/form-data"
                    class="mb-4">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="file" class="form-control">
                        <button class="btn btn-success" type="submit"><i class="fa fa-file-import"></i> Import</button>
                    </div>
                </form>

                <div class="filter-section mb-3">

                    <button id="lihat-grafik-btn" class="btn btn-primary mb-2">
                        <i class="fa fa-chart-bar"></i> Lihat Grafik
                    </button>


                <script>
                document.getElementById('lihat-grafik-btn').addEventListener('click', function () {
                    const dataCount = {{ $dataJalan->count() }};

                    if (dataCount === 0) {
                        showNoDataAlert();
                    } else {
                        window.location.href = "{{ route('grafik.index') }}";
                    }
                });

                function showNoDataAlert() {
                    const alertBox = document.createElement('div');
                    alertBox.innerHTML = `
                        <div id="custom-alert" class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert"
                            style="
                                position: fixed;
                                top: 20px;
                                left: 50%;
                                transform: translateX(-50%);
                                z-index: 1055;
                                max-width: 500px;
                                width: 90%;
                                text-align: center;
                                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                                padding-right: 3rem;
                            ">
                            <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                <i class="fa fa-exclamation-circle me-2"></i>
                                <span>Tidak ada data untuk ditampilkan.</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%);"></button>
                        </div>
                    `;
                    document.body.appendChild(alertBox);

                    // Auto dismiss after 3 seconds
                    setTimeout(() => {
                        const alertEl = document.getElementById('custom-alert');
                        if (alertEl) {
                            // Trigger fade out before removing
                            alertEl.classList.remove('show');
                            alertEl.classList.add('fade');
                            setTimeout(() => alertEl.remove(), 300);
                        }
                    }, 3000);
                }
            </script>

                    <select id="filter-kabupaten" class="form-select w-auto mb-2">
                        <option value="all">Semua Kabupaten / Kota</option>
                        @foreach ($dataJalan->pluck('kabupaten')->unique() as $kabupaten)
                            <option value="{{ $kabupaten }}">{{ $kabupaten }}</option>
                        @endforeach
                    </select>

                    <div class="btn-group export-group mb-2">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-download"></i> Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item export-link" data-format="excel" href="#">Excel</a></li>
                            <li><a class="dropdown-item export-link" data-format="csv" href="#">CSV</a></li>
                            <li><a class="dropdown-item export-link" data-format="pdf" href="#">PDF</a></li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive rounded border">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No Ruas</th>
                                <th>Kode Ruas</th>
                                <th>Nama Ruas</th>
                                <th>Kabupaten</th>
                                <th>Panjang Ruas (km)</th>
                                <th>Panjang Survey (km)</th>
                                <th>Lebar Ruas (m)</th>
                                <th>Hotmix (km)</th>
                                <th>Lapen (km)</th>
                                <th>Beton (km)</th>
                                <th>Telford/Kerikil (km)</th>
                                <th>Tanah Belum Tembus (km)</th>
                                <th>Baik (km)</th>
                                <th>Baik (%)</th>
                                <th>Sedang (km)</th>
                                <th>Sedang (%)</th>
                                <th>Rusak Ringan (km)</th>
                                <th>Rusak Ringan (%)</th>
                                <th>Rusak Berat (km)</th>
                                <th>Rusak Berat (%)</th>
                                <th>LHR</th>
                                <th>Akses</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataJalan as $jalan)
                                <tr data-kabupaten="{{ $jalan->kabupaten }}">
                                    <td>{{ $jalan->no_ruas }}</td>
                                    <td>{{ $jalan->kode_ruas }}</td>
                                    <td>{{ $jalan->nama_ruas }}</td>
                                    <td>{{ $jalan->kabupaten }}</td>
                                    <td>{{ $jalan->panjang_ruas_km }}</td>
                                    <td>{{ $jalan->panjang_survey_km }}</td>
                                    <td>{{ $jalan->lebar_ruas_m }}</td>
                                    <td>{{ $jalan->perkerasan_hotmix_km }}</td>
                                    <td>{{ $jalan->perkerasan_lapen_km }}</td>
                                    <td>{{ $jalan->perkerasan_beton_km }}</td>
                                    <td>{{ $jalan->telford_kerikil }}</td>
                                    <td>{{ $jalan->tanah_belum_tembus }}</td>
                                    <td>{{ $jalan->kondisi_baik_km }}</td>
                                    <td>{{ $jalan->kondisi_baik_persen }}</td>
                                    <td>{{ $jalan->kondisi_sedang_km }}</td>
                                    <td>{{ $jalan->kondisi_sedang_persen }}</td>
                                    <td>{{ $jalan->kondisi_rusak_ringan_km }}</td>
                                    <td>{{ $jalan->kondisi_rusak_ringan_persen }}</td>
                                    <td>{{ $jalan->kondisi_rusak_berat_km }}</td>
                                    <td>{{ $jalan->kondisi_rusak_berat_persen }}</td>
                                    <td>{{ $jalan->lhr }}</td>
                                    <td>{{ $jalan->akses }}</td>
                                    <td>{{ $jalan->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('filter-kabupaten').addEventListener('change', function() {
            let selected = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                let kab = row.getAttribute('data-kabupaten').toLowerCase();
                row.style.display = (selected === 'all' || kab === selected) ? '' : 'none';
            });
        });

        document.querySelectorAll('.export-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const format = this.getAttribute('data-format');
                const kabupaten = document.getElementById('filter-kabupaten').value;
                const url =
                    `/prasarana-jalan/export?format=${format}&kabupaten=${encodeURIComponent(kabupaten)}`;
                window.location.href = url;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
