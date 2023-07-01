<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_matkul',
        'sks',
        'semester',
        'jenis',
        'kode_mk',
    ];
    protected $table = 'matakuliah';

    public function getCourse($tahunAkademik, $semesterGanjil = 0)
    {
        return DB::table('pengampu')
            ->select(DB::raw("CONCAT(pengampu.kode,' - ',pengampu.kode_dosen,' - ',matakuliah.jenis,' - ',matakuliah.nama) as nama_mata_kuliah"))
            ->leftJoin('matakuliah', 'matakuliah.kode', '=', 'pengampu.kode_mk')
            ->where('pengampu.tahun_akademik', '=', $tahunAkademik)
            ->where(DB::raw('matakuliah.semester % 2'), '=', $semesterGanjil)
            ->pluck('nama_mata_kuliah')->toArray();
    }
}
