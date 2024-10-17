<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datapiket extends Model
{
    use HasFactory;

    protected $fillable = ['nama_guru', 'hari_piket'];
}
