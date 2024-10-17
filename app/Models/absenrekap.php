<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absenrekap extends Model
{
    use HasFactory;
    protected $fillable = ['file_name','kelas', 'jurusan', 'kode_walikelas'];

    public function walikelas()
    {
        return $this->belongsTo(walikelas::class, 'kode_walikelas', 'kode_walikelas');
    }
}
