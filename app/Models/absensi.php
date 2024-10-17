<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    use HasFactory;

    protected $fillable = ['nis', 'status', 'tanggal'];

    public function student()
    {
        return $this->belongsTo(student::class, 'nis', 'nis');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'kode_jurusan', 'kode_jurusan');
    }

}
