<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kapasitas',
        'jenis',

    ];
    protected $table = 'ruang';

    public function getRoom()
    {
        return DB::table($this->table)
            ->select(DB::raw('kode as id'), DB::raw('nama as name'), 'jenis')
            ->get()->toArray();
    }
}
