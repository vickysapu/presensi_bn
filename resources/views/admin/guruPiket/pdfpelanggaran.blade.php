<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body {
            text-align: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            padding: 2cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            padding: 2px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #000;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .signature {
            font-size: 15px;
            margin-top: 50px;
            text-align: center;
            margin-right: 50px;
            font-size: 10px;
        }

        .signature p {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <h3>DATA PELANGGARAN SISWA</h3>

    @php
        $bulanIndo = [
            'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April',
            'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus',
            'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember'
        ];
        $hariIndo = [
            'Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa', 'Wed' => 'Rabu',
            'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu'
        ];

        $hari = $hariIndo[now()->format('D')];
        $bulan = $bulanIndo[now()->format('M')];
        $tanggal = now()->format('d');
        $tahun = now()->format('Y');
    @endphp

    <h6>Hari/Tanggal : {{ $hari }}, {{ $tanggal }} {{ $bulan }} {{ $tahun }}</h5>

    <table style="font-size : 12px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas/Jurusan</th>
                <th>Jenis Pelanggaran</th>
                <th>Jumlah Poin</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($datapelanggaransiswaall->sortByDesc('total_poin') as $student)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td style="text-align: left;">{{ $student->nama_siswa }}</td>
                    <td>
                        @if ($student->kelas == 10)
                            X
                        @elseif($student->kelas == 11)
                            XI
                        @elseif ($student->kelas == 12)
                            XII
                        @endif
                        / {{ $student->jurusan->nama_jurusan }}
                    </td>
                    <td style="text-align: left;">
                        @foreach ($datajenis as $jenis)
                            @if ($jenis['nis'] == $student->nis)
                                - {{ $jenis['jenis_pelanggaran'] }} = {{ $jenis['poin'] }} poin
                                <br>
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $student->total_poin }} poin</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $sekolah = App\Models\sekolah::first();
    @endphp

    <div class="signature">
        <p>Mengetahui,</p>
        <p>Kepala Sekolah {{ $sekolah->nama_sekolah }}</p>
        <br><br><br>
        <p><strong>{{ $sekolah->kepala_sekolah }}</strong></p>
    </div>
</body>

</html>
