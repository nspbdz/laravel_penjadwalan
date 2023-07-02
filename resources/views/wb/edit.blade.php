@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Waktu Bersedia Dosen</h3>
                  </div>
                  <div class="card-header">

    @foreach($wb as $p)
    <form action="/wb/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}"> <br />



        
        Masukan Dosen, Matakuliah dan Kelas
        <select name="kode_pengampu" id="kode_pengampu" class="form-control">
            @foreach ($data as $item)
            <option value="{{ $item->kode_pengampu }}">== {{ $item->nm }} === {{ $item->nmmtk }} == {{ $item->kelas }} ==</option>
            @endforeach
            @foreach ($support as $key => $value)

            <option value="{{ $value->kode_pengampu }}">{{ $value->dosen }} === {{ $value->matkul }} == {{ $value->kelas }}</option>
            @endforeach
        </select>
      
        <br>
        Masukan Hari
        <select name="kode_hari" id="kode_hari" class="form-control">
        @foreach ($data as $item)
            <option value="{{$item->kode_hari}}">=={{ $item->hr }} ==</option>
            @endforeach
            @foreach ($day as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->nama }}</option>
            @endforeach
        </select>
        <br>
        Masukan Jam
        <select name="kode_jam" id="kode_jam" class="form-control">
        @foreach ($data as $item)
            <option value="{{ $item->kode_jam }}">=={{ $item->range_jam }}==</option>
            @endforeach
            @foreach ($hour as $key => $value)

            <option value="{{ $value->kode }}">{{ $value->range_jam }}</option>
            @endforeach
        </select>
        <br>
        Masukan Ruang
        <select name="kode_ruang" id="kode_ruang" class="form-control">
        @foreach ($data as $item)
            <option value="{{$item->kode_ruang}}">== {{ $item->ruang }} ==</option>
            @endforeach
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
    @endforeach
    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
