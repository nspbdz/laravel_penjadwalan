@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Pengampu</h3>
                  </div>
                  <div class="card-header">

    @foreach($support as $p)
    <form action="/support/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}"> <br />

       
        Masukan Matakuliah
        <select name="kode_mk" id="kode_mk" class="form-control">
            <option value="">== {{ $p->mt }} ==</option>
            @foreach ($course as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->nama }}</option>
            @endforeach
        </select>
      
        <br>
        Masukan Dosen
        <select name="kode_dosen" id="kode_dosen" class="form-control">
            <option value="">=={{ $p->nm }} ==</option>
            @foreach ($lecture as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->nama }}</option>
            @endforeach
        </select>
        <br>
        Kelas <input type="text" name="kelas" required="required" value="{{ $p->kelas }}" class="form-control"> 
        <br>
        Tahun Akademik <input type="text" name="tahun_akademik" required="required" value="{{ $p->tahun_akademik }}" class="form-control">
        <br>

        <a href="/support">

<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/support">

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
