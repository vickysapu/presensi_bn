@extends('layout.masterFile')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Surat Izin</h1>
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
                                                    <i class="fa fa-plus"></i> Buat Surat
                                                </a>
                                            @endif
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <form action="{{ route('suratizin.cetak') }}" class="p-3" method="POST">
                                                        @csrf
                                                        <div class="form-check">

                                                            <div class="form-group">
                                                                <label for="nomor">Nomor Surat</label>
                                                                <input type="text" class="form-control" id="nomor"
                                                                    name="nomor" aria-describedby="emailHelp"
                                                                    placeholder="Nomor Surat">
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <div class="form-group mb-3">
                                                                <label for="perihal">Perihal</label>
                                                                <input type="text" class="form-control" id="perihal"
                                                                    name="perihal" placeholder="perihal">
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <div class="form-group mb-3">
                                                                <label for="nis">Nama Siswa</label>
                                                                <input type="text" class="form-control" name="nis"
                                                                    id="nis" placeholder="Nama Siswa..."
                                                                    list="datalistOptions" oninput="validateForm()">
                                                                <datalist id="datalistOptions">
                                                                    @foreach ($datasiswa as $item)
                                                                        <option value="{{ $item->nama_siswa }}"></option>
                                                                    @endforeach
                                                                </datalist>
                                                                <small id="nisAlert" class="text-danger"
                                                                    style="display: none;">Nama
                                                                    siswa tidak ada.</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <div class="form-group">
                                                                <label for="jam_pelajaran">Jam Pelajaran</label>
                                                                <input type="time" class="form-control"
                                                                    id="jam_pelajaran" name="jam_pelajaran"
                                                                    placeholder="jam pelajaran">
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <div class="form-group">
                                                                <label for="keterangan">Alasan</label>
                                                                <input type="text" class="form-control" id="keterangan"
                                                                    name="keterangan" placeholder="Alasan">
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <button type="submit" class="btn btn-primary">Buat</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm p-2">
                                                    hallo
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
