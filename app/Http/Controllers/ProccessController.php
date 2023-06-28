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


    // function __construct()
    // {
    //     parent::__construct();
    // 	$this->load->model(array('m_dosen',
    // 							 'm_matakuliah',
    // 							 'm_ruang',
    // 							 'm_jam',
    // 							 'm_hari',
    // 							 'm_pengampu',
    // 							 'm_waktu_tidak_bersedia',
    // 							 'm_jadwalkuliah'));
    // 	include_once("genetik.php");
    // 	define('IS_TEST','FALSE');
    // }






    // $jumlah_generasi = config('config.jumlah_generasi');
    // // dd($jumlah_generasi);
    // $genetik = new BisnisController(); //kode jam dhuhur


    // // dd($genetik);
    public function masuk()
    {
        $tidakBentrok = [];
        $bentrokdata = [];
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
            ->orderBy('kdhari')
            ->orderBy('kdjam')
            ->orderBy('kelas')
            ->get();

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




        $data['bentrok'] = $bentrok; // kalo misal ada kelas / ruangan / dosen bentrok, nilainya di array ini jadi 1 
        //dd($bentrok);
        $data['rs_jadwal'] = Schedule::get();
        //$query = DB::table('jadwalkuliah AS a')
        //  ->select([
        //      'e.nama AS hr',
        //      'a.kode_jam AS kode_jam',
        //      'g.range_jam',
        //      'b.kelas as kelas',
        //      DB::raw("MAX(CASE WHEN b.kelas  THEN CONCAT(c.nama, '\n', ' - ', d.nama) ELSE NULL END) AS kelas_data"),

        //  ])
        //  ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
        //  ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
        //  ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
        //  ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
        //  ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode')
        //  ->groupBy('hr', 'kode_jam', 'range_jam','kelas','kelas_data')
        //  ->orderBy('hr', 'DESC')
        //  ->get();
        $query = DB::table('jadwalkuliah AS a')
            ->select([
                'e.nama AS hr',
                'g.kode as kdjam',
                'g.range_jam',
                'b.kelas as kelas',
                DB::raw("GROUP_CONCAT(DISTINCT CONCAT(c.nama, '\n', ' - ', d.nama) ORDER BY c.nama SEPARATOR '\n') AS kelas_data")
            ])
            ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
            ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
            ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
            ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
            ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode')
            ->groupBy('hr', 'kdjam', 'range_jam', 'kelas')
            ->orderBy('hr', 'desc')
            // ->orderBy('kode_jam')
            ->get();
        // $query = DB::table('jadwalkuliah AS a')
        // ->select([
        //     'e.nama AS hari',
        //     DB::raw("CONCAT_WS('-', CONCAT('(', g.kode), CONCAT((SELECT kode 
        //         FROM jam 
        //         WHERE kode = (SELECT jm.kode 
        //             FROM jam jm 
        //             WHERE SUBSTRING(jm.range_jam, 1, 5) = SUBSTRING(g.range_jam, 1, 5)) + (c.sks - 1)),')')) AS sesi"),
        //     DB::raw("CONCAT_WS('-', SUBSTRING(g.range_jam, 1, 5), 
        //         (SELECT SUBSTRING(range_jam, 7, 5) 
        //         FROM jam 
        //         WHERE kode = (SELECT jm.kode 
        //             FROM jam jm 
        //             WHERE SUBSTRING(jm.range_jam, 1, 5) = SUBSTRING(g.range_jam, 1, 5)) + (c.sks - 1))) AS jam_kuliah"),
        //     'c.nama AS nama_mk',
        //     'c.sks AS sks',
        //     'c.semester AS semester',
        //     'b.kelas AS kelas',
        //     'd.nama AS dosen',
        //     'f.nama AS ruang'
        // ])
        // ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
        // ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
        // ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
        // ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
        // ->leftJoin('ruang AS f', 'a.kode_ruang', '=', 'f.kode')
        // ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode')
        // ->orderBy('e.kode')
        // ->orderBy('jam_kuliah')
        // ->orderBy('kelas')
        // ->get();

        return view(
            'schedule.index',
            [
                'data' => $data,
                'query' => $query,
                'bentrok' => $bentrok,
                'tidakBentrok' => $tidakBentrok,
                'bentrokdata' => $bentrokdata,
                'jadwal' => $jadwal
            ]
        );
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

    public function index(Request $request)
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


                                DB::table('jadwalkuliah')->insertOrIgnore([
                                    'kode_pengampu' => $kode_pengampu,
                                    'kode_jam' => $kode_jam,
                                    'kode_hari' => $kode_hari,
                                    'kode_ruang' => $kode_ruang,
                                ]);
                                //$this->db->query("INSERT INTO jadwalkuliah(kode_pengampu,kode_jam,kode_hari,kode_ruang) ".
                                //				 "VALUES($kode_pengampu,$kode_jam,$kode_hari,$kode_ruang)");


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
                //echo "<pre>";print_r($fitness_akhir); exit(); //buat liat fitness setelah mutasi
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
                        ($jam_a + 1) == $jam_b &&
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
                        ($jam_a + 2) == $jam_b &&
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
                        ($jam_a + 3) == $jam_b &&
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
                        ($jam_a + 4) == $jam_b &&
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

        //         $fitness_cek = array();
        //         $fitness_jadwal = floatval(1/(1+$jumlah_bentrok));
        //         for($indv = 0; $indv < $jumlah_populasi; $indv++){
        //             $fitness_cek[$indv] = $fitness_jadwal;
        //         }

        //         $jumlah = 0;
        //         $rank = array();
        //         for ($i = 0; $i < $jumlah_populasi; $i++)
        //         {
        //           //proses ranking berdasarkan nilai fitness
        //             $rank[$i] = 1;
        //             for ($j = 0; $j < $jumlah_populasi; $j++)
        //             {
        //               //ketika nilai fitness jadwal sekarang lebih dari nilai fitness jadwal yang lain,
        //               //ranking + 1;
        //               //if (i == j) continue;

        //                 $fitnessA = floatval($fitness_cek[$i]);
        //                 $fitnessB = floatval($fitness_cek[$j]);

        //                dd($fitnessA, $fitnessB);

        //                 if ( $fitnessA > $fitnessB)
        //                 {
        //                     $rank[$i] += 1;

        //                 }
        //             }

        //             $jumlah += $rank[$i];

        //         }
        //         $induk = array();
        //         $jumlah_rank = count($rank);
        //         for ($i = 0; $i < $jumlah_populasi; $i++)
        //         {
        //             $target = mt_rand(0, $jumlah - 1);

        //             $cek    = 0;
        //             for ($j = 0; $j < $jumlah_rank; $j++) {
        //                 $cek += $rank[$j];
        //                 if (intval($cek) >= intval($target)) {
        //                     $induk[$i] = $j;
        //                     break;
        //                 }
        //             }
        //         }
        //         $Individu_baru = array(array(array()));
        //         for($i=0; $i < $jumlah_populasi; $i+2){
        //             $b=0;

        //             $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        //             if (floatval($cr) < floatval($crossOver)) {
        //                 $a= mt_rand(0, $jumlah_bentrok - 2);
        //                 // while($a <= $c){
        //                 //     $a = mt_rand(0, $jumlah_pengampu - 2);

        //                 // }
        //                 while($b <= $a){

        //                     $b = mt_rand(0, $jumlah_bentrok - 1);
        //                 }

        //                 //var_dump($this->induk);
        //                 //var_dump($this->induk);
        //                 //penentuan jadwal baru dari awal sampai titik pertama

        //                 for ($j = 0; $j < $a; $j++) {
        //                     for ($k = 0; $k < 4; $k++) {
        //                         $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
        //                         $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
        //                     }
        //                 }
        //                 //var_dump($this->induk);


        //                 //Penentuan jadwal baru dari titik pertama sampai titik kedua
        //                 for ($j = $a; $j < $b; $j++) {
        //                     for ($k = 0; $k < 4; $k++) {
        //                         $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i + 1]][$j][$k];
        //                         $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
        //                     }
        //                 }

        //                 //penentuan jadwal baru dari titik kedua sampai akhir
        //                 for ($j = $b; $j < $jumlah_bentrok; $j++) {
        //                     for ($k = 0; $k < 4; $k++) {
        //                         $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
        //                         $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
        //                     }
        //                 }
        //             } else { //Ketika nilai random lebih dari nilai probabilitas pertukaran, maka jadwal baru sama dengan jadwal terpilih
        //                 for ($j = 0; $j < $jumlah_bentrok; $j++) {
        //                     for ($k = 0; $k < 4; $k++) {
        //                         $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
        //                         $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
        //                     }
        //                 }
        //             }
        // dd($individu_baru);
        //         }
        //dd($fitness_cek);
        // kalo misal ada kelas / ruangan / dosen bentrok, nilainya di array ini jadi 1 
        //$rs_jadwal = Schedule::get();
        //dd($bentrokdata,$tidakBentrok, $bentrok);
        //dd($sks, $jam_a, $jam_b,$hari_a, $hari_b, $dosen_a, $dosen_b, $kelas_a,$kelas_b, $ruang_a, $ruang_b);
        //       $cek = count($bentrok[1]);
        //    dd($cek);
        $data['rs_jadwal'] = Schedule::get();
        // print_r($data['rs_jadwal']->result()); exit();
        // dd($rs_jadwal);

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
                'f.nama AS ruang'
            ])
            ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
            ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
            ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
            ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
            ->leftJoin('ruang AS f', 'a.kode_ruang', '=', 'f.kode')
            ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode')
            ->orderBy('e.kode')
            ->orderBy('jam_kuliah')
            ->get();
        return view('schedule.index', ['data' => $data, 'query' => $query, 'bentrok' => $bentrok, 'tidakBentrok' => $tidakBentrok, 'bentrokdata' => $bentrokdata, 'jadwal' => $jadwal]);
    }



    function excel_report()
    {
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
                'f.nama AS ruang'
            ])
            ->leftJoin('pengampu AS b', 'a.kode_pengampu', '=', 'b.kode')
            ->leftJoin('matakuliah AS c', 'b.kode_mk', '=', 'c.kode')
            ->leftJoin('dosen AS d', 'b.kode_dosen', '=', 'd.kode')
            ->leftJoin('hari AS e', 'a.kode_hari', '=', 'e.kode')
            ->leftJoin('ruang AS f', 'a.kode_ruang', '=', 'f.kode')
            ->leftJoin('jam AS g', 'a.kode_jam', '=', 'g.kode')
            ->orderBy('e.kode')
            ->orderBy('jam_kuliah')
            ->get();
        if (!$query)
            return false;

        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);
        // Field names in the first row
        $fields = $query->list_fields();
        $col = 0;
        foreach ($fields as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach ($query->result() as $data) {
            $col = 0;
            foreach ($fields as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Hasil Penjadwalan_' . date('dMy') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
        return view('proccess.index');
    }
}
