<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use App\Models\walikelas;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\absensi;
use App\Models\absenrekap;
use App\Models\datapelangaran;
use App\Models\rekappelanggaran;
use App\Models\tahunpelajaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class pdfController extends Controller
{
    public function generatePDFwalikelas($id)
    {
        $walikelas = Walikelas::findOrFail($id);
        $datatahunpelajaran = tahunpelajaran::all();
        $datajumlahkehadiran = Absensi::all();
        $currentMonth = date('m');
        $currentYear = date('Y');
        $totalDays = date('t');

        $publicAbsensiDir = public_path('absensi');
        if (!file_exists($publicAbsensiDir)) {
            mkdir($publicAbsensiDir, 0777, true);
        }

        $students = $walikelas->students;
        $jumalahsemuanya = $students->count();
        $attendanceData = [];
        $totalHadir = [];
        $totalTidakHadir = [];
        $totalSakit = [];
        $totalIzin = [];
        $totalMagang = [];

        foreach ($students as $student) {
            $attendanceRecords = Absensi::where('nis', $student->nis)
                ->whereMonth('tanggal', $currentMonth)
                ->whereYear('tanggal', $currentYear)
                ->get();

            $totalHadir[$student->nama_siswa] = $attendanceRecords->where('status', 'Hadir')->count();
            $totalTidakHadir[$student->nama_siswa] = $attendanceRecords->where('status', 'Tidak Hadir')->count();
            $totalSakit[$student->nama_siswa] = $attendanceRecords->where('status', 'Sakit')->count();
            $totalIzin[$student->nama_siswa] = $attendanceRecords->where('status', 'Izin')->count();
            $totalMagang[$student->nama_siswa] = $attendanceRecords->where('status', 'Magang')->count();

            $attendanceData[$student->nama_siswa] = [];
            foreach ($attendanceRecords as $record) {
                $day = Carbon::parse($record->tanggal)->day;
                $attendanceData[$student->nama_siswa][$day] = $record->status;
            }
        }

        $pdf = DomPDF::loadView('admin.guruPiket.pdfabsensi', compact(
            'datajumlahkehadiran',
            'walikelas',
            'datatahunpelajaran',
            'students',
            'attendanceData',
            'totalDays',
            'currentYear',
            'currentMonth',
            'totalHadir',
            'totalTidakHadir',
            'totalSakit',
            'totalIzin',
            'totalMagang',
            'jumalahsemuanya'
        ))->setPaper([0, 0, 636.89, 885.72], 'landscape');

        $fileName = 'absensi_' . str_replace(' ', '_', strtolower($walikelas->nama_walikelas)) . now()->format('H-s') . '.pdf';

        $tempFilePath = $publicAbsensiDir . '/' . $fileName;
        $pdf->save($tempFilePath);

        Absenrekap::create([
            'file_name' => $fileName,
            'kelas' => $walikelas->kelas,
            'jurusan' => $walikelas->jurusan->nama_jurusan
        ]);

        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }


    public function generatePS()
    {
        $datasiswa = student::all();
        $datapelanggaranpoin = datapelangaran::all();
        $nama_pelanggaran = [];
        $jumlah_pelanggaran = [];

        $datapelanggaransiswaall = student::with('jurusan', 'pelanggarans.datapelanggaran')
            ->whereHas('pelanggarans')
            ->get();

        $waktu = now()->format('Y-m-d');
        $indexpelanggaransiswa = pelanggaran::whereDate('created_at', $waktu)->get();

        foreach ($indexpelanggaransiswa as $pelanggaran) {
            if ($pelanggaran->datapelanggaran) {
                $nama_pelanggaran[] = $pelanggaran->datapelanggaran->nama_pelanggaran;

                $jumlah_pelanggaran[] = pelanggaran::where('id_pelanggaran', $pelanggaran->datapelanggaran->id)
                    ->count();
            }
        }

        $datajenis = [];
        foreach ($datasiswa as $siswa) {
            $violations = pelanggaran::with('datapelanggaran')
                ->where('nis', $siswa->nis)
                ->get();

            foreach ($violations as $violation) {
                $datajenis[] = [
                    'nis' => $siswa->nis,
                    'jenis_pelanggaran' => $violation->datapelanggaran->jenis_pelanggaran ?? '',
                    'poin' => $violation->datapelanggaran->poin ?? 0
                ];
            }
        }

        // Set the directory path to 'pelanggaran_rekap' instead of 'pelanggaran'
        $publicAbsensiDir = public_path('pelanggaran');
        if (!file_exists($publicAbsensiDir)) {
            mkdir($publicAbsensiDir, 0777, true);
        }

        // Generate the PDF using DomPDF
        $pdf = DomPDF::loadView('admin.guruPiket.pdfpelanggaran', compact(
            'datapelanggaransiswaall',
            'datajenis'
        ))->setPaper('A4', 'portrait');

        // Create a file name for the PDF
        $fileName = 'absensi_' . str_replace(' ', '_', strtolower("Data_Pelanggaran_Siswa")) . now()->format('H_s_i') . '.pdf';
        $tempFilePath = $publicAbsensiDir . '/' . $fileName;

        try {
            // Attempt to save the generated PDF to the specified directory
            $pdf->save($tempFilePath);
        } catch (\Exception $e) {
            // Handle any errors during the save process
            return response()->json(['error' => 'Failed to save PDF: ' . $e->getMessage()], 500);
        }

        // Check if the file was successfully created
        if (!file_exists($tempFilePath)) {
            return response()->json(['error' => 'File not created.'], 500);
        }

        // Store the file name in the database
        rekappelanggaran::create([
            'nama_file' => $fileName,
        ]);

        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function generatePDF()
    {
        $walikelasList = Walikelas::all();
        $datatahunpelajaran = tahunpelajaran::all();
        $datajumlahkehadiran = Absensi::all();
        $currentMonth = date('m');
        $currentYear = date('Y');
        $totalDays = date('t');

        $publicAbsensiDir = public_path('absensi');
        if (!file_exists($publicAbsensiDir)) {
            mkdir($publicAbsensiDir, 0777, true);
        }

        $monthName = date('F');
        $zipFileName = 'absensi_kelas_' . $monthName . '_' . $currentYear . '.zip';
        $zipFilePath = $publicAbsensiDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->route('absensi.index')->with('error', 'Gagal membuat file ZIP.');
        }

        foreach ($walikelasList as $walikelas) {
            $students = $walikelas->students;
            $jumalahsemuanya = $students->count(); // Count students
            $attendanceData = [];
            $totalHadir = [];
            $totalTidakHadir = [];
            $totalSakit = [];
            $totalIzin = [];
            $totalMagang = [];

            foreach ($students as $student) {
                $attendanceRecords = Absensi::where('nis', $student->nis)
                    ->whereMonth('tanggal', $currentMonth)
                    ->whereYear('tanggal', $currentYear)
                    ->get();

                // Count attendance status
                $totalHadir[$student->nama_siswa] = $attendanceRecords->where('status', 'Hadir')->count();
                $totalTidakHadir[$student->nama_siswa] = $attendanceRecords->where('status', 'Tidak Hadir')->count();
                $totalSakit[$student->nama_siswa] = $attendanceRecords->where('status', 'Sakit')->count();
                $totalIzin[$student->nama_siswa] = $attendanceRecords->where('status', 'Izin')->count();
                $totalMagang[$student->nama_siswa] = $attendanceRecords->where('status','Magang' )->count();

                $attendanceData[$student->nama_siswa] = [];
                foreach ($attendanceRecords as $record) {
                    $day = Carbon::parse($record->tanggal)->day;
                    $attendanceData[$student->nama_siswa][$day] = $record->status;
                }
            }

            // Load the PDF view
            $pdf = DomPDF::loadView('admin.guruPiket.pdfabsensi', compact(
                'datajumlahkehadiran',
                'walikelas',
                'datatahunpelajaran',
                'students',
                'attendanceData',
                'totalDays',
                'currentYear',
                'currentMonth',
                'totalHadir',
                'totalTidakHadir',
                'totalSakit',
                'totalIzin',
                'totalMagang',
                'jumalahsemuanya' // Include this variable
            ))->setPaper([0, 0, 636.89, 885.72], 'landscape');

            $time = now()->format('H-s');
            $fileName = 'absensi_' . str_replace(' ', '_', strtolower($walikelas->nama_walikelas)) . strtolower($time) . '.pdf';

            $tempFilePath = $publicAbsensiDir . '/' . $fileName; // Save directly to public/absensi
            $pdf->save($tempFilePath);

            // Save to the database
            Absenrekap::create([
                'file_name' => $fileName,
                'kelas' => $walikelas->kelas,
                'jurusan' => $walikelas->jurusan->nama_jurusan
            ]);

            // Add the PDF file to the ZIP archive
            $zip->addFile($tempFilePath, $fileName);
        }

        // Close the ZIP file after adding all PDFs
        $zip->close();

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }



    public function tampilAbsensi()
    {
        $absenrekapwalikelas = collect();

        if (session('datawalikelas')) {
            $walikelas = walikelas::where('id', session('datawalikelas')->id)->first();
            $absenrekapwalikelas = absenrekap::where('kode_walikelas', $walikelas->kode_walikelas)->get();
        }

        $absenrekap = absenrekap::where('kode_walikelas', '=', null)->get();

        return view('admin.guruPiket.rekapabsensi', compact('absenrekap', 'absenrekapwalikelas'));
    }

    public function hapus($id)
    {
        $rekap = absenrekap::find($id);

        if ($rekap) {
            $filePath = public_path('absensi/' . $rekap->file_name);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $rekap->delete();
        }

        return redirect()->route('absenrekapan')->with('success', 'Data dan file berhasil dihapus.');
    }
}
