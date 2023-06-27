<?php

namespace App\Http\Controllers;

use App\Models\Day;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class DayController extends Controller
{
    public function index()
    {
        $query = Day::get();

        return view('day.index', ['query' => $query]);
    }

    public function datas(Request $request)
    {
        // dd('aaa');
        if ($request->ajax()) {
            $data = Day::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $editUrl = route('day.edit', $row->kode);
                    // $showUrl = route('your-route.show', $row->kode);
                    $deleteUrl = route('day.hapus', $row->kode);

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
        $query = Day::get();

        return view('day.add', ['query' => $query]);
    }

    public function edit($id)
    {
        // mengambil data hari berdasarkan id yang dipilih
        $day = DB::table('hari')->where('kode', $id)->get();
        // passing data day yang didapat ke view edit.blade.php
        return view('day.edit', ['day' => $day]);
    }


    public function store(Request $request)
    {

        DB::table('Hari')->insert([
            'nama' => $request->nama,
        ]);

        return redirect('/day');
    }
    public function update(Request $request)
    {

        // update data hari
        DB::table('hari')->where('kode', $request->id)->update([
            'nama' => $request->nama,
        ]);
        // alihkan halaman ke halaman hari
        return redirect('/day');
    }

    public function hapus($id)
    {
        // menghapus data hari berdasarkan id yang dipilih
        DB::table('hari')->where('kode', $id)->delete();

        // alihkan halaman ke halaman hari
        return redirect('/day');
    }
}
