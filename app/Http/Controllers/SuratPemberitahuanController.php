<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPemberitahuan;
use Yajra\DataTables\DataTables;
use App\Models\Instansi;
use Carbon\Carbon;
use PDF;
use Alert;

class SuratPemberitahuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    //  {
    //       $this->middleware('permission:suratPemberitahuan-list|suratPemberitahuan-create|suratPemberitahuan-edit|suratPemberitahuan-delete', ['only' => ['index','show']]);

    //       $this->middleware('permission:suratPemberitahuan-create', ['only' => ['create','store']]);

    //       $this->middleware('permission:suratPemberitahuan-edit', ['only' => ['edit','update']]);
    //       $this->middleware('permission:suratPemberitahuan-delete', ['only' => ['destroy']]);
    //  }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $suratPemberitahuan = SuratPemberitahuan::latest()->paginate(5);
        // return view('suratPemberitahuan.index',compact('suratPemberitahuan'))
        //     ->with('i', (request()->input('page', 1) - 1) * 5);

        return view('suratPemberitahuan.index', compact('request'));
    }

    public function getSuratPemberitahuan(Request $request)
    {
        if ($request->ajax()) {
            $data = SuratPemberitahuan::select('*');
            $data->when($request->awal, function ($value) use ($request) {
                $value->where('tanggal', '>=', $request->awal);
            });
            $data->when($request->akhir, function ($value) use ($request) {
                $value->where('tanggal', '<=', $request->akhir);
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal_surat', function($value){
                    $tanggal = Carbon::parse($value->tanggal_surat)->format('d-m-Y');
                    return $tanggal;
                })

                ->addColumn('action', function ($value) {
                    $btn = '<div class="d-flex flex-row bd-higlight mb-3">
                    <a href="' . route('suratPemberitahuan.show', $value->id) . '"
                        class="btn btn-warning btn-sm"><i class="fas fa-info"></i>&nbsp;</a>&nbsp;

                    <a class="btn btn-info btn-sm"
                        href="' . route('suratPemberitahuan.edit', $value->id) . '">
                            <i class="fas fa-pen-fancy"></i>&nbsp;</a>&nbsp;

                    <a class="btn btn-danger text-white delete" id="' . $value->id . '"
                        nama="' . $value->jenis_surat . '" onclick="deleteSuratPemberitahuan(' . $value->id . ')"><i
                            class="fas fa-trash"></i></a>

                </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $instansis = Instansi::all();
        return view('suratPemberitahuan.create', ['instansis' => $instansis]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'jenis_surat' => 'required',
            'kode_instansi' => 'required',
            'tempat_surat' => 'required',
            'tanggal_surat' => 'required',
            'pengirim' => 'required',
            'perihal' => 'required',
            'pnrm_surat' => 'required',
            'alamat_surat' => 'required',
            'isi_surat' => 'required',

        ], [
            'jenis_surat.required' => 'Jenis Surat Wajib diisi!',
            'kode_instansi.required' => 'Kode Instansi Wajib diisi!',
            'tempat_surat.required' => 'Tempat Surat Wajib diisi!',
            'tanggal_surat.required' => 'Tanggal Surat Wajib diisi!',
            'pengirim.required' => 'Pengirim Wajib diisi!',
            'perihal.required' => 'Perihal Wajib diisi!',
            'pnrm_surat.required' => 'Penerima Surat Wajib diisi!',
            'alamat_surat.required' => 'Alamat surat Wajib diisi!',
            'isi_surat.required' => 'Isi Surat Wajib diisi!',
        ]);

        $suratPemberitahuan = new SuratPemberitahuan();
        // $suratPemberitahuan = SuratPemberitahuan::create($request->all());

        $suratPemberitahuan->jenis_surat = $request->jenis_surat;
        $suratPemberitahuan->instansis_id = $request->kode_instansi;
        $suratPemberitahuan->tempat_surat = $request->tempat_surat;
        $suratPemberitahuan->tanggal_surat = $request->tanggal_surat;
        $suratPemberitahuan->pengirim = $request->pengirim;
        $suratPemberitahuan->perihal = $request->perihal;
        $suratPemberitahuan->pnrm_surat = $request->pnrm_surat;
        $suratPemberitahuan->alamat_surat = $request->alamat_surat;
        $suratPemberitahuan->isi_surat = $request->isi_surat;
        $suratPemberitahuan->no_surat = $request->no_surat;
        $suratPemberitahuan->save();

        return redirect('suratPemberitahuan')->with('success', 'Surat Berhasil di tambahkan!');
    }

    public function generateLetterNumber(Request $request)
    {
        $nama_pj = Instansi::where('id', '=', $request->kode_instansi)->first();
        $nama_pj = $nama_pj->nama_pj;
        $letterNumber = SuratPemberitahuan::generateLetterNumber($request);
        return ['letterNumber' => $letterNumber, 'nama_pj' => $nama_pj];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $suratPemberitahuan = SuratPemberitahuan::findOrFail($id);
        $instansi = Instansi::all();
        return view('suratPemberitahuan.show', ['suratPemberitahuan' => $suratPemberitahuan, 'instansi' => $instansi]);
    }

    public function generatePDF(Request $request, $id)
    {
        $suratPemberitahuan = SuratPemberitahuan::find($id);
        $instansi = $suratPemberitahuan->instansis;
        $logo = 'logoinstansi/'.$instansi->logo;
        $logoData = base64_encode(file_get_contents($logo));
        $src = 'data:' . mime_content_type($logo) . ';base64' . $logoData;
        $pdf = PDF::loadview('suratPemberitahuan.surat_pemberitahuanPDF', ['suratPemberitahuan'=>$suratPemberitahuan, 'instansi'=>$instansi, 'logo'=>$logo]);
        return $pdf->stream('Surat Pemberitahuan PDF.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suratPemberitahuan = SuratPemberitahuan::findOrFail($id);
        $instansis = Instansi::all();
        return view('suratPemberitahuan.edit', ['suratPemberitahuan' => $suratPemberitahuan, 'instansis' => $instansis]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $suratPemberitahuan = SuratPemberitahuan::findOrFail($id);

            $suratPemberitahuan->tempat_surat = $request->tempat_surat;
            $suratPemberitahuan->tanggal_surat = $request->tanggal_surat;
            $suratPemberitahuan->pengirim = $request->pengirim;
            $suratPemberitahuan->perihal = $request->perihal;
            $suratPemberitahuan->pnrm_surat = $request->pnrm_surat;
            $suratPemberitahuan->alamat_surat = $request->alamat_surat;
            $suratPemberitahuan->isi_surat= $request->isi_surat;
            if($request->hasFile('file_asli_pemberitahuan')){
            $request->file_asli_pemberitahuan->move('fileAsliPemberitahuan/', $request->file_asli_pemberitahuan->getClientOriginalName());
            $suratPemberitahuan->file_asli_pemberitahuan = $request->file_asli_pemberitahuan->getClientOriginalName();
            }
            if($request->hasFile('file_scan_pemberitahuan')){
            $request->file('file_scan_pemberitahuan')->move('fileScanPemberitahuan/', $request->file('file_scan_pemberitahuan')->getClientOriginalName());
            $suratPemberitahuan->file_scan_pemberitahuan = $request->file('file_scan_pemberitahuan')->getClientOriginalName();
            }
            $suratPemberitahuan->save();

            return redirect('suratPemberitahuan')->with('success', 'Surat Berhasil di edit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $suratPemberitahuan = SuratPemberitahuan::find($id);
        $suratPemberitahuan->delete();
        return $id;
    }
}
