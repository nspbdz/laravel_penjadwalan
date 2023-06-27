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
        $query = DB::table('jadwalkuliah')
            ->join('pengampu', 'pengampu.kode', '=', 'jadwalkuliah.kode_pengampu')
            ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
            ->join('hari', 'jadwalkuliah.kode_hari', '=', 'hari.kode')
            ->join('ruang', 'jadwalkuliah.kode_ruang', '=', 'ruang.kode')
            ->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
            ->join('jam', 'jadwalkuliah.kode_jam', '=', 'jam.kode')

            ->select(
                'dosen.nama AS nm',
                'hari.nama as hr',
                'dosen.nidn',
                'jadwalkuliah.*',
                'matakuliah.nama',
                'jam.range_jam',
                'matakuliah.sks',
                'matakuliah.semester',
                'pengampu.kelas',
                'ruang.nama as nama_ruang'
            )
            ->get();
        return view('schedule.index', ['query' => $query]);
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
        set_time_limit(1200);
        $data = array();

        //if(!empty($_POST)){
        //if (!empty(request()->post())) {

        //tempat keajaiban dimulai. SEMANGAAAAAATTTTTTT BANZAIIIIIIIIIIIII !

        // $jenis_semester = $this->input->post('semester_tipe');
        // $tahun_akademik = $this->input->post('tahun_akademik');
        // $jumlah_populasi = $this->input->post('jumlah_populasi');
        // $crossOver = $this->input->post('probabilitas_crossover');
        // $mutasi = $this->input->post('probabilitas_mutasi');
        // $jumlah_generasi = $this->input->post('jumlah_generasi');
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

                    ////$fitnessAfterMutation = $genetik->Mutasi();

                    for ($j = 0; $j < count($fitnessAfterMutation); $j++) {

                        //dd($fitnessAfterMutation);
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

        $jadwal = DB::table('jadwalkuliah')
            ->select('jadwalkuliah.*', 'pengampu.kode_dosen', 'pengampu.kelas', 'matakuliah.sks')
            ->leftJoin('pengampu', 'jadwalkuliah.kode_pengampu', '=', 'pengampu.kode')
            ->leftJoin('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
            ->get();

        $jumlahJadwal = count($jadwal);
        $bentrok = array();
        for ($i = 0; $i < $jumlahJadwal; $i++) {
            $bentrok[$i] = 0;
            $jam_a = intval($jadwal[$i]->kode_jam);
            $hari_a = intval($jadwal[$i]->kode_hari);
            $ruang_a = intval($jadwal[$i]->kode_ruang);
            $dosen_a = intval($jadwal[$i]->kode_dosen);
            $kelas_a = $jadwal[$i]->kelas;
            $sks = $jadwal[$i]->sks;

            for ($j = 0; $j < $jumlahJadwal; $j++) {
                $jam_b = intval($jadwal[$j]->kode_jam);
                $hari_b = intval($jadwal[$j]->kode_hari);
                $ruang_b = intval($jadwal[$j]->kode_ruang);
                $dosen_b = intval($jadwal[$j]->kode_dosen);
                $kelas_b = $jadwal[$j]->kelas;
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
                }
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                    }
                }
                if ($sks >= 3) {
                    if (
                        $jam_a + 2 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                    }
                }
                if ($sks >= 4) {
                    if (
                        $jam_a + 3 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                    }
                }
                if ($sks >= 5) {
                    if (
                        $jam_a + 4 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrok[$i] = 1;
                    }
                }

                //cek kelas
                if (
                    $jam_a == $jam_b &&
                    $hari_a == $hari_b &&
                    $kelas_a == $kelas_b
                ) {
                    $bentrok[$i] = 1;
                }
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                    }
                }
                if ($sks >= 3) {
                    if (
                        $jam_a + 2 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                    }
                }
                if ($sks >= 4) {
                    if (
                        $jam_a + 3 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
                    }
                }
                if ($sks >= 5) {
                    if (
                        $jam_a + 4 == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrok[$i] = 1;
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
                }
                if ($sks >= 2) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        ($jam_a + 1) == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $bentrok[$i] = 1;
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
                    }
                }
            }
        }

        $data['bentrok'] = $bentrok; // kalo misal ada kelas / ruangan / dosen bentrok, nilainya di array ini jadi 1



        if (in_array(1, $bentrok)) {
            $datas = array();
            $found = false;

            for ($i = 0; $i < $jumlah_generasi; $i++) {

                $fitness = $genetik->HitungFitness();


                $genetik->Seleksi($fitness);

                $genetik->StartCrossOver();

                $fitness_akhir[$i] = $fitnessAfterMutation = $genetik->Mutasi();

                ////$fitnessAfterMutation = $genetik->Mutasi();

                for ($j = 0; $j < count($fitnessAfterMutation); $j++) {

                    //dd($fitnessAfterMutation);
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
                $datas['msg'] = 'Tidak Ditemukan Solusi Optimal';
            }

            $datas['page_name'] = 'penjadwalan';
            $datas['page_title'] = 'Penjadwalan';

            $jadwal = DB::table('jadwalkuliah')
                ->select('jadwalkuliah.*', 'pengampu.kode_dosen', 'pengampu.kelas', 'matakuliah.sks')
                ->leftJoin('pengampu', 'jadwalkuliah.kode_pengampu', '=', 'pengampu.kode')
                ->leftJoin('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
                ->get();

            $jumlahJadwal = count($jadwal);
            $bentrooks = array();
            for ($i = 0; $i < $jumlahJadwal; $i++) {
                $bentrooks[$i] = 0;
                $jam_a = intval($jadwal[$i]->kode_jam);
                $hari_a = intval($jadwal[$i]->kode_hari);
                $ruang_a = intval($jadwal[$i]->kode_ruang);
                $dosen_a = intval($jadwal[$i]->kode_dosen);
                $kelas_a = $jadwal[$i]->kelas;
                $sks = $jadwal[$i]->sks;

                for ($j = 0; $j < $jumlahJadwal; $j++) {
                    $jam_b = intval($jadwal[$j]->kode_jam);
                    $hari_b = intval($jadwal[$j]->kode_hari);
                    $ruang_b = intval($jadwal[$j]->kode_ruang);
                    $dosen_b = intval($jadwal[$j]->kode_dosen);
                    $kelas_b = $jadwal[$j]->kelas;
                    if ($i == $j) {
                        continue;
                    }

                    // cek ruangan
                    if (
                        $jam_a == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $bentrooks[$i] = 1;
                    }
                    if ($sks >= 2) {
                        if (
                            $jam_a + 1 == $jam_b &&
                            $hari_a == $hari_b &&
                            $ruang_a == $ruang_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 3) {
                        if (
                            $jam_a + 2 == $jam_b &&
                            $hari_a == $hari_b &&
                            $ruang_a == $ruang_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 4) {
                        if (
                            $jam_a + 3 == $jam_b &&
                            $hari_a == $hari_b &&
                            $ruang_a == $ruang_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 5) {
                        if (
                            $jam_a + 4 == $jam_b &&
                            $hari_a == $hari_b &&
                            $ruang_a == $ruang_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }

                    //cek kelas
                    if (
                        $jam_a == $jam_b &&
                        $hari_a == $hari_b &&
                        $kelas_a == $kelas_b
                    ) {
                        $bentrooks[$i] = 1;
                    }
                    if ($sks >= 2) {
                        if (
                            $jam_a + 1 == $jam_b &&
                            $hari_a == $hari_b &&
                            $kelas_a == $kelas_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 3) {
                        if (
                            $jam_a + 2 == $jam_b &&
                            $hari_a == $hari_b &&
                            $kelas_a == $kelas_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 4) {
                        if (
                            $jam_a + 3 == $jam_b &&
                            $hari_a == $hari_b &&
                            $kelas_a == $kelas_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 5) {
                        if (
                            $jam_a + 4 == $jam_b &&
                            $hari_a == $hari_b &&
                            $kelas_a == $kelas_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }

                    //cek dosen
                    if (
                        //ketika jam, hari, dan dosen sama
                        $jam_a == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $bentrooks[$i] = 1;
                    }
                    if ($sks >= 2) {
                        if (
                            //ketika jam, hari, dan dosen sama
                            ($jam_a + 1) == $jam_b &&
                            $hari_a == $hari_b &&
                            $dosen_a == $dosen_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 3) {
                        if (
                            //ketika jam, hari, dan dosen sama
                            ($jam_a + 2) == $jam_b &&
                            $hari_a == $hari_b &&
                            $dosen_a == $dosen_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 4) {
                        if (
                            //ketika jam, hari, dan dosen sama
                            ($jam_a + 3) == $jam_b &&
                            $hari_a == $hari_b &&
                            $dosen_a == $dosen_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                    if ($sks >= 5) {
                        if (
                            //ketika jam, hari, dan dosen sama
                            ($jam_a + 4) == $jam_b &&
                            $hari_a == $hari_b &&
                            $dosen_a == $dosen_b
                        ) {
                            $bentrooks[$i] = 1;
                        }
                    }
                }
            }

            $datas['bentrok'] = $bentrooks; // kalo misal ada kelas / ruangan / dosen bentrok, nilainya di array ini jadi 1
            dd($bentrooks);

        } else {
            echo "Array tidak memiliki nilai 1";
        }


        $data['rs_jadwal'] = Schedule::get();
        $query = DB::table('jadwalkuliah')
            ->join('pengampu', 'pengampu.kode', '=', 'jadwalkuliah.kode_pengampu')
            ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
            ->join('hari', 'jadwalkuliah.kode_hari', '=', 'hari.kode')
            ->join('ruang', 'jadwalkuliah.kode_ruang', '=', 'ruang.kode')
            ->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
            ->join('jam', 'jadwalkuliah.kode_jam', '=', 'jam.kode')

            ->select(
                'dosen.nama AS nm',
                'hari.nama as hr',
                'dosen.nidn',
                'jadwalkuliah.*',
                'matakuliah.nama',
                'jam.range_jam',
                'matakuliah.sks',
                'matakuliah.semester',
                'pengampu.kelas',
                'ruang.nama as nama_ruang'
            )
            ->get();
        return view('schedule.index', ['data' => $data, 'query' => $query, 'bentrok' => $bentrok]);
    }



    function excel_report()
    {
        $query = $this->m_jadwalkuliah->get();
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
