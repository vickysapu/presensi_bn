@extends('layout.masterFile')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pelanggaran Siswa</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="container">

                            @if (session('datawalikelas'))
                                <table class="table text-center">
                                    <thead>
                                        @php
                                            $no = 1;
                                        @endphp
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Siswa</th>
                                            <th scope="col">Kelas/Jurusan</th>
                                            <th scope="col">Jumlah Poin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datapelanggaransiswawalikelas as $data)
                                            <tr>
                                                <th scope="row">{{ $no++ }}</th>
                                                <td>{{ $data->nama_siswa }}</td>
                                                <td>{{ $data->kelas }}/{{ $data->jurusan->nama_jurusan }}</td>
                                                <td>{{ $data->total_poin }}</td>
                                            </tr>
                                        @endforeach

                                        @php
                                            $no++;
                                        @endphp
                                    </tbody>
                                </table>
                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card shadow-sm p-4 mb-4">
                                            <h5 class="mb-3">Tambah Pelanggaran Siswa</h5>
                                            <form action="{{ route('pelanggaransiswa.add') }}" method="POST"
                                                onsubmit="return confirmSubmission(event)">
                                                @csrf
                                                <div class="form-group mb-3">
                                                    <label for="nis">Nama Siswa</label>
                                                    <input type="text" class="form-control" name="nis" id="nis"
                                                        placeholder="Nama Siswa..." list="datalistOptions"
                                                        oninput="validateForm()">
                                                    <datalist id="datalistOptions">
                                                        @foreach ($datasiswa as $item)
                                                            <option value="{{ $item->nama_siswa }}"></option>
                                                        @endforeach
                                                    </datalist>
                                                    <small id="nisAlert" class="text-danger" style="display: none;">Nama
                                                        siswa tidak ada.</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="poin">Jenis Pelanggaran</label>
                                                    <input type="text" class="form-control" id="poin" name="poin"
                                                        placeholder="Jenis Pelanggaran..." list="datalistOptionsp"
                                                        oninput="validateForm()">
                                                    <datalist id="datalistOptionsp">
                                                        @foreach ($datapelanggaranpoin as $item)
                                                            <option value="{{ $item->jenis_pelanggaran }}"></option>
                                                        @endforeach
                                                    </datalist>
                                                    <small id="poinAlert" class="text-danger" style="display: none;">Jenis
                                                        pelanggaran tidak ada.</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="keterangan">Keterangan <span
                                                            class="text-danger"><small>*(opsional)</small></span></label>
                                                    <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="5"
                                                        placeholder="keterangan *(inputan ini bersifat opsional)*...."></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary" id="submitButton"
                                                    disabled>Kirim</button>
                                            </form>

                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                            <script>
                                                function confirmSubmission(event) {
                                                    event.preventDefault();

                                                    Swal.fire({
                                                        title: 'Apa Anda Yakin?',
                                                        text: 'Anda tidak akan dapat mengembalikan ini!',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        cancelButtonText: 'Batal',
                                                        confirmButtonText: 'Ya, kirim!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            event.target.submit();
                                                        }
                                                    });
                                                }

                                                function validateForm() {
                                                    let submitButton = document.getElementById('submitButton');
                                                    let nisInput = document.getElementById('nis').value;
                                                    let poinInput = document.getElementById('poin').value;

                                                    if (nisInput && poinInput) {
                                                        submitButton.disabled = false;
                                                    } else {
                                                        submitButton.disabled = true;
                                                    }
                                                }
                                            </script>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card shadow-sm p-4 mb-4">
                                            <h5 class="mb-3">Pelanggaran Terbanyak</h5>
                                            @if (auth()->check() && auth()->user()->username !== 'Guru Piket')
                                                <!-- Show the download button if the user is not "Guru Piket" -->
                                                <a href="{{ route('generate.pelanggaran') }}" class="btn btn-success w-25 m-2">Download</a>
                                            @endif
                                            <div class="overflow-auto" style="height: 300px;">
                                                @foreach ($datapelanggaransiswaall->sortByDesc('total_poin') as $student)
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <h6 class="mb-1">{{ $student->nama_siswa }}</h6>
                                                                    <p class="text-muted mb-0">{{ $student->kelas }} -
                                                                        {{ $student->jurusan->nama_jurusan }}</p>
                                                                </div>
                                                                <div class="text-end">
                                                                    <span class="badge bg-danger">{{ $student->total_poin }} Poin</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card shadow-sm p-4 mb-4">
                                            <h5 class="mb-3">Data Pelanggaran Siswa</h5>
                                            <p class="mb-4">{{ now()->format('d M Y') }}</p>

                                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                                @foreach ($indexpelanggaransiswa as $index)
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <h6 class="fw-bold">
                                                                            {{ $index->datapelanggaran->jenis_pelanggaran }}
                                                                        </h6>
                                                                        <p class="text-muted mb-1">
                                                                            {{ $index->student->nama_siswa }}</p>
                                                                        <p class="text-muted mb-1">
                                                                            {{ $index->student->kelas }}
                                                                            {{ $index->student->jurusan->nama_jurusan }}
                                                                        </p>
                                                                        <p class="text-danger fw-bold">Poin:
                                                                            {{ $index->datapelanggaran->poin }}</p>
                                                                    </div>
                                                                    <div class="text-end">
                                                                        <small
                                                                            class="text-muted">{{ optional($index->updated_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') ?? 'Tanggal tidak tersedia' }}</small>
                                                                        <br>
                                                                        <button type="button" class="btn btn-info"
                                                                            data-toggle="modal"
                                                                            data-target="#preview-{{ $index->id }}">Lihat</button>

                                                                        <div class="modal fade"
                                                                            id="preview-{{ $index->id }}"
                                                                            tabindex="-1" role="dialog"
                                                                            aria-labelledby="exampleModalLabel"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title"
                                                                                            id="exampleModalLabel">
                                                                                            Keterangan</h5>
                                                                                        <button type="button"
                                                                                            class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body text-start">
                                                                                        <label for="nama">Nama
                                                                                            Siswa</label>
                                                                                        <p class="text-muted mb-1"
                                                                                            id="nama">
                                                                                            {{ $index->student->nama_siswa }}
                                                                                        </p>

                                                                                        <label
                                                                                            for="kelas">Kelas/Jurusan</label>
                                                                                        <p class="text-muted mb-1">
                                                                                            {{ $index->student->kelas }}
                                                                                            {{ $index->student->jurusan->nama_jurusan }}
                                                                                        </p>

                                                                                        <label for="nama_pelanggaran">Jenis
                                                                                            Pelanggaran</label>
                                                                                        <p class="mb-1"
                                                                                            id="nama_pelanggaran">
                                                                                            {{ $index->datapelanggaran->jenis_pelanggaran }}
                                                                                        </p>

                                                                                        <label
                                                                                            for="keterangan">Keterangan</label>
                                                                                        <p class="mb-1">
                                                                                            {{ $index->keterangan ? $index->keterangan : '-' }}
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-dismiss="modal">Tutup</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <script>
                                function validateForm() {
                                    const nisInput = document.getElementById('nis').value;
                                    const poinInput = document.getElementById('poin').value;
                                    const submitButton = document.getElementById('submitButton');
                                    const nisAlert = document.getElementById('nisAlert');
                                    const poinAlert = document.getElementById('poinAlert');

                                    const nisOptions = document.getElementById('datalistOptions').options;
                                    const poinOptions = document.getElementById('datalistOptionsp').options;

                                    let nisExists = Array.from(nisOptions).some(option => option.value === nisInput);
                                    let poinExists = Array.from(poinOptions).some(option => option.value === poinInput);

                                    submitButton.disabled = !(nisExists && poinExists);

                                    nisAlert.style.display = nisInput && !nisExists ? 'block' : 'none';
                                    poinAlert.style.display = poinInput && !poinExists ? 'block' : 'none';
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
