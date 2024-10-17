<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Izin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.3;
            margin: 0;
            padding: 4mm;
            width: 80mm;
            height: auto;
        }

        .surat-container {
            width: 100%;
            padding: 3mm;
        }

        .header {
            text-align: left;
            margin-bottom: 3px;
        }

        .details .row {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 5px;
            text-align: right;
        }

        h4 {
            margin: 1px 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 4mm;
                width: 80mm;
                height: auto;
            }

            * {
                -webkit-print-color-adjust: exact;
            }

            @page {
                margin: 5mm;
                size: 80mm auto;
            }
        }
    </style>


</head>

<body onload="window.print();">
    <div class="surat-container">
        <div class="header">
            @php
                $data = App\Models\sekolah::first();
            @endphp
            @if ($data)
                <p style="font-weight: bold;">{{ $data->nama_sekolah }}</p>
                <p><small>{{ $data->alamat_sekolah }}</small></p>
                <hr style="border: 0.5px solid black;">
            @endif
        </div>

        <div class="details">
            <div class="row">
                <div>
                    <strong>No:</strong>
                    @if (isset($suratIzins[0]))
                        {{ $suratIzins[0]->nomor }}
                    @endif
                </div>
            </div>
            <div class="row">
                <div>
                    <strong>Hal:</strong>
                    @if (isset($suratIzins[0]))
                        {{ $suratIzins[0]->perihal }}
                    @endif
                </div>
            </div>
            <h4>Kepada Yth. Bp/Ibu Guru</h4>
            <h4>Dengan ini kami memberitahukan bahwa:</h4>
            <div class="row" style="margin-top: 3px;">
                <div>
                    <strong>Nama:</strong>
                    @php
                        $namaSiswa = $studentsWithSameUUID->pluck('nama_siswa')->join(', ');
                    @endphp
                    {{ $namaSiswa }}
                </div>
            </div>
            <div class="row">
                <div>
                    <strong>Kelas:</strong>
                    @if (isset($suratIzins[0]->student))
                        @if ($suratIzins[0]->student->kelas == 10)
                            X
                        @elseif ($suratIzins[0]->student->kelas == 11)
                            XI
                        @elseif ($suratIzins[0]->student->kelas == 12)
                            XII
                        @endif
                        {{ $suratIzins[0]->student->jurusan->nama_jurusan }}
                    @endif
                </div>
            </div>

            @php
                \Carbon\Carbon::setLocale('id');
                $tanggal = \Carbon\Carbon::now()->translatedFormat('l, d F Y');
            @endphp

            <h4>Tidak mengikuti kegiatan belajar mengajar pada hari {{ $tanggal }} pada jam
                @if (isset($suratIzins[0]))
                    {{ $suratIzins[0]->jam_pelajaran }}
                @endif
                dengan alasan
                @if (isset($suratIzins[0]))
                    {{ $suratIzins[0]->keterangan }}
                @endif
            </h4>
        </div>

        <div class="footer">
            <p>Semarang, {{ now()->format('d/m/Y') }}</p>
            <p>{{ session('username') }}</p>
            <br><br>
            <p>( {{ session('nama_pengguna') }} )</p>
        </div>
    </div>
</body>

</html>
