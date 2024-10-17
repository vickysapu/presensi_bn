<?php

namespace App\Http\Controllers;

use App\Imports\ImportDataSiswa;
use App\Models\absensi;
use App\Models\datapelangaran;
use App\Models\datapiket;
use Illuminate\Http\Request;
use App\Models\student;
use App\Models\jurusan;
use App\Models\pelanggaran;
use App\Models\walikelas;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\FacadesLog;
use Maatwebsite\Excel\Facades\Excel;

class studentController extends Controller
{
    public function addfoto(Request $request, $nis)
    {
        $request->validate([
            'foto_pelajar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $addfoto = student::find($nis);

        if ($request->hasFile('foto_pelajar')) {
            $image = $request->file('foto_pelajar');

            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('fotoPelajar'), $fileName);

            $addfoto->foto_pelajar = $fileName;
            $addfoto->save();
        }

        return redirect()->route('datasiswa.preview', ['nis' => $nis]);
    }

    public function add(Request $request)
    {
        $addsiswa = new student();

        $addsiswa->nama_siswa = $request->input('nama_siswa');
        $addsiswa->nis = $request->input('nis');
        $addsiswa->nisn = $request->input('nisn');
        $addsiswa->kelas = $request->input('kelas');
        $addsiswa->kode_jurusan = $request->input('kode_jurusan');
        $addsiswa->jenis_kelamin = $request->input('jenis_kelamin');

        if ($request->hasFile('foto_pelajar')) {
            $image = $request->file('foto_pelajar');

            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('fotoPelajar'), $fileName);

            $addsiswa->foto_pelajar = $fileName;
        } else {
            $addsiswa->foto_pelajar = 'default.jpg';
        }

        $addsiswa->save();

        return redirect()->route('datasiswa.index')->with('success', 'Berhasil menambahkan data!');
    }

    public function index(Request $request)
    {
        $datajurusan = jurusan::all();
        $alldatasiswa = student::all();

        $kelas = $request->input('kelas');
        $jurusan = $request->input('kode_jurusan');
        $search = $request->input('search');

        $penggunasiswa = null;

        if (session('datawalikelas')) {
            $datapengguna = session('datawalikelas');

            $penggunasiswa = student::where('kelas', $datapengguna->kelas)
                ->where('kode_jurusan', $datapengguna->kode_jurusan)
                ->paginate(10);
        }

        $query = student::query();

        if ($kelas) {
            $query->where('kelas', $kelas);
        }

        if ($jurusan) {
            $query->where('kode_jurusan', $jurusan);
        }

        if ($search) {
            $query->where('nama_siswa', 'like', '%' . $search . '%');
        }

        $indexdatasiswa = $query->paginate(10);
        $totaldatasiswa = student::count();

        $editModalId = session('edit_modal_id');
        $editdatasiswa = $editModalId ? student::where('nis', $editModalId)->first() : null;

        $previewModalNis = session('preview_modal_nis');
        $previewdatasiswa = $previewModalNis ? student::where('nis', $previewModalNis)->first() : null;

        return view('admin.guruPiket.dataSiswa', compact('indexdatasiswa', 'editdatasiswa', 'previewdatasiswa', 'totaldatasiswa', 'alldatasiswa', 'datajurusan', 'penggunasiswa'));
    }


    public function hapus($nis)
    {
        $hapusdatasiswa = student::where('nis', $nis);
        $hapusdatasiswa->delete();

        $hapuspelanggaran = pelanggaran::where('nis', $nis);
        $hapuspelanggaran->delete();

        $hapusabsen = absensi::where('nis', $nis);
        $hapusabsen->delete();

        return redirect()->route('datasiswa.index');
    }

    public function edit($nis)
    {
        $editdatasiswa = student::where('nis', $nis)->firstOrFail();

        session()->flash('edit_modal_id', $nis);

        return redirect()->route('datasiswa.index');
    }

    public function preview($nis)
    {
        $previewdatasiswa = student::where('nis', $nis)->firstOrFail();

        session()->flash('preview_modal_nis', $nis);

        return redirect()->route('datasiswa.index');
    }

    public function update(Request $request, $nis)
    {
        $updatedatasiswa = student::find($nis);

        $updatedatasiswa->nama_siswa = $request->input('nama_siswa');
        $updatedatasiswa->nis = $request->input('nis');
        $updatedatasiswa->nisn = $request->input('nisn');
        $updatedatasiswa->kelas = $request->input('kelas');
        $updatedatasiswa->kode_jurusan = $request->input('kode_jurusan');
        $updatedatasiswa->jenis_kelamin = $request->input('jenis_kelamin');

        if ($request->hasFile('foto_pelajar')) {
            $image = $request->file('foto_pelajar');
            $fileName = $image->getClientOriginalName();

            $oldImage = public_path('fofoPelajar/' . $updatedatasiswa->foto);
            if (File::exists($oldImage)) {
                File::delete($oldImage);
            }

            $image->move(public_path('fotoPelajar'), $fileName);
            $updatedatasiswa->foto = $fileName;
        }
        $updatedatasiswa->save();

        return redirect()->route('datasiswa.index');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($request->hasFile('file_import')) {
            try {
                Excel::import(new ImportDataSiswa, $request->file('file_import'));

                return redirect()->route('datasiswa.index')->with('success', 'Data siswa berhasil diimpor!');
            } catch (\Exception $e) {
                Log::error('Import Error: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Tidak ada file yang diupload.');
    }
    private function convertRomanToInteger($roman)
    {
        $romans = [
            'XII' => 12,
            'XI' => 11,
            'X' => 10,
        ];

        $result = $romans[strtoupper($roman)] ?? intval($roman);
        Log::info('Converted roman: ' . $roman . ' to ' . $result);
        return $result;
    }

    private function getKodeJurusan($namaJurusan)
    {
        $jurusan = Jurusan::where('nama_jurusan', $namaJurusan)->first();
        Log::info('Kode jurusan untuk ' . $namaJurusan . ' adalah: ' . ($jurusan ? $jurusan->kode_jurusan : 'Not found'));
        return $jurusan ? $jurusan->kode_jurusan : null;
    }

    public function indexdashboard()
    {
        if (session('datawalikelas')) {
            $datapengguna = session('datawalikelas');

            $datasiswa_walikelas = pelanggaran::with('walikelassiswa.jurusan')
                ->whereHas('walikelassiswa', function ($query) use ($datapengguna) {
                    $query->where('kelas', $datapengguna->kelas)
                          ->where('kode_jurusan', $datapengguna->kode_jurusan);
                })
                ->get();

            $count_kelas_walikelas = $datasiswa_walikelas->count();
        } else {
            $datasiswa_walikelas = collect();
            $count_kelas_walikelas = 0;
        }

        $count_kelas = jurusan::count();
        $count_siswa = student::count();
        $count_pelanggaran = pelanggaran::count();
        $count_walikelas = walikelas::count();

        $currentDay = now()->format('d');
        $datapiket = datapiket::where('hari_piket', $currentDay)->get();

        $dataasli = pelanggaran::all();
        $diagram = [];

        if ($dataasli->isNotEmpty()) {
            $pelanggaranCounts = pelanggaran::whereMonth('created_at', now()->format('m'))
                ->select('id_pelanggaran', DB::raw('count(*) as total'))
                ->groupBy('id_pelanggaran')
                ->get();

            $diagram = $pelanggaranCounts->map(function ($item) {
                $jenisPelanggaran = datapelangaran::find($item->id_pelanggaran)->jenis_pelanggaran ?? 'Unknown';
                return [
                    'jenis_pelanggaran' => $jenisPelanggaran,
                    'total' => $item->total,
                ];
            });
        }

        return view('layout.content', compact(
            'datasiswa_walikelas',
            'count_kelas',
            'count_siswa',
            'count_pelanggaran',
            'count_walikelas',
            'count_kelas_walikelas',
            'diagram',
            'datapiket',
            'dataasli'
        ));
    }



    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Siswa');

        $sheet->setCellValue('A1', 'Nama Siswa');
        $sheet->setCellValue('B1', 'NIS');
        $sheet->setCellValue('C1', 'NISN');
        $sheet->setCellValue('D1', 'Kelas');
        $sheet->setCellValue('E1', 'Kode Jurusan');
        $sheet->setCellValue('F1', 'Jenis Kelamin');

        $students = student::all();

        $row = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $row, $student->nama_siswa);
            $sheet->setCellValue('B' . $row, $student->nis);
            $sheet->setCellValue('C' . $row, $student->nisn);
            $sheet->setCellValue('D' . $row, $student->kelas);
            $sheet->setCellValue('E' . $row, $student->kode_jurusan);
            $sheet->setCellValue('F' . $row, $student->jenis_kelamin);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'data_siswa.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
