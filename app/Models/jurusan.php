<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jurusan extends Model
{
    use HasFactory;
    protected $fillable = ['kode_jurusan', 'nama_jurusan', 'kepanjangan_jurusan'];

    public function student()
    {
        return $this->belongsTo(student::class, 'kode_jurusan', 'kode_jurusan');
    }

    public function walikelas()
    {
        return $this->belongsTo(walikelas::class, 'kode_jurusan', 'kode_jurusan');
    }
}
