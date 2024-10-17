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
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-wrap align-items-center">
                                        @if (session('username') == 'Guru Piket')

                                        @else
                                        <a href="#" class="btn btn-primary mr-2" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            <i class="fa fa-plus"></i> Tambah Data
                                        </a>
                                        @endif
                                        <div class="form-group mb-0 ml-2">
                                            <div class="form-inline">
                                                <form action="{{ route('jurusan.index') }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                                    <div class="input-group">
                                                        <input type="text" list="jurusan-options" id="jurusan-search" name="search" style="background: white;" class="form-control border-0 small" placeholder="Cari Jurusan..." aria-label="Search" aria-describedby="basic-addon2">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="submit">
                                                                <i class="fas fa-search fa-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <datalist id="jurusan-options">
                                                    @foreach($allJurusan as $jurusan)
                                                    <option value="{{ $jurusan->nama_jurusan }}"></option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6"></div>
                                                <div class="col-sm-12 col-md-6"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table id="example2"
                                                        class="table table-bordered table-hover dataTable dtr-inline text-center">
                                                        <thead>
                                                            <tr>
                                                                <th class="sorting sorting_asc" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1" aria-sort="ascending">
                                                                    no</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Kode Jurusan</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Nama Jurusan</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Kepanjangan Jurusan</th>

                                                                @if (session('username') == 'Guru Piket')

                                                                @else
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Aksi</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $no = 1;
                                                            @endphp
                                                            @foreach ($indexJurusan as $index)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td>{{ $index->kode_jurusan }}</td>
                                                                <td>{{ $index->nama_jurusan }}</td>
                                                                <td>{{ $index->kepanjangan_jurusan }}</td>
                                                                @if (session('username') == 'Guru Piket')

                                                                @else
                                                                <td>
                                                                    <a href="{{ route('jurusan.edit', $index->id) }}" class="btn btn-warning">
                                                                        <i class="fa fa-pen"></i>
                                                                    </a>
                                                                    <a href="#" onclick="
                                                                                event.preventDefault();
                                                                                Swal.fire({
                                                                                    title: 'anda yakin?',
                                                                                    text: 'apakah anda yakinuntuk menghapus data ini!',
                                                                                    icon: 'warning',
                                                                                    showCancelButton: true,
                                                                                    confirmButtonColor: '#3085d6',
                                                                                    cancelButtonColor: '#d33',
                                                                                    confirmButtonText: 'hapus',
                                                                                    cancelButtonText: 'batal',
                                                                                }).then((result) => {
                                                                                    if (result.isConfirmed) {
                                                                                        window.location.href = '{{ route('jurusan.hapus', $index->id) }}';
                                                                                    }
                                                                                });
                                                                            " class="btn btn-danger">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                                @endif
                                                            </tr>
                                                            @php
                                                            $no++;
                                                            @endphp
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                @if ($totalJurusan)
                                                                <th rowspan="6" colspan="6">Total Jurusan : {{ $totalJurusan }}</th>
                                                                @endif
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-7">
                                                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                                        {{ $indexJurusan->links('layout.paginate') }}
                                                    </div>
                                                </div>
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


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jurusan.add') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="Kode_Jurusan">Kode Jurusan</label>
                        <input type="text" id="kode_jurusan_display" class="form-control"
                            placeholder="Kode Jurusan" disabled>
                        <input type="hidden" name="kode_jurusan" id="kode_jurusan_hidden">
                    </div>
                    <div class="form-group">
                        <label for="Nama_jurusan">Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" class="form-control" id="Nama_jurusan"
                            placeholder="Masukkan nama jurusan (singkatan)..." required>
                    </div>
                    <div class="form-group">
                        <label for="kepanjangan_jurusan">Kepanjangan Jurusan</label>
                        <input type="text" name="kepanjangan_jurusan" class="form-control"
                            id="kepanjangan_jurusan" placeholder="Masukkan kepanjangan jurusan..." required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@if (session('edit_modal_id'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editModal = new bootstrap.Modal(document.getElementById('Edit_Siswa'));
        editModal.show();
    });
</script>
@endif

<!-- Modal -->
<div class="modal fade" id="Edit_Siswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Jurusan</h5>
            </div>
            @if ($editJurusan)
            <form action="{{ route('jurusan.update', $editJurusan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nama_jurusan">Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" class="form-control" id="nama_jurusan"
                            placeholder="Masukan nama jurusan..." value="{{ $editJurusan->nama_jurusan }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="kepanjangan_jurusan">Kepanjangan Jurusan</label>
                        <input type="text" name="kepanjangan_jurusan" class="form-control"
                            id="kepanjangan_jurusan" placeholder="Masukan kepanjangan jurusan..."
                            value="{{ $editJurusan->kepanjangan_jurusan }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('jurusan.index') }}" type="button" class="btn btn-secondary">Close</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @else
            <p>No data available for editing.</p>
            @endif
        </div>
    </div>
</div>
@endsection