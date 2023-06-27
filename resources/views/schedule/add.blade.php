@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Tambah Data Jadwak</h3>
                  </div>
                  <div class="card-header">

    <form action="/schedule/store" method="post">
        {{ csrf_field() }}
        Kode Pengampu <input type="number" name="kode_pengampu" required="required" class="form-control">
        <br>
        Kode Jam <input type="number" name="kode_jam" required="required" class="form-control"> 
        <br>
        Kode Hari <input type="number" name="kode_hari" required="required" class="form-control"> 
        <br>
        Kode Ruang <input type="number" name="kode_ruang" required="required" class="form-control"> 
        <br>

        <a href="/schedule">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/schedule">

<button type="submit" class="btn btn-success">Simpan</button>
</a>
    </form>


    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
