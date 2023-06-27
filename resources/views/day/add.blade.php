@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Tambah Data Hari</h3>
                  </div>
    

   
    <div class="card-header">
        
    <form action="/day/store" method="post">
        
        {{ csrf_field() }}
        &nbsp;  <label>Masukan Nama Hari</label>
    <input type="text" name="nama" required="required" class="form-control"> <br />
        
        <a href="/day">

        <button type="button" class="btn btn-danger">Kembali</button>
    </a>
    <a href="/day">

        <button type="submit" class="btn btn-success">Simpan</button>
    </a>
    
       
    
    
                  </div>
    </form>
   
    </div>
                </div>
              </div>
 </div>

    @endauth
    
    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
