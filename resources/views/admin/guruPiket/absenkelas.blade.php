@extends('layout.masterFile')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            @if (session('datawalikelas'))
                            @else
                                <span>
                                    <a href="{{ route('absensi.index') }}"
                                        class="text-decoration-none text-dark hover-link text-primary">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </span>
                            @endif

                            Data Absen Kelas {{ $walikelas->kelas }} {{ $walikelas->jurusan->nama_jurusan }}
                        </h1>
                        @if (session('datawalikelas'))
                            <a href="{{ route('generate.pdfwalikelas', session('datawalikelas')->id) }}"
                                class="btn btn-success mt-4">Unduh absen</a>
                        @else
                            <a href="{{ route('generate.pdfwalikelas', $walikelas->id) }}   "
                                class="btn btn-success mt-4">Unduh absen</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <section class="content mt-4" id="pdf">
            <div class="container-fluid">
                @php
                    use Carbon\Carbon;
                @endphp

                <div class="container mt-3">
                    <h2>Presensi Kelas {{ $walikelas->kelas }} {{ $walikelas->jurusan->nama_jurusan }}</h2>
                    <p><strong>Nama Walikelas:</strong> {{ $walikelas->nama_walikelas }}</p>

                    @if ($datatahunpelajaran)
                        <p><strong>Tahun Pelajaran:</strong>
                            {{ $datatahunpelajaran->tahunmulai }}/{{ $datatahunpelajaran->tahunselesai }} -
                            @if ($datatahunpelajaran->semester == 1)
                                Ganjil
                            @else
                                Genap
                            @endif
                        </p>
                    @else
                        <p>Tahun pelajaran tidak tersedia.</p>
                    @endif


                    <p><strong>Bulan:</strong> {{ Carbon::now()->isoFormat('MMMM YYYY') }}</p>

                    <!-- Tabel Presensi -->
                    <div class="table-responsive mt-3">
                        <style>
                            .table th,
                            .table td {
                                padding: 0.1rem;
                                /* Ubah sesuai kebutuhan */
                            }
                        </style>

                        <table class="table table-bordered table-responsive" style="font-size: 12px;">
                            <thead class="text-center">
                                <tr>
                                    @php
                                        $no = 1;
                                    @endphp
                                    <th rowspan="2" class="text-nowrap" style="width: 50px;">No</th>
                                    <th rowspan="2" class="text-nowrap" style="width: 100px;">Nama Siswa</th>
                                    <!-- Lebar 100px -->
                                    <th rowspan="2" class="text-nowrap" style="width: 100px;">NIS</th>
                                    <th rowspan="2" class="text-nowrap" style="width: 50px;">L/P</th>
                                    <th colspan="{{ $totalDays }}">Tanggal</th>
                                    <th colspan="4">Jumlah</th>
                                </tr>
                                <tr>
                                    @for ($day = 1; $day <= $totalDays; $day++)
                                        @php
                                            $date = Carbon::create($currentYear, $currentMonth, $day);
                                            $isWeekend = $date->isWeekend();
                                        @endphp
                                        <th style="{{ $isWeekend ? 'background-color: #F55050; color: white;' : '' }}">
                                            {{ str_pad($day, 2, '0', STR_PAD_LEFT) }}
                                        </th>
                                    @endfor
                                    <th style="background-color: #28a745; color: black;">H</th>
                                    <th style="background-color: #dc3545; color: black;">A</th>
                                    <th style="background-color: #17a2b8; color: black;">S</th>
                                    <th style="background-color: #ffc107; color: black;">I</th>
                                    <th style="background-color: #789DBC; color: black;">M</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($students as $siswa)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td class="text-nowrap text-left" style="width: 100px;">{{ $siswa->nama_siswa }}
                                        </td> <!-- Lebar 100px -->
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ strtolower($siswa->jenis_kelamin) === 'laki-laki' ? 'L' : 'P' }}</td>
                                        @for ($day = 1; $day <= $totalDays; $day++)
                                            @php
                                                $date = Carbon::create($currentYear, $currentMonth, $day);
                                                $isWeekend = $date->isWeekend();
                                            @endphp
                                            <td style="{{ $isWeekend ? 'background-color: #F55050; color: white;' : '' }}">
                                                @if (isset($attendanceData[$siswa->nama_siswa][$day]))
                                                    @if ($attendanceData[$siswa->nama_siswa][$day] === 'Hadir')
                                                        <span class="text-success" style="font-size: 8px">&#10003;</span>
                                                    @elseif ($attendanceData[$siswa->nama_siswa][$day] === 'Tidak Hadir')
                                                        <span class="text-danger" style="font-size: 8px">&#10007;</span>
                                                    @elseif ($attendanceData[$siswa->nama_siswa][$day] === 'Sakit')
                                                        <span class="text-info" style="font-size: 8px">S</span>
                                                    @elseif ($attendanceData[$siswa->nama_siswa][$day] === 'Izin')
                                                        <span class="text-dark" style="font-size: 8px">I</span>
                                                    @elseif ($attendanceData[$siswa->nama_siswa][$day] == 'Magang')
                                                        <span class="text-dark" style="font-size: 8px">M</span>
                                                    @endif
                                                @elseif (!$isWeekend)
                                                    <span></span>
                                                @endif
                                            </td>
                                        @endfor

                                        <td>{{ array_count_values($attendanceData[$siswa->nama_siswa] ?? [])['Hadir'] ?? '' }}
                                        </td>
                                        <td>{{ array_count_values($attendanceData[$siswa->nama_siswa] ?? [])['Tidak Hadir'] ?? '' }}
                                        </td>
                                        <td>{{ array_count_values($attendanceData[$siswa->nama_siswa] ?? [])['Sakit'] ?? '' }}
                                        </td>
                                        <td>{{ array_count_values($attendanceData[$siswa->nama_siswa] ?? [])['Izin'] ?? '' }}
                                        </td>
                                        <td>{{ array_count_values($attendanceData[$siswa->nama_siswa] ?? [])['Magang'] ?? '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <td colspan="4" class="text-left">Jumlah Siswa Seluruhnya</td>
                                    @for ($day = 1; $day <= $totalDays; $day++)
                                        @php
                                            $date = Carbon::create($currentYear, $currentMonth, $day);
                                            $isWeekend = $date->isWeekend();
                                            $countPerDay = 0;

                                            foreach ($students as $student) {
                                                if (isset($attendanceData[$student->nama_siswa][$day])) {
                                                    $countPerDay++;
                                                }
                                            }
                                        @endphp

                                        <td style="{{ $isWeekend ? 'background-color: #dc3545; color: white;' : '' }}">
                                            @if ($isWeekend)
                                                <strong></strong>
                                            @else
                                                <strong>{{ $jumalahsemuanya ? $jumalahsemuanya : '' }}</strong>
                                            @endif
                                        </td>
                                    @endfor

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-left">Jumlah Siswa Tidak Hadir</td>
                                    @for ($day = 1; $day <= $totalDays; $day++)
                                        @php
                                            $isWeekend = $date->isWeekend();
                                            $countPerDay = 0;
                                            foreach ($students as $student) {
                                                if (
                                                    isset($attendanceData[$student->nama_siswa][$day]) &&
                                                    ($attendanceData[$student->nama_siswa][$day] == 'Tidak Hadir' ||
                                                        $attendanceData[$student->nama_siswa][$day] == 'Izin' ||
                                                        $attendanceData[$student->nama_siswa][$day] == 'Sakit'||
                                                        $attendanceData[$student->nama_siswa][$day] == 'Magang')
                                                ) {
                                                    $countPerDay++;
                                                }
                                            }
                                        @endphp
                                        <td style="{{ $isWeekend ? 'background-color: #dc3545; color: white;' : '' }}">
                                            @if ($isWeekend)
                                                <strong></strong>
                                            @else
                                            <strong>{{ $countPerDay ? $countPerDay : '' }}</strong>
                                            @endif
                                        </td>
                                    @endfor
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-left">Jumlah Siswa Hadir</td>
                                    @for ($day = 1; $day <= $totalDays; $day++)
                                        @php
                                            $isWeekend = $date->isWeekend();
                                            $countPerDay = 0;
                                            foreach ($students as $student) {
                                                if (
                                                    isset($attendanceData[$student->nama_siswa][$day]) &&
                                                    $attendanceData[$student->nama_siswa][$day] == 'Hadir'
                                                ) {
                                                    $countPerDay++;
                                                }
                                            }
                                        @endphp
                                        <td style="{{ $isWeekend ? 'background-color: #dc3545; color: white;' : '' }}">
                                            @if ($isWeekend)
                                                <strong></strong>
                                            @else
                                            <strong>{{ $countPerDay ? $countPerDay : '' }}</strong>
                                            @endif
                                        </td>
                                    @endfor
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                    <div class="mt-3 mb-3">
                        <p><strong>Keterangan:</strong></p>
                        <p><span class="badge badge-success">H = Hadir</span></p>
                        <p><span class="badge badge-danger">A = Tidak Hadir</span></p>
                        <p><span class="badge badge-info">S = Sakit</span></p>
                        <p><span class="badge badge-warning">I = Izin</span></p>
                        <p><span class="badge badge-primary">M = Magang</span></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
