<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sekolah;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\User;


class sekolahController extends Controller
{
    public function index()
    {
        $indexSekolah = sekolah::all();

        return view("admin.guruPiket.datasekolah", compact('indexSekolah'));
    }
    public function add(Request $request)
    {
        $addsekolah = sekolah::find(1);

        if ($addsekolah) {
            // Cari user berdasarkan nama_pengguna
            $user = User::where('nama_pengguna', $addsekolah->kepala_sekolah)->first();

            // Pengecekan apakah user ditemukan
            if ($user) {
                $user->nama_pengguna = $request->input('kepala_sekolah');
                $user->save();
            } else {
                $user = new User();
                $user->username = "Kepala Sekolah";
                $password = Str::uuid()->toString();
                $password = substr($password, 0, 5);
                $user->password = $password;
                $user->nama_pengguna = $request->input('kepala_sekolah');
                $user->save();
            }

            $addsekolah->nama_sekolah = $request->input('nama_sekolah');
            $addsekolah->telepon_sekolah = $request->input('telepon_sekolah');
            $addsekolah->email_sekolah = $request->input('email_sekolah');
            $addsekolah->website_sekolah = $request->input('website_sekolah');
            $addsekolah->alamat_sekolah = $request->input('alamat_sekolah');
            $addsekolah->kode_pos = $request->input('kode_pos');
            $addsekolah->kepala_sekolah = $request->input('kepala_sekolah');
            $addsekolah->nip_kepala_sekolah = $request->input('nip_kepala_sekolah');
            $addsekolah->save();

            return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil diperbarui!');
        } else {
            // Menambahkan data sekolah baru
            $newsekolah = new sekolah();
            $newsekolah->nama_sekolah = $request->input('nama_sekolah');
            $newsekolah->telepon_sekolah = $request->input('telepon_sekolah');
            $newsekolah->email_sekolah = $request->input('email_sekolah');
            $newsekolah->website_sekolah = $request->input('website_sekolah');
            $newsekolah->alamat_sekolah = $request->input('alamat_sekolah');
            $newsekolah->kode_pos = $request->input('kode_pos');
            $newsekolah->kepala_sekolah = $request->input('kepala_sekolah');
            $newsekolah->nip_kepala_sekolah = $request->input('nip_kepala_sekolah');

            // Buat password dari UUID 5 karakter
            $password = Str::uuid()->toString();
            $password = substr($password, 0, 5);

            // Buat user baru
            $user = new User();
            $user->username = "Kepala Sekolah";
            $user->password = $password;
            $user->nama_pengguna = $request->input("kepala_sekolah");
            $user->save();

            $newsekolah->save();

            return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil ditambahkan!');
        }
    }


    public function updateImage(Request $request)
    {
        $updateLogo = sekolah::find(1);

        if ($updateLogo) {
            if ($request->hasFile('logo_sekolah')) {
                $image = $request->file('logo_sekolah');
                $fileName = $image->getClientOriginalName();

                $oldImage = public_path('logo/' . $updateLogo->logo_sekolah);
                if (File::exists($oldImage)) {
                    File::delete($oldImage);
                }

                $image->move(public_path('logo'), $fileName);
                $updateLogo->logo_sekolah = $fileName;
            }

            $updateLogo->save();

            return redirect()->route('sekolah.index')->with('success', 'Logo sekolah berhasil diperbarui!');
        } else {
            $newsekolah = new sekolah();

            if ($request->hasFile('logo_sekolah')) {
                $image = $request->file('logo_sekolah');
                $fileName = $image->getClientOriginalName();

                $image->move(public_path('logo'), $fileName);
                $newsekolah->logo_sekolah = $fileName;
            }

            $newsekolah->save();

            return redirect()->route('sekolah.index')->with('success', 'Data sekolah baru dan logo berhasil ditambahkan!');
        }
    }
}
