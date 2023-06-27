<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_mk',
        'kode_dosen',
        'kelas',
        'tahun_akademik',
       
    ];
    protected $table = 'pengampu';
}
