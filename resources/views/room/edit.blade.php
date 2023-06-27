@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Ruangan</h3>
                  </div>
                  <div class="card-header">

    @foreach($room as $p)
    <form action="/room/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}" class="form-control"> 

        Nama <input type=" text" name="nama" required="required" value="{{ $p->nama }}" class="form-control"> 
        <br>
        Kapasitas <input type=" number" name="kapasitas" required="required" value="{{ $p->kapasitas }}" class="form-control"> 
        <br>
        Jenis Ruangan
        <select name="jenis" id="jenis" class="form-control">
            <option value="">== {{ $p->jenis }} ==</option>
            <option value="TEORI">TEORI</option>
            <option value="LABORATORIUM">LABORATORIUM</option>
            <option value="PROYEK">PROYEK</option>
            <option value="BAHASA">BAHASA</option>
        </select>
        <br>

      
        <a href="/room">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/room">

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
