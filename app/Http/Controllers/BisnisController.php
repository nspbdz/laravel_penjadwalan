<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hour;
use App\Models\Day;
use App\Models\Wb;
use Illuminate\Support\Facades\DB;

class BisnisController extends Controller
{
    private $PRAKTIKUM = 'PRAKTIKUM';
    private $TEORI = 'TEORI';
    private $LABORATORIUM = 'LABORATORIUM';
    private $PROYEK = 'PROYEK';
    private $BAHASA = 'BAHASA';
    private $jenis_semester;
    private $tahun_akademik;
    private $populasi;
    private $crossOver;
    private $mutasi;
    private $pengampu = array();
    private $individu = array(array(array()));
    private $sks = array();
    private $dosen = array();
    private $jam = array();
    private $hari = array();
    private $idosen = array();
    //waktu keinginan dosen
    private $waktu_dosen = array(array());
    private $jenis_mk = array();
    //teori, praktek, proyek/TA, atau bahasa inggris
    private $ruangLaboratorium = array();
    private $ruangReguler = array();
    private $ruangProyek = array();
    private $ruangBahasa = array();
    private $induk = array();
    //jumat
    private $kode_jumat;
    private $range_jumat = array();
    private $kode_dhuhur;
    private $wb;

    function __construct($jenis_semester, $tahun_akademik, $populasi, $crossOver, $mutasi, $kode_jumat, $range_jumat, $kode_dhuhur)
    {
        $this->jenis_semester = $jenis_semester;
        $this->tahun_akademik = $tahun_akademik;
        $this->populasi       = intval($populasi);
        $this->crossOver      = $crossOver;
        $this->mutasi         = $mutasi;
        $this->kode_jumat     = intval($kode_jumat);
        $this->range_jumat    = explode('-', $range_jumat);
        $this->kode_dhuhur    = intval($kode_dhuhur);
    }

    public function ambildata()
    {
        $rs_data = DB::table('pengampu AS a')
            ->select('a.kode', 'b.sks', 'a.kode_dosen', 'b.jenis', 'b.semester', 'a.tahun_akademik')
            ->leftJoin('matakuliah AS b', 'a.kode_mk', '=', 'b.kode')
            ->whereRaw('b.semester % 2 = ?', [$this->jenis_semester])
            ->where('a.tahun_akademik', '=', $this->tahun_akademik)
            ->get();

        $i = 0;
        foreach ($rs_data as $data) {
            $this->pengampu[$i]    = intval($data->kode);
            $this->sks[$i]         = intval($data->sks);
            $this->dosen[$i]       = intval($data->kode_dosen);
            $this->jenis_mk[$i]    = $data->jenis;
            $i++;
        }

        //Fill Array of Jam Variables
        $rs_jam = Hour::select('kode')->get();
        $i      = 0;
        foreach ($rs_jam as $data) {
            $this->jam[$i] = intval($data->kode);
            $i++;
        }

        //Fill Array of Hari Variables
        $rs_hari = Day::select('kode')->get();
        $i       = 0;
        foreach ($rs_hari as $data) {
            $this->hari[$i] = intval($data->kode);
            $i++;
        }

        //ruang teori
        $rs_RuangTeori = Room::select('kode')->where('jenis', '=', $this->TEORI)->get();

        $i = 0;
        foreach ($rs_RuangTeori as $data) {
            $this->ruangReguler[$i] = intval($data->kode);
            $i++;
        }

        //ruang praktek/lab
        $rs_Ruanglaboratorium = Room::select('kode')->where('jenis', '=', $this->LABORATORIUM)->get();
        $i                    = 0;
        foreach ($rs_Ruanglaboratorium as $data) {
            $this->ruangLaboratorium[$i] = intval($data->kode);
            $i++;
        }

        //ruang proyek /TA
        $rs_Ruangproyek = Room::select('kode')->where('jenis', '=', $this->PROYEK)->get();
        $i                    = 0;
        foreach ($rs_Ruangproyek as $data) {
            $this->ruangProyek[$i] = intval($data->kode);
            $i++;
        }

        //ruang Bahasa Inggris
        $rs_Ruangbahasa = Room::select('kode')->where('jenis', '=', $this->BAHASA)->get();
        $i                    = 0;
        foreach ($rs_Ruangbahasa as $data) {
            $this->ruangBahasa[$i] = intval($data->kode);
            $i++;
        }

        $rs_WaktuDosen = DB::table('waktu_tidak_bersedia')
            ->select('kode_dosen', DB::raw("CONCAT_WS(':', kode_hari, kode_jam) AS kode_hari_jam"))
            ->get();

        $i             = 0;
        foreach ($rs_WaktuDosen as $data) {
            $this->idosen[$i]         = intval($data->kode_dosen);
            $this->waktu_dosen[$i][0] = intval($data->kode_dosen);
            $this->waktu_dosen[$i][1] = $data->kode_hari_jam;
            $i++;
        }
    }

    public function inisialisasi()
    {
        $jumlah_pengampu = count($this->pengampu);
        $jumlah_jam = count($this->jam);
        $jumlah_hari = count($this->hari);
        $jumlah_ruang_reguler = count($this->ruangReguler);
        $jumlah_ruang_lab = count($this->ruangLaboratorium);
        $jumlah_ruang_proyek = count($this->ruangProyek);
        $jumlah_ruang_bahasa = count($this->ruangBahasa);
        $this->populasi = 10;

        for ($i = 0; $i < $this->populasi; $i++) {

            for ($j = 0; $j < $jumlah_pengampu; $j++) {

                $sks = $this->sks[$j];

                if (isset($this->wb[$this->pengampu[$i]])) {
                    $this->individu[$i][$j][0] = $j;
                    $this->individu[$i][$j][1] = $this->wb[$this->pengampu]['time'] - 1;
                    $this->individu[$i][$j][2] = $this->wb[$this->pengampu]['day'] - 1;
                    $this->individu[$i][$j][3] = $this->wb[$this->pengampu]['ruang'] - 1;
                    continue;
                }

                $this->individu[$i][$j][0] = $j;

                // Penentuan jam secara acak ketika 1 sks
                if ($sks == 1) {
                    $this->individu[$i][$j][1] = mt_rand(0,  $jumlah_jam - 1);
                }

                // Penentuan jam secara acak ketika 2 sks
                if ($sks == 2) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlah_jam - 1) - 1);
                }

                // Penentuan jam secara acak ketika 3 sks
                if ($sks == 3) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlah_jam - 1) - 2);
                }

                // Penentuan jam secara acak ketika 4 sks
                if ($sks == 4) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlah_jam - 1) - 3);
                }

                // Penentuan jam secara acak ketika 5 sks
                if ($sks == 5) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlah_jam - 1) - 4);
                }

                $this->individu[$i][$j][2] = mt_rand(0, $jumlah_hari - 1); // Penentuan hari secara acak

                if ($this->jenis_mk[$j] === $this->TEORI) {
                    $this->individu[$i][$j][3] = intval($this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)]);
                } elseif ($this->jenis_mk[$j] === $this->PRAKTIKUM) {
                    $this->individu[$i][$j][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);
                } elseif ($this->jenis_mk[$j] === $this->PROYEK) {
                    $this->individu[$i][$j][3] = intval($this->ruangProyek[mt_rand(0, $jumlah_ruang_proyek - 1)]);
                } else {
                    $this->individu[$i][$j][3] = intval($this->ruangBahasa[mt_rand(0, $jumlah_ruang_bahasa - 1)]);
                }
            }
        }
    }

    public function setWb()
    {
        $resultWb = Wb::all();
        foreach ($resultWb as $row) {
            $this->wb[$row->kode_pengampu]['day'] = $row->kode_hari;
            $this->wb[$row->kode_pengampu]['time'] = $row->kode_jam;
            $this->wb[$row->kode_pengampu]['ruang'] = $row->kode_ruang;
        }
    }

    private function cekfitness($indv)
    {
        $penalty = 0;

        $hari_jumat = intval($this->kode_jumat);
        $jumat_0 = intval($this->range_jumat[0]);
        $jumat_1 = intval($this->range_jumat[1]);
        $jumat_2 = intval($this->range_jumat[2]);

        $jumlah_pengampu = count($this->pengampu);

        for ($i = 0; $i < $jumlah_pengampu; $i++) {

            $sks = intval($this->sks[$i]);

            $jam_a = intval($this->individu[$indv][$i][1]);
            $hari_a = intval($this->individu[$indv][$i][2]);
            $ruang_a = intval($this->individu[$indv][$i][3]);
            $dosen_a = intval($this->dosen[$i]);


            for ($j = 0; $j < $jumlah_pengampu; $j++) {

                $jam_b = intval($this->individu[$indv][$j][1]);
                $hari_b = intval($this->individu[$indv][$j][2]);
                $ruang_b = intval($this->individu[$indv][$j][3]);
                $dosen_b = intval($this->dosen[$j]);


                //1.bentrok ruang dan waktu dan 3.bentrok dosen

                //ketika pemasaran matakuliah sama, maka langsung ke perulangan berikutnya
                if ($i == $j)
                    continue;

                //#region Bentrok Ruang dan Waktu
                //Ketika jam,hari dan ruangnya sama, maka penalty + satu
                if (
                    $jam_a == $jam_b &&
                    $hari_a == $hari_b &&
                    $ruang_a == $ruang_b
                ) {
                    $penalty += 1;
                }

                //Ketika sks  = 2,
                //hari dan ruang sama, dan
                //jam kedua sama dengan jam pertama matakuliah yang lain, maka penalty + 1
                if ($sks >= 2) {
                    if (
                        $jam_a + 1 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $penalty += 1;
                    }
                }


                //Ketika sks  = 3,
                //hari dan ruang sama dan
                //jam ketiga sama dengan jam pertama matakuliah yang lain, maka penalty + 1
                if ($sks >= 3) {
                    if (
                        $jam_a + 2 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $penalty += 1;
                    }
                }

                //Ketika sks  = 4,
                //hari dan ruang sama dan
                //jam ketiga sama dengan jam pertama matakuliah yang lain, maka penalty + 1
                if ($sks >= 4) {
                    if (
                        $jam_a + 3 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $penalty += 1;
                    }
                }


                //Ketika sks  = 5,
                //hari dan ruang sama dan
                //jam ketiga sama dengan jam pertama matakuliah yang lain, maka penalty + 1
                if ($sks >= 5) {
                    if (
                        $jam_a + 4 == $jam_b &&
                        $hari_a == $hari_b &&
                        $ruang_a == $ruang_b
                    ) {
                        $penalty += 1;
                    }
                }

                //______________________BENTROK DOSEN
                if (
                    //ketika jam, hari, dan dosen sama
                    $jam_a == $jam_b &&
                    $hari_a == $hari_b &&
                    $dosen_a == $dosen_b
                ) {
                    $penalty += 1;
                }



                if ($sks >= 2) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        ($jam_a + 1) == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $penalty += 1;
                    }
                }

                if ($sks >= 3) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        ($jam_a + 2) == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $penalty += 1;
                    }
                }

                if ($sks >= 4) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        ($jam_a + 3) == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $penalty += 1;
                    }
                }

                if ($sks >= 5) {
                    if (
                        //ketika jam, hari, dan dosen sama
                        ($jam_a + 4) == $jam_b &&
                        $hari_a == $hari_b &&
                        $dosen_a == $dosen_b
                    ) {
                        $penalty += 1;
                    }
                }
            }

            //
            // #region Bentrok sholat Jumat
            if (($hari_a  + 1) == $hari_jumat) //2.bentrok sholat jumat
            {

                if ($sks == 1) {
                    if (

                        ($jam_a == ($jumat_0 - 1)) ||
                        ($jam_a == ($jumat_1 - 1)) ||
                        ($jam_a == ($jumat_2 - 1))

                    ) {

                        $penalty += 1;
                    }
                }


                if ($sks == 2) {
                    if (
                        ($jam_a == ($jumat_0 - 2)) ||
                        ($jam_a == ($jumat_0 - 1)) ||
                        ($jam_a == ($jumat_1 - 1)) ||
                        ($jam_a == ($jumat_2 - 1))
                    ) {

                        $penalty += 1;
                    }
                }

                if ($sks == 3) {
                    if (
                        ($jam_a == ($jumat_0 - 3)) ||
                        ($jam_a == ($jumat_0 - 2)) ||
                        ($jam_a == ($jumat_0 - 1)) ||
                        ($jam_a == ($jumat_1 - 1)) ||
                        ($jam_a == ($jumat_2 - 1))
                    ) {
                        $penalty += 1;
                    }
                }

                if ($sks == 4) {
                    if (
                        ($jam_a == ($jumat_0 - 4)) ||
                        ($jam_a == ($jumat_0 - 3)) ||
                        ($jam_a == ($jumat_0 - 2)) ||
                        ($jam_a == ($jumat_0 - 1)) ||
                        ($jam_a == ($jumat_1 - 1)) ||
                        ($jam_a == ($jumat_2 - 1))
                    ) {
                        $penalty += 1;
                    }
                }

                if ($sks == 5) {
                    if (
                        ($jam_a == ($jumat_0 - 5)) ||
                        ($jam_a == ($jumat_0 - 4)) ||
                        ($jam_a == ($jumat_0 - 3)) ||
                        ($jam_a == ($jumat_0 - 2)) ||
                        ($jam_a == ($jumat_0 - 1)) ||
                        ($jam_a == ($jumat_1 - 1)) ||
                        ($jam_a == ($jumat_2 - 1))
                    ) {
                        $penalty += 1;
                    }
                }
            }
            //#endregion


            //#region Bentrok dengan Waktu Keinginan Dosen
            //Boolean penaltyForKeinginanDosen = false;

            $jumlah_waktu_tidak_bersedia = count($this->idosen);

            for ($j = 0; $j < $jumlah_waktu_tidak_bersedia; $j++) {
                if ($dosen_a == $this->idosen[$j]) {
                    $hari_jam = array();
                    $hari_jam = explode(':', $this->waktu_dosen[$j][1]);

                    if (isset($hari_jam[1])) {
                        if (
                            $this->jam[$jam_a] == $hari_jam[1] &&
                            $this->hari[$hari_a] == $hari_jam[0]
                        ) {
                            $penalty += 1;
                        }
                    }
                }
            }




            //#endregion

            //#region Bentrok waktu dhuhur
            if ($jam_a == ($this->kode_dhuhur - 1)) {
                $penalty += 1;
            }
        }

        $fitness = floatval(1 / (1 + $penalty));

        return $fitness;
    }

    public function HitungFitness()
    {
        //hard constraint
        //1.bentrok ruang dan waktu
        //2.bentrok sholat jumat
        //3.bentrok dosen
        //4.bentrok keinginan waktu dosen
        //5.bentrok waktu dhuhur
        //6.praktikum harus pada ruang lab telah ditetapkan dari awal perandoman
        //    bahwa jika praktikum harus ada pada LAB, mata kuliah teori harus
        //    pada kelas reguler, mata kuliah ta/proyek harus di ruang it terapan, dan
        //    mata kuliah b. inggris harus di lab b.inggris

        //soft constraint //TODO
        $fitness = array();

        for ($indv = 0; $indv < $this->populasi; $indv++) {
            $fitness[$indv] = $this->CekFitness($indv);
        }

        return $fitness;
    }
    public function Seleksi($fitness)
    {
        $jumlah = 0;
        $rank   = array();



        for ($i = 0; $i < $this->populasi; $i++) {
            //proses ranking berdasarkan nilai fitness
            $rank[$i] = 1;
            for ($j = 0; $j < $this->populasi; $j++) {
                //ketika nilai fitness jadwal sekarang lebih dari nilai fitness jadwal yang lain,
                //ranking + 1;
                //if (i == j) continue;

                $fitnessA = floatval($fitness[$i]);
                $fitnessB = floatval($fitness[$j]);

                $a = $fitnessA = floatval($fitness[$i]);
                $b = $fitnessB = floatval($fitness[$j]);

                if ($fitnessA > $fitnessB) {
                    $rank[$i] += 1;
                }
            }

            $jumlah += $rank[$i];
        }
        $jumlah_rank = count($rank);
        for ($i = 0; $i < $this->populasi; $i++) {
            $target = mt_rand(0, $jumlah - 1);

            $cek    = 0;
            for ($j = 0; $j < $jumlah_rank; $j++) {
                $cek += $rank[$j];
                if (intval($cek) >= intval($target)) {
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }

    //#endregion
    #endregion
    public function StartCrossOver()
    {
        $individu_baru = array(array(array()));
        $jumlah_pengampu = count($this->pengampu);

        for ($i = 0; $i < $this->populasi; $i += 2) //perulangan untuk jadwal yang terpilih
        {
            $b = 0;
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

            //One point crossover
            if (floatval($cr) < floatval($this->crossOver)) {
                $a = mt_rand(0, $jumlah_pengampu - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, $jumlah_pengampu - 1);
                }
                //var_dump($this->induk);
                //var_dump($this->induk);
                //penentuan jadwal baru dari awal sampai titik pertama
                for ($j = 0; $j < $a; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
                //var_dump($this->induk);


                //Penentuan jadwal baru dari titik pertama sampai titik kedua
                for ($j = $a; $j < $b; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i + 1]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                    }
                }

                //penentuan jadwal baru dari titik kedua sampai akhir
                for ($j = $b; $j < $jumlah_pengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else { //Ketika nilai random lebih dari nilai probabilitas pertukaran, maka jadwal baru sama dengan jadwal terpilih
                for ($j = 0; $j < $jumlah_pengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }

        $jumlah_pengampu = count($this->pengampu);

        for ($i = 0; $i < $this->populasi; $i += 2) {
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                for ($k = 0; $k < 4; $k++) {
                    $this->individu[$i][$j][$k] = $individu_baru[$i][$j][$k];
                    $this->individu[$i + 1][$j][$k] = $individu_baru[$i + 1][$j][$k];
                }
            }
        }
    }
    public function Mutasi()
    {
        $fitness = array();
        //proses perandoman atau penggantian komponen untuk tiap jadwal baru
        $r       = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

        $jumlah_pengampu = count($this->pengampu);
        $jumlah_jam = count($this->jam);
        $jumlah_hari = count($this->hari);
        $jumlah_ruang_reguler = count($this->ruangReguler);
        $jumlah_ruang_lab = count($this->ruangLaboratorium);
        $jumlah_ruang_proyek = count($this->ruangProyek);
        $jumlah_ruang_bahasa = count($this->ruangBahasa);

        for ($i = 0; $i < $this->populasi; $i++) {
            //Ketika nilai random kurang dari nilai probalitas Mutasi,
            //maka terjadi penggantian komponen

            if ($r < $this->mutasi) {
                //Penentuan pada matakuliah dan kelas yang mana yang akan dirandomkan atau diganti
                $krom = mt_rand(0, $jumlah_pengampu - 1);

                if (isset($this->wb[$krom])) {
                    $this->individu[$i][$krom][0] = $krom;
                    $this->individu[$i][$krom][1] = $this->wb[$this->pengampu]['time'] - 1;
                    $this->individu[$i][$krom][2] = $this->wb[$this->pengampu]['day'] - 1;
                    $this->individu[$i][$krom][3] = $this->wb[$this->pengampu]['ruang'] - 1;
                    continue;
                }

                $j = intval($this->sks[$krom]);

                switch ($j) {
                    case 1:
                        $this->individu[$i][$krom][1] = mt_rand(0, $jumlah_jam - 1);
                        break;
                    case 2:
                        $this->individu[$i][$krom][1] = mt_rand(0, ($jumlah_jam - 1) - 1);
                        break;
                    case 3:
                        $this->individu[$i][$krom][1] = mt_rand(0, ($jumlah_jam - 1) - 2);
                        break;
                    case 4:
                        $this->individu[$i][$krom][1] = mt_rand(0, ($jumlah_jam - 1) - 3);
                        break;
                    case 5:
                        $this->individu[$i][$krom][1] = mt_rand(0, ($jumlah_jam - 1) - 4);
                        break;
                }
                //Proses penggantian hari
                $this->individu[$i][$krom][2] = mt_rand(0, $jumlah_hari - 1);

                //proses penggantian ruang

                if ($this->jenis_mk[$krom] === $this->TEORI) {
                    $this->individu[$i][$krom][3] = $this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)];
                } elseif ($this->jenis_mk[$krom] === $this->PRAKTIKUM) {
                    $this->individu[$i][$krom][3] = $this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)];
                } elseif ($this->jenis_mk[$krom] === $this->PROYEK) {
                    $this->individu[$i][$krom][3] = $this->ruangProyek[mt_rand(0, $jumlah_ruang_proyek - 1)];
                } else {
                    $this->individu[$i][$krom][3] = $this->ruangBahasa[mt_rand(0, $jumlah_ruang_bahasa - 1)];
                }
            }

            $fitness[$i] = $this->CekFitness($i);
        }

        return $fitness;
    }


    public function GetIndividu($indv)
    {

        //int[,] individu_solusi = new int[mata_kuliah.Length, 4];
        $individu_solusi = array(array());

        for ($j = 0; $j < count($this->pengampu); $j++) {
            $individu_solusi[$j][0] = intval($this->pengampu[$this->individu[$indv][$j][0]]);
            $individu_solusi[$j][1] = intval($this->jam[$this->individu[$indv][$j][1]]);
            $individu_solusi[$j][2] = intval($this->hari[$this->individu[$indv][$j][2]]);
            $individu_solusi[$j][3] = intval($this->individu[$indv][$j][3]);
        }

        return $individu_solusi;
    }
    #region Seleksi


    // public function cekfitness(Request $request)
    // {

    //     // $sks=$this->sks;
    //     // dd($sks);


    //     // dd($jumlah_pengampu);


    //     // $range_jumat;
    //     // $kode_jumat = array();

    //     // $hari_jumat = intval($kode_jumat);
    //     // $jumat_0 = intval($range_jumat[0]);

    //     // for ($i = 0; $i < $jumlah_pengampu; $i++) {
    //     //     // $sks = [$i];
    //     //     $sks = $this->sks[$i];

    //     //     $jam_a = $individu[$indv][$i][1];
    //     //     // $hari_a = intval($individu[$indv][$i][2]);
    //     //     // $ruang_a = intval($individu[$indv][$i][3]);
    //     //     // $dosen_a = intval($dosen[$i]);
    //     // }
    //     dd($sks);
    // }
}
