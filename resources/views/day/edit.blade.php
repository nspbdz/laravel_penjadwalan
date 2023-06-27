@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Hari</h3>
                  </div>
                  <div class="card-header">

    @foreach($day as $p)
    <form action="/day/update" method="post">
        {{ csrf_field() }}
        &nbsp; <label>Masukan Nama Hari</label>
        <input type="hidden" name="id" value="{{ $p->kode }}"> <br />
      <input type="text" required="required" name="nama" value="{{ $p->nama }}" class="form-control"> <br />
    
       
        <a href="/day">

<button type="button" class="btn btn-danger ">Kembali</button>
</a>
<a href="/day">

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
