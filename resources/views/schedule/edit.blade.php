@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Jadwal</h3>
                  </div>
                  <div class="card-header">

    @foreach($schedule as $p)
    <form action="/schedule/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}"> 
        Kode Pengampu <input type="number" name="kode_pengampu" required="required" value="{{ $p->kode_pengampu }}" class="form-control">
        <br>
        Kode Jam <input type="number" name="kode_jam" required="required" value="{{ $p->kode_jam }}" class="form-control"> 
        <br>
        Kode Hari <input type="number" name="kode_hari" required="required" value="{{ $p->kode_hari }}" class="form-control"> 
        <br>
        Kode Ruang <input type="number" name="kode_ruang" required="required" value="{{ $p->kode_ruang }}" class="form-control">
        <br>

        <a href="/schedule">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/schedule">

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
