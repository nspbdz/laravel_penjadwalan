<?php

namespace App\Http\Controllers;

use App\Models\Course;

use Illuminate\Http\Request;
use DB;

use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{

    public function index()
    {
        $query = Course::get();

        return view('course.index', ['query' => $query]);
    }

    public function datas(Request $request)
    {
        // dd('aaa');
        if ($request->ajax()) {
            $data = Course::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $editUrl = route('course.edit', $row->kode);
                    // $showUrl = route('your-route.show', $row->kode);
                    $deleteUrl = route('course.hapus', $row->kode);

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

    public function add()
    {

        return view('course.add');
    }

    public function edit($id)
    {
        // dd("edit");
        // mengambil data dosen berdasarkan id yang dipilih
        $course = DB::table('matakuliah')->where('kode', $id)->get();
        // passing data dosen yang didapat ke view edit.blade.php
        return view('course.edit', ['course' => $course]);
    }

    public function store(Request $request)
    {
        
        DB::table('matakuliah')->insert([
            'kode_mk' => $request->kode_mk,
            'nama' => $request->nama,
            'sks' => $request->sks,
            'semester' => $request->semester,
            'aktif' => $request->aktif,
            'jenis' => $request->jenis,
        ]);

        // alihkan halaman ke halaman Mata Kuliah
        return redirect('/course');
    }

    public function update(Request $request)
    {
        // dd($request);
        // die();
        // update data dosen
        DB::table('matakuliah')->where('kode', $request->id)->update([
            'kode_mk' => $request->kode_mk,
            'nama' => $request->nama,
            'sks' => $request->sks,
            'semester' => $request->semester,
            'aktif' => $request->aktif,
            'jenis' => $request->jenis,
        ]);
        // alihkan halaman ke halaman dosen
        return redirect('/course');
    }

    public function hapus($id)
    {
        // menghapus data hari berdasarkan id yang dipilih
        DB::table('matakuliah')->where('kode', $id)->delete();

        // alihkan halaman ke halaman hari
        return redirect('/course');
    }
}
