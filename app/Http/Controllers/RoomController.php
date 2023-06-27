<?php

namespace App\Http\Controllers;

use App\Models\Room;

use Illuminate\Http\Request;
use DB;

use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{

    public function index()
    {
        $query = Room::get();

        return view('room.index', ['query' => $query]);
    }
    public function datas(Request $request)
    {
        // dd('aaa');
        if ($request->ajax()) {
            $data = Room::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $editUrl = route('room.edit', $row->kode);
                    // $showUrl = route('your-route.show', $row->kode);
                    $deleteUrl = route('room.hapus', $row->kode);

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

        return view('room.add');
    }

    public function edit($id)
    {
        // mengambil data dosen berdasarkan id yang dipilih
        $room = DB::table('ruang')->where('kode', $id)->get();
        // dd($room );

        // passing data dosen yang droom apat ke view edit.blade.php
        return view('room.edit', ['room' => $room]);
    }

    public function store(Request $request)
    {
        // dd($request);

        DB::table('ruang')->insert([

            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'jenis' => $request->jenis,

        ]);

        // alihkan halaman ke halaman Hari
        return redirect('/room');
    }

    public function update(Request $request)
    {
        // dd($request->nama);
        // die();
        // update data dosen
        DB::table('ruang')->where('kode', $request->id)->update([
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'jenis' => $request->jenis,
        ]);
        // alihkan halaman ke halaman dosen
        return redirect('/room');
    }

    public function hapus($id)
    {
        // menghapus data hari berdasarkan id yang dipilih
        DB::table('ruang')->where('kode', $id)->delete();

        // alihkan halaman ke halaman hari
        return redirect('/room');
    }
}
