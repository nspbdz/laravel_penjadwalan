<?php

namespace App\Exports;

use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportSchedule implements FromView,ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        return view('schedule.export', [
            'schedule' => Schedule::join('pengampu', 'jadwalkuliah.kode_pengampu', '=', 'pengampu.kode')
                ->join('jam', 'jadwalkuliah.kode_jam', '=', 'jam.kode')
                ->join('hari', 'jadwalkuliah.kode_hari', '=', 'hari.kode')
                ->join('ruang', 'jadwalkuliah.kode_ruang', '=', 'ruang.kode')
                ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
                ->select('jadwalkuliah.*', 'jam.range_jam', 'hari.nama as nama_hari', 'ruang.nama as nama_ruang', 'matakuliah.*', 'matakuliah.nama as matkul_name', 'pengampu.kelas')
                ->get(),

        ]);
    }
}
