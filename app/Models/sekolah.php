<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sekolah extends Model
{
    use HasFactory;
    protected $fillable = ['logo_sekolah', 'nama_sekolah','telepon_sekolah','email_sekolah','website_sekolah','alamat_sekolah','kode_pos','kepala_sekolah','nip_kepala_sekolah'];
}
