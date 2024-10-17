<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kehadiran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .content-wrapper {
            width: 100%;
            padding: 1px;
        }

        .content-header {
            margin-bottom: 5px;
        }

        .container {
            padding: 0.5cm;
        }

        h1,
        h2 {
            color: #333;
        }

        .text-decoration-none {
            text-decoration: none;
        }

        .text-dark {
            color: #333;
        }

        .hover-link:hover {
            color: #0056b3;
        }

        .text-primary {
            color: #007bff;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 0px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table th[rowspan] {
            vertical-align: middle;
        }

        .table thead th {
            background-color: #ECECEC;
            color: black;
        }

        /* Weekend Styles */
        .table th[style*="background-color: #F55050;"],
        .table td[style*="background-color: #F55050;"] {
            background-color: #F55050;
            color: white;
        }

        /* Attendance Color Coding */
        .attendance-h {
            background-color: green;
            color: white;
            padding: 5px;
            border-radius: 2px;
        }

        .attendance-a {
            background-color: #A02334;
            color: white;
            padding: 5px;
            border-radius: 2px;
        }

        .attendance-s {
            background-color: #4D96FF;
            color: white;
            padding: 5px;
            border-radius: 2px;
        }

        .attendance-i {
            background-color: #FCCD2A;
            color: black;
            padding: 5px;
            border-radius: 2px;
        }

        /* Table Headers for Totals */
        th.total-h {
            background-color: green;
            color: white;
        }

        th.total-a {
            background-color: #A02334;
            color: white;
        }

        th.total-s {
            background-color: #4D96FF;
            color: white;
        }

        th.total-i {
            background-color: #FCCD2A;
            color: black;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -1px;
        }

        .column {
            flex: 1;
            padding: 1px;
            box-sizing: border-box;
        }


        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            text-align: center;
            font-size: 8px;
        }

        .grid-container>div {
            padding: 0px;
            margin-top: -6px;
            margin-bottom: -10px;
            ;
        }
    </style>
</head>

<body>

    @php
        use Carbon\Carbon;
    @endphp
    @php
        $sekolah = App\Models\Sekolah::first();
    @endphp

    <div class="container">
        <table style="font-size: 6px; width: 10cm; margin: 0 auto 5px auto; text-align: center; margin-left : 10.5cm;">
            <tr>
                <td style="text-align: center; vertical-align: middle;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo/' . $sekolah->logo_sekolah))) }}"
                        alt="School Logo" style="width: 12mm;">
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <div>
                        <h6 style="font-size: 8px;">YAYASAN SMK BAGIMU NEGERIKU</h6>
                        <h5 style="font-size: 10px;">{{ $sekolah->nama_sekolah }} SEMARANG</h5>
                        <p style="font-size: 8px;">No SK Pendirian: 420/2823/2011, NSS: 420 363 16087, NPSN: 2036 2057
                        </p>
                        <p style="font-size: 8px;">{{ $sekolah->alamat_sekolah }} Telp. {{ $sekolah->telepon_sekolah }}
                        </p>
                        <p style="font-size: 8px;">email: {{ $sekolah->email_sekolah }} , website:
                            {{ $sekolah->website_sekolah }}</p>
                    </div>
                </td>
            </tr>
        </table>


        <hr>

        <table style="font-size: 10px; width: 100%; text-align:left;">
            <tr style="text-align: center;">
                <td colspan="2"><strong>PRESENSI KELAS</strong></td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    <strong>Program Keahlian: {{ $walikelas->jurusan->kepanjangan_jurusan }}</strong>
                </td>
                <td style="text-align: right;">
                    <strong>
                        Kelas:
                        @if ($walikelas->kelas == 10)
                            X
                        @elseif ($walikelas->kelas == 11)
                            XI
                        @elseif ($walikelas->kelas == 12)
                            XII
                        @endif
                        / {{ $walikelas->jurusan->nama_jurusan }}
                    </strong>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    <strong>Tahun Pelajaran:
                        @if ($datatahunpelajaran && count($datatahunpelajaran) > 0)
                            @foreach ($datatahunpelajaran as $data)
                                @if ($data->status == '1')
                                    {{ $data->tahunmulai }}/{{ $data->tahunselesai }} -
                                    @if ($data->semester == 1)
                                        Ganjil
                                    @elseif ($data->semester == 2)
                                        Genap
                                    @endif
                                @endif
                            @endforeach
                        @else
                            Tahun pelajaran tidak ditemukan.
                        @endif
                    </strong>
                </td>
                <td style="text-align: right;">
                    <strong>
                        Bulan: {{ Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}
                    </strong>
                </td>
            </tr>
        </table>


        <table class="table table-bordered text-center" style="font-size: 10px; margin-top: 10px;">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Siswa</th>
                    <th rowspan="2">NIS</th>
                    <th colspan="{{ $totalDays }}">Tanggal</th>
                    <th rowspan="2" style="background-color : #379777;">H</th>
                    <th rowspan="2" style="background-color : #B43F3F;">A</th>
                    <th rowspan="2" style="background-color : #03AED2;">S</th>
                    <th rowspan="2" style="background-color : #FDDE55;">I</th>
                </tr>
                <tr>
                    @for ($day = 1; $day <= $totalDays; $day++)
                        @php
                            $date = Carbon::create($currentYear, $currentMonth, $day);
                            $isWeekend = $date->isWeekend();
                        @endphp
                        <th style="{{ $isWeekend ? 'background-color: #EEEEEE; color: black;' : '' }}">
                            {{ str_pad($day, 2, '0', STR_PAD_LEFT) }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $siswa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="text-align: left; padding: 2px;">{{ $siswa->nama_siswa }}</td>
                        <td style="padding: 2px;">{{ $siswa->nis }}</td>

                        @for ($day = 1; $day <= $totalDays; $day++)
                            @php
                                $date = Carbon::create($currentYear, $currentMonth, $day);
                                $isWeekend = $date->isWeekend();
                            @endphp
                            <td
                                style="{{ $isWeekend ? 'background-color: rgb(80, 80, 80); color: black; padding: 2px;' : 'padding: 2px;' }}">
                                @if (isset($attendanceData[$siswa->nama_siswa][$day]))
                                    @if ($attendanceData[$siswa->nama_siswa][$day] === 'Hadir')
                                        <span
                                            style="font-weight : bold; color: green; padding: 3px; border-radius: 2px;">H</span>
                                    @elseif ($attendanceData[$siswa->nama_siswa][$day] === 'Tidak Hadir')
                                        <span
                                            style=" font-weight : bold; color: #A02334; padding: 3px; border-radius: 2px;">A</span>
                                    @elseif ($attendanceData[$siswa->nama_siswa][$day] === 'Sakit')
                                        <span
                                            style="font-weight : bold; color: #4D96FF; padding: 3px; border-radius: 2px;">S</span>
                                    @elseif ($attendanceData[$siswa->nama_siswa][$day] === 'Izin')
                                        <span
                                            style="font-awesome : bold; background-color: #FCCD2A; height : 100%; width : 100%; padding: 3px; border-radius: 2px;">I</span>
                                    @elseif ($attendanceData($siswa->nama_siswa)[$day] == 'Magang')
                                        <span
                                            style="font-awesome : bold; color: #BC7C7C; padding: 3px; border-radius: 2px;">M</span>
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
                    <td colspan="3" class="text-left">Jumlah Siswa Seluruhnya</td>
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

                        <td style="">
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
                    <td colspan="3" class="text-left">Jumlah Siswa Tidak Hadir</td>
                    @for ($day = 1; $day <= $totalDays; $day++)
                        @php
                            $countPerDay = 0;
                            foreach ($students as $student) {
                                if (
                                    isset($attendanceData[$student->nama_siswa][$day]) &&
                                    ($attendanceData[$student->nama_siswa][$day] == 'Tidak Hadir' ||
                                        $attendanceData[$student->nama_siswa][$day] == 'Izin' ||
                                        $attendanceData[$student->nama_siswa][$day] == 'Sakit' ||
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
                    <td colspan="3" class="text-left">Jumlah Siswa Hadir</td>
                    @for ($day = 1; $day <= $totalDays; $day++)
                        @php
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

        <br>

        <div style="text-align: right; font-size: 10px;">
            <p>Semarang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Wali Kelas,</p>
            <br><br>
            <p>{{ $walikelas->nama_walikelas }}</p>
        </div>
    </div>
</body>

</html>
