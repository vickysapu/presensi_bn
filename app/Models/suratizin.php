<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suratizin extends Model
{
    use HasFactory;
    protected $fillable = ['nomor', 'perihal', 'nis', 'jam_pelajaran', 'keterangan'];


    public function student()
    {
        return $this->belongsTo(student::class, 'nis', 'nis');
    }

}
