<?php

namespace App\Http\Controllers;

use App\Models\Wtb;

use App\Models\Hour;

use App\Models\Day;

use App\Models\Lecture;
use Illuminate\Http\Request;
use DB;

use Yajra\DataTables\Facades\DataTables;

class WtbController extends Controller
{

    public function index()
    {
        $data = DB::table('waktu_tidak_bersedia')
            ->join('dosen', 'waktu_tidak_bersedia.kode_dosen', '=', 'dosen.kode')
            ->join('hari', 'waktu_tidak_bersedia.kode_hari', '=', 'hari.kode')
            ->join('jam', 'waktu_tidak_bersedia.kode_jam', '=', 'jam.kode')
            ->select('dosen.nama AS nm', 'hari.nama AS hr', 'waktu_tidak_bersedia.*', 'jam.range_jam', 'dosen.nidn')
            ->get();
        return view('wtb.index')->with('data', $data);
    }

    public function add()
    {
        $lecture = Lecture::get();
        $hour = Hour::get();
        $day = Day::get();
        return view('wtb.add', ['lecture' => $lecture, 'hour' => $hour, 'day' => $day]);
    }

    public function datas(Request $request)
    {
        // dd('aaa');
        if ($request->ajax()) {
            $data = DB::table('waktu_tidak_bersedia')
                ->join('dosen', 'dosen.kode', '=', 'waktu_tidak_bersedia.kode_dosen')
                ->join('hari', 'waktu_tidak_bersedia.kode_hari', '=', 'hari.kode')
                ->join('jam', 'waktu_tidak_bersedia.kode_jam', '=', 'jam.kode')
                ->select('dosen.nama AS nm', 'hari.nama AS hr', 'waktu_tidak_bersedia.*', 'jam.range_jam', 'dosen.nidn');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $editUrl = route('wtb.edit', $row->kode);
                    // $showUrl = route('your-route.show', $row->kode);
                    $deleteUrl = route('wtb.hapus', $row->kode);

                    // $btn = '<a href="' . $showUrl . '" class="btn btn-info btn-sm">Show</a>';
                    $btn = ' <a href="' . $editUrl . '" class="btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form action="' . $deleteUrl . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete?\')">Delete</button>
                            </form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $lecture = Lecture::get();
        $hour = Hour::get();
        $day = Day::get();
        // mengambil data dosen berdasarkan id yang dipilih
        $wtb = DB::table('waktu_tidak_bersedia')
            ->join('dosen', 'dosen.kode', '=', 'waktu_tidak_bersedia.kode_dosen')
            ->join('hari', 'hari.kode', '=', 'waktu_tidak_bersedia.kode_hari')
            ->join('jam', 'jam.kode', '=', 'waktu_tidak_bersedia.kode_jam')
            ->select(
                'waktu_tidak_bersedia.*',
                'dosen.kode as kddos',
                'dosen.nama as nm',
                'hari.nama as hr',
                'jam.range_jam',
                'hari.kode as kdhar',
                'jam.kode as kdjam'
            )
            ->where('waktu_tidak_bersedia.kode', $id)->get();
        // passing data dosen yang didapat ke view edit.blade.php
        return view('wtb.edit', ['wtb' => $wtb], ['lecture' => $lecture, 'hour' => $hour, 'day' => $day]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // die();
        // "kode_dosen" => "12"
        // "kode_hari" => "12"
        // "kode_jam" => "12"
        // insert data ke table Hari
        DB::table('waktu_tidak_bersedia')->insert([
            'kode_dosen' => $request->kode_dosen,
            'kode_hari' => $request->kode_hari,
            'kode_jam' => $request->kode_jam,

        ]);

        //     "nama" => "aa"
        //   "nidn" => "123"
        //   "alamat" => "asd123"
        //   "telp" => "123123"
        // ]

        // alihkan halaman ke halaman Hari
        return redirect('/wtb');
    }

    public function update(Request $request)
    {
        // dd($request->nama);
        // die();
        // update data dosen
        DB::table('waktu_tidak_bersedia')->where('kode', $request->id)->update([
            'kode_dosen' => $request->kode_dosen,
            'kode_hari' => $request->kode_hari,
            'kode_jam' => $request->kode_jam,
        ]);
        // alihkan halaman ke halaman dosen
        return redirect('/wtb');
        // echo $request->kode_dosen;
        // echo $request->kode_hari;
        // echo  $request->kode_jam;
        // echo 'ini kode',$request->id;
    }

    public function hapus($id)
    {
        // menghapus data hari berdasarkan id yang dipilih
        DB::table('waktu_tidak_bersedia')->where('kode', $id)->delete();

        // alihkan halaman ke halaman hari
        return redirect('/wtb');
    }
}
