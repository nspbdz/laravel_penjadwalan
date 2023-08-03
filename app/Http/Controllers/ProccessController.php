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
        $prodi = request('getprodi') ?? '';
        $bentrokdata = [];
        $tidakBentrok = [];
        $tahun = DB::table('tahun_akademik')->get();
        $query = DB::table('jadwalkuliah AS a')
            ->select([
                'e.nama AS hari',
                DB::raw("CONCAT_WS('-', CONCAT('(', g.kode), CONCAT((SELECT kode 
             FROM jam 
             WHERE kode = (SELECT jm.kode 
                 FROM jam jm 
                 WHERE SUBSTRING(jm.range_jam, 1, 5) = SUBSTRING(g.range_jam, 1, 5)) + (c.sks - 1)),')')) AS sesi"),
                DB::raw("CONCAT_WS('-', SUBSTRING(g.range_jam, 1, 5), 
             (SELECT SUBSTRING(range_jam, 7, 5) 
             FROM jam 
             WHERE kode = (SELECT jm.kode 
                 FROM jam jm 
                 WHERE SUBSTRING(jm.range_jam, 1, 5) = SUBSTRING(g.range_jam, 1, 5)) + (c.sks - 1))) AS jam_kuliah"),
                'c.nama AS nama_mk',
                'c.sks AS sks',
                'c.semester AS semester',
                'b.kelas AS kelas',
                'd.nama AS dosen',
                'a.kode_hari as kdhari',
                'f.nama AS ruang',
                'a.kode_ruang as kdruang',
                'a.kode_jam as kdjam',
                'b.kode_dosen as kddos',
                'b.kode as pengampuId'


            ])
            ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
            ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
            ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
            ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
            ->leftJoin('ruang AS f', 'a.kode_ruang', '=', 'f.kode')
            ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode');
        if ($prodi != '') {
            $query->where('c.prodi', '=', $prodi);
        }

        $query = $query->orderBy('kelas')->orderBy('kdhari')->orderBy('kdjam');

        $jadwal = $query->get();



        $jumlahJadwal = count($jadwal);
        //dd($jumlahJadwal);
        $jumlah_bentrok = 0;
        $bentrok = array();
        $keterangan = [];
        for ($i = 0; $i < $jumlahJadwal; $i++) {
            $bentrok[$i] = 0;
            $jam_a = intval($jadwal[$i]->kdjam);
            $hari_a = intval($jadwal[$i]->kdhari);
            $ruang_a = intval($jadwal[$i]->kdruang);
            $dosen_a = intval($jadwal[$i]->kddos);
            $kelas_a = $jadwal[$i]->kelas;
            $sks = intval($jadwal[$i]->sks);


            
            for ($j = 0; $j < $jumlahJadwal; $j++) {
                $jam_b = intval($jadwal[$j]->kdjam);
                $hari_b = intval($jadwal[$j]->kdhari);
                $ruang_b = intval($jadwal[$j]->kdruang);
                $dosen_b = intval($jadwal[$j]->kddos);
                $kelas_b = $jadwal[$j]->kelas;
                //dd($sks);
                if ($i == $j) {
                    continue;
                }
                //dd($i, $j, $jam_a, $jam_b, $hari_a, $hari_b, $ruang_a, $ruang_b);
                // cek ruangan
                if (
                    $jam_a == $jam_b &&
                    $hari_a == $hari_b &&
                    $ruang_a == $ruang_b
                ) {
                    $bentrok[$i] = 1;
                    $jumlah_bentrok = $jumlah_bentrok + 1;
                    $keterangan[$i][] = 'Bentrok Ruangan';
                }
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Ruangan';
                    }
                }
                if ($sks >= 3) {
                    if (
                        $jam_a + 2 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Ruangan';
                    }
                }
                if ($sks >= 4) {
                    if (
                        $jam_a + 3 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Ruangan';
                    }
                }
                if ($sks >= 5) {
                    if (
                        $jam_a + 4 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Ruangan';
                    }
                }

                //cek kelas
                if (
                    $jam_a == $jam_b &&
                    $hari_a == $hari_b &&
                    $kelas_a == $kelas_b
                ) {
                    $bentrok[$i] = 1;
                    $jumlah_bentrok = $jumlah_bentrok + 1;
                    $keterangan[$i][] = 'Bentrok Kelas';
                }
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Kelas';
                    }
                }
                if ($sks >= 3) {
                    if (
                        $jam_a + 2 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Kelas';
                    }
                }
                if ($sks >= 4) {
                    if (
                        $jam_a + 3 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Kelas';
                    }
                }
                if ($sks >= 5) {
                    if (
                        $jam_a + 4 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Kelas';
                    }
                }

                //cek dosen
                if (
                    //ketika jam, hari, dan dosen sama
                    $jam_a == $jam_b &&
                    $hari_a == $hari_b &&
                    $dosen_a == $dosen_b
                ) {
                    $bentrok[$i] = 1;
                    $jumlah_bentrok = $jumlah_bentrok + 1;
                    $keterangan[$i][] = 'Bentrok Dosen';
                }
                if ($sks >= 2) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a + 1 == $jam_b  &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Dosen';
                    }
                }
                if ($sks >= 3) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a + 2 == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Dosen';
                    }
                }
                if ($sks >= 4) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a + 3 == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Dosen';
                    }
                }
                if ($sks >= 5) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a + 4 == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Bentrok Dosen';
                    }
                }
                //u8ntuk mengcek jam nya kelebihan

                if ($sks >= 2) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a  == 10
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Kelebihan Jam';
                    }
                }
                if ($sks >= 3) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a == 10 || $jam_a  == 9
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Kelebihan Jam';
                    }
                }
                if ($sks >= 4) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a == 10 || $jam_a  == 9 || $jam_a  == 8
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Kelebihan Jam';
                    }
                }
                if ($sks >= 5) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a  == 10 || $jam_a  == 9 || $jam_a  == 8 || $jam_a  == 7
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
                        $keterangan[$i][] = 'Kelebihan Jam';
                    }
                }
            }
            if ($bentrok[$i] == 1) {
                $dataBentrok = [

                    $jam_a = $jadwal[$i]->hari,

                    $kdjam = $jadwal[$i]->kdjam,
                    $hari_a = $jadwal[$i]->sesi,

                    $ruang_a = $jadwal[$i]->jam_kuliah,
                    $dosen_a = $jadwal[$i]->nama_mk,
                    $kelas_a = $jadwal[$i]->dosen,
                    $sks = $jadwal[$i]->sks,
                    $sks = $jadwal[$i]->semester,
                    $sks = $jadwal[$i]->kelas,
                    $sks = $jadwal[$i]->ruang,
                    $pengampuId = $jadwal[$i]->pengampuId,
                    $kdhari = $jadwal[$i]->kdhari,

                ];


                $bentrokdata[] = $dataBentrok;
            }
            if ($bentrok[$i] == 0) {
                $dataBentrok = [
                    $jam_a = $jadwal[$i]->hari,

                    $hari_a = $jadwal[$i]->sesi,
                    $ruang_a = $jadwal[$i]->jam_kuliah,
                    $dosen_a = $jadwal[$i]->nama_mk,
                    $kelas_a = $jadwal[$i]->dosen,
                    $sks = $jadwal[$i]->sks,
                    $sks = $jadwal[$i]->semester,
                    $sks = $jadwal[$i]->kelas,
                    $sks = $jadwal[$i]->ruang,
                    $pengampuId = $jadwal[$i]->pengampuId,

                ];

                $tidakBentrok[] = $dataBentrok;
            }
        }
        $prodi = DB::table('matakuliah')->select('prodi')->get();

        $jam = DB::table('jam')->get();
        $listJam = [
            '07:30-08:20', '08:20-09:10', '09:10-10:00', '10:00-10:50', '10:50-11:40',
            '12:40-13:30', '13:30-14:20', '14:20-15:10', '15:10-16:00'
        ];
        $ruangrpl = DB::table('ruang')->get();
        $uniqueJamCodes = $jam->pluck('kode')->unique();
        $harirpl = DB::table('hari')->get();
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
                'jam.range_jam as jam',
                'jadwalkuliah.kode_hari as kdhari',
                'jadwalkuliah.kode_jam as kdjam',
                'matakuliah.sks as sks',
                'matakuliah.nama as nmmatkul',
                'pengampu.kelas as kelas',
                'dosen.nama as nmdos',
                'dosen.kode_dosen as kddos',
                'ruang.nama as nmruang',
                'pengampu.kode_dosen as kodedos',
                'pengampu.kode as kodepengampu'
            )

            ->groupBy('pengampu.kode', 'pengampu.kode_dosen', 'jadwalkuliah.kode_ruang', 'hari.nama', 'jam.kode', 'jam.range_jam', 'jadwalkuliah.kode_jam', 'jadwalkuliah.kode_hari', 'matakuliah.sks', 'matakuliah.nama', 'pengampu.kelas', 'dosen.nama', 'ruang.nama', 'dosen.kode_dosen')
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
            'bentrokdata' => $bentrokdata,
            'tidakBentrok' => $tidakBentrok,

            'schedulerpl' => $schedulerpl,
            'keterangan' => $keterangan

        ]);
    }
    public function bentrok()
    {
        $jam = DB::table('jam')->get();

        $ruangrpl = DB::table('ruang')->get();
        $harirpl = DB::table('hari')->get();
        $kelasrpl = DB::table('kelas')
            ->get();
        $viewrpl = DB::table('jadwalkuliah')
            ->leftJoin('pengampu', 'jadwalkuliah.kode_pengampu', '=', 'pengampu.kode')
            ->leftJoin('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')

            ->select(
                'jadwalkuliah.kode_ruang as kdruang',
                'jadwalkuliah.kode_hari as kdhari',
                'jadwalkuliah.kode_jam as kdjam',
                'matakuliah.sks as sks',
                'pengampu.kelas as kelas',

                'pengampu.kode_dosen as kddos',
                'pengampu.kode as kodepengampu'
            )

            ->groupBy('pengampu.kode', 'pengampu.kode_dosen', 'jadwalkuliah.kode_ruang', 'jadwalkuliah.kode_jam', 'jadwalkuliah.kode_hari', 'matakuliah.sks', 'pengampu.kelas')
            // ->where('kelas.jenis_kelas','=','rpl')
            // ->orderBy('hari.kode', 'asc')
            // ->orderBy('jam.kode', 'asc')
            ->get();
        $jumlah_bentrokrpl = 0;
        $tableDataBentrok = [];
        $tableData = [];
        $schedulerpl = [];
        $data_bentrok = array();


        foreach ($viewrpl as $row) {


            $hari_c = intval($row->kdhari);
            $kelas_c = $row->kelas;
            $jam_c = intval($row->kdjam);
            $ruang_c = intval($row->kdruang);
            $sksrpl = intval($row->sks);
            $dosen_c = intval($row->kddos);


            $bentrokrpl = 0;
            // $schedulerpl[$row->Hari][$listJam[$k]][$row->kelas] = $row->nmmatkul;
            foreach ($viewrpl as $row2) {
                if ($row === $row2) {
                    continue;
                }

                $jam_d = intval($row2->kdjam);
                $hari_d = intval($row2->kdhari);
                $ruang_d = intval($row2->kdruang);
                $dosen_d = intval($row2->kddos);
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
                $update = false;
                $haricodes = [1, 2, 3, 4, 5];
                shuffle($haricodes);
                foreach ($haricodes as $hari) {

                    $maxJam = 10 - ($row->sks - 1);

                    foreach ($jam as $jr) {
                        foreach ($ruangrpl as $ruang) {
                            $maxJam = $jr->kode == 10 - ($row->sks - 1);
                            // dd($jr);
                            $bentrok = (new Schedule())->checkBentrok2($row->kodepengampu, $row, $jr->kode, $hari);
                            if ($bentrok == 0) {
                                //   foreach($haricodes as $harikod){
                                if ($jr->kode == 6) {
                                    continue;
                                }
                                if ($row->sks == 2 && ($jr->kode == 6 || $jr->kode == 10)) {
                                    continue;
                                }
                                if ($row->sks == 3 && ($jr->kode == 6 || $jr->kode == 9 || $jr->kode == 10)) {
                                    continue;
                                }
                                if ($row->sks == 4 && ($jr->kode == 6 || $jr->kode == 8 || $jr->kode == 9 || $jr->kode == 10)) {
                                    continue;
                                }

                                $setData = ['kode_jam' => $jr->kode];
                                $this->updateData($row->kodepengampu, $setData);
                                $bentrokrpl = 0;
                                break 2;
                            }
                        }
                        // }
                    }
                }
            }
        }

        return redirect('schedule');
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

    public function updateKodeHari()
    {
        // dd(request());
        $idPengampu = request('id');
        $kodeHari = request('kodeHari');
        // die($kodeJam);
        $schedule = (new Schedule)->getScheduleByPengampu($idPengampu);

        $bentrok = (new Schedule())->checkBentrokHari($idPengampu, $schedule, $kodeHari);
        if ($bentrok > 0) {
            return response(['success' => false]);
        }

        $result = Schedule::where('kode_pengampu', $idPengampu)->update(['kode_hari' => $kodeHari]);
        if ($result) {
            return response(['success' => true]);
        }
    }



    public function updateData($idPengampu, $setData)
    {

        return Schedule::where('kode_pengampu', $idPengampu)->update($setData);
    }
}
