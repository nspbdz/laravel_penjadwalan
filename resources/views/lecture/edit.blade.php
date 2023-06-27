@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Dosen</h3>
                  </div>
                  <div class="card-header">

    @foreach($lecture as $p)
    <form action="/lecture/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}"> <br />
        Nama <input type="text" required="required" name="nama" value="{{ $p->nama }}" class="form-control"> 
        <br>
        NIP / NIDN <input type="text" name="nidn" required="required" value="{{ $p->nidn }}" class="form-control"> 
        <br>
       
        Alamat
        <textarea type="text" name="alamat" required="required" value="{{ $p->alamat }}" class="form-control">
        {{ $p->alamat }}

        </textarea>
     
        <br>

        Telphone <input type="number" name="telp" required="required" value="{{ $p->telp }}" class="form-control"> 
        <br>
        
        <a href="/lecture">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/lecture">

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
