<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\BisnisController;
use App\Models\Support;
use App\Models\Hour;
use App\Models\Day;
use App\Models\Room;
use App\Models\Lecture;
use App\Models\Wtb;
use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ProccessController extends Controller
{
    private $induk = array();
    private $individu = array(array(array()));
    public function masuk()
    {
        $prodi = DB::table('matakuliah')->select('prodi')->get();


        $tahun = DB::table('tahun_akademik')->get();
        $jam = DB::table('jam')->get();
        $listJam = [
            '07:30-08:20', '08:20-09:10', '09:10-10:00', '10:00-10:50', '10:50-11:40',
            '11:40-12:40', '12:40-13:30', '13:30-14:20', '14:20-15:10', '15:10-16:00'
        ];
        $uniqueJamCodes = $jam->pluck('kode')->unique();
        $harirpl = DB::table('hari')->get();
        $jamrange = DB::table('jam')->get();
        $kelasrpl = DB::table('kelas')
            ->get();
        $viewrpl = DB::table('jadwalkuliah')
            ->leftJoin('pengampu', 'jadwalkuliah.kode_pengampu', '=', 'pengampu.kode')
            ->leftJoin('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
            ->leftJoin('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
            ->leftJoin('hari', 'jadwalkuliah.kode_hari', '=', 'hari.kode')
            ->leftJoin('jam', 'jadwalkuliah.kode_jam', '=', 'jam.kode')
            ->leftJoin('ruang', 'jadwalkuliah.kode_ruang', '=', 'ruang.kode')
            ->leftJoin('kelas', 'pengampu.kelas', '=', 'kelas.nama')
            ->select(
                'hari.nama AS Hari',
                'jam.kode AS kode_jam',
                'jadwalkuliah.kode_ruang as kdruang',
                'jadwalkuliah.kode_ruang',
                'jam.range_jam as jam',
                'jadwalkuliah.kode_hari as kdhari',
                'jadwalkuliah.kode_hari',
                'jadwalkuliah.kode_jam as kdjam',
                'matakuliah.sks as sks',
                'matakuliah.nama as nmmatkul',
                'pengampu.kelas as kelas',
                'dosen.nama as nmdos',
                'dosen.kode_dosen as kddos',
                'dosen.kode_dosen',
                'ruang.nama as nmruang',
                'pengampu.kode_dosen as kodedos',
                'pengampu.kode as kodepengampu'
            )

            ->groupBy('pengampu.kode_dosen', 'jadwalkuliah.kode_ruang', 'hari.nama', 'jam.kode', 'jam.range_jam', 'jadwalkuliah.kode_jam', 'jadwalkuliah.kode_hari', 'matakuliah.sks', 'matakuliah.nama', 'pengampu.kelas', 'dosen.nama', 'ruang.nama', 'dosen.kode_dosen', 'pengampu.kode')
            // ->where('kelas.jenis_kelas','=','rpl')
            ->orderBy('hari.kode', 'asc')
            ->orderBy('jam.kode', 'asc')
            ->get();
        $jumlah_bentrokrpl = 0;
        $tableDataBentrok = [];
        $tableData = [];
        $schedulerpl = [];
        foreach ($viewrpl as $row) {
            $key = array_search($row->jam, $listJam);
            $hari_c = intval($row->kdhari);
            $kelas_c = $row->kelas;
            $jam_c = intval($row->kdjam);
            $ruang_c = intval($row->kdruang);
            $sksrpl = intval($row->sks);
            $dosen_c = intval($row->kodedos);
            for ($i = 0; $i < $row->sks; $i++) {
                $k = $key + $i;
                if (!isset($listJam[$k])) {
                    continue;
                }

                $bentrokrpl = 0;
                // $schedulerpl[$row->Hari][$listJam[$k]][$row->kelas] = $row->nmmatkul;
                foreach ($viewrpl as $row2) {
                    if ($row === $row2) {
                        continue;
                    }
                    $jam_d = intval($row2->kdjam);
                    $hari_d = intval($row2->kdhari);
                    $ruang_d = intval($row2->kdruang);
                    $dosen_d = intval($row2->kodedos);
                    $kelas_d = $row2->kelas;
                    $sksrpl_d = intval($row2->sks);
                    // cek ruangan
                    if (
                        $jam_c == $jam_d &&
                        $hari_c == $hari_d &&
                        $ruang_c == $ruang_d
                    ) {
                        $bentrokrpl = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                    if ($sksrpl >= 2) {
                        if (
                            $jam_c + 1 == $jam_d &&
                            $hari_c == $hari_d &&
                            $ruang_c == $ruang_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 3) {
                        if (
                            $jam_c + 2 == $jam_d &&
                            $hari_c == $hari_d &&
                            $ruang_c == $ruang_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 4) {
                        if (
                            $jam_c + 3 == $jam_d &&
                            $hari_c == $hari_d &&
                            $ruang_c == $ruang_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 5) {
                        if (
                            $jam_c + 4 == $jam_d &&
                            $hari_c == $hari_d &&
                            $ruang_c == $ruang_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }

                    //cek kelas
                    if (
                        $jam_c == $jam_d &&
                        $hari_c == $hari_d &&
                        $kelas_c == $kelas_d
                    ) {
                        $bentrokrpl = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                    if ($sksrpl >= 2) {
                        if (
                            $jam_c + 1 == $jam_d &&
                            $hari_c == $hari_d &&
                            $kelas_c == $kelas_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 3) {
                        if (
                            $jam_c + 2 == $jam_d &&
                            $hari_c == $hari_d &&
                            $kelas_c == $kelas_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 4) {
                        if (
                            $jam_c + 3 == $jam_d &&
                            $hari_c == $hari_d &&
                            $kelas_c == $kelas_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 5) {
                        if (
                            $jam_c + 4 == $jam_d &&
                            $hari_c == $hari_d &&
                            $kelas_c == $kelas_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }

                    //cek dosen
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_c == $jam_d &&
                        $hari_c == $hari_d &&
                        $dosen_c == $dosen_d
                    ) {
                        $bentrokrpl = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                    if ($sksrpl >= 2) {
                        if (
                            //ketika jam, hari, dan dosen sama
                            $jam_c + 1 == $jam_d  &&
                            $hari_c == $hari_d &&
                            $dosen_c == $dosen_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 3) {
                        if (
                            //ketika jam, hari, dan dosen sama
                            $jam_c + 2 == $jam_d &&
                            $hari_c == $hari_d &&
                            $dosen_c == $dosen_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 4) {
                        if (
                            //ketika jam, hari, dan dosen sama
                            $jam_c + 3 == $jam_d &&
                            $hari_c == $hari_d &&
                            $dosen_c == $dosen_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                    if ($sksrpl >= 5) {
                        if (
                            //ketika jam, hari, dan dosen sama
                            $jam_c + 4 == $jam_d &&
                            $hari_c == $hari_d &&
                            $dosen_c == $dosen_d
                        ) {
                            $bentrokrpl = 1;
                            $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                        }
                    }
                }
                if ($bentrokrpl === 1) {
                    // dd($row);
                    // dd($harirpl);
                    foreach ($harirpl as $hari) {
                        // dd($k);
                        foreach ($jamrange as $jr) {
                            // dd($jr);
                            $bentrok = (new Schedule())->checkBentrok2($row->kodepengampu, $row, $jr->kode, $hari->kode);
                            if ($bentrok == 0) {
                                $setData = ['kode_jam' => $jr->kode, 'kode_hari' => $hari->kode];
                                $this->updateData($row->kodepengampu, $setData);
                                $bentrokrpl = 0;
                                break 2;
                            }
                        }
                    }
                }
                if ($bentrokrpl === 1) {

                    for ($i = 0; $i < $row->sks; $i++) {
                        $k = $key + $i;
                        if (!isset($listJam[$k])) {
                            continue;
                        }
                        $tableDataBentrok[$row->Hari][$listJam[$k]][$row->kelas] = $row->nmmatkul . ' - ' . $row->nmruang . ' - ' . $row->kddos;
                    }
                }
                if ($bentrokrpl === 0) {
                    $tableData[$row->Hari][$listJam[$k]][$row->kelas] = $row->nmmatkul . ' - ' . $row->nmruang . ' - ' . $row->kddos;
                }
            }
        }

        return view('schedule.index', [
            'kelasrpl' => $kelasrpl, 'viewrpl' => $viewrpl, 'tahun' => $tahun, 'jam' => $jam, 'uniqueJamCodes' => $uniqueJamCodes, 'harirpl' => $harirpl,
            'tableData' => $tableData,
            'tableDataBentrok' => $tableDataBentrok,
            'listJam' => $listJam,

            'schedulerpl' => $schedulerpl

        ]);
    }
    public function updateKodeJam_old(Request $request)
    {
        // Mendapatkan nomor baris dan kode jam dari permintaan AJAX
        $row = $request->input('row');
        $kodeJam = $request->input('kodeJam');

        // Lakukan operasi untuk memperbarui kode jam dalam database
        // Misalnya, jika Anda memiliki model Schedule, Anda dapat menggunakan kode berikut:
        $schedule = Schedule::find($row + 1); // Nomor baris dimulai dari 0, sementara ID dimulai dari 1
        $schedule->kode_jam = $kodeJam;
        $schedule->save();

        // Mengembalikan respons sukses dalam bentuk JSON
        return response()->json(['success' => true]);
    }


    public function updateKodeJam()
    {
        // dd(request());
        $idPengampu = request('id');
        $kodeJam = request('kodeJam');
        // die($kodeJam);
        $schedule = (new Schedule)->getScheduleByPengampu($idPengampu);

        $bentrok = (new Schedule())->checkBentrok($idPengampu, $schedule, $kodeJam);
        if ($bentrok > 0) {
            return response(['success' => false]);
        }

        $result = Schedule::where('kode_pengampu', $idPengampu)->update(['kode_jam' => $kodeJam]);
        if ($result) {
            return response(['success' => true]);
        }
    }



    public function updateData($idPengampu, $setData)
    {

        return Schedule::where('kode_pengampu', $idPengampu)->update($setData);
    }
}
