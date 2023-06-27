@extends('layouts.main')

@section('content')
<div class="bg-light p-5 rounded">
    @auth
  proses



    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
