<?php

namespace App\Http\Controllers;

use App\Models\Lecture;

use Illuminate\Http\Request;
use DB;

use Yajra\DataTables\Facades\DataTables;

class LectureController extends Controller
{

    public function index()
    {
        $query = Lecture::get();

        return view('lecture.index', ['query' => $query]);
    }

    public function datas(Request $request)
    {
        // dd('aaa');
        if ($request->ajax()) {
            $data = Lecture::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $editUrl = route('lecture.edit', $row->kode);
                    // $showUrl = route('your-route.show', $row->kode);
                    $deleteUrl = route('lecture.hapus', $row->kode);

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

        return view('lecture.add');
    }

    public function edit($id)
    {
        // mengambil data dosen berdasarkan id yang dipilih
        $lecture = DB::table('dosen')->where('kode', $id)->get();
        // passing data dosen yang didapat ke view edit.blade.php
        return view('lecture.edit', ['lecture' => $lecture]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // die();
        // insert data ke table Hari
        DB::table('dosen')->insert([
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
        ]);

        // alihkan halaman ke halaman Hari
        return redirect('/lecture');
    }

    public function update(Request $request)
    {
        // dd($request->nama);
        // die();
        // update data dosen
        DB::table('dosen')->where('kode', $request->id)->update([
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
        ]);
        // alihkan halaman ke halaman dosen
        return redirect('/lecture');
    }

    public function hapus($id)
    {
        // menghapus data hari berdasarkan id yang dipilih
        DB::table('dosen')->where('kode', $id)->delete();

        // alihkan halaman ke halaman hari
        return redirect('/lecture');
    }
}
