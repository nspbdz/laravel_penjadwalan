@extends('layouts.main')

@section('content')
<div class="bg-light p-5 rounded">
    @auth
    <h3>Data Jam</h3>

    <a href="/hour"> Kembali</a>

    <br />
    <br />

    <form action="/hour/store" method="post">
        {{ csrf_field() }}
        Range Jam <input type="text" name="range_jam" required="required"> <br />
        <br>
        <input type="submit" value="Simpan Data">
    </form>


    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
