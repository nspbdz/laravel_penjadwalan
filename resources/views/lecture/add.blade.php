@extends('layouts.main')

@section('content')

  @auth
  <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Tambah Data Dosen</h3>
                  </div>
                  <div class="card-header">


  <form action="/lecture/store" method="post">
    {{ csrf_field() }}
    Nama <input type="text" name="nama" required="required" class="form-control"> 
    <br>
    NIP / NIDN <input type="text" name="nidn" required="required" class="form-control"> 
    <br>
   
    Alamat
    <textarea type="text" name="alamat" required="required" class="form-control">
      </textarea>
  
    <br>
    Telphone <input type="number" name="telp" required="required" class="form-control"> 
    <br>
  
    <a href="/lecture">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/lecture">

<button type="submit" class="btn btn-success">Simpan</button>
</a>
  </form>


  @endauth

  @guest

  <p>guest day</p>
  @endguest
</div>
@endsection
