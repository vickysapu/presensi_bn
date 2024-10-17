@extends('layout.masterFile')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Jurusan</h1>
                </div>
                <section class="content mt-4">
                    <div class="container-fluid">
                        <div class="col-12">
                            <div class="card">
                                <div class="col-sm-12">
                                    @if (session('username') == 'Guru Piket')
                                    @else
                                    <label type="button" class="mt-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Tambahkan
                                    </label>
                                    @endif


                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('tahunpelajaran.add') }}" method="POST">
                                                        @method('POST')
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="tahunmulai" class="form-label">Tahun Mulai</label>
                                                            <div class="input-group">
                                                                <input type="number" name="tahunmulai" class="form-control" id="tahunmulai" placeholder="YYYY" required>
                                                                <span class="input-group-text">/</span>
                                                                <input type="number" name="tahunselesai" class="form-control" id="tahunselesai" placeholder="YYYY" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="semester" class="form-label">Semester</label>
                                                            <select name="semester" id="semester" class="form-select" required>
                                                                <option value="" disabled selected>Pilih Semester</option>
                                                                <option value="1">Ganjil</option>
                                                                <option value="2">Genap</option>
                                                            </select>
                                                        </div>
                                                        <div class="footer mt-5">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>

                                                    <script>
                                                        function validateYears() {
                                                            const currentYear = new Date().getFullYear();
                                                            const tahunMulai = parseInt(document.getElementById('tahunmulai').value);
                                                            const tahunSelesai = parseInt(document.getElementById('tahunselesai').value);

                                                            if (tahunMulai < currentYear || tahunSelesai < currentYear) {
                                                                alert('Tahun harus sama dengan tahun sekarang atau lebih besar.');
                                                                return false; // Menghentikan pengiriman form
                                                            }
                                                            if (tahunSelesai < tahunMulai) {
                                                                alert('Tahun selesai harus lebih besar atau sama dengan tahun mulai.');
                                                                return false; // Menghentikan pengiriman form
                                                            }
                                                            return true; // Mengizinkan pengiriman form
                                                        }
                                                    </script>


                                                    <script>
                                                        function validateYears() {
                                                            const currentYear = new Date().getFullYear();
                                                            const tahunMulai = parseInt(document.getElementById('tahunmulai').value);
                                                            const tahunSelesai = parseInt(document.getElementById('tahunselesai').value);

                                                            if (tahunMulai < currentYear || tahunSelesai < currentYear) {
                                                                alert('Perhatikan tahunya.');
                                                                return false;
                                                            }
                                                            if (tahunSelesai <= tahunMulai) {
                                                                alert('Tahun selesai harus lebih besar tahun mulai.');
                                                                return false;
                                                            }
                                                            return true;
                                                        }
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example2" class="text-center mt-3 table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Tahun Pelajaran</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Semester</th>
                                                @if (session('username') == 'Guru Piket')

                                                @else
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataTahunpelajaran as $data)
                                            <tr>
                                                <td>{{ $data->tahunmulai }} / {{ $data->tahunselesai }}</td>
                                                <td>
                                                    @if ($data->semester == 1)
                                                    {{ $data->semester }} (Ganjil)
                                                    @elseif ($data->semester == 2)
                                                    {{ $data->semester }} (Genap)
                                                    @endif
                                                </td>
                                                @if (session('username') == 'Guru Piket')
                                                <td>
                                                    <label href="#" class="btn {{ $data->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                        {{ $data->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                                    </label>
                                                </td>
                                                @else
                                                <td>
                                                    <a href="#" class="btn {{ $data->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                        onclick="toggleStatus({{ $data->id }}, {{ $data->status }})">
                                                        {{ $data->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-danger" href="{{ route('tahunpelajaran.hapus', $data->id) }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                                @endif
                                                <script>
                                                    function toggleStatus(id, currentStatus) {
                                                        const newStatus = currentStatus === 1 ? 0 : 1;

                                                        $.ajax({
                                                            url: `{{ url('/sipensi/dashboard/data-tahun-pelajaran/pengaktifan') }}/${id}`,
                                                            type: 'PUT',
                                                            data: {
                                                                _token: '{{ csrf_token() }}',
                                                                status: newStatus,
                                                            },
                                                            success: function(response) {
                                                                location.reload(); // Reload the page to see the updated status
                                                            },
                                                            error: function(xhr) {
                                                                console.error(xhr.responseText);
                                                            }
                                                        });
                                                    }
                                                </script>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
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
