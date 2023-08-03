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

    public function checkBentrokHari($idPengampu, $schedule, $kodeHari)
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
            ->where(function ($query) use ($schedule, $kodeHari) {
                $query->where('jadwalkuliah.kode_ruang', $schedule->kode_ruang)
                    ->where('jadwalkuliah.kode_jam', $schedule->kode_ruang)
                    ->where('jadwalkuliah.kode_hari', $kodeHari);
            })
            ->orWhere(function ($query) use ($schedule, $kodeHari) {
                $query->where('pengampu.kelas', $schedule->kelas)
                    ->where('jadwalkuliah.kode_jam', $schedule->kode_ruang)
                    ->where('jadwalkuliah.kode_hari', $kodeHari);
            })
            ->orWhere(function ($query) use ($schedule, $kodeHari) {
                $query->where('pengampu.kode_dosen', $schedule->kode_dosen)
                    ->where('jadwalkuliah.kode_jam', $schedule->kode_ruang)
                    ->where('jadwalkuliah.kode_hari', $kodeHari);
            })
            ->get()->count();
    }
//     public function checkBentrok2($idPengampu, $schedule, $kodeJam, $kodeHari)
//     {
        
      
//         return DB::table($this->table)
//             ->select(
//                 'matakuliah.sks',
//                 'pengampu.kode_dosen',
//                 'pengampu.kode_mk',
//                 'pengampu.kelas',
//                 'jadwalkuliah.kode_ruang',
                
//             )
//             ->leftJoin('pengampu', 'pengampu.kode', '=', 'jadwalkuliah.kode_pengampu')
//             ->leftJoin('matakuliah','matakuliah.kode','=','pengampu.kode_mk')
//             ->where('jadwalkuliah.kode_pengampu', $idPengampu)
//             ->when(function ($query) use ($schedule) {
//                 return $query
//                 ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//                 ->where('jadwalkuliah.kode_jam', $schedule->kdjam)
//                 ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
//         })
//         ->when($schedule->sks >= 2, function ($query) use ($schedule) {
//             return $query
//             ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//             ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 1)
//             ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
//     })
//     ->when($schedule->sks >= 3, function ($query) use ($schedule) {
//         return $query
//         ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//         ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 2)
//         ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 4, function ($query) use ($schedule) {
//     return $query
//     ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//     ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 3)
//     ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 5, function ($query) use ($schedule) {
//     return $query
//     ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//     ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 4)
//     ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when( function ($query) use ($schedule) {
//     return $query
//     ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
//     ->where('jadwalkuliah.kode_jam', $schedule->kdjam)
//     ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 2, function ($query) use ($schedule) {
// return $query
// ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
// ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 1)
// ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 3, function ($query) use ($schedule) {
// return $query
// ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
// ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 2)
// ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 4, function ($query) use ($schedule) {
// return $query
// ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
// ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 3)
// ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 5, function ($query) use ($schedule) {
// return $query
// ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
// ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 4)
// ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when( function ($query) use ($schedule) {
//     return $query
//     ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
//     ->where('jadwalkuliah.kode_jam', $schedule->kdjam)
//     ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 2, function ($query) use ($schedule) {
// return $query
// ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
// ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 1)
// ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 3, function ($query) use ($schedule) {
// return $query
// ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
// ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 2)
// ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 4, function ($query) use ($schedule) {
// return $query
// ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
// ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 3)
// ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// ->when($schedule->sks >= 5, function ($query) use ($schedule) {
// return $query
// ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
// ->where('jadwalkuliah.kode_jam', $schedule->kdjam + 4)
// ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
// })
// //cek lain
// ->when($schedule->sks >= 1, function ($query) use ($schedule,$kodeJam,$kodeHari) {
//                 return $query
//                 ->where('matakuliah.sks', 1)
//                 ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//                 ->where('jadwalkuliah.kode_jam', $kodeJam)
//                 ->where('jadwalkuliah.kode_hari', $kodeHari);
//         })
//         ->when($schedule->sks >= 2, function ($query) use ($schedule,$kodeJam,$kodeHari) {
//             return $query
//             ->where('matakuliah.sks', 2)
//             ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//             ->where('jadwalkuliah.kode_jam', $kodeJam)
//             ->where('jadwalkuliah.kode_hari', $kodeHari);
//     })
//     ->when($schedule->sks >= 3, function ($query) use ($schedule,$kodeJam,$kodeHari) {
//         return $query
//         ->where('matakuliah.sks', 3)
//         ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//         ->where('jadwalkuliah.kode_jam', $kodeJam)
//         ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 4, function ($query) use ($schedule,$kodeJam,$kodeHari) {
//     return $query
//     ->where('matakuliah.sks', 4)
//     ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//     ->where('jadwalkuliah.kode_jam', $kodeJam)
//     ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 5, function ($query) use ($schedule,$kodeJam,$kodeHari) {
//     return $query
//     ->where('matakuliah.sks', 5)
//     ->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
//     ->where('jadwalkuliah.kode_jam', $kodeJam)
//     ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 1, function ($query) use ($schedule,$kodeJam,$kodeHari) {
//     return $query
//     ->where('matakuliah.sks', 1)
//     ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
//     ->where('jadwalkuliah.kode_jam', $kodeJam)
//     ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 2, function ($query) use ($schedule,$kodeJam,$kodeHari) {
// return $query
// ->where('matakuliah.sks', 2)
// ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
// ->where('jadwalkuliah.kode_jam', $kodeJam)
// ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 3, function ($query) use ($schedule,$kodeJam,$kodeHari) {
// return $query
// ->where('matakuliah.sks', 3)
// ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
// ->where('jadwalkuliah.kode_jam', $kodeJam)
// ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 4, function ($query) use ($schedule,$kodeJam,$kodeHari) {
// return $query
// ->where('matakuliah.sks', 4)
// ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
// ->where('jadwalkuliah.kode_jam', $kodeJam)
// ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 5, function ($query) use ($schedule,$kodeJam,$kodeHari) {
// return $query
// ->where('matakuliah.sks', 5)
// ->where('jadwalkuliah.kode_ruang', $schedule->kddos)
// ->where('jadwalkuliah.kode_jam', $kodeJam)
// ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 1, function ($query) use ($schedule,$kodeJam,$kodeHari) {
//     return $query
//     ->where('matakuliah.sks', 1)
//     ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
//     ->where('jadwalkuliah.kode_jam', $kodeJam)
//     ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 2, function ($query) use ($schedule,$kodeJam,$kodeHari) {
// return $query
// ->where('matakuliah.sks', 2)
// ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
// ->where('jadwalkuliah.kode_jam', $kodeJam)
// ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 3, function ($query) use ($schedule,$kodeJam,$kodeHari) {
// return $query
// ->where('matakuliah.sks', 3)
// ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
// ->where('jadwalkuliah.kode_jam', $kodeJam)
// ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 4, function ($query) use ($schedule,$kodeJam,$kodeHari) {
// return $query
// ->where('matakuliah.sks', 4)
// ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
// ->where('jadwalkuliah.kode_jam', $kodeJam)
// ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
// ->when($schedule->sks >= 5, function ($query) use ($schedule,$kodeJam,$kodeHari) {
// return $query
// ->where('matakuliah.sks', 5)
// ->where('jadwalkuliah.kode_ruang', $schedule->kelas)
// ->where('jadwalkuliah.kode_jam', $kodeHari)
// ->where('jadwalkuliah.kode_hari', $kodeHari);
// })
            
//             ->get()->count();
          
//     }
public function checkBentrok2($idPengampu, $schedule, $kodeJam, $kodeHari)
{
    return DB::table($this->table)
        ->select(
            'pengampu.kode_dosen',
            'pengampu.kode_mk',
            'pengampu.kelas',
            'jadwalkuliah.kode_ruang',
            'jadwalkuliah.kode_jam',
            'jadwalkuliah.kode_hari'
        )
        ->leftJoin('pengampu', 'pengampu.kode', '=', 'jadwalkuliah.kode_pengampu')
        ->where('jadwalkuliah.kode_pengampu', $idPengampu)
        ->where(function ($query) use ($schedule, $kodeJam ) {
            $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
                ->where('jadwalkuliah.kode_jam', $kodeJam)
                ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
        })
        ->orWhere(function ($query) use ($schedule, $kodeJam) {
            $query->where('pengampu.kelas', $schedule->kelas)
                ->where('jadwalkuliah.kode_jam', $kodeJam)
                ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
        })
        ->orWhere(function ($query) use ($schedule, $kodeJam) {
            $query->where('pengampu.kode_dosen', $schedule->kddos)
                ->where('jadwalkuliah.kode_jam', $kodeJam)
                ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
        })
        ->orWhere(function ($query) use ($schedule, $kodeJam, $kodeHari) {
            $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
                ->where('jadwalkuliah.kode_jam', $kodeJam)
                ->where('jadwalkuliah.kode_hari', $kodeHari);
        })
        ->orWhere(function ($query) use ($schedule, $kodeJam, $kodeHari) {
            $query->where('pengampu.kelas', $schedule->kelas)
                ->where('jadwalkuliah.kode_jam', $kodeJam)
                ->where('jadwalkuliah.kode_hari', $kodeHari);
        })
        ->orWhere(function ($query) use ($schedule, $kodeJam, $kodeHari) {
            $query->where('pengampu.kode_dosen', $schedule->kddos)
                ->where('jadwalkuliah.kode_jam', $kodeJam)
                ->where('jadwalkuliah.kode_hari', $kodeHari);
        })
        // ->orWhere(function ($query) use ($schedule,  $kodeHari) {
        //     $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
        //         ->where('jadwalkuliah.kode_jam', $schedule->kdjam)
        //         ->where('jadwalkuliah.kode_hari', $kodeHari);
        // })
        // ->orWhere(function ($query) use ($schedule,  $kodeHari) {
        //     $query->where('pengampu.kelas', $schedule->kelas)
        //         ->where('jadwalkuliah.kode_jam', $schedule->kdjam)
        //         ->where('jadwalkuliah.kode_hari', $kodeHari);
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeHari) {
        //     $query->where('pengampu.kode_dosen', $schedule->kddos)
        //         ->where('jadwalkuliah.kode_jam', $schedule->kdjam)
        //         ->where('jadwalkuliah.kode_hari', $kodeHari);
        // })
        ->get()->count();
        // return DB::table($this->table)
        // ->select(
        //     'pengampu.kode_dosen',
        //     'pengampu.kode_mk',
        //     'pengampu.kelas',
        //     'jadwalkuliah.kode_ruang'
        // )
        // ->leftJoin('pengampu', 'pengampu.kode', '=', 'jadwalkuliah.kode_pengampu')
        // ->where('jadwalkuliah.kode_pengampu', $idPengampu)
        // ->where(function ($query) use ($schedule, $kodeJam ) {
        //     $query->when($schedule->sks >= 1, function ($query) use ($schedule, $kodeJam) {
        //         return $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
        //                      ->where('jadwalkuliah.kode_jam', $kodeJam)
        //                      ->where('jadwalkuliah.kode_hari', '=', $schedule->kdhari);
        //     });
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeJam) {
        //     $query->when($schedule->sks >= 2, function ($query) use ($schedule, $kodeJam) {
        //         return $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
        //                      ->where('jadwalkuliah.kode_jam', $kodeJam)
        //                      ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
        //     });
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeJam) {
        //     $query->when($schedule->sks >= 3, function ($query) use ($schedule, $kodeJam) {
        //         return $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
        //                      ->where('jadwalkuliah.kode_jam', $kodeJam)
        //                      ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
        //     });
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeJam) {
        //     $query->when($schedule->sks >= 4, function ($query) use ($schedule, $kodeJam) {
        //         return $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
        //                      ->where('jadwalkuliah.kode_jam', $kodeJam)
        //                      ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
        //     });
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeJam) {
        //     $query->when($schedule->sks >= 5, function ($query) use ($schedule, $kodeJam) {
        //         return $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
        //                      ->where('jadwalkuliah.kode_jam', $kodeJam)
        //                      ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
        //     });
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeJam) {
        //     $query->where('pengampu.kode_dosen', $schedule->kddos)
        //         ->where('jadwalkuliah.kode_jam', $kodeJam)
        //         ->where('jadwalkuliah.kode_hari', $schedule->kdhari);
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeJam, $kodeHari) {
        //     $query->where('jadwalkuliah.kode_ruang', $schedule->kdruang)
        //         ->where('jadwalkuliah.kode_jam', $kodeJam)
        //         ->where('jadwalkuliah.kode_hari', $kodeHari);
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeJam, $kodeHari) {
        //     $query->where('pengampu.kelas', $schedule->kelas)
        //         ->where('jadwalkuliah.kode_jam', $kodeJam)
        //         ->where('jadwalkuliah.kode_hari', $kodeHari);
        // })
        // ->orWhere(function ($query) use ($schedule, $kodeJam, $kodeHari) {
        //     $query->where('pengampu.kode_dosen', $schedule->kddos)
        //         ->where('jadwalkuliah.kode_jam', $kodeJam)
        //         ->where('jadwalkuliah.kode_hari', $kodeHari);
        // })
        // ->get()->count();
}
}
