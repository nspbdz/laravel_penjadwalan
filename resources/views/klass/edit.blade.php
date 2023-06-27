@extends('layouts.main')

@section('content')
<div class="bg-light p-5 rounded">
    @auth
    <h3>Edit Jam</h3>

    <a href="/hour"> Kembali</a>

    <br />
    <br />

    @foreach($hour as $p)
    <form action="/hour/update" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $p->kode }}"> <br />
        Range Jam <input type="text" required="required" name="range_jam" value="{{ $p->range_jam }}"> <br />
        <br>
        <input type="submit" value="Simpan Data">
    </form>
    @endforeach
    @endauth

    @guest

    <p>guest Hour</p>
    @endguest
</div>
@endsection
