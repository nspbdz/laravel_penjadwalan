<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hour extends Model
{
    use HasFactory;

    protected $fillable = [
        'range_jam',
        'kode',
        'aktif',
    ];
    protected $table = 'jam';

    public function getJam()
    {
        return DB::table($this->table)
            ->select('range_jam')
            ->pluck('range_jam')->unique()->toArray();
    }
}
