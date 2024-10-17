<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelanggaran extends Model
{
    use HasFactory;

    protected $fillable = ['id_pelanggaran', 'nis', 'keterangan'];

    protected $table = 'pelanggaran';

    public function datapelanggaran()
    {
        return $this->belongsTo(datapelangaran::class, 'id_pelanggaran', 'id');
    }

    public function student()
    {
        return $this->belongsTo(student::class, 'nis', 'nis');
    }


    public function walikelassiswa()
    {
        return $this->belongsTo(Student::class, 'nis', 'nis');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'kode_jurusan', 'kode_jurusan');
    }
}
