<?php

namespace App\Http\Controllers;

use App\Models\sekolah;
use App\Models\suratizin;
use App\Models\student;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class suratizinController extends Controller
{
    public function index()
    {
        $datasiswa = student::all();
        $sekolah = sekolah::first();

        return view("admin.guruPiket.suratizin", compact("datasiswa", "sekolah"));
    }

    public function cetak(Request $request)
    {
        function generateUUID()
        {
            return Uuid::uuid4()->toString();
        }

        $uuids = [];
        $suratIzins = [];

        $nisList = explode(',', $request->input('nis'));

        foreach ($nisList as $nis) {
            $nis = trim($nis);
            $student = student::where('nis', $nis)->first();

            if ($student) {
                $uuid = generateUUID();

                $addsuratizin = new suratizin();
                $addsuratizin->nomor = $request->input("nomor");
                $addsuratizin->perihal = $request->input("perihal");
                $addsuratizin->nis = $student->nis;
                $addsuratizin->uuid = $uuid;
                $addsuratizin->jam_pelajaran = $request->input("jam_pelajaran");
                $addsuratizin->keterangan = $request->input("keterangan");
                $addsuratizin->save();

                $uuids[] = $uuid;
                $suratIzins[] = $addsuratizin;
            }
        }

        $studentsWithSameUUID = student::whereHas('suratizin', function ($query) use ($uuids) {
            $query->whereIn('uuid', $uuids);
        })->get();

        $sekolah = sekolah::first();

        return view('admin.guruPiket.desainsurat', compact('suratIzins', 'sekolah', 'studentsWithSameUUID'))
            ->with('print', true);
    }
}
