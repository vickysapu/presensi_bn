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
                                        <div class="card-body">
                                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6"></div>
                                                    <div class="col-sm-12 col-md-6"></div>
                                                </div>
                                                <div class="d-flex flex-wrap justify-content-start" style="padding: 20px; gap: 20px;">
                                                    @foreach ($pelanggaran as $item)
                                                        <div class="col-sm-6 col-md-4 col-xl-3 mb-5" style="flex: 0 0 auto; max-width: 250px;">
                                                            <div class="card card-raised h-100" style="border-radius: 10px;">
                                                                <div class="card-body">
                                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                                        <i class="fa-solid fa-folder-closed fa-2x"></i>
                                                                    </div>
                                                                    <a href="{{ asset('pelanggaran/' . $item->file_name) }}" target="_blank">
                                                                    <div class="text-center">
                                                                        <h5 class="fs-6 fw-500" style="font-size: 1.5rem;">Data Pelanggaran</h5>
                                                                        <p class="card-text font-monospace mb-3">
                                                                            {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('D, d M Y') }}
                                                                        </p>
                                                                    </div>
                                                                    </a>
                                                                    <div class="text-center">
                                                                        <a href="{{ asset('pelanggaran/' . $item->file_name) }}" target="_blank" class="btn btn-primary btn-block mb-2" download>
                                                                            <i class="fa-solid fa-file-arrow-down"></i> Unduh
                                                                        </a>
                                                                        <a href="#" class="btn btn-danger btn-block mb-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                            <i class="fa-solid fa-trash"></i> Hapus
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
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
