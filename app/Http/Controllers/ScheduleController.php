<?php

namespace App\Http\Controllers;

use App\Exports\ExportSchedule;
use App\Models\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use DB;


class ScheduleController extends Controller
{

    public function index()
    {

        $data = DB::table('jadwalkuliah')
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

        return view('schedule.index')->with('data', $data);
    }

    public function add()
    {

        return view('schedule.add');
    }

    public function edit($id)
    {
        // dd($id);
        // mengambil data dosen berdasarkan id yang dipilih
        $schedule = DB::table('jadwalkuliah')->where('kode', $id)->get();
        // passing data dosen yang didapat ke view edit.blade.php
        return view('schedule.edit', ['schedule' => $schedule]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // die();
        // insert data ke table Hari
        DB::table('jadwalkuliah')->insert([
            'kode_pengampu' => $request->kode_pengampu,
            'kode_jam' => $request->kode_jam,
            'kode_hari' => $request->kode_hari,
            'kode_ruang' => $request->kode_ruang,
        ]);


        // alihkan halaman ke halaman Hari
        return redirect('/schedule');
    }

    public function update(Request $request)
    {
        // dd($request->nama);
        // die();
        // update data dosen
        DB::table('jadwalkuliah')->where('kode', $request->id)->update([
            'kode_pengampu' => $request->kode_pengampu,
            'kode_jam' => $request->kode_jam,
            'kode_hari' => $request->kode_hari,
            'kode_ruang' => $request->kode_ruang,
        ]);
        // alihkan halaman ke halaman dosen
        return redirect('/schedule');
    }

    public function hapus($id)
    {
        // menghapus data hari berdasarkan id yang dipilih
        DB::table('jadwalkuliah')->where('kode', $id)->delete();

        // alihkan halaman ke halaman hari
        return redirect('/schedule');
    }

    public function export()
    {

        return Excel::download(new ExportSchedule, 'schedule.xlsx');
    }
}
