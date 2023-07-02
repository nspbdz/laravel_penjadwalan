<?php

namespace App\Http\Controllers;

use App\Models\wb;

use App\Models\Hour;

use App\Models\Day;

use App\Models\Lecture;
use App\Models\Room;

use App\Models\Support;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class wbController extends Controller
{

    public function index()
    {
        $data = DB::table('waktu_bersedia')
        ->join('pengampu', 'waktu_bersedia.kode_pengampu', '=', 'pengampu.kode')
        ->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
        ->join('hari', 'waktu_bersedia.kode_hari', '=', 'hari.kode')
        ->join('jam', 'waktu_bersedia.kode_jam', '=', 'jam.kode')
        ->join('ruang', 'waktu_bersedia.kode_ruang', '=', 'ruang.kode')
        ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
        ->select('dosen.nama AS nm','hari.nama AS hr','waktu_bersedia.*','jam.range_jam', 'dosen.nidn', 'matakuliah.nama as nmmtk', 'pengampu.kelas as kelas', 'ruang.nama as ruang')
        ->get();
        return view('wb.index')->with('data', $data);
    }
    function waktu_tidak_bersedia($kode_dosen = NULL){
		
		$data = array();
		
		if($kode_dosen == NULL){
			//$kode_dosen = $this->db->query("SELECT kode FROM dosen ORDER BY nama LIMIT 1")->row()->kode;
		$kode_dosen = DB::table('dosen')
        ->select('kode')
        ->orderBy('nama')
        ->LIMIT(1)
        ->row()
        ->kode;
        }
		
		if (array_key_exists('arr_tidak_bersedia', $_POST) && !empty($_POST['arr_tidak_bersedia'])){
			
			
			if(IS_TEST === 'FALSE'){
				$this->db->query("DELETE FROM waktu_tidak_bersedia WHERE kode_dosen = $kode_dosen");
				
				foreach($_POST['arr_tidak_bersedia'] as $tidak_bersedia) {				
					
					$waktu_tidak_bersedia = explode('-',$tidak_bersedia);				
					$this->db->query("INSERT INTO waktu_tidak_bersedia(kode_dosen,kode_hari,kode_jam) VALUES($waktu_tidak_bersedia[0],$waktu_tidak_bersedia[1],$waktu_tidak_bersedia[2])");
				}						
				
				$data['msg'] = 'Data telah berhasil diupdate';			
			}else{
				$data['msg'] = 'WARNING: READ ONLY !';
			}
		}elseif(!empty($_POST['hide_me']) && empty($_POST['arr_tidak_bersedia'])){
			$this->db->query("DELETE FROM waktu_tidak_bersedia WHERE kode_dosen = $kode_dosen");
			$data['msg'] = 'Data telah berhasil diupdate';					
		}
		
		
		
		$data['rs_dosen'] = Lecture::get_all();
		$data['rs_waktu_tidak_bersedia'] = wb::get_by_dosen($kode_dosen);
		$data['rs_hari']  = Day::get();
		$data['rs_jam'] = Hour::get();
		
		$data['page_title'] = 'Waktu Tidak Bersedia';
		$data['page_name'] = 'waktu_tidak_bersedia';
		$data['kode_dosen'] = $kode_dosen;
		$this->render_view($data);
	}
	

    public function add()
    {
        //$support = Support::get();
        $hour = Hour::get();
        $day = Day::get();
        $room = Room::get();

        $support = DB:: table('pengampu')
       ->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
        ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
        ->select('dosen.nama as dosen', 'matakuliah.nama as matkul', 'pengampu.kode as kode_pengampu','pengampu.kelas as kelas')
        ->get();
    return view('wb.add', ['support' => $support, 'hour' => $hour, 'day' => $day, 'room' => $room]);
   
    }

    public function edit($id)
    {
        //$lecture = Lecture::get();
        $hour = Hour::get();
        $day = Day::get();
        $room = Room::get();
        $data = DB::table('waktu_bersedia')
        ->join('pengampu', 'waktu_bersedia.kode_pengampu', '=', 'pengampu.kode')
        ->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
        ->join('hari', 'waktu_bersedia.kode_hari', '=', 'hari.kode')
        ->join('jam', 'waktu_bersedia.kode_jam', '=', 'jam.kode')
        ->join('ruang', 'waktu_bersedia.kode_ruang', '=', 'ruang.kode')
        ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
        ->select('dosen.nama AS nm','hari.nama AS hr','waktu_bersedia.*','jam.range_jam', 'dosen.nidn', 'matakuliah.nama as nmmtk', 'pengampu.kelas as kelas', 'ruang.nama as ruang',
        'pengampu.kode as kode_pengampu','hari.kode as kode_hari', 'jam.kode as kode_jam', 'ruang.kode as kode_ruang')
        ->where('waktu_bersedia.kode', $id)->get();
        $support = DB:: table('pengampu')
        ->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
         ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
         ->select('dosen.nama as dosen', 'matakuliah.nama as matkul', 'pengampu.kode as kode_pengampu','pengampu.kelas as kelas')
         ->get();
        // mengambil data dosen berdasarkan id yang dipilih
        $wb = DB::table('waktu_bersedia')
        
        ->where('kode', $id)->get();
        // passing data dosen yang didapat ke view edit.blade.php
        return view('wb.edit', ['wb' => $wb],['data' => $data, 'hour' => $hour, 'day' => $day, 'room' => $room, 'support' => $support]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // die();
        // "kode_dosen" => "12"
        // "kode_hari" => "12"
        // "kode_jam" => "12"
        // insert data ke table Hari
        DB::table('waktu_bersedia')->insert([
            'kode_pengampu' => $request->kode_pengampu,
            'kode_hari' => $request->kode_hari,
            'kode_jam' => $request->kode_jam,
            'kode_ruang' => $request->kode_ruang,

        ]);

        //     "nama" => "aa"
        //   "nidn" => "123"
        //   "alamat" => "asd123"
        //   "telp" => "123123"
        // ]

        // alihkan halaman ke halaman Hari
        return redirect('/wb');
    }

    public function update(Request $request)
    {
        // dd($request->nama);
        // die();
        // update data dosen
        DB::table('waktu_bersedia')->where('kode', $request->id)->update([
            'kode_pengampu' => $request->kode_pengampu,
            'kode_hari' => $request->kode_hari,
            'kode_jam' => $request->kode_jam,
            'kode_ruang' => $request->kode_ruang,
        ]);
        // alihkan halaman ke halaman dosen
        return redirect('/wb');
        // echo $request->kode_dosen;
        // echo $request->kode_hari;
        // echo  $request->kode_jam;
        // echo 'ini kode',$request->id;
    }

    public function hapus($id)
    {
        // menghapus data hari berdasarkan id yang dipilih
        DB::table('waktu_bersedia')->where('kode', $id)->delete();

        // alihkan halaman ke halaman hari
        return redirect('/wb');
    }
}
