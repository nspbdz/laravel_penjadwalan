@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Mata Kuliah</h3>
                  </div>
                  <div class="card-header">

    @foreach($course as $p)
    <form action="/course/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}" class="form-control">

        Kode Matakuliah <input type="text" name="kode_mk" required="required" class="form-control" value="{{ $p->kode_mk }}">
        <br>
        Nama <input type=" text" name="nama" required="required" value="{{ $p->nama }}" class="form-control"> 
        <br>
        Jumlah SKS <input type=" number" name="sks" required="required" value="{{ $p->sks }}" class="form-control">
        <br>
        Semester <input type=" text" name="semester" required="required" value="{{ $p->semester }}" class="form-control">
        <br>
      
        Aktif
        <select name="aktif" id="aktif" class="form-control">
            <option value="">== {{ $p->aktif }} ==</option>
            <option value="true">True</option>
            <option value="false">False</option>
        </select>
        
       
        <br>
        Jenis Matakuliah
        <select name="jenis" id="jenis" class="form-control">
            <option value="">== {{ $p->jenis }} ==</option>
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
    @endforeach
    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
