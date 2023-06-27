@extends('layouts.main')

@section('content')

    @auth
    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Edit Data Jam</h3>
                  </div>
                  <div class="card-header">

    @foreach($hour as $p)
    <form action="/hour/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}">
&nbsp; </label>Masukan Range Jam</label> <br>
 <input type="text" required="required" name="range_jam" value="{{ $p->range_jam }}" class="form-control"> <br />
 <a href="/hour">       
<button type="button" class="btn btn-danger">Kembali</button>
</a>
<a href="/hour">

<button type="submit" class="btn btn-success">Simpan</button>
</a>
    </form>
    @endforeach
    @endauth

    @guest

    <p>guest Hour</p>
    @endguest
</div>
@endsection
