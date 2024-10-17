<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Presensi</title>
    @php
        $logos = App\Models\sekolah::first();
    @endphp
    @foreach ($logos as $item)
        <link rel="stylesheet" href="{{ asset('logo/' . $item) }}">
    @endforeach
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-fluid p-4">
        <button onclick="toggleFullscreen()" style="border: none;" style="mb-4"><i
                class="fa fa-maximize"></i></button>
        <a href="{{ route('lgp') }}" class="btn btn-primary mb-4">Masuk <i class="fa-solid fa-right-to-bracket"></i></a>
        @if (session('success'))
            <div class="alert alert-success p-3" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger p-3" role="alert" id="error-alert">
                {{ session('error') }}
            </div>
        @endif

        <script>
            setTimeout(function() {
                document.getElementById('success-alert')?.classList.add('d-none');
                document.getElementById('error-alert')?.classList.add('d-none');
            }, 3000);
        </script>


        <div class="row">
            <div class="col-sm">
                <form action="{{ route('absensi.absen') }}" method="POST"
                    style="padding: 2rem; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    @csrf
                    <div class="header">
                        <h5 class="mb-0" style="font-size: 1.25rem; font-weight: 600;">Absen Form</h5>
                    </div>
                    <div class="form-group mt-5">
                        <label for="nis">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" autofocus
                            oninput="submitOnScan()">
                        <small id="error-message" class="text-danger" style="display: none;">NIS tidak
                            ditemukan.</small>
                    </div>

                    <div class="form-group mt-5">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa"
                            list="datalistOptions" oninput="validateInput()">
                        <datalist id="datalistOptions">
                            @foreach ($dataSiswa as $item)
                                <option value="{{ $item->nama_siswa }}"></option>
                            @endforeach
                        </datalist>
                        <small id="error-message" class="text-danger" style="display: none;">Nama siswa tidak
                            ditemukan.</small>
                    </div>

                    <div class="form-group mt-5">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Tidak Hadir">Tidak Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Magang">Magang</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" disabled>Absen</button>
                </form>
            </div>
            <div class="col-sm">
                <div class="container-fluid p-4"
                    style="width: 100%; height: 30rem; overflow-y: scroll; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    <h5>Berhasil Absen</h5>
                    @foreach ($absensi->reverse() as $item)
                    <div class="container mt-4">
                        <div class="container">
                            <div class="row p-2" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 5px;">
                                <div class="col-sm text-start">
                                    <h5>{{ $item->student->nama_siswa }}</h5>
                                    <h6><small>
                                            @if ($item->student->kelas == 10)
                                                X
                                            @elseif ($item->student->kelas == 11)
                                                XI
                                            @elseif ($item->student->kelas == 12)
                                                XII
                                            @endif {{ $item->student->jurusan->nama_jurusan }}
                                        </small></h6>
                                </div>
                                <div class="col-sm text-end">
                                    <span class="text-light bg-success p-2 mt-2" style="border-radius: 100%; margin-top : 10px;">&#10003;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                </div>
            </div>
        </div>
    </div>
    <script>
        // Capture the form submission
        document.getElementById('absenForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Display a SweetAlert confirmation
            Swal.fire({
                title: 'Konfirmasi Absen',
                text: 'Apakah Anda yakin ingin melanjutkan presensi?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    this.submit();
                }
            });
        });
    </script>

    <script>
        function validateInput() {
            const namaSiswa = document.getElementById('nama_siswa').value.trim();
            const status = document.getElementById('status').value;
            const submitButton = document.querySelector('button[type="submit"]');

            if (namaSiswa && status) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        document.getElementById('nama_siswa').addEventListener('input', validateInput);
        document.getElementById('status').addEventListener('change', validateInput);
    </script>

    <script>
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    localStorage.setItem('isFullscreen', 'true');
                }).catch(err => {
                    console.error(`Error attempting to enable fullscreen mode: ${err.message} (${err.name})`);
                });
            } else {
                document.exitFullscreen().then(() => {
                    localStorage.setItem('isFullscreen', 'false');
                });
            }
        }

        function checkFullscreenState() {
            if (localStorage.getItem('isFullscreen') === 'true') {
                document.documentElement.requestFullscreen().catch(err => {
                    console.error(`Error attempting to enable fullscreen mode: ${err.message} (${err.name})`);
                });
            }
        }

        window.onload = checkFullscreenState;
    </script>

    <script>
        function submitOnScan() {
            let nisInput = document.getElementById('nis');
            let submitButton = document.querySelector('button[type="submit"]');

            if (nisInput.value.length >= 5) {
                submitButton.disabled = false;

                submitButton.click();
            }
        }

        document.getElementById('nis').addEventListener('input', submitOnScan);
    </script>
</body>

</html>
