<?php

namespace App\Http\Controllers;

use App\Models\datapelangaran;
use App\Models\pelanggaran;
use App\Models\student;
use App\Models\rekappelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class pelanggaranController extends Controller
{

    public function rekappelanggaran() {
        $pelanggaran = rekappelanggaran::all();
        return view('admin.guruPiket.rekappelanggaran', compact('pelanggaran'));
    }

    public function index()
    {
        $datasiswa = student::all();
        $datapelanggaranpoin = datapelangaran::all();

        $datapelanggaransiswawalikelas = [];
        $nama_pelanggaran = [];
        $jumlah_pelanggaran = [];

        if (session('datawalikelas')) {
            $datapengguna = session('datawalikelas');

            $datapelanggaransiswaall = student::with('jurusan', 'pelanggarans.datapelanggaran')
                ->where('kelas', $datapengguna->kelas)
                ->where('kode_jurusan', $datapengguna->kode_jurusan)
                ->whereHas('pelanggarans') // Ensure students have violations
                ->get();

            $datapelanggaransiswawalikelas = student::with('jurusan', 'pelanggarans.datapelanggaran')
                ->where('kelas', $datapengguna->kelas)
                ->where('kode_jurusan', $datapengguna->kode_jurusan)
                ->whereHas('pelanggarans')
                ->get();

            // Fetch violations for today
            $waktu = now()->format('Y-m-d');
            $indexpelanggaransiswa = pelanggaran::whereDate('created_at', $waktu)
                ->whereHas('walikelassiswa', function ($query) use ($datapengguna) {
                    $query->where('kelas', $datapengguna->kelas)
                        ->where('kode_jurusan', $datapengguna->kode_jurusan);
                })
                ->get();
        } else {
            $datapelanggaransiswaall = student::with('jurusan', 'pelanggarans.datapelanggaran')
                ->whereHas('pelanggarans')
                ->get();

            $waktu = now()->format('Y-m-d');
            $indexpelanggaransiswa = pelanggaran::whereDate('created_at', $waktu)->get();
        }

        foreach ($indexpelanggaransiswa as $pelanggaran) {
            if ($pelanggaran->datapelanggaran) {
                $nama_pelanggaran[] = $pelanggaran->datapelanggaran->nama_pelanggaran;

                $jumlah_pelanggaran[] = pelanggaran::where('id_pelanggaran', $pelanggaran->datapelanggaran->id)
                    ->count();
            }
        }

        return view('admin.guruPiket.pelanggaran', compact(
            'datapelanggaransiswawalikelas',
            'indexpelanggaransiswa',
            'datasiswa',
            'datapelanggaranpoin',
            'datapelanggaransiswaall',
            'nama_pelanggaran',
            'jumlah_pelanggaran'
        ));
    }


    public function add(Request $request)
    {
        $addpelanggaransiswa = new pelanggaran();

        $nis = $request->input('nis');
        $datanis = student::where('nama_siswa', $nis)->first();

        $poin = $request->input('poin');
        $datapoin = datapelangaran::where('jenis_pelanggaran', $poin)->first();

        $addpelanggaransiswa->id_pelanggaran = $datapoin->id;
        $addpelanggaransiswa->nis = $datanis->nis;
        $addpelanggaransiswa->keterangan = $request->input('keterangan');
        $addpelanggaransiswa->save();

        return redirect()->route('pelanggaransiswa.index');
    }
}
