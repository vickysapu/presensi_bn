@extends('layout.masterFile')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Sekolah</h1>
                </div>
            </div>
            <div class="container-xl px-4 mt-4">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Logo Sekolah</div>
                            <div class="card-body text-center">
                                <form action="{{ route('datasekolah.updateImage') }}" method="POST"
                                    enctype="multipart/form-data" id="logoForm">
                                    @csrf
                                    @if ($indexSekolah->isEmpty())
                                        <img class="img-account-profile rounded-circle mb-2"
                                            src="{{ asset('default-logo.png') }}" style="width: 48rem"
                                            alt="Default Logo">
                                    @else
                                        @foreach ($indexSekolah as $index)
                                        <img class="img-account-profile rounded-circle mb-2"
                                            src="{{ asset('logo/' . $index->logo_sekolah) }}" style="width: 48rem"
                                            alt="Logo Sekolah">
                                        @endforeach
                                    @endif
                                    <div class="small font-italic text-muted mb-4">.PNG tidak lebih besar dari 5 MB
                                    </div>
                                    @if (session('username') != 'Guru Piket')
                                    <button class="btn btn-primary" type="button" id="changeLogoButton">
                                        Ubah
                                    </button>
                                    @endif
                                    <input type="file" id="logoInput" name="logo_sekolah" style="display:none;">
                                </form>
                            </div>
                            <script>
                                document.getElementById('changeLogoButton').addEventListener('click', function() {
                                    document.getElementById('logoInput').click();
                                });

                                document.getElementById('logoInput').addEventListener('change', function() {
                                    if (this.files && this.files.length > 0) {
                                        document.getElementById('logoForm').submit();
                                    }
                                });
                            </script>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card mb-4">
                            <div class="card-header">Detail Data</div>
                            <div class="card-body">
                                <form action="{{ route('sekolah.add') }}" method="POST">
                                    @csrf
                                    @if ($indexSekolah->isEmpty())
                                        <!-- Form kosong untuk menambahkan data baru -->
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="nama_sekolah">Nama Sekolah</label>
                                                <input class="form-control" id="nama_sekolah" name="nama_sekolah"
                                                    type="text" required placeholder="nama sekolah...">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="telepon_sekolah">No. Telepon Sekolah</label>
                                                <input class="form-control" id="telepon_sekolah" type="text"
                                                    placeholder="telepon sekolah..." name="telepon_sekolah" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="email_sekolah">Email Sekolah</label>
                                            <input class="form-control" id="email_sekolah" name="email_sekolah"
                                                type="email" placeholder="email sekolah...">
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="website_sekolah">Website Sekolah</label>
                                            <input class="form-control" id="website_sekolah" name="website_sekolah"
                                                type="text" placeholder="website sekolah...">
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="alamat_sekolah">Alamat Sekolah</label>
                                            <input class="form-control" id="alamat_sekolah" type="text"
                                                placeholder="alamat sekolah..." name="alamat_sekolah">
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="kode_pos">Kode Pos</label>
                                            <input class="form-control" id="kode_pos" name="kode_pos" type="text"
                                                placeholder="Kode pos...">
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="kepala_sekolah">Nama Kepala Sekolah</label>
                                                <input class="form-control" id="kepala_sekolah" type="text"
                                                    name="kepala_sekolah" required placeholder="nama kepala sekolah...">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="nip_kepala_sekolah">Nip Kepala Sekolah</label>
                                                <input class="form-control" id="nip_kepala_sekolah"
                                                    name="nip_kepala_sekolah" type="text"
                                                    placeholder="nip kepala sekolah..." required>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Form untuk mengedit data yang sudah ada -->
                                        @foreach ($indexSekolah as $index)
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="nama_sekolah">Nama Sekolah</label>
                                                <input class="form-control" id="nama_sekolah" name="nama_sekolah"
                                                    type="text" required placeholder="nama sekolah..."
                                                    value="{{ $index->nama_sekolah }}"
                                                    @if (session('username') == 'Guru Piket') readonly @endif>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="telepon_sekolah">No. Telepon Sekolah</label>
                                                <input class="form-control" id="telepon_sekolah" type="text"
                                                    placeholder="telepon sekolah..." name="telepon_sekolah"
                                                    value="{{ $index->telepon_sekolah }}" required
                                                    @if (session('username') == 'Guru Piket') readonly @endif>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="email_sekolah">Email Sekolah</label>
                                            <input class="form-control" id="email_sekolah" name="email_sekolah"
                                                value="{{ $index->email_sekolah }}" type="email"
                                                placeholder="email sekolah..." @if (session('username') == 'Guru Piket') readonly @endif>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="website_sekolah">Website Sekolah</label>
                                            <input class="form-control" id="website_sekolah" name="website_sekolah"
                                                value="{{ $index->website_sekolah }}" type="text"
                                                placeholder="website sekolah..." @if (session('username') == 'Guru Piket') readonly @endif>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="alamat_sekolah">Alamat Sekolah</label>
                                            <input class="form-control" id="alamat_sekolah" type="text"
                                                value="{{ $index->alamat_sekolah }}" placeholder="alamat sekolah..."
                                                name="alamat_sekolah" @if (session('username') == 'Guru Piket') readonly @endif>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="kode_pos">Kode Pos</label>
                                            <input class="form-control" id="kode_pos" name="kode_pos" type="text"
                                                value="{{ $index->kode_pos }}" placeholder="Kode pos..."
                                                @if (session('username') == 'Guru Piket') readonly @endif>
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="kepala_sekolah">Nama Kepala Sekolah</label>
                                                <input class="form-control" id="kepala_sekolah" type="text"
                                                    name="kepala_sekolah" required placeholder="nama kepala sekolah..."
                                                    value="{{ $index->kepala_sekolah }}" @if (session('username') == 'Guru Piket') readonly @endif>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="nip_kepala_sekolah">Nip Kepala Sekolah</label>
                                                <input class="form-control" id="nip_kepala_sekolah"
                                                    name="nip_kepala_sekolah" type="text"
                                                    placeholder="nip kepala sekolah..." required
                                                    value="{{ $index->nip_kepala_sekolah }}" @if (session('username') == 'Guru Piket') readonly @endif>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
