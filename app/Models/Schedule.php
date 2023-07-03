<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public $timestamps = false;

    public function getScheduleByPengampu($idPengampu)
    {
        return DB::table($this->table)
            ->select(
                'pengampu.kode_dosen',
                'pengampu.kode_mk',
                'pengampu.kelas',
                'jadwalkuliah.kode_ruang',
                'jadwalkuliah.kode_hari'
            )
            ->leftJoin('pengampu', 'pengampu.kode', '=', 'jadwalkuliah.kode_pengampu')
            ->where('kode_pengampu', $idPengampu)->first();
    }

    public function checkBentrok($idPengampu, $schedule, $kodeJam)
    {
        return DB::table($this->table)
            ->select(
                'pengampu.kode_dosen',
                'pengampu.kode_mk',
                'pengampu.kelas',
                'jadwalkuliah.kode_ruang'
            )
            ->leftJoin('pengampu', 'pengampu.kode', '=', 'jadwalkuliah.kode_pengampu')
            ->where('jadwalkuliah.kode_pengampu', $idPengampu)
            ->where(function ($query) use ($schedule, $kodeJam) {
                $query->where('jadwalkuliah.kode_ruang', $schedule->kode_ruang)
                    ->where('jadwalkuliah.kode_jam', $kodeJam)
                    ->where('jadwalkuliah.kode_hari', $schedule->kode_hari);
            })
            ->orWhere(function ($query) use ($schedule, $kodeJam) {
                $query->where('pengampu.kelas', $schedule->kelas)
                    ->where('jadwalkuliah.kode_jam', $kodeJam)
                    ->where('jadwalkuliah.kode_hari', $schedule->kode_hari);
            })
            ->orWhere(function ($query) use ($schedule, $kodeJam) {
                $query->where('pengampu.kode_dosen', $schedule->kode_dosen)
                    ->where('jadwalkuliah.kode_jam', $kodeJam)
                    ->where('jadwalkuliah.kode_hari', $schedule->kode_hari);
            })
            ->get()->count();
    }
}
