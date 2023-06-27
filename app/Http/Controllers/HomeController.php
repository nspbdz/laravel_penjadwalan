<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\Models\Support;
use App\Models\Room;
use App\Models\Course;
use App\Models\Wtb;
class HomeController extends Controller
{
    public function index()
    {
        $data = DB::table('pengampu')
        ->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
        ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
        ->select('dosen.nama AS nm','dosen.nidn', 'pengampu.*', 'matakuliah.nama','matakuliah.kode_mk as kdmk')
        ->limit(5)
        ->get();
        $support = DB::table('pengampu')
        ->select('kode')
        ->count();
        $course = DB::table('matakuliah')
        ->select('kode')
        ->count();
        $room = DB::table('ruang')
        ->select('kode')
        ->count();
        $lecture = DB::table('dosen')
        ->select('kode')
        ->count();
      //dd($data);
        return view('home.index',['support'=> $support, 'course' =>$course, 'room'=>$room, 'lecture'=>$lecture, 'data'=>$data ]);
    }
}
