@extends('layout.masterFile')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Siswa</h1>
                </div>
                <section class="content mt-4">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    @if (session('datawalikelas'))
                                    <div class="card-header d-flex flex-wrap align-items-center">
                                        <div class="form-group mb-0 ml-2">
                                            <div class="form-inline">
                                                <form action="{{ route('datasiswa.index') }}" method="GET"
                                                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                                    <div class="input-group">
                                                        <input type="text" list="datasiswa-options"
                                                            id="datasiswa-search" name="search"
                                                            style="background: white;"
                                                            class="form-control border-0 small"
                                                            placeholder="Cari datasiswa..." aria-label="Search"
                                                            aria-describedby="basic-addon2">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="submit">
                                                                <i class="fas fa-search fa-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <datalist id="datasiswa-options">
                                                    @foreach ($alldatasiswa as $datasiswa)
                                                    <option value="{{ $datasiswa->nama_datasiswa }}"></option>
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
                                            @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show"
                                                role="alert">
                                                <strong>{{ session('success') }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            @endif

                                            @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show"
                                                role="alert">
                                                <strong>{{ session('error') }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            @endif

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
                                                                    Nama Siswa</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    NIS</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    NISN</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Kelas</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Jurusan</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Jenis kelamin</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $no = 1;
                                                            @endphp
                                                            @foreach ($penggunasiswa as $index)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td>{{ $index->nama_siswa }}</td>
                                                                <td>{{ $index->nis }}</td>
                                                                <td>{{ $index->nisn }}</td>
                                                                <td>
                                                                    @if ($index->kelas == 10)
                                                                    X
                                                                    @elseif ($index->kelas == 11)
                                                                    XI
                                                                    @elseif ($index->kelas == 12)
                                                                    XII
                                                                    @endif
                                                                </td>
                                                                <td>{{ $index->jurusan->nama_jurusan }}</td>
                                                                <td>{{ $index->jenis_kelamin }}</td>
                                                                <td>
                                                                    <a href="{{ route('datasiswa.preview', $index->nis) }}"
                                                                        class="btn btn-primary">
                                                                        <i class="fa fa-newspaper"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @php
                                                            $no++;
                                                            @endphp
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                @if ($penggunasiswa)
                                                                <th rowspan="8" colspan="8">Total datasiswa
                                                                    :
                                                                    {{ $penggunasiswa->count() }}
                                                                </th>
                                                                @endif
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-7">
                                                    <div class="dataTables_paginate paging_simple_numbers"
                                                        id="example2_paginate">
                                                        {{ $penggunasiswa->links('layout.paginate') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="card-header d-flex flex-wrap align-items-center">
                                        @if (session('username') == 'Guru Piket')

                                        @else
                                        <a href="#" class="btn btn-primary mr-2" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            <i class="fa fa-plus"></i> Tambah Data
                                        </a>
                                        <a href="#" class="btn btn-success mr-2" data-bs-toggle="modal"
                                            data-bs-target="#modal_import">
                                            <i class="fa fa-file-import"></i> Import Data
                                        </a>
                                        <a href="{{ route('datasiswa.export') }}" class="btn btn-success mr-2">
                                            <i class="fa fa-file-export"></i> Export Data
                                        </a>
                                        @endif
                                        <div class="form-group mb-0 ml-2">
                                            <div class="form-inline">
                                                <form action="{{ route('datasiswa.index') }}" method="GET"
                                                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                                    <div class="input-group">
                                                        <input type="text" list="datasiswa-options"
                                                            id="datasiswa-search" name="search"
                                                            style="background: white;"
                                                            class="form-control border-0 small"
                                                            placeholder="Cari datasiswa..." aria-label="Search"
                                                            aria-describedby="basic-addon2">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="submit">
                                                                <i class="fas fa-search fa-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <datalist id="datasiswa-options">
                                                    @foreach ($alldatasiswa as $datasiswa)
                                                    <option value="{{ $datasiswa->nama_datasiswa }}"></option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 ml-2">
                                            <div class="form-inline">
                                                <form id="filterForm" method="GET"
                                                    action="{{ route('datasiswa.index') }}" class="form-inline mb-2 mt-2">
                                                    <div class="form-group mb-0 mr-2">
                                                        <select class="form-select" name="kelas"
                                                            aria-label="Default select example"
                                                            onchange="this.form.submit()">
                                                            <option value="">Kelas</option>
                                                            <option value="10"
                                                                {{ request('kelas') == '10' ? 'selected' : '' }}>X
                                                            </option>
                                                            <option value="11"
                                                                {{ request('kelas') == '11' ? 'selected' : '' }}>XI
                                                            </option>
                                                            <option value="12"
                                                                {{ request('kelas') == '12' ? 'selected' : '' }}>XII
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group mb-0 mr-2">
                                                        <select class="form-select" name="kode_jurusan"
                                                            aria-label="Default select example"
                                                            onchange="this.form.submit()">
                                                            <option value="">Jurusan</option>
                                                            @foreach ($datajurusan as $jurusan)
                                                            <option value="{{ $jurusan->kode_jurusan }}"
                                                                {{ request('kode_jurusan') == $jurusan->kode_jurusan ? 'selected' : '' }}>
                                                                {{ $jurusan->nama_jurusan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6"></div>
                                                <div class="col-sm-12 col-md-6"></div>
                                            </div>
                                            @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show"
                                                role="alert">
                                                <strong>{{ session('success') }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            @endif

                                            @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show"
                                                role="alert">
                                                <strong>{{ session('error') }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            @endif

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
                                                                    Nama Siswa</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    NIS</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    NISN</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Kelas</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Jurusan</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Jenis kelamin</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $no = 1;
                                                            @endphp
                                                            @foreach ($indexdatasiswa as $index)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td>{{ $index->nama_siswa }}</td>
                                                                <td>{{ $index->nis }}</td>
                                                                <td>{{ $index->nisn }}</td>
                                                                <td>
                                                                    @if ($index->kelas == 10)
                                                                    X
                                                                    @elseif ($index->kelas == 11)
                                                                    XI
                                                                    @elseif ($index->kelas == 12)
                                                                    XII
                                                                    @endif
                                                                </td>
                                                                <td>{{ $index->jurusan->nama_jurusan }}</td>
                                                                <td>{{ $index->jenis_kelamin }}</td>
                                                                <td>
                                                                    <a href="{{ route('datasiswa.preview', $index->nis) }}"
                                                                        class="btn btn-primary">
                                                                        <i class="fa fa-newspaper"></i>
                                                                    </a>
                                                                    @if (session('username') == 'Guru Piket')

                                                                    @else
                                                                    <a href="{{ route('datasiswa.edit', $index->nis) }}"
                                                                        class="btn btn-warning">
                                                                        <i class="fa fa-pen"></i>
                                                                    </a>
                                                                    <a href="#"
                                                                        onclick="
                                                                                event.preventDefault();
                                                                                Swal.fire({
                                                                                    title: 'anda yakin?',
                                                                                    text: 'apakah anda yakin untuk menghapus data ini!',
                                                                                    icon: 'warning',
                                                                                    showCancelButton: true,
                                                                                    confirmButtonColor: '#3085d6',
                                                                                    cancelButtonColor: '#d33',
                                                                                    confirmButtonText: 'hapus',
                                                                                    cancelButtonText: 'batal',
                                                                                }).then((result) => {
                                                                                    if (result.isConfirmed) {
                                                                                        window.location.href = '{{ route('datasiswa.hapus', $index->nis) }}';
                                                                                    }
                                                                                });
                                                                            "
                                                                        class="btn btn-danger">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @php
                                                            $no++;
                                                            @endphp
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                @if ($totaldatasiswa)
                                                                <th rowspan="8" colspan="8">Total datasiswa
                                                                    :
                                                                    {{ $totaldatasiswa }}
                                                                </th>
                                                                @endif
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-7">
                                                    <div class="dataTables_paginate paging_simple_numbers"
                                                        id="example2_paginate">
                                                        {{ $indexdatasiswa->links('layout.paginate') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
            <form action="{{ route('datasiswa.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="foto_pelajar">Foto Siswa</label>
                        <input type="file" id="foto_pelajar" name="foto_pelajar" class="form-control"
                            placeholder="Masukan nama siswa...">
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" id="nama_siswa" name="nama_siswa" class="form-control"
                            placeholder="Masukan nama siswa...">
                    </div>
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" class="form-control" id="nis"
                            placeholder="Masukkan nis..." required>
                    </div>
                    <div class="form-group">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" class="form-control" id="nisn"
                            placeholder="Masukkan nisn..." required>
                    </div>
                    <div class="form-group">
                        <div class="form-group mb-3">
                            <label for="kelas">Kelas</label>
                            <select class="form-select" name="kelas" required aria-label="Default select example">
                                <option selected>Pilih Kelas</option>
                                <option value="10">X</option>
                                <option value="11">XI</option>
                                <option value="12">XII</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kode_jurusan">Jurusan</label>
                        <select class="form-select" name="kode_jurusan" required aria-label="Default select example">
                            <option selected>Pilih jurusan</option>
                            @foreach ($datajurusan as $jurusan)
                            <option value="{{ $jurusan->kode_jurusan }}">{{ $jurusan->nama_jurusan }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Laki-Laki" name="jenis_kelamin"
                                id="jenis_kelamin1">
                            <label class="form-check-label" for="jenis_kelamin1">
                                Laki-Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Perempuan" name="jenis_kelamin"
                                id="jenis_kelamin2" checked>
                            <label class="form-check-label" for="jenis_kelamin2">
                                Perempuan
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit data siswa</h5>
            </div>
            @if ($editdatasiswa)
            <form action="{{ route('datasiswa.update', $editdatasiswa->nis) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" id="nama_siswa" name="nama_siswa"
                            value="{{ $editdatasiswa->nama_siswa }}" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" class="form-control" id="nis"
                            placeholder="Masukan NIS..." value="{{ $editdatasiswa->nis }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" class="form-control" id="nisn"
                            placeholder="Masukan NISN..." value="{{ $editdatasiswa->nisn }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="kelas">Kelas</label>
                        <select class="form-select" name="kelas" required aria-label="Pilih Kelas">
                            <option value="10" {{ $editdatasiswa->kelas == 10 ? 'selected' : '' }}>X</option>
                            <option value="11" {{ $editdatasiswa->kelas == 11 ? 'selected' : '' }}>XI</option>
                            <option value="12" {{ $editdatasiswa->kelas == 12 ? 'selected' : '' }}>XII
                            </option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="kode_jurusan">Jurusan</label>
                        <select class="form-select form-select-sm" name="kode_jurusan" required id="id_jurusan"
                            aria-label="Pilih Jurusan">
                            <option value="">Pilih jurusan</option>
                            @foreach ($datajurusan as $jurusan)
                            <option value="{{ $jurusan->kode_jurusan }}"
                                {{ $editdatasiswa->kode_jurusan == $jurusan->kode_jurusan ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                id="jenis_kelamin1" value="{{ $editdatasiswa->jenis_kelamin }}"
                                {{ $editdatasiswa->jenis_kelamin == 'Laki-Laki' ? 'checked' : '' }}>
                            <label class="form-check-label" for="jenis_kelamin1">
                                Laki-Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                id="jenis_kelamin2" value="{{ $editdatasiswa->jenis_kelamin }}"
                                {{ $editdatasiswa->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="jenis_kelamin2">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            @else
            <p>No data available for editing.</p>
            @endif
        </div>
    </div>
</div>

@if (session('preview_modal_nis'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var previewModal = new bootstrap.Modal(document.getElementById('preview_modal'));
        previewModal.show();
    });
</script>
@endif

<div class="modal fade" id="preview_modal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header border-0" style="background-color: #f1f1f1;">
                <h5 class="modal-title" id="previewModalLabel">Preview Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if ($previewdatasiswa)
            <div class="modal-body text-center">
                <div class="mb-3">
                    @if ($previewdatasiswa->foto_pelajar == null)
                    <div class="text-start">
                        <button type="button" class="btn btn-primary p-5"
                            style="border-radius: 100%; max-width: 150px; font-size: 2rem;"
                            onclick="document.getElementById('fileInput').click();">
                            <i class="fa fa-plus"></i>
                        </button>
                        <form id="uploadForm"
                            action="{{ route('datasiswa.addfoto', $previewdatasiswa->nis) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="foto_pelajar" accept="image/*" id="fileInput"
                                style="display: none;"
                                onchange="document.getElementById('uploadForm').submit();">
                        </form>
                    </div>
                    @else
                    <img src="{{ asset('fotoPelajar/' . $previewdatasiswa->foto_pelajar) }}"
                        alt="Foto Pelajar" class="img-fluid rounded-circle"
                        style="max-width: 150px; border: 2px solid #ccc;">
                    @endif
                </div>
                <div class="mb-2"
                    style="background-color: #f9f9f9; padding: 5px; display: flex; justify-content: flex-start;">
                    <span
                        style="width: 120px; display: inline-block; text-align: left;"><strong>Nama</strong></span>
                    <span>: {{ $previewdatasiswa->nama_siswa }}</span>
                </div>
                <div class="mb-2"
                    style="background-color: #ffffff; padding: 5px; display: flex; justify-content: flex-start;">
                    <span
                        style="width: 120px; display: inline-block; text-align: left;"><strong>NIS</strong></span>
                    <span>: {{ $previewdatasiswa->nis }}</span>
                </div>
                <div class="mb-2"
                    style="background-color: #f9f9f9; padding: 5px; display: flex; justify-content: flex-start;">
                    <span
                        style="width: 120px; display: inline-block; text-align: left;"><strong>NISN</strong></span>
                    <span>: {{ $previewdatasiswa->nisn }}</span>
                </div>
                <div class="mb-2"
                    style="background-color: #ffffff; padding: 5px; display: flex; justify-content: flex-start;">
                    <span
                        style="width: 120px; display: inline-block; text-align: left;"><strong>Kelas</strong></span>
                    <span>: {{ $previewdatasiswa->kelas }}</span>
                </div>
                <div class="mb-2"
                    style="background-color: #f9f9f9; padding: 5px; display: flex; justify-content: flex-start;">
                    <span
                        style="width: 120px; display: inline-block; text-align: left;"><strong>Jurusan</strong></span>
                    <span>: {{ $previewdatasiswa->jurusan->nama_jurusan }}</span>
                </div>
                <div class="mb-2"
                    style="background-color: #ffffff; padding: 5px; display: flex; justify-content: flex-start;">
                    <span style="width: 120px; display: inline-block; text-align: left;"><strong>Jenis
                            Kelamin</strong></span>
                    <span>: {{ $previewdatasiswa->jenis_kelamin }}</span>
                </div>
                <div class="mb-2"
                    style="background-color: #ffffff; padding: 5px; display: flex; justify-content: flex-start;">
                    <span style="width: 120px; display: inline-block; text-align: left;"><strong>Poin Pelanggaran</strong></span>
                    <span>: {{ $previewdatasiswa->total_poin ?? 'Tidak ada pelanggaran' }}</span>
                </div>


            </div>
            @else
            <div class="modal-body text-center">
                <p class="text-muted">Data not found for preview.</p>
            </div>
            @endif
            <div class="modal-footer border-0" style="background-color: #f1f1f1;">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_import" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a href="{{ asset('file_input.xlsx') }}" class="btn btn-primary align-content-center text-center"
                    aria-describedby="downloadfile" download>Download</a>
                <small id="downloadfile" class="form-text text-muted text-danger">
                    1. download file excel terlebih dahulu
                    <br>2. isi data sesuai header di excel
                    <br>3. jangan hapus header excelnya
                    <br>4. untuk kelas, bisa diinput menggunakan angka biasa (contoh: 10, 11, dan 12) atau angka romawi
                    (contoh: X, XI, dan XII)
                    <br>5. jurusan diisi sesuai nama jurusan yang ada di data jurusan
                    <br>6. pilih file di input file di bawah
                    <br>7. import file tersebut
                </small>


                <form action="{{ route('datasiswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                    </div>
                    <div class="mb-3">
                        <label for="file_import" class="form-label">Pilih File untu diimport</label>
                        <input type="file" class="form-control" name="file_import" id="file_import">
                    </div>
                    <button type="submit" class="btn btn-primary">Import</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
