<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lecture;
use App\Models\Room;
use App\Models\Support;
use App\Models\Hour;
use App\Models\Day;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Wtb;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class GenetikaSearchController extends Controller
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
    private $logAmbilData;
    private $logInisialisasi;
    private $log;
    private $induk = array();
    //jumat
    private $kode_jumat;
    private $range_jumat = array();
    private $kode_dhuhur;
    private $is_waktu_dosen_tidak_bersedia_empty;
    private $processController;

private $patter = array();


    public function index()
    {
        return view('genetika_search.index');
    }
    public function search()
    {
        $rs_data = DB::table('pengampu AS a')
        ->select('a.kode')
     
        
        // ->whereRaw('b.semester % 2 = 1')
        // ->where('a.tahun_akademik', '=', '2018-2019')
        ->get();
        //misalkan Pengampu
        $i = 0;
        foreach ($rs_data as $data) {
            $this->pengampu[$i]    = intval($data->kode);
           
            $i++;
        }
        $x0 = 0;
        $delta = 1;
        $k = 0;
        // ketentuand dari rumus gps
        $meshPoints = []; //untuk menyimpan slot mesh

        $l = null;
        
        for ($k = 0; $k < $this->pengampu; $k++) {
            $l = [$k];

            dd($this->pengampu);
            foreach ($this->pengampu as $element) {
                
                $meshPoints[] = $x0 + $delta * $element;
            }
        }
     
    }
    public function meshbaru(){

            //dd($meshPoints);
             //Fill Array of Jam Variables
                
        $rs_jam = Hour::select('kode')->get();
        $i      = 0;
        foreach ($rs_jam as $data) {
            $this->jam[$i] = intval($data->kode);
            $i++;
        }
        // dd($this->jam);

        //Fill Array of Hari Variables
        $rs_hari = Day::select('kode')->get();
        $i       = 0;
        foreach ($rs_hari as $data) {
            $this->hari[$i] = intval($data->kode);
            $i++;
        }
        // dd($this->hari);

        //ruang teori
        $rs_RuangTeori = Room::select('kode')->where('jenis', '=', $this->TEORI)->get();
        // dd($rs_RuangTeori);
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
        // dd($this->ruangLaboratorium);


        //ruang proyek /TA
        $rs_Ruangproyek = Room::select('kode')->where('jenis', '=', $this->PROYEK)->get();
        $i                    = 0;
        foreach ($rs_Ruangproyek as $data) {
            $this->ruangProyek[$i] = intval($data->kode);
            $i++;
        }
        // dd($this->ruangProyek);


        //ruang Bahasa Inggris
        $rs_Ruangbahasa = Room::select('kode')->where('jenis', '=', $this->BAHASA)->get();
        $i                    = 0;
        foreach ($rs_Ruangbahasa as $data) {
            $this->ruangBahasa[$i] = intval($data->kode);
            $i++;
        }
        // dd($this->ruangBahasa);
        $rs_WaktuDosen = DB::table('waktu_tidak_bersedia')
            ->select('kode_dosen', DB::raw("CONCAT_WS(':', kode_hari, kode_jam) AS kode_hari_jam"))
            ->get();
        // dd($rs_WaktuDosen);
        // $rs_WaktuDosen = WTB::select('kode_dosen',CONCAT_WS(':',kode_hari,kode_jam) as kode_hari_jam)->get();
        // $rs_WaktuDosen = $this->db->query("SELECT kode_dosen, CONCAT_WS(':',kode_hari,kode_jam) as kode_hari_jam FROM waktu_tidak_bersedia");
        $i             = 0;
        foreach ($rs_WaktuDosen as $data) {
            $this->idosen[$i]         = intval($data->kode_dosen);
            $this->waktu_dosen[$i][0] = intval($data->kode_dosen);
            $this->waktu_dosen[$i][1] = $data->kode_hari_jam;
            $i++;
        }
       
        $jumlah_jam = count($this->jam);
        $jumlah_hari = count($this->hari);
        $jumlah_ruang_reguler = count($this->ruangReguler);
        $jumlah_ruang_lab = count($this->ruangLaboratorium);
        $jumlah_ruang_proyek = count($this->ruangProyek);
        $jumlah_ruang_bahasa = count($this->ruangBahasa);
        
        for ($i = 0; $i < $this->populasi; $i++) {

            for ($j = 0; $j < $meshPoints; $j++) {

                $sks = $this->sks[$j];

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
            dd($meshPoints);
          
        }
            //  Langkah selanjutnya adalah menghasilkan titik mesh baru berdasarkan pola waktu yang telah ditentukan.
            // Dalam konteks penjadwalan matakuliah, titik mesh dapat berarti menghasilkan kombinasi waktu dan ruang yang mungkin untuk setiap mata kuliah yang perlu dijadwalkan.
            // ambil data berdasarkan jam yang telah diinput
            // query untuk menghasilkanya?
            
            // $bestSolution = $this->geneticAlgorithm($meshPoints);
        

       
        //return view('genetika_search.index');

        // Kembalikan hasil penjadwalan, misalnya sebagai response JSON
        // return response()->json(['meshPoints' => $xmeshPoints]);
    }

    private function geneticAlgorithm($meshPoints)
    {

        // looping meshpoint untuk query berdasarkan kode waktu
        // hasile data berdasarkan kode hour


        // Implementasikan algoritma genetika sesuai kebutuhan
        // Return solusi terbaik dari populasi awal meshPoints
        //dd($meshPoints);
    }
}
