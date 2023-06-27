<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hour;

use DB;
use Yajra\DataTables\Facades\DataTables;

class HourController extends Controller
{
    public function index()
    {
        $query = Hour::get();

        return view('hour.index', ['query' => $query]);
    }

    public function datas(Request $request)
    {
        // dd('aaa');
        if ($request->ajax()) {
            $data = Hour::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $editUrl = route('hour.edit', $row->kode);
                    // $showUrl = route('your-route.show', $row->kode);
                    $deleteUrl = route('hour.hapus', $row->kode);

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
        $query = Hour::get();

        return view('hour.add', ['query' => $query]);
    }

    public function edit($id)
    {
        // mengambil data jam berdasarkan id yang dipilih
        $hour = DB::table('jam')->where('kode', $id)->get();
        // passing data jam yang didapat ke view edit.blade.php
        return view('hour.edit', ['hour' => $hour]);
    }

    public function store(Request $request)
    {
        // insert data ke table jam
        DB::table('jam')->insert([
            'range_jam' => $request->range_jam,
        ]);

        // alihkan halaman ke halaman jam
        return redirect('/hour');
    }

    public function update(Request $request)
    {
        // update data jam
        DB::table('jam')->where('kode', $request->id)->update([
            'range_jam' => $request->range_jam,
        ]);
        // alihkan halaman ke halaman jam
        return redirect('/hour');
    }

    public function hapus($id)
    {
        // menghapus data jam berdasarkan id yang dipilih
        DB::table('jam')->where('kode', $id)->delete();

        // alihkan halaman ke halaman jam
        return redirect('/hour');
    }
}
