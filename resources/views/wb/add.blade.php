@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Tambah Data Waktu Bersedia Dosen</h3>
                  </div>
                  <div class="card-header">

    <form action="/wb/store" method="post">
        {{ csrf_field() }}
        Masukan Dosen, Matakuliah dan Kelas
        <select name="kode_pengampu" id="kode_pengampu" class="form-control">
            <option value="">== Pilih Dosen, Matakuliah dan Kelas ==</option>
            @foreach ($support as $key => $value)

            <option value="{{ $value->kode_pengampu }}">{{ $value->dosen }} === {{ $value->matkul }} == {{ $value->kelas }}</option>
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
        <br>
        Masukan Ruang
        <select name="kode_ruang" id="kode_ruang" class="form-control">
            <option value="">== Pilih ruang ==</option>
            @foreach ($room as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->nama }}</option>
            @endforeach
        </select>
        <br>

        <a href="/wb">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/wb">

<button type="submit" class="btn btn-success">Simpan</button>
</a>
    </form>


    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
