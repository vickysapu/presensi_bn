@extends('layout.masterFile')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data wali kelas</h1>
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
                                                <form action="{{ route('walikelas.index') }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                                    <div class="input-group">
                                                        <input type="text" list="walikelas-options" id="walikelas-search" name="search" style="background: white;" class="form-control border-0 small" placeholder="Cari walikelas..." aria-label="Search" aria-describedby="basic-addon2">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="submit">
                                                                <i class="fas fa-search fa-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <datalist id="walikelas-options">
                                                    @foreach($allwalikelas as $walikelas)
                                                    <option value="{{ $walikelas->nama_walikelas }}"></option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>
                                        <form id="filterForm" method="GET" action="{{ route('walikelas.index') }}"
                                            class="form-inline mb-2 mt-2">
                                            <div class="form-group mb-0 mr-2 ml-2">
                                                <select class="form-select" name="kelas"
                                                    aria-label="Default select example" onchange="this.form.submit()">
                                                    <option value="">Kelas</option>
                                                    <option value="10"
                                                        {{ request('kelas') == '10' ? 'selected' : '' }}>X</option>
                                                    <option value="11"
                                                        {{ request('kelas') == '11' ? 'selected' : '' }}>XI</option>
                                                    <option value="12"
                                                        {{ request('kelas') == '12' ? 'selected' : '' }}>XII</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-0 mr-2">
                                                <select class="form-select" name="kode_jurusan"
                                                    aria-label="Default select example" onchange="this.form.submit()">
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
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Nama Wali Kelas</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Kelas</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="example2" rowspan="1"
                                                                    colspan="1">
                                                                    Jurusan</th>
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
                                                            @foreach ($indexwalikelas as $index)
                                                            <tr>
                                                                <td>{{ $index->nama_walikelas }}</td>
                                                                <td>
                                                                    @if ( $index->kelas == 10)
                                                                    X
                                                                    @elseif( $index->kelas == 11)
                                                                    XI
                                                                    @elseif( $index->kelas == 12)
                                                                    XII
                                                                    @endif
                                                                </td>
                                                                <td>{{ $index->jurusan->nama_jurusan }}</td>
                                                                @if (session('username') == 'Guru Piket')

                                                                @else
                                                                <td>
                                                                    <a href="{{ route('walikelas.edit', $index->id) }}" class="btn btn-warning">
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
                                                                                            window.location.href = '{{ route('walikelas.hapus', $index->id) }}';
                                                                                        }
                                                                                    });
                                                                                " class="btn btn-danger">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                                @endif

                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                @if ($totalwalikelas)
                                                                <th rowspan="6" colspan="6">Total Data : {{ $totalwalikelas }}</th>
                                                                @endif
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-7">
                                                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                                        {{ $indexwalikelas->links('layout.paginate') }}
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
            <form action="{{ route('walikelas.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_walikelasi">Nama wali kelas</label>
                        <input type="text" name="nama_walikelas" class="form-control" id="nama_walikelas"
                            placeholder="Masukkan nama wali kelas" required>
                    </div>
                    <div class="form-group">
                        <label for="kelas">kelas</label>
                        <select class="form-select" id="kelas" name="kelas" required>
                            <option selected disabled>Pilih Kelas</option>
                            <option value="10">X</option>
                            <option value="11">XI</option>
                            <option value="12">XII</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kode_jurusan">Jurusan</label>
                        <select class="form-select" id="kode_jurusan" name="kode_jurusan" required>
                            <option selected disabled>Pilih jurusan</option>
                            @foreach ($datajurusan as $jurusan)
                            <option value="{{ $jurusan->kode_jurusan }}">{{ $jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
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
        var editModal = new bootstrap.Modal(document.getElementById('Edit_walikelas'));
        editModal.show();
    });
</script>
@endif

<!-- Modal -->
<div class="modal fade" id="Edit_walikelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit wali kelas</h5>
            </div>
            @if ($editWalikelas)
            <form action="{{ route('walikelas.update', $editWalikelas->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nama_walikelas">Nama wali kelas</label>
                        <input type="text" name="nama_walikelas" class="form-control" id="nama_walikelas"
                            placeholder="Masukan nama walikelas..." value="{{ $editWalikelas->nama_walikelas }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" id="kelas" class="form-select" required>
                            <option disabled>Pilih kelas</option>
                            @if ($editWalikelas && $editWalikelas->kelas)
                            <option value="10" {{ $editWalikelas->kelas == 10 ? 'selected' : '' }}>X</option>
                            <option value="11" {{ $editWalikelas->kelas == 11 ? 'selected' : '' }}>XI</option>
                            <option value="12" {{ $editWalikelas->kelas == 12 ? 'selected' : '' }}>XII</option>
                            @endif

                            @if (!isset($editWalikelas->kelas))
                            <option value="10">X</option>
                            <option value="11">XI</option>
                            <option value="12">XII</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="kode_jurusan">Jurusan</label>
                        <select name="kode_jurusan" id="kode_jurusan" class="form-select" required>
                            <option disabled>Pilih jurusan</option>
                            @if ($editWalikelas && $editWalikelas->kode_jurusan)
                            <!-- Display the associated jurusan first -->
                            @foreach ($datajurusan as $jurusan)
                            @if ($jurusan->kode_jurusan == $editWalikelas->kode_jurusan)
                            <option value="{{ $jurusan->kode_jurusan }}" selected>{{ $jurusan->nama_jurusan }}</option>
                            @endif
                            @endforeach
                            @endif

                            <!-- Display other jurusan -->
                            @foreach ($datajurusan as $jurusan)
                            @if ($jurusan->kode_jurusan != $editWalikelas->kode_jurusan)
                            <option value="{{ $jurusan->kode_jurusan }}">{{ $jurusan->nama_jurusan }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="{{ route('walikelas.index') }}" type="button" class="btn btn-secondary">Close</a>
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