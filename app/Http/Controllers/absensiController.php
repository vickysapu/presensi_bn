<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\absensi;
use App\Models\walikelas;
use App\Models\student;
use App\Models\datapiket;
use Carbon\Carbon;
use App\Models\tahunpelajaran;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\StudentT;

class absensiController extends Controller
{
    public function absenkelasUser($id)
    {
        $walikelas = walikelas::find($id);

        if (!$walikelas) {
            return abort(404);
        }

        $data = $walikelas->students;
        $jumlahkeseluruhan = $data->count();

        $attendanceData = [];
        foreach ($data as $student) {
            $attendanceRecords = absensi::where('nis', $student->nis)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', operator: now()->year)
                ->get();

            foreach ($attendanceRecords as $record) {
                $day = Carbon::parse($record->tanggal)->day;
                $attendanceData[$student->nama_siswa][$day] = $record->status;
            }
        }


        $datatahunpelajaran = tahunpelajaran::where('status', 1)->get();

        return view('admin.guruPiket.absenkelas', [
            'datatahunpelajaran' => $datatahunpelajaran,
            'jumlahkeseluruhan' => $jumlahkeseluruhan,
            'walikelas' => $walikelas,
            'students' => $data,
            'attendanceData' => $attendanceData,
            'currentYear' => now()->year,
            'currentMonth' => now()->month,
            'totalDays' => now()->daysInMonth
        ]);
    }
    public function absenkelas($id)
    {
        $walikelas = walikelas::find($id);

        if (!$walikelas) {
            return abort(404);
        }

        $students = Student::where('kelas', $walikelas->kelas)
            ->where('kode_jurusan', $walikelas->kode_jurusan)
            ->get();

        $jumalahsemuanya = $students->count();
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada siswa yang ditemukan untuk kelas ini.');
        }

        $attendanceData = [];
        $totalkehadiran = 0;

        foreach ($students as $student) {
            $attendanceRecords = absensi::where('nis', $student->nis)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->get();

            foreach ($attendanceRecords as $record) {
                $day = Carbon::parse($record->tanggal)->day;
                $attendanceData[$student->nama_siswa][$day] = $record->status;
                if ($record->status == 'Hadir') {
                    $totalkehadiran++;
                }
            }
        }

        $datatahunpelajaran = tahunpelajaran::where('status', 1)->first();

        return view('admin.guruPiket.absenkelas', [
            'jumalahsemuanya' => $jumalahsemuanya,
            'walikelas' => $walikelas,
            'students' => $students,
            'attendanceData' => $attendanceData,
            'datatahunpelajaran' => $datatahunpelajaran,
            'totalkehadiran' => $totalkehadiran,
            'currentYear' => now()->year,
            'currentMonth' => now()->month,
            'totalDays' => now()->daysInMonth,
        ]);
    }





    public function index()
    {
        $datawalikelas = walikelas::all();
        $datapiket = datapiket::all();
        $dataSiswa = student::all();
        $currentMonth = date('m');
        $currentYear = date('Y');
        $totalDays = date('t');
        $attendanceData = [];

        foreach ($dataSiswa as $siswa) {
            $attendanceRecords = Absensi::where('nis', $siswa->nis)
                ->whereMonth('tanggal', $currentMonth)
                ->whereYear('tanggal', $currentYear)
                ->get();

            foreach ($attendanceRecords as $record) {
                $day = Carbon::parse($record->tanggal)->day;
                $attendanceData[$siswa->nama_siswa][$day] = $record->status;
            }
        }

        $today = now()->toDateString();

        $siswahadir = Absensi::where('tanggal', $today)->get();

        $belumabsen = Student::whereDoesntHave('absensi', function ($query) use ($today) {
            $query->where('tanggal', $today);
        })->get();
        return view('admin.guruPiket.absensi', compact('dataSiswa', 'totalDays', 'currentMonth', 'currentYear', 'attendanceData', 'datapiket', 'belumabsen', 'datawalikelas', 'siswahadir'));
    }

    public function absen(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'nullable|string|max:255',
            'status' => 'required|string|in:Hadir,Tidak Hadir,Sakit,Izin,Magang',
        ]);

        $dataabsensi = null;

        if ($request->filled('nis')) {
            $student = student::where('nis', $request->nis)->first();

            if (!$student) {
                return back()->with('error', 'NIS tidak ditemukan.');
            }

            $today = now();
            $currentHour = $today->hour;

            if ($currentHour < 6 || $currentHour > 17) {
                return back()->with('error', 'Absen hanya dapat dilakukan antara jam 06:00 dan 17:00.');
            }

            $existingAbsen = absensi::where('nis', $student->nis)
                ->where('tanggal', $today->toDateString())
                ->first();

            if ($existingAbsen) {
                return back()->with('success', 'Siswa telah diabsen.');
            }

            $status = "Hadir";
            absensi::create([
                'nis' => $student->nis,
                'status' => $status,
                'tanggal' => $today,
            ]);

            $dataabsensi = Absensi::where('created_at', now())->first();
        } else {
            $request->validate([
                'nama_siswa' => 'required|string|max:255',
            ]);

            $student = student::where('nama_siswa', $request->nama_siswa)->first();

            if (!$student) {
                return back()->with('error', 'Nama siswa tidak ditemukan.');
            }

            $today = now();
            $currentHour = $today->hour;

            if ($currentHour < 6 || $currentHour > 17) {
                return back()->with('error', 'Absen hanya dapat dilakukan antara jam 06:00 dan 17:00.');
            }

            $existingAbsen = absensi::where('nis', $student->nis)
                ->where('tanggal', $today->toDateString())
                ->first();

            if ($existingAbsen) {
                return back()->with('success', 'Siswa Telah diabsen.');
            }

            absensi::create([
                'nis' => $student->nis,
                'status' => $request->status,
                'tanggal' => $today->toDateString(),
            ]);
        }

        return back()->with('success', 'Berhasil Absen.')->with(compact('dataabsensi'));
    }
}
