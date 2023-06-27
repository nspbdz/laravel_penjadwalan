<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wtb extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'kode_dosen',
        'kode_hari',
        'kode_jam',
       
    ];
    protected $table = 'waktu_tidak_bersedia';
}
