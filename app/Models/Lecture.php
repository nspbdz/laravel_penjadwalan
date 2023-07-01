<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'nidn',
        'alamat',
        'telp',
    ];
    protected $table = 'dosen';

    public function getDosen()
    {
        return DB::table($this->table)
            ->select(DB::raw('kode as id'), DB::raw('nama as name'))
            ->get()->toArray();
    }
}
