<?php

namespace App\Http\Controllers;

use App\Models\datapelangaran;
use App\Models\pelanggaran;
use Illuminate\Http\Request;

class datapelangaranController extends Controller
{
    public function add(Request $request) {
        $adddatapelanggaran = new datapelangaran();

        $adddatapelanggaran->jenis_pelanggaran = $request->input('jenis_pelanggaran');
        $adddatapelanggaran->poin = $request->input('poin');
        $adddatapelanggaran->save();

        return redirect()->route('datapelanggaran.index');
    }
 

    public function index(Request $request)
    {
        $alldatapelanggaran = datapelangaran::all();

        $search = $request->input('search');

        if ($search) {
            $indexdatapelanggaran = datapelangaran::where('jenis_pelanggaran', 'like', '%' . $search . '%')->paginate(10);
        } else {
            $indexdatapelanggaran = datapelangaran::paginate(10);
        }
        $totaldatapelanggaran = datapelangaran::count();
        $editModalId = session('edit_modal_id');
        $editDatapelanggaran = $editModalId ? datapelangaran::find($editModalId) : null;

        return view('admin.guruPiket.datapelanggaran', compact('indexdatapelanggaran', 'editDatapelanggaran', 'totaldatapelanggaran', 'alldatapelanggaran'));
    }


    public function hapus($id)
    {
        $hapusdatapelanggaran = datapelangaran::find($id);
        $hapusdatapelanggaran->delete();

        return redirect()->route('datapelanggaran.index');
    }

    public function edit($id)
    {
        $editDatapelanggaran = datapelangaran::find($id);

        session()->flash('edit_modal_id', $id);

        return redirect()->route('datapelanggaran.index');
    }

    public function update(Request $request, $id)
    {
        $updateDatapelanggaran = datapelangaran::find($id);

        $updateDatapelanggaran->jenis_pelanggaran = $request->input('jenis_pelanggaran');
        $updateDatapelanggaran->poin = $request->input('poin');
        $updateDatapelanggaran->save();

        return redirect()->route('datapelanggaran.index');
    }
}
