<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\datapiket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use App\Models\User;

class datapiketController extends Controller
{
    public function add(Request $request)
    {
        $nama_guru = explode(',', $request->input('nama_guru'));

        foreach ($nama_guru as $guru) {
            $guru = trim($guru);

            $adddatapiket = new datapiket();
            $adddatapiket->nama_guru = $guru;
            $adddatapiket->hari_piket = $request->input('hari_piket');
            $adddatapiket->save();

            $addusergp = new User();
            $role = "Guru Piket";

            $addusergp->username = $role;
            $addusergp->nama_pengguna = $guru;

            $addusergp->password = substr(Uuid::uuid4()->toString(), 0, 5);

            $addusergp->save();
        }

        return redirect()->route('datapiket.index')->with('success', 'datapiket added successfully!');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $alldatapiket = datapiket::all();

        $query = datapiket::select('hari_piket', DB::raw('GROUP_CONCAT(nama_guru SEPARATOR ", ") as nama_guru'))
            ->groupBy('hari_piket');

        $indexdatapiket = $query->paginate(10);

        $totaldatapiket = datapiket::count();

        $editModalId = session('edit_modal_id');
        $editdatapiket = $editModalId ? datapiket::where('hari_piket', $editModalId)
            ->select('hari_piket', DB::raw('GROUP_CONCAT(nama_guru SEPARATOR ", ") as nama_guru'))
            ->groupBy('hari_piket')
            ->first() : null;

        return view('admin.guruPiket.datapiket', compact('indexdatapiket', 'editdatapiket', 'totaldatapiket', 'alldatapiket'));
    }

    public function hapus($hari_piket)
    {
        $datapiket = datapiket::where('hari_piket', $hari_piket)->get();

        datapiket::where('hari_piket', $hari_piket)->delete();

        foreach ($datapiket as $data) {
            $trimmed_guru = trim($data->nama_guru);

            User::where('nama_pengguna', $trimmed_guru)->delete();
        }

        return redirect()->route('datapiket.index')->with('success', 'Data piket and related users deleted successfully!');
    }

    public function edit($hari_piket)
    {
        $editdatapiket = datapiket::where('hari_piket', $hari_piket)
            ->select('hari_piket', DB::raw('GROUP_CONCAT(nama_guru SEPARATOR ", ") as nama_guru'))
            ->groupBy('hari_piket')
            ->first();

        if ($editdatapiket) {
            session()->flash('edit_modal_id', $editdatapiket->hari_piket);
        }

        return redirect()->route('datapiket.index');
    }   

public function update(Request $request, $hari_piket)
{
    $validator = Validator::make($request->all(), [
        'nama_guru' => 'required|array',
        'nama_guru.*' => 'string',
        'hari_piket' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $datapiket = Datapiket::where('hari_piket', $hari_piket)->first();

    if (!$datapiket) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    $datapiket->nama_guru = implode(',', array_map('trim', $request->input('nama_guru')));
    $datapiket->hari_piket = $request->input('hari_piket');
    $datapiket->save();

    foreach ($request->input('nama_guru') as $nama_guru) {
        $trimmedGuru = trim($nama_guru);
        $user = User::where('nama_pengguna', $trimmedGuru)->first();

        if ($user) {

            $user->nama_pengguna = $trimmedGuru;
            $user->save();
        } else {
            $userPassword = substr(Str::uuid(), 0, 5);
            User::create([
                'username' => 'Guru Piket',
                'password' => $userPassword,
                'nama_pengguna' => $trimmedGuru,
            ]);
        }
    }

    return redirect()->route('datapiket.index')->with('success', 'Data berhasil diperbarui!');
}

}
