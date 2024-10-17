@extends('layout.masterFile')
@section('content')
    <div class="content-wrapper" style="overflow-x: hidden">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard
                            @if (session()->has('datawalikelas'))
                            {{ implode(' ', array_slice(explode(' ', session('datawalikelas')->nama_walikelas), 0, 2)) }}
                            @elseif (session()->has('nama_pengguna'))
                                @if (session('username') == 'Guru Piket')
                                {{ implode(' ', array_slice(explode(' ', session('nama_pengguna')), 0, 2)) }}
                                @else
                                    {{ session('username') }}
                                @endif
                            @endif
                        </h1>

                    </div>
                </div>
            </div>
        </div>
        <section class="content">

            <div class="row">
                @if (session('datawalikelas'))
                    <div class="col-12 col-sm-6 col-md-3 ml-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Data Siswa</span>
                                <span class="info-box-number">
                                    <small>Total :</small>
                                    @if ($count_kelas_walikelas)
                                        {{ $count_kelas_walikelas }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i
                                    class="fa-solid fa-circle-exclamation"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">
                                    <a href="{{ route('pelanggaransiswa.index', session('datawalikelas')->id) }}"
                                        class="text-decoration-none text-reset">
                                        Pelanggaran <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-check-to-slot"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jurusan</span>
                                <span class="info-box-number">
                                    <small>Total :</small>
                                    @if ($count_kelas)
                                        {{ $count_kelas }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-user-tie"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Wali Kelas</span>
                                <span class="info-box-number">
                                    <small>Total :</small>
                                    @if ($count_walikelas)
                                        {{ $count_walikelas }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Data Siswa</span>
                                <span class="info-box-number">
                                    <small>Total :</small>
                                    @if ($count_siswa)
                                        {{ $count_siswa }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i
                                    class="fa-solid fa-circle-exclamation"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">
                                    <a href="{{ route('pelanggaransiswa.index') }}" class="text-decoration-none text-reset">
                                        Pelanggaran <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="col-lg-20 col-md-20 mb-4">
                            <div class="card shadow-lg">
                                <div class="card-header bg-dark text-white">
                                    <h3 class="card-title">
                                        <i class="far fa-calendar-alt"></i> Kalender
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card card-raised h-100">
                            <div class="card-header bg-transparent px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-4">
                                        <h2 class="card-title mb-0">Tingkat Pelanggaran</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex h-100 w-100 align-items-center justify-content-center">
                                    <div class="w-100" style="max-width: 20rem">
                                        <canvas id="myPieChart" width="480" height="480"
                                            style="display: block; box-sizing: border-box; height: 320px; width: 320px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var diagramData = @json($diagram);

                                if (!diagramData.length) {
                                    console.error("Data untuk diagram kosong.");
                                    return;
                                }

                                var labels = diagramData.map(function (item) { return item.jenis_pelanggaran; });
                                var totalData = diagramData.map(function (item) { return item.total; });
                                var duplicateData = diagramData.map(function (item) { return item.duplicates || 0; });

                                var backgroundColors = totalData.map(function () {
                                    return 'rgba(' + Math.floor(Math.random() * 255) + ', ' +
                                                  Math.floor(Math.random() * 255) + ', ' +
                                                  Math.floor(Math.random() * 255) + ', 1)';
                                });
                                var borderColors = totalData.map(function () {
                                    return 'rgba(' + Math.floor(Math.random() * 255) + ', ' +
                                                  Math.floor(Math.random() * 255) + ', ' +
                                                  Math.floor(Math.random() * 255) + ', 2)';
                                });

                                var ctx = document.getElementById('myPieChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Tingkat Pelanggaran',
                                            data: totalData,
                                            backgroundColor: backgroundColors,
                                            borderColor: borderColors,
                                            borderWidth: 0
                                        }]
                                    },
                                });
                            });
                        </script>

                    </div>
                </div>
            </div>

            <div class="card-body">
                @if (!empty($diagram))
                    <div class="bg-light p-3" style="box-shadow: 2px 2px 4px #000000;">
                        <canvas id="lineChart" width="300" height="100"></canvas>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var diagramData = @json($diagram);

                            if (!diagramData.length) {
                                console.error("Data untuk diagram kosong.");
                                return;
                            }

                            var labels = diagramData.map(item => item.jenis_pelanggaran);
                            var totalData = diagramData.map(item => item.total);
                            var duplicateData = diagramData.map(item => item.duplicates || 0);

                            var backgroundColors = totalData.map(() => {
                                return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 28)`;
                            });
                            var borderColors = totalData.map(() => {
                                return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 13)`;
                            });

                            var ctx = document.getElementById('lineChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Tingkat Pelanggaran',
                                        data: totalData,
                                        backgroundColor: backgroundColors,
                                        borderColor: borderColors,
                                        borderWidth: 0
                                    }, ]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 5
                                            },
                                            suggestedMax: Math.ceil(Math.max(...totalData.concat(duplicateData)) / 5) * 5 +
                                                5
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                @else
                    <div class="alert alert-danger text-center">
                        Tidak ada pelanggaran!
                    </div>
                @endif
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js" crossorigin="anonymous"></script>
@endsection
