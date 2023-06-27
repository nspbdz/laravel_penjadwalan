<?php

namespace App\Http\Controllers;

use App\Models\Support;
use App\Models\Lecture;
use App\Models\Course;
use App\Models\Room;


use Illuminate\Http\Request;
use DB;

use Yajra\DataTables\Facades\DataTables;

class SupportController extends Controller
{

    public function index()
    {

        $data = DB::table('pengampu')
            ->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
            ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
            ->select('dosen.nama AS nm', 'dosen.nidn', 'pengampu.*', 'matakuliah.nama', 'matakuliah.kode_mk as kdmk')
            ->get();
        return view('support.index')->with('data', $data);
    }

    public function datas(Request $request)
    {
        // dd('aaa');
        if ($request->ajax()) {
            $data = Support::select('*')->join('dosen', 'pengampu.kode_dosen', '=', 'dosen.kode')
                ->join('matakuliah', 'pengampu.kode_mk', '=', 'matakuliah.kode')
                ->select('dosen.nama AS nm', 'dosen.nidn', 'pengampu.*', 'matakuliah.nama', 'matakuliah.kode_mk as kdmk');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $editUrl = route('support.edit', $row->kode);
                    // $showUrl = route('your-route.show', $row->kode);
                    $deleteUrl = route('support.hapus', $row->kode);

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
    public function getMataKuliahBySemester(Request $request)
    {
        $selectedSemester = $request->get('semester');

        $filteredMataKuliah = [];
        $mataKuliahData = Course::get();
        if ($selectedSemester == 'ganjil') {
            // Logika filter mata kuliah ganjil
            foreach ($mataKuliahData as $kode => $value) {
                if ($kode % 2 != 0) {
                    $filteredMataKuliah[$kode] = $value->nama;
                }
            }
        } elseif ($selectedSemester == 'genap') {
            // Logika filter mata kuliah genap
            foreach ($mataKuliahData as $kode => $value) {
                // dd($value->nama);
                if ($kode % 2 == 0) {
                    $filteredMataKuliah[$kode] = $value->nama;
                }
            }
        }
        return response()->json($filteredMataKuliah);
    }


    public function add()
    {
        $lecture = Lecture::get();
        $course = Course::get();
        $room = Room::get();
        return view('support.add', ['lecture' => $lecture, 'room' => $room, 'course' => $course]);
    }

    public function edit($id)
    {
        $lecture = Lecture::get();
        $course = Course::get();
        // mengambil data dosen berdasarkan id yang dipilih
        $support = DB::table('pengampu')
            ->join('dosen', 'dosen.kode', '=', 'pengampu.kode_dosen')
            ->join('matakuliah', 'matakuliah.kode', '=', 'pengampu.kode_mk')
            ->select('dosen.nama as nm', 'matakuliah.nama as mt', 'pengampu.*')
            ->where('pengampu.kode', $id)->get();
        // passing data dosen yang didapat ke view edit.blade.php
        return view('support.edit', ['support' => $support], ['lecture' => $lecture, 'course' => $course]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // die();
        // insert data ke table Hari
        DB::table('pengampu')->insert([

            'kode_mk' => $request->kode_mk,
            'kode_dosen' => $request->kode_dosen,
            'kelas' => $request->kelas,
            'tahun_akademik' => $request->tahun_akademik,

        ]);

        //     "nama" => "aa"
        //   "nidn" => "123"
        //   "alamat" => "asd123"
        //   "telp" => "123123"
        // ]

        // alihkan halaman ke halaman Hari
        return redirect('/support');
    }

    public function update(Request $request)
    {
        // dd($request->nama);
        // die();
        // update data dosen
        DB::table('pengampu')->where('kode', $request->id)->update([
            'kode_mk' => $request->kode_mk,
            'kode_dosen' => $request->kode_dosen,
            'kelas' => $request->kelas,
            'tahun_akademik' => $request->tahun_akademik,
        ]);
        // alihkan halaman ke halaman dosen
        return redirect('/support');
    }

    public function hapus($id)
    {
        // menghapus data hari berdasarkan id yang dipilih
        DB::table('pengampu')->where('kode', $id)->delete();

        // alihkan halaman ke halaman hari
        return redirect('/support');
    }
}
