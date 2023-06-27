@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Tambah Data Waktu Tidak Bersedia Dosen</h3>
                  </div>
                  <div class="card-header">

    <form action="/wtb/store" method="post">
        {{ csrf_field() }}
        Masukan Dosen
        <select name="kode_dosen" id="kode_dosen" class="form-control">
            <option value="">== Pilih Dosen ==</option>
            @foreach ($lecture as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->nama }}</option>
            @endforeach
        </select>
      
        <br>
        Masukan Hari
        <select name="kode_hari" id="kode_hari" class="form-control">
            <option value="">== Pilih Hari ==</option>
            @foreach ($day as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->nama }}</option>
            @endforeach
        </select>
        <br>
        Masukan Jam
        <select name="kode_jam" id="kode_jam" class="form-control">
            <option value="">== Pilih Jam ==</option>
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


    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
