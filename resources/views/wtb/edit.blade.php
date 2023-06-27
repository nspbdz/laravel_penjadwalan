@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Waktu Tidak Bersedia Dosen</h3>
                  </div>
                  <div class="card-header">

    @foreach($wtb as $p)
    <form action="/wtb/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}"> <br />



        
  Masukan Dosen
        <select name="kode_dosen" id="kode_dosen" class="form-control">
            <option value="">== {{ $p->nm }} ==</option>
            @foreach ($lecture as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->nama }}</option>
            @endforeach
        </select>
      
        <br>
        Masukan Hari
        <select name="kode_hari" id="kode_hari" class="form-control">
            <option value="">=={{ $p->hr }} ==</option>
            @foreach ($day as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->nama }}</option>
            @endforeach
        </select>
        <br>
        Masukan Jam
        <select name="kode_jam" id="kode_jam" class="form-control">
            <option value="">=={{ $p->range_jam }}==</option>
            @foreach ($hour as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->range_jam }}</option>
            @endforeach
        </select>
        
        <a href="/wtb">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/wtb">

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
