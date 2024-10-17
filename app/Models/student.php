<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;
    protected $fillable = ['nis', 'nama_siswa', 'nisn', 'kelas', 'kode_jurusan', 'jenis_kelamin', 'foto_pelajar'];
    protected $primaryKey = 'nis';

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'kode_jurusan', 'kode_jurusan');
    }

    public function pelanggarans()
    {
        return $this->hasMany(pelanggaran::class, 'nis', 'nis');
    }

    public function suratizin()
    {
        return $this->hasMany(suratizin::class, 'nis', 'nis');
    }



    public function walikelas()
    {
        return $this->belongsTo(walikelas::class, 'kelas', 'kelas')
            ->where('kode_jurusan', $this->kode_jurusan);
    }


    public function getTotalPoinAttribute()
    {
        return $this->pelanggarans->sum(function ($pelanggaran) {
            return $pelanggaran->datapelanggaran ? $pelanggaran->datapelanggaran->poin : 0;
        });
    }

    public function absensi()
    {
        return $this->hasMany(absensi::class, 'nis', 'nis');
    }

    public function walikelassiswa()
    {
        return $this->hasMany(Student::class, 'kelas', 'kelas')
            ->where('kode_jurusan', $this->kode_jurusan);
    }
}
