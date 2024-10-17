<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tahunpelajaran extends Model
{
    use HasFactory;
    protected $fiilable = ['tahunmulai','tahunselesai','semester','status'];
}
