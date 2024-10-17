<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jurusan;

class jurusanController extends Controller
{

    public function add(Request $request) {
        $addJurusan = new jurusan();

        $addJurusan->kode_jurusan = $request->input('kode_jurusan');
        $addJurusan->nama_jurusan = $request->input('nama_jurusan');
        $addJurusan->kepanjangan_jurusan = $request->input('kepanjangan_jurusan');
        $addJurusan->save();

        return redirect()->route('jurusan.index');
    }
 

    public function index(Request $request)
    {
        $allJurusan = jurusan::all();

        $search = $request->input('search');

        if ($search) {
            $indexJurusan = jurusan::where('nama_jurusan', 'like', '%' . $search . '%')->paginate(10);
        } else {
            $indexJurusan = jurusan::paginate(10);
        }
        $totalJurusan = jurusan::count();
        $editModalId = session('edit_modal_id');
        $editJurusan = $editModalId ? jurusan::find($editModalId) : null;

        return view('admin.guruPiket.dataJurusan', compact('indexJurusan', 'editJurusan', 'totalJurusan', 'allJurusan'));
    }


    public function hapus($id)
    {
        $hapusJurusan = jurusan::find($id);
        $hapusJurusan->delete();

        return redirect()->route('jurusan.index');
    }

    public function edit($id)
    {
        $editJurusan = jurusan::find($id);

        session()->flash('edit_modal_id', $id);

        return redirect()->route('jurusan.index');
    }

    public function update(Request $request, $id)
    {
        $updateJurusan = jurusan::find($id);

        $updateJurusan->nama_jurusan = $request->input('nama_jurusan');
        $updateJurusan->kepanjangan_jurusan = $request->input('kepanjangan_jurusan');
        $updateJurusan->save();

        return redirect()->route('jurusan.index');
    }
}