@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Tambah Data Jam</h3>
                  </div>
                  <div class="card-header">

    <form action="/hour/store" method="post">
        {{ csrf_field() }}
        <label>Masukan Range Jam </label> <input type="text" name="range_jam" required="required" class="form-control"> <br />
    
        <a href="/hour">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/hour">

<button type="submit" class="btn btn-success">Simpan</button>
</a>
    </form>


    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
