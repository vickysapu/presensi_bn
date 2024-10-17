<?php

namespace App\Http\Controllers;

use App\Models\absensi;
use App\Models\penggunalogin;
use App\Models\student;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\walikelas;
use Illuminate\Support\Facades\Log;

class penggunaloginController extends Controller
{

    public function indexGP()
    {
        $absensi = Absensi::whereDate('created_at', now()->toDateString())->get();
        $dataSiswa = student::all();

        return view('admin.guruPiket.halamanabsen', compact('absensi', 'dataSiswa'));
    }

    public function logout()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        if ($username === 'Wali Kelas') {
            $keamanan = $password . "19131121418    ";
            $datawalikelas = walikelas::where('kode_walikelas', $keamanan)->first();

            if ($datawalikelas) {
                session(['datawalikelas' => $datawalikelas]);
                session()->forget('username');

                return redirect()->route('dashboard', compact('datawalikelas'));
            }
        } elseif ($username === 'Guru Piket') {
            return $this->loginGuruPiket($username, $password);
        } else {
            $user = User::where('username', $username)->first();

            if ($user && $user->password === $password) {
                session([
                    'username' => $user->username,
                    'password' => $password,
                    'nama_pengguna' => $user->nama_pengguna,
                ]);

                session()->forget('datawalikelas');

                return redirect()->route('dashboard');
            }
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    private function loginGuruPiket($username, $password)
    {
        $users = User::where('username', $username)->get();

        foreach ($users as $user) {
            if ($user->password === $password) {
                session([
                    'username' => $user->username,
                    'password' => $password,
                    'nama_pengguna' => $user->nama_pengguna,
                ]);

                session()->forget('datawalikelas');

                return redirect()->route('halaman.absen.index');
            }
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function lgp(){
        session('username');

        return redirect()->route('dashboard');
    }
    public function datapenggunaindex()
    {
        $datapengguna = User::all();

        return view('admin.guruPiket.datapengguna', compact('datapengguna'));
    }

    public function passwordupdate(Request $request, $id)
    {
        $validate = user::where('id', $id)->first();

        if ($validate) {
            $validate->password = $request->input('password');
            $validate->save();

            return redirect()->route('datapengguna.index');
        }
    }

    public function updatepenggunainti(Request $request, $id)
    {
        $updatepengguna = User::where('id', $id)->first();

        $updatepengguna->nama_pengguna = $request->input('nama_pengguna');
        $updatepengguna->password = $request->input('password');
        $updatepengguna->save();

        return redirect()->route('datapengguna.index');
    }
}
