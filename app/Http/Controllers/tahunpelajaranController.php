<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tahunpelajaran;

class tahunpelajaranController extends Controller
{
    public function index() {
        $aktif = 1;
        $tidakaktif = 0;
        $dataTahunpelajaran = tahunpelajaran::all();

        return view('admin.guruPiket.tahunpelajaran', compact('dataTahunpelajaran'));
    }

    public function add(Request $request) {
        $request->validate([
            'tahunmulai' => 'required|integer|min:' . date('Y'),
            'tahunselesai' => 'required|integer|min:' . date('Y'),
            'semester' => 'required|integer|in:1,2',
        ]);

        $addTahunpelajaran = new tahunpelajaran();

        $addTahunpelajaran->tahunmulai = $request->input('tahunmulai');
        $addTahunpelajaran->tahunselesai = $request->input('tahunselesai');
        $addTahunpelajaran->semester = $request->input('semester');
        $addTahunpelajaran->status = 0;
        $addTahunpelajaran->save();

        return redirect()->route('tahunpelajaran.index')->with('success', 'Data tahun pelajaran berhasil ditambahkan.');
    }

    public function toggleStatus(Request $request, $id) {
        $data = tahunpelajaran::find($id);

        if ($data) {
            if ($data->status == 0) {
                tahunpelajaran::where('status', 1)->update(['status' => 0]);
            }

            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();
        }

        return response()->json(['success' => true]);
    }

    public function hapus($nis) {
        $hapus = tahunpelajaran::where('id',$nis)->first();

        $hapus->delete();

        return redirect()->route('tahunpelajaran.index');
    }

}
