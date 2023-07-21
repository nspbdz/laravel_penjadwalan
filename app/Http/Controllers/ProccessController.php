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
    protected $m_dosen;
    protected $m_matakuliah;
    protected $m_ruang;
    protected $m_jam;
    protected $m_hari;
    protected $m_pengampu;
    protected $m_waktu_tidak_bersedia;
    protected $m_jadwalkuliah;
    protected $bisnisController;









    // $jumlah_generasi = config('config.jumlah_generasi');
    // // dd($jumlah_generasi);
    // $genetik = new BisnisController(); //kode jam dhuhur


    // // dd($genetik);
    // public function getProdi(Request $request)
    // {
    //     $prodi = $request->get('prodi');

    //     $kelas = DB::table('kelas')
    //     ->where('jenis_kelas','=',$prodi)
    //     ->get();
    //   dd($prodi);
    //   $cek= array();
    //   foreach($kelas as $value){

    //       //dd($value);

    //       $cek[$value->kode] = $value->jenis_kelas;
    //   }


    //     return response()->json($cek);
    // }
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
                'e.kode as kdhari',
                'f.nama AS ruang',
                'f.kode as kdruang',
                'a.kode_jam as kdjam',
                'd.kode as kddos',
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
                }
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
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
                }
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
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

                ];
                // $where = ['kode_jam' => ($kdjam + 1)];
                //    $this->updateData($pengampuId, $where);

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

        $bentrokdatarpl = [];
        $tidakBentrokrpl = [];
        $jadwalrpl = DB::table('jadwalkuliah AS a')
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
                'e.kode as kdhari',
                'f.nama AS ruang',
                'f.kode as kdruang',
                'a.kode_jam as kdjam',
                'd.kode as kddos',
                'b.kode as pengampuId',
                'f.jenis as jenisruang'


            ])
            ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
            ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
            ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
            ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
            ->leftJoin('ruang AS f', 'a.kode_ruang', '=', 'f.kode')
            ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode')
            ->where('c.prodi', '=', 'rpl')
            ->orderBy('kelas')
            ->orderBy('kdhari')
            ->orderBy('kdjam')

            ->get();

        $jumlahJadwal = count($jadwalrpl);
        //dd($jumlahJadwal);
        $jumlah_bentrokrpl = 0;
        $bentrok = array();
        for ($i = 0; $i < $jumlahJadwal; $i++) {
            $bentrokrpl[$i] = 0;
            $jam_c = intval($jadwalrpl[$i]->kdjam);
            $hari_c = intval($jadwalrpl[$i]->kdhari);
            $ruang_c = intval($jadwalrpl[$i]->kdruang);
            $dosen_c = intval($jadwalrpl[$i]->kddos);
            $kelas_c = $jadwalrpl[$i]->kelas;
            $sksrpl = intval($jadwalrpl[$i]->sks);



            for ($j = 0; $j < $jumlahJadwal; $j++) {
                $jam_d = intval($jadwalrpl[$j]->kdjam);
                $hari_d = intval($jadwalrpl[$j]->kdhari);
                $ruang_d = intval($jadwalrpl[$j]->kdruang);
                $dosen_d = intval($jadwalrpl[$j]->kddos);
                $kelas_d = $jadwalrpl[$j]->kelas;
                //dd($sks);
                if ($i == $j) {
                    continue;
                }
                //dd($i, $j, $jam_c, $jam_b, $hari_a, $hari_b, $ruang_a, $ruang_b);
                // cek ruangan
                if (
                    $jam_c == $jam_d &&
                    $hari_c == $hari_d &&
                    $ruang_c == $ruang_d
                ) {
                    $bentrokrpl[$i] = 1;
                    $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                }
                if ($sksrpl >= 2) {
                    if (
                        $jam_c + 1 == $jam_d &&
                        $hari_c == $hari_d &&
                        $ruang_c == $ruang_d
                    ) {
                        $bentrokrpl[$i] = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                }
                if ($sksrpl >= 3) {
                    if (
                        $jam_c + 2 == $jam_d &&
                        $hari_c == $hari_d &&
                        $ruang_c == $ruang_d
                    ) {
                        $bentrokrpl[$i] = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                }
                if ($sksrpl >= 4) {
                    if (
                        $jam_c + 3 == $jam_d &&
                        $hari_c == $hari_d &&
                        $ruang_c == $ruang_d
                    ) {
                        $bentrokrpl[$i] = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                }
                if ($sksrpl >= 5) {
                    if (
                        $jam_c + 4 == $jam_d &&
                        $hari_c == $hari_d &&
                        $ruang_c == $ruang_d
                    ) {
                        $bentrokrpl[$i] = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                }

                //cek kelas
                if (
                    $jam_c == $jam_d &&
                    $hari_c == $hari_d &&
                    $kelas_c == $kelas_d
                ) {
                    $bentrokrpl[$i] = 1;
                    $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                }
                if ($sksrpl >= 2) {
                    if (
                        $jam_c + 1 == $jam_d &&
                        $hari_c == $hari_d &&
                        $kelas_c == $kelas_d
                    ) {
                        $bentrokrpl[$i] = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                }
                if ($sksrpl >= 3) {
                    if (
                        $jam_c + 2 == $jam_d &&
                        $hari_a == $hari_d &&
                        $kelas_a == $kelas_d
                    ) {
                        $bentrokrpl[$i] = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                }
                if ($sksrpl >= 4) {
                    if (
                        $jam_c + 3 == $jam_d &&
                        $hari_c == $hari_d &&
                        $kelas_c == $kelas_d
                    ) {
                        $bentrokrpl[$i] = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                }
                if ($sksrpl >= 5) {
                    if (
                        $jam_c + 4 == $jam_d &&
                        $hari_c == $hari_d &&
                        $kelas_c == $kelas_d
                    ) {
                        $bentrokrpl[$i] = 1;
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
                    $bentrokrpl[$i] = 1;
                    $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                }
                if ($sksrpl >= 2) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_c + 1 == $jam_d  &&
                        $hari_c == $hari_d &&
                        $dosen_c == $dosen_d
                    ) {
                        $bentrokrpl[$i] = 1;
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
                        $bentrokrpl[$i] = 1;
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
                        $bentrokrpl[$i] = 1;
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
                        $bentrokrpl[$i] = 1;
                        $jumlah_bentrokrpl = $jumlah_bentrokrpl + 1;
                    }
                }
            }
            if ($bentrokrpl[$i] == 1) {
                $dataBentrokrpl = [
                    $jam_c = $jadwalrpl[$i]->hari,
                    $kdjam = $jadwalrpl[$i]->kdjam,
                    $hari_a = $jadwalrpl[$i]->sesi,
                    $ruang_a = $jadwalrpl[$i]->jam_kuliah,
                    $dosen_a = $jadwalrpl[$i]->nama_mk,
                    $kelas_a = $jadwalrpl[$i]->dosen,
                    $sks = $jadwalrpl[$i]->sks,
                    $sks = $jadwalrpl[$i]->semester,
                    $sks = $jadwalrpl[$i]->kelas,
                    $sks = $jadwalrpl[$i]->ruang,
                    $pengampu = $jadwalrpl[$i]->pengampuId,
                    $jenisruang = $jadwalrpl[$i]->jenisruang,
                ];

                $bentrokdatarpl[] = $dataBentrokrpl;
            }
            if ($bentrokrpl[$i] == 0) {
                $dataBentrokrpl = [
                    $jam_c = $jadwalrpl[$i]->hari,
                    $kdjam = $jadwalrpl[$i]->kdjam,
                    $hari_a = $jadwalrpl[$i]->sesi,
                    $ruang_a = $jadwalrpl[$i]->jam_kuliah,
                    $dosen_a = $jadwalrpl[$i]->nama_mk,
                    $kelas_a = $jadwalrpl[$i]->dosen,
                    $sks = $jadwalrpl[$i]->sks,
                    $sks = $jadwalrpl[$i]->semester,
                    $sks = $jadwalrpl[$i]->kelas,
                    $sks = $jadwalrpl[$i]->ruang,
                    $pengampu = $jadwalrpl[$i]->pengampuId,
                    $jenisruang = $jadwalrpl[$i]->jenisruang,
                ];

                $tidakBentrokrpl[] = $dataBentrokrpl;
            }
        }
        //dd($bentrokdatarpl);


        $kelasti = DB::table('kelas')
            ->where('jenis_kelas', '=', 'ti')
            ->get();
        $jam = DB::table('jam')->get();
        $harirpl = DB::table('hari')->get();
        $viewti = DB::table('jadwalkuliah')
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
                'jam.range_jam as jam',
                'jadwalkuliah.kode_hari as kdhari',
                'jadwalkuliah.kode_jam as kdjam',
                // 'pengampu.kelas as kelas',
                // DB::raw("CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') as info"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI1A' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI1A"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI1B' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI1B"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI1C' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI1C"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI2A' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI2A"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI2B' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI2B"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI2C' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI2C"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI3A' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI3A"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI3B' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI3B"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI3C' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI3C"),
            )

            ->groupBy('hari.nama', 'jam.kode', 'jam.range_jam', 'jadwalkuliah.kode_hari', 'jadwalkuliah.kode_jam')
            ->where('kelas.jenis_kelas', '=', 'ti')
            ->orderBy('hari.kode', 'asc')
            ->orderBy('jam.kode', 'asc')
            ->get();

        // dd($viewti);
        $scheduleti = [];
        $listJam = [
            '07:30-08:20', '08:20-09:10', '09:10-10:00', '10:00-10:50', '10:50-11:40',
            '11:40-12:40', '12:40-13:30', '13:30-14:20', '14:20-15:10', '15:10-16:00'
        ];
        foreach ($viewti as $ti) {
            if ($ti->D3TI1A) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI1A'] = $ti->D3TI1A;
            }
            if ($ti->D3TI1B) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI1B'] = $ti->D3TI1B;
            }
            if ($ti->D3TI1C) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI1C'] = $ti->D3TI1C;
            }
            if ($ti->D3TI2A) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI2A'] = $ti->D3TI2A;
            }
            if ($ti->D3TI2B) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI2B'] = $ti->D3TI2B;
            }
            if ($ti->D3TI2C) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI2C'] = $ti->D3TI2C;
            }
            if ($ti->D3TI3A) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI3A'] = $ti->D3TI3A;
            }
            if ($ti->D3TI3B) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI3B'] = $ti->D3TI3B;
            }
            if ($ti->D3TI3C) {
                $scheduleti[$ti->Hari][$ti->jam]['D3TI3C'] = $ti->D3TI3C;
            }
        }

        // dd($scheduleti);

        $uniqueJamCodes = $jam->pluck('kode')->unique();
        // dd($uniqueJamCodes);
        $harirpl = DB::table('hari')->get();
        $kelasrpl = DB::table('kelas')
            ->where('jenis_kelas', '=', 'rpl')
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
                'jam.range_jam as jam',
                'jadwalkuliah.kode_hari as kdhari',
                'jadwalkuliah.kode_jam as kdjam',
                'matakuliah.sks as sks',
                'matakuliah.nama as nmmatkul',
                'pengampu.kelas as kelas',
                'dosen.nama as nmdos',
                'ruang.nama as nmruang'
            )

            ->groupBy('hari.nama', 'jam.kode', 'jam.range_jam', 'jadwalkuliah.kode_jam', 'jadwalkuliah.kode_hari', 'matakuliah.sks', 'matakuliah.nama', 'pengampu.kelas', 'dosen.nama', 'ruang.nama')
            ->where('kelas.jenis_kelas', '=', 'rpl')
            ->orderBy('hari.kode', 'asc')
            ->orderBy('jam.kode', 'asc')
            ->get();
        // dd($jam);
        $tableData = [];
        $schedulerpl = [];
        foreach ($viewrpl as $row) {
            $key = array_search($row->jam, $listJam);
            // dd($key);
            for ($i = 0; $i < $row->sks; $i++) {
                $k = $key + $i;
                if(!isset($listJam[$k])){
                    continue;
                }
                $schedulerpl[$row->Hari][$listJam[$k]][$row->kelas] = $row->nmmatkul;
            }
            $matkulIndex = array_search($row->nmmatkul, array_column($tableData, 'matakuliah'));
            if ($matkulIndex === false) {
                $tableData[] = [
                    'matakuliah' => $row->nmmatkul,
                    'sks' => $row->sks,
                    'hari_jam' => [
                        [
                            'hari' => $row->Hari,
                            'jam' => $row->kdjam,
                        ]
                    ],
                ];
            } else {
                $tableData[$matkulIndex]['hari_jam'][] = [
                    'hari' => $row->Hari,
                    'jam' => $row->jam,
                ];
            }
        }

        return view('schedule.index', [
            'bentrok' => $bentrok,
            'tidakBentrok' => $tidakBentrok,
            'bentrokdata' => $bentrokdata,
            'tidakBentrokrpl' => $tidakBentrokrpl,
            'bentrokdatarpl' => $bentrokdatarpl,
            'jadwal' => $jadwal,
            'kelasti' => $kelasti,
            'viewti' => $viewti,
            'kelasrpl' => $kelasrpl,
            'viewrpl' => $viewrpl,
            'prodi' => $prodi,
            'tahun' => $tahun,
            'jam' => $jam,
            'uniqueJamCodes' => $uniqueJamCodes,
            'harirpl' => $harirpl,
            'tableData' => $tableData,
            'hari' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
            'listJam' => $listJam,
            'scheduleti' => $scheduleti,
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
    public function __construct(
        Lecture $m_dosen,
        Course $m_matakuliah,
        Room $m_ruang,
        Hour $m_jam,
        Day $m_hari,
        Support $m_pengampu,
        Wtb $m_waktu_tidak_bersedia,
        Schedule $m_jadwalkuliah
    ) {

        $this->m_dosen = $m_dosen;
        $this->m_matakuliah = $m_matakuliah;
        $this->m_ruang = $m_ruang;
        $this->m_jam = $m_jam;
        $this->m_hari = $m_hari;
        $this->m_pengampu = $m_pengampu;
        $this->m_waktu_tidak_bersedia = $m_waktu_tidak_bersedia;
        $this->m_jadwalkuliah = $m_jadwalkuliah;
    }

    public  function index(Request $request)
    {
        set_time_limit(120000);
        $data = array();



        //tempat keajaiban dimulai. SEMANGAAAAAATTTTTTT BANZAIIIIIIIIIIIII !


        if ($request->isMethod('post')) {
            $jenis_semester = request()->post('semester_tipe');
            $tahun_akademik = request()->post('tahun_akademik');
            $jumlah_populasi = request()->post('jumlah_populasi');
            $crossOver = request()->post('probabilitas_crossover');
            $mutasi = request()->post('probabilitas_mutasi');
            $jumlah_generasi = request()->post('jumlah_generasi');

            $data['semester_tipe'] = $jenis_semester;
            $data['tahun_akademik'] = $tahun_akademik;
            $data['jumlah_populasi'] = $jumlah_populasi;
            $data['probabilitas_crossover'] = $crossOver;
            $data['probabilitas_mutasi'] = $mutasi;
            $data['jumlah_generasi'] = $jumlah_generasi;



            $rs_data = DB::table('pengampu AS a')
                ->select('a.kode', 'b.sks', 'a.kode_dosen', 'b.jenis', 'a.kelas')
                ->leftJoin('matakuliah AS b', 'a.kode_mk', '=', 'b.kode')
                ->where(DB::raw('b.semester % 2'), $jenis_semester)
                ->where('a.tahun_akademik', $tahun_akademik)
                ->get();

            if ($rs_data->count() == 0) {

                $data['msg'] = 'Tidak Ada Data dengan Semester dan Tahun Akademik ini <br>Data yang tampil dibawah adalah data dari proses sebelumnya';

                //redirect(base_url() . 'web/penjadwalan','reload');
            } else {
                $genetik = new BisnisController(
                    $jenis_semester,
                    $tahun_akademik,
                    $jumlah_populasi,
                    $crossOver,
                    $mutasi,
                    //~~~~~~BUG!~~~~~~~
                    /*										   
                                                1 senin 5
                                                2 selasa 4
                                                3 rabu 3
                                                4 kamis 2
                                                5 jumat 1										    
                                               */
                    5, //kode hari jumat										   
                    '4-5-6', //kode jam jumat
                    //jam dhuhur tidak dipake untuk sementara
                    6
                ); //kode jam dhuhur
                $genetik->ambildata();
                $genetik->setWb();
                $genetik->inisialisasi();

                $found = false;

                for ($i = 0; $i < $jumlah_generasi; $i++) {

                    $fitness = $genetik->HitungFitness();


                    $genetik->Seleksi($fitness);

                    $genetik->StartCrossOver();

                    $fitness_akhir[$i] = $fitnessAfterMutation = $genetik->Mutasi();
                    //dd($fitnessAfterMutation);
                    ////$fitnessAfterMutation = $genetik->Mutasi();

                    for ($j = 0; $j < count($fitnessAfterMutation); $j++) {
                        // if (!isset($fitnessAfterMutation[$j])) {
                        //     dd($fitnessAfterMutation);
                        // }
                        //dd($fitnessAfterMutation[2]);
                        if ($fitnessAfterMutation[$j] == 1) {
                            Schedule::truncate();



                            $jadwal_kuliah = array(array());

                            $jadwal_kuliah = $genetik->GetIndividu($j);
                            $fitnessok[$j] = $genetik->GetIndividu($j);

                            $fitness = $fitnessok[$j];



                            for ($k = 0; $k < count($jadwal_kuliah); $k++) {

                                $kode_pengampu = intval($jadwal_kuliah[$k][0]);
                                $kode_jam = intval($jadwal_kuliah[$k][1]);
                                $kode_hari = intval($jadwal_kuliah[$k][2]);
                                $kode_ruang = intval($jadwal_kuliah[$k][3]);

                                //                                     $existingSchedule = DB::table('jadwalkuliah AS a')
                                //                                     ->select([
                                //                                         'e.nama AS hari',
                                //                                         DB::raw("CONCAT_WS('-', CONCAT('(', g.kode), CONCAT((SELECT kode 
                                //                                             FROM jam 
                                //                                             WHERE kode = (SELECT jm.kode 
                                //                                                 FROM jam jm 
                                //                                                 WHERE SUBSTRING(jm.range_jam, 1, 5) = SUBSTRING(g.range_jam, 1, 5)) + (c.sks - 1)),')')) AS sesi"),
                                //                                         DB::raw("CONCAT_WS('-', SUBSTRING(g.range_jam, 1, 5), 
                                //                                             (SELECT SUBSTRING(range_jam, 7, 5) 
                                //                                             FROM jam 
                                //                                             WHERE kode = (SELECT jm.kode 
                                //                                                 FROM jam jm 
                                //                                                 WHERE SUBSTRING(jm.range_jam, 1, 5) = SUBSTRING(g.range_jam, 1, 5)) + (c.sks - 1))) AS jam_kuliah"),
                                //                                         'c.nama AS nama_mk',
                                //                                         'c.sks AS sks',
                                //                                         'c.semester AS semester',
                                //                                         'b.kelas AS kelas',
                                //                                         'd.nama AS dosen',
                                //                                         'e.kode as kdhari',
                                //                                         'f.nama AS ruang',
                                //                                         'f.kode as kdruang',
                                //                                         'a.kode_jam as kdjam',
                                //                                         'd.kode as kddos',
                                //                                         'b.kode as pengampuId'


                                //                                     ])
                                //                                     ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
                                //                                     ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
                                //                                     ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
                                //                                     ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
                                //                                     ->leftJoin('ruang AS f', 'a.kode_ruang', '=', 'f.kode')
                                //                                     ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode')
                                //                                     ->orderBy('kelas')
                                //                                     ->orderBy('kdhari')
                                //                                     ->orderBy('kdjam')
                                //                                     ->where('a.kode_jam', $kode_jam)
                                //                                     ->where('a.kode_hari', $kode_hari)
                                //                                     ->where('a.kode_ruang', $kode_ruang)
                                //                                     ->get   ();
                                // dd($existingSchedule);


                                DB::table('jadwalkuliah')->insert([
                                    'kode_pengampu' => $kode_pengampu,
                                    'kode_jam' => $kode_jam,
                                    'kode_hari' => $kode_hari,
                                    'kode_ruang' => $kode_ruang,
                                ]);
                            }

                            //var_dump($jadwal_kuliah);
                            //exit();

                            $found = true;
                        }

                        if ($found) {
                            break;
                        }
                    }

                    if ($found) {
                        break;
                    }
                }
                echo "<pre>";
                print_r($fitness_akhir);
                exit(); //buat liat fitness setelah mutasi
                if (!$found) {
                    $data['msg'] = 'Tidak Ditemukan Solusi Optimal';
                }
            }
        }




        $data['page_name'] = 'penjadwalan';
        $data['page_title'] = 'Penjadwalan';

        // $jadwal = DB::table('jadwalkuliah')
        // ->select('jadwalkuliah.*', 'pengampu.kode_dosen', 'pengampu.kelas', 'matakuliah.sks')
        // ->leftJoin('pengampu', 'jadwalkuliah.kode_pengampu', '=', 'pengampu.kode')
        // ->leftJoin('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
        // ->get();
        $jadwal = DB::table('jadwalkuliah AS a')
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
                'e.kode as kdhari',
                'f.nama AS ruang',
                'f.kode as kdruang',
                'a.kode_jam as kdjam',
                'd.kode as kddos'


            ])
            ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
            ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
            ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
            ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
            ->leftJoin('ruang AS f', 'a.kode_ruang', '=', 'f.kode')
            ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode')
            ->orderBy('e.kode')
            ->orderBy('jam_kuliah')
            ->orderBy('kelas')
            ->get();

        $jumlahJadwal = count($jadwal);
        $bentrok = array();
        $jumlah_bentrok = 0;
        for ($i = 0; $i < $jumlahJadwal; $i++) {
            $bentrok[$i] = 0;
            $jam_a = intval($jadwal[$i]->kdjam);
            $hari_a = intval($jadwal[$i]->kdhari);
            $ruang_a = intval($jadwal[$i]->kdruang);
            $dosen_a = intval($jadwal[$i]->kddos);
            $kelas_a = $jadwal[$i]->kelas;
            $sks = $jadwal[$i]->sks;
            $isBentrok = false;
            //dd($jadwal[$i], $jadwal[$j]);

            for ($j = 0; $j < $jumlahJadwal; $j++) {
                $jam_b = intval($jadwal[$j]->kdjam);
                $hari_b = intval($jadwal[$j]->kdhari);
                $ruang_b = intval($jadwal[$j]->kdruang);
                $dosen_b = intval($jadwal[$j]->kddos);
                $kelas_b = $jadwal[$j]->kelas;
                // dd($kelas_b);
                if ($i == $j) {
                    continue;
                }

                // cek ruangan
                if (
                    $jam_a == $jam_b &&
                    $hari_a == $hari_b &&
                    $ruang_a == $ruang_b
                ) {
                    $bentrok[$i] = 1;
                    $jumlah_bentrok = $jumlah_bentrok + 1;
                }
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
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
                }
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
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
                }
                if ($sks >= 2) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $bentrok[$i] = 1;
                        $jumlah_bentrok = $jumlah_bentrok + 1;
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
                    }
                }


                if ($isBentrok) {
                    $bentrok[$i] = 1;
                    break;
                }
            }
            if ($bentrok[$i] == 1) {
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
                ];

                $tidakBentrok[] = $dataBentrok;
            }
        }

        // print_r($bentrok); exit();

        $data['bentrok'] = $bentrok;
        $data['tidakBentrok'] = $tidakBentrok;
        $data['bentrokdata'] = $bentrokdata;

        $data['rs_jadwal'] = Schedule::get();
        $kelasti = DB::table('kelas')
            ->where('jenis_kelas', '=', 'ti')
            ->get();
        $viewti = DB::table('jadwalkuliah')
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
                'jam.range_jam as jam',
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI1A' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI1A"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI1B' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI1B"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI1C' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI1C"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI2A' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI2A"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI2B' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI2B"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI2C' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI2C"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI3A' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI3A"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI3B' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI3B"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3TI3C' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3TI3C"),
            )

            ->groupBy('hari.nama', 'jam.kode', 'jam.range_jam')
            ->where('kelas.jenis_kelas', '=', 'ti')
            ->orderBy('hari.kode', 'asc')
            ->orderBy('jam.kode', 'asc')
            ->get();
        $kelasrpl = DB::table('kelas')
            ->where('jenis_kelas', '=', 'rpl')
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
                'jam.range_jam as jam',
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3RPL1A' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3RPL1A"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3RPL1B' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3RPL1B"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3RPL1C' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3RPL1C"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3RPL2A' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3RPL2A"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3RPL2B' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3RPL2B"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3RPL3' THEN CONCAT(matakuliah.nama, '\n', dosen.nama, '\n', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3RPL3"),
                DB::raw("MAX(CASE WHEN pengampu.kelas = 'D3RPL4' THEN CONCAT(matakuliah.nama, '\n ', dosen.nama, '\n ', ruang.nama, ', ', matakuliah.sks, ' SKS') ELSE NULL END) AS D3RPL4"),
            )

            ->groupBy('hari.nama', 'jam.kode', 'jam.range_jam')
            ->where('kelas.jenis_kelas', '=', 'rpl')
            ->orderBy('hari.kode', 'asc')
            ->orderBy('jam.kode', 'asc')
            ->get();






        return view('schedule.index', ['data' => $data, 'bentrok' => $bentrok, 'tidakBentrok' => $tidakBentrok, 'bentrokdata' => $bentrokdata, 'jadwal' => $jadwal, 'kelasti' => $kelasti, 'viewti' => $viewti, 'kelasrpl' => $kelasrpl, 'viewrpl' => $viewrpl]);
    }

    public function updateData($idPengampu, $setData)
    {

        return Schedule::where('kode_pengampu', $idPengampu)->update($setData);
    }
}
