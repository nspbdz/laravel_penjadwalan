<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pengampu',
        'kode_jam',
        'kode_hari',
        'kode_ruang',
    ];
    protected $table = 'jadwalkuliah';
}
