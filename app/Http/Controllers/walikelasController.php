<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\walikelas;
use App\Models\jurusan;
use App\Models\User;

class walikelasController extends Controller
{
    public function add(Request $request)
    {
        $addwalikelas = new walikelas();

        $kodewalikelas = 'WK' . $request->input('kelas') . $request->input('kode_jurusan');

        $addwalikelas->kode_walikelas = $kodewalikelas;
        $addwalikelas->nama_walikelas = $request->input('nama_walikelas');
        $addwalikelas->kelas = $request->input('kelas');
        $addwalikelas->kode_jurusan = $request->input('kode_jurusan');

        $addwalikelas->save();

        $kode_jurusan = $request->input('kode_jurusan');
        $kode_jurusan_format = preg_replace('/[^KJ0-9]/', '', $kode_jurusan);
        $kode_jurusan_format = substr($kode_jurusan_format, 0, 5);

        $adduser = new User();

        $username = "Wali Kelas";
        $adduser->password = 'WK' . $request->input('kelas') . $kode_jurusan_format;
        $adduser->username = $username;
        $adduser->nama_pengguna = $request->input('nama_walikelas');

        $adduser->save();


        return redirect()->route('walikelas.index')->with('success', 'walikelas added successfully!');
    }

    public function index(Request $request)
    {
        $allwalikelas = walikelas::all();


        $kelas = $request->input('kelas');
        $jurusan = $request->input('kode_jurusan');
        $search = $request->input('search');
        $datajurusan = jurusan::all();

        $query = walikelas::query();

        if ($kelas) {
            $query->where('kelas', $kelas);
        }

        if ($jurusan) {
            $query->where('kode_jurusan', $jurusan);
        }

        if ($search) {
            $query->where('nama_walikelas', 'like', '%' . $search . '%');
        }
        $indexwalikelas = $query->paginate(10);

        $totalwalikelas = walikelas::count();
        $editModalId = session('edit_modal_id');
        $editWalikelas = $editModalId ? walikelas::find($editModalId) : null;

        return view('admin.guruPiket.walikelas', compact('indexwalikelas', 'editWalikelas', 'totalwalikelas', 'allwalikelas', 'datajurusan'));
    }


    public function hapus($id)
    {
        $hapuswalikelas = walikelas::find($id);

        if ($hapuswalikelas) {
            $hapususerwalikelas = User::where('nama_pengguna', $hapuswalikelas->nama_walikelas)->first();
            $hapususerwalikelas->delete();

            $hapuswalikelas->delete();
        }

        return redirect()->route('walikelas.index');
    }


    public function edit($id)
    {
        $editWalikelas = walikelas::find($id);

        session()->flash('edit_modal_id', $id);

        return redirect()->route('walikelas.index');
    }

    public function update(Request $request, $id)
    {
        $updatewalikelas = walikelas::find($id);

        $kodewalikelas = 'WK' . $request->input('kelas') . $request->input('kode_jurusan');

        if ($updatewalikelas) {
            $updateuserwalikelas = User::where('nama_pengguna', $updatewalikelas->nama_walikelas)->first();
            $updateuserwalikelas->nama_pengguna = $request->input('nama_walikelas');
            $updateuserwalikelas->save();
        }

        $updatewalikelas->kode_walikelas = $kodewalikelas;
        $updatewalikelas->nama_walikelas = $request->input('nama_walikelas');
        $updatewalikelas->kelas = $request->input('kelas');
        $updatewalikelas->kode_jurusan = $request->input('kode_jurusan');
        $updatewalikelas->save();

        return redirect()->route('walikelas.index');
    }
}
