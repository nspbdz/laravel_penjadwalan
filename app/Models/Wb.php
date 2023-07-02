<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wb extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'kode_pengampu',
        'kode_hari',
        'kode_jam',
        'kode_ruang',
       
    ];
    protected $table = 'waktu_bersedia';

    
}
