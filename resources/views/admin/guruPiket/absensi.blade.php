@extends('layout/masterFile')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <section class="content mt-4">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="container mt-3">
                                                @if (session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show position-relative"
                                                        role="alert" id="success-alert">
                                                        <strong>{{ session('success') }}</strong><br>
                                                        <p>Nama Siswa: {{ session('nama_siswa') }}</p>

                                                        <div class="progress position-absolute bottom-0 start-0 w-100"
                                                            style="height: 5px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 100%;" id="progress-bar"></div>
                                                        </div>
                                                    </div>
                                                @endif


                                                @if (session('error'))
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                        role="alert">
                                                        {{ session('error') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif
                                                <div class="container w-100">
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <form action="{{ route('absensi.absen') }}" method="POST"
                                                                id="absenForm"
                                                                style="padding : 2rem; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="nama_siswa">Nama Siswa</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama_siswa" required name="nama_siswa"
                                                                        list="datalistOptions" oninput="validateInput()">
                                                                    <datalist id="datalistOptions">
                                                                        @foreach ($dataSiswa as $item)
                                                                            <option value="{{ $item->nama_siswa }}">
                                                                        @endforeach
                                                                    </datalist>
                                                                    <small id="error-message" class="text-danger"
                                                                        style="display: none;">Nama siswa tidak
                                                                        ditemukan.</small>
                                                                </div>

                                                                <script>
                                                                    document.addEventListener("DOMContentLoaded", function() {
                                                                        const nisInput = document.getElementById("nis");
                                                                        let scannerData = '';

                                                                        nisInput.addEventListener("input", function(event) {
                                                                            const value = event.target.value;

                                                                            if (value.length > scannerData.length) {
                                                                                scannerData += value.charAt(value.length - 1);
                                                                            }

                                                                            if (scannerData.length > 0) {
                                                                                console.log("NIS yang di-scan:", scannerData);
                                                                                nisInput.value = scannerData;
                                                                            }
                                                                        });

                                                                        setInterval(() => {
                                                                            if (scannerData.length > 0) {
                                                                                scannerData = '';
                                                                            }
                                                                        }, 2000);
                                                                    });
                                                                </script>



                                                                <div class="form-group">
                                                                    <label for="status">Status</label>
                                                                    <select class="form-control" id="status"
                                                                        name="status" required>
                                                                        <option value="Hadir">Hadir</option>
                                                                        <option value="Tidak Hadir">Tidak Hadir</option>
                                                                        <option value="Sakit">Sakit</option>
                                                                        <option value="Izin">Izin</option>
                                                                        <option value="Magang">Magang</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary"
                                                                    id="submitButton" disabled>Absen</button>
                                                            </form>
                                                            <div class="container p-3 mt-5"
                                                                style="overflow-y: scroll; height: 10rem; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                                @php
                                                                    $hasTidakHadir = false;
                                                                @endphp

                                                                @foreach ($siswahadir as $hadir)
                                                                    @if ($hadir->status === 'Tidak Hadir')
                                                                        @php
                                                                            $hasTidakHadir = true;
                                                                        @endphp
                                                                    @break
                                                                @endif
                                                            @endforeach

                                                            @if ($hasTidakHadir)
                                                                <div class="header mb-2">
                                                                    <h3>Data Belum Absen</h3>
                                                                </div>
                                                            @endif

                                                            @foreach ($belumabsen as $index)
                                                                <div class="card mb-1">
                                                                    <div class="card-body">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-between">
                                                                            <div>
                                                                                <div class="h6 card-title mb-0 fw-bold">
                                                                                    {{ $index->nama_siswa }}
                                                                                </div>
                                                                                <div class="small text-muted">
                                                                                    @if ($index->kelas == '10')
                                                                                        X
                                                                                        @elseif($index->kelas == '11')
                                                                                        XI
                                                                                        @elseif($index->kelas == '12')
                                                                                        XII
                                                                                    @endif
                                                                                    {{ $index->jurusan->nama_jurusan }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-flex align-items-center">
                                                                                <span
                                                                                    class="me-2">{{ $index->tanggal }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>

                                                    </div>
                                                    <div class="col-sm text-left" style="height: 25rem;">
                                                        <div class="header p-2">
                                                            <h3>Berhasil Absen</h3>
                                                        </div>

                                                        <div class="container p-3"
                                                            style="height: calc(100% - -3rem); overflow-y: auto; overflow-x: hidden; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                            @foreach ($siswahadir as $hadir)
                                                                @if ($hadir->status == 'Hadir')
                                                                    <div class="card mb-1">
                                                                        <div class="card-body">
                                                                            <div
                                                                                class="d-flex align-items-left align-baseline justify-content-between">
                                                                                <div>
                                                                                    <div
                                                                                        class="h6 card-title mb-0 fw-bold">
                                                                                        {{ $hadir->student ? $hadir->student->nama_siswa : 'Unknown Student' }}
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="small text-muted">
                                                                                        @if ($hadir->student->kelas == '10')
                                                                                            X
                                                                                            @elseif($hadir->student->kelas == '11')
                                                                                            XI
                                                                                            @elseif($hadir->student->kelas == '12')
                                                                                            XII
                                                                                        @endif
                                                                                        {{ $hadir->student && $hadir->student->jurusan ? $hadir->student->jurusan->nama_jurusan : 'Unknown Jurusan' }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-center">
                                                                                    <span
                                                                                        class="me-2">{{ $hadir->created_at->format('d M Y H:i') }}</span>
                                                                                    @if ($hadir->status == 'Hadir')
                                                                                        <i
                                                                                            class="fa fa-check-circle text-success"></i>
                                                                                        @elseif($hadir->status == 'Tidak Hadir')
                                                                                        <i
                                                                                            class="fa fa-times-circle text-danger"></i>
                                                                                        @elseif($hadir->status == 'Sakit')
                                                                                        <i
                                                                                            class="fa fa-medkit text-warning"></i>
                                                                                        @elseif($hadir->status == 'Izin')
                                                                                        <i
                                                                                            class="fa fa-user-clock text-info"></i>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                document.getElementById('nis').addEventListener('input', function() {
                                                    const scannedNis = this.value;

                                                    console.log("NIS yang di-scan: " + scannedNis);

                                                });

                                                function clearNisInput() {
                                                    setTimeout(function() {
                                                        document.getElementById('nis').value = '';
                                                    }, 2000);
                                                }
                                            </script>

                                            <script>
                                                function validateInput() {
                                                    const input = document.getElementById('nama_siswa');
                                                    const submitButton = document.getElementById('submitButton');
                                                    const errorMessage = document.getElementById('error-message');

                                                    const options = Array.from(document.querySelectorAll('#datalistOptions option')).map(option => option.value);

                                                    if (options.includes(input.value)) {
                                                        errorMessage.style.display = 'none';
                                                        submitButton.disabled = false;
                                                    } else {
                                                        errorMessage.style.display = 'block';
                                                        submitButton.disabled = true;
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                    <div class="container mt-5">
                                        <a href="{{ route('generate.pdf') }}" class="btn btn-primary mb-4">Download
                                            absen semua kelas</a>
                                        <div class="row justify-content-left">
                                            @php
                                                $order = [
                                                    'RPL',
                                                    'DKV 1',
                                                    'DKV 2',
                                                    'TKP',
                                                    'TP',
                                                    'KULINER 1',
                                                    'KULINER 2',
                                                ];

                                                $sortedData = $datawalikelas->sortBy(function ($item) use ($order) {
                                                    $index = array_search($item->Jurusan->nama_jurusan, $order);
                                                    return $index !== false ? $index : count($order);
                                                });
                                            @endphp

                                            @foreach ($sortedData as $data)
                                                @php
                                                    $bgColor = '';
                                                    switch ($data->Jurusan->nama_jurusan) {
                                                        case 'RPL':
                                                            $bgColor = 'bg-warning';
                                                            break;
                                                        case 'DKV 1':
                                                        case 'DKV 2':
                                                            $bgColor = 'bg-orange';
                                                            break;
                                                        case 'TKP':
                                                            $bgColor = 'bg-danger';
                                                            break;
                                                        case 'TP':
                                                            $bgColor = 'bg-primary';
                                                            break;
                                                        case 'KULINER':
                                                        case 'KULINER 1':
                                                        case 'KULINER 2':
                                                            $bgColor = 'bg-light';
                                                            break;
                                                        default:
                                                            $bgColor = 'bg-pink';
                                                            break;
                                                    }
                                                @endphp
                                                <div class="col-md-4 mb-4">
                                                    <a href="{{ route('absensi.absenkelas', $data->id) }}"
                                                        class="text-decoration-none text-dark hover-link text-primary">
                                                        <div class="card text-white {{ $bgColor }}"
                                                            style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                                            <div class="card-body text-center" style="color: black;">
                                                                <h3 class="card-title">Kelas {{ $data->kelas }}</h3>
                                                                <p class="card-text" style="font-size: 3rem">
                                                                    {{ $data->Jurusan->nama_jurusan }}
                                                                </p>
                                                                <p class="card-text mt-2">{{ $data->nama_walikelas }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </section>
        </div>
    </div>
</div>
</section>
</div>
@endsection
