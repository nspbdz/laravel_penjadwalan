@extends('layouts.main')

@section('content')
<div class="bg-light p-5 rounded">
    @auth
    GPS
    <form action="/genetika_search/search" method="post">


        <input type="submit" value="Simpan Data">
    </form>
    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
