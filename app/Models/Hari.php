<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hari extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
    ];
    protected $table = 'hari';

    public function getHari()
    {
        return DB::table($this->table)
            ->select('kode', 'nama')
            ->get()->toArray();
    }
}
