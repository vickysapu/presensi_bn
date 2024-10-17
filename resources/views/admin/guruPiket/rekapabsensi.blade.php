@extends('layout.masterFile')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Rekap Presensi</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @php
                                    $previousYear = null;
                                @endphp

                                @if (session('datawalikelas'))
                                    <div class="d-flex flex-wrap justify-content-start">
                                        @if ($absenrekapwalikelas->isEmpty())
                                            <p>Belum ada rekapan.</p>
                                        @else
                                            @foreach ($absenrekapwalikelas as $rekap)
                                                @php
                                                    $currentYear = $rekap->created_at->format('M Y');
                                                @endphp

                                                @if ($currentYear !== $previousYear)
                                                    <h5 class="p-3 w-100">{{ $currentYear }}</h5>
                                                    @php
                                                        $previousYear = $currentYear;
                                                    @endphp
                                                @endif
                                                <a href="{{ asset('absensi/' . $rekap->file_name) }}" target="_blank"
                                                    class="text-decoration-none mt-2 mb-2">
                                                    <div class="card border-left-success shadow h-100 py-2 mx-2 mb-4"
                                                        style="width: 18rem;">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col-8">
                                                                    <div
                                                                        class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                        File: <br> {{ $rekap->file_name }}
                                                                    </div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                        {{ $rekap->kelas }} {{ $rekap->jurusan }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 text-center">
                                                                    <i class="fa-solid fa-file-pdf fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>

                                                            <!-- Buttons Section -->
                                                            <div class="row mt-3">
                                                                <div class="col-6">
                                                                    <a href="{{ route('rekap.hapus', $rekap->id) }}"
                                                                        class="btn btn-danger btn-block"
                                                                        onclick="Swal.fire({
                                                                             title: 'Apa Anda Yakin?',
                                                                             text: 'Anda tidak akan dapat mengembalikan ini!',
                                                                             icon: 'warning',
                                                                             showCancelButton: true,
                                                                             confirmButtonColor: '#3085d6',
                                                                             cancelButtonColor: '#d33',
                                                                             cancelButtontext : 'Batal',
                                                                             confirmButtonText: 'Ya, hapus!'
                                                                         }).then((result) => {
                                                                             if (result.isConfirmed) {
                                                                                 window.location.href = '{{ route('rekap.hapus', $rekap->id) }}';
                                                                             }
                                                                         }); return false;">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="{{ asset('absensi/' . $rekap->file_name) }}"
                                                                        onclick="Swal.fire({
                                                                           title: 'Apa Anda Yakin?',
                                                                           text: 'Kamu ingin mengunduh file ini lagi!',
                                                                           icon: 'question',
                                                                           showCancelButton: true,
                                                                           confirmButtonColor: '#3085d6',
                                                                           cancelButtonColor: '#d33',
                                                                           cancelButtonText : 'Batal',
                                                                           confirmButtonText: 'Ya, Donwload!'
                                                                         }).then((result) => {
                                                                           if (result.isConfirmed) {
                                                                             window.location.href = '{{ asset('absensi/' . $rekap->file_name) }}';
                                                                             Swal.fire({
                                                                               title: 'Downloaded!',
                                                                               text: 'Your file has been downloaded.',
                                                                               icon: 'success'
                                                                             });
                                                                           }
                                                                         });
                                                                         return false;"
                                                                        class="btn btn-success btn-block download-btn" download>
                                                                        <i class="fa-solid fa-file-arrow-down"></i>
                                                                     </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <div class="d-flex flex-wrap justify-content-start">
                                        @if ($absenrekap->isEmpty())
                                            <p>Belum ada rekapan.</p>
                                        @else
                                            @foreach ($absenrekap as $rekap)
                                                @php
                                                    $currentYear = $rekap->created_at->format('M Y');
                                                @endphp

                                                @if ($currentYear !== $previousYear)
                                                    <h5 class="p-3 w-100">{{ $currentYear }}</h5>
                                                    @php
                                                        $previousYear = $currentYear;
                                                    @endphp
                                                @endif
                                                <a href="{{ asset('absensi/' . $rekap->file_name) }}" target="_blank"
                                                    class="text-decoration-none mt-2 mb-2">
                                                    <div class="card border-left-success shadow h-100 py-2 mx-2 mb-4"
                                                        style="width: 18rem;">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col-8">
                                                                    <div
                                                                        class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                        File: <br> {{ $rekap->file_name }}
                                                                    </div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                        {{ $rekap->kelas }} {{ $rekap->jurusan }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 text-center">
                                                                    <i class="fa-solid fa-file-pdf fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-6">
                                                                    <a href="{{ route('rekap.hapus', $rekap->id) }}"
                                                                        class="btn btn-danger btn-block"
                                                                        onclick="Swal.fire({
                                                                            title: 'Apa Anda Yakin?',
                                                                            text: 'Anda tidak akan dapat mengembalikan ini!',
                                                                            icon: 'warning',
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: '#3085d6',
                                                                            cancelButtonColor: '#d33',
                                                                            cancelButtonText : 'Batal',
                                                                            confirmButtonText: 'Ya, hapus!'
                                                                        }).then((result) => {
                                                                            if (result.isConfirmed) {
                                                                                window.location.href = '{{ route('rekap.hapus', $rekap->id) }}';
                                                                            }
                                                                        }); return false;">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="{{ asset('absensi/' . $rekap->file_name) }}"
                                                                        onclick="Swal.fire({
                                                                            title: 'Apa Anda Yakin?',
                                                                            text: 'Kamu ingin mengunduh file ini lagi!',
                                                                            icon: 'question',
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: '#3085d6',
                                                                            cancelButtonColor: '#d33',
                                                                            cancelButtonText : 'Batal',
                                                                            confirmButtonText: 'Ya, Donwload!'
                                                                          }).then((result) => {
                                                                            if (result.isConfirmed) {
                                                                              window.location.href = '{{ asset('absensi/' . $rekap->file_name) }}';
                                                                              Swal.fire({
                                                                                title: 'Downloaded!',
                                                                                text: 'Your file has been downloaded.',
                                                                                icon: 'success'
                                                                              });
                                                                            }
                                                                          });
                                                                          return false;"
                                                                        class="btn btn-success btn-block download-btn"
                                                                        download>
                                                                        <i class="fa-solid fa-file-arrow-down"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
