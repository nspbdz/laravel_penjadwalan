@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Tambah Data Mata Kuliah</h3>
                  </div>
                  <div class="card-header">
    <form action="/course/store" method="post">
        {{ csrf_field() }}
        Kode Matakuliah <input type="text" name="kode_mk" required="required" class="form-control">
        <br>
        Nama <input type="text" name="nama" required="required" class="form-control"> 
        <br>
        Jumlah SKS <input type="number" name="sks" required="required" class="form-control"> 
        <br>
        Semester <input type="text" name="semester" required="required" class="form-control"> 
        <br>
        Aktif
        <select name="aktif" id="aktif" class="form-control">
            <option value="">== Pilih Jenis ==</option>
            <option value="true">True</option>
            <option value="false">False</option>
        </select>
        
       
        <br>
        Jenis Matakuliah
        <select name="jenis" id="jenis" class="form-control">
            <option value="">== Pilih Jenis ==</option>
            <option value="TEORI">TEORI</option>
            <option value="PRAKTIKUM">PRAKTIKUM</option>
            <option value="BAHASA">BAHASA</option>
            <option value="PROYEK">PROYEK</option>
        </select>
        <br>
        <a href="/course">

        <button type="button" class="btn btn-danger">Kembali</button>
    </a>
    <a href="/course">

        <button type="submit" class="btn btn-success">Simpan</button>
    </a>
    </form>


    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
