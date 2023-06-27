@extends('layouts.main')

@section('content')
<div class="bg-light p-5 rounded">
    @auth
    <h1>Jam</h1>
    <a href="hour/add">

        <button type="button" class="btn btn-primary"> Tambah Data</button>
    </a>
    <br>
    <br>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Ruangan</th>

            <!-- <th>Status</th> -->
            <th>Action</th>
        </tr>
        @foreach($query as $item)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $item->range_jam }}</td>
            <!-- @if( $item->aktif != null || $item->aktif != '0')
            <td>tidak aktif</td>
            @elseif( $item->aktif != 1)
            <td>aktif</td>
            @else
            <td>-</td>
            @endif-->
            <td>
                <a href="/hour/edit/{{ $item->kode }}">Edit</a>
                |
                <a href="/hour/hapus/{{ $item->kode }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
  

    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Data Jam</h3>
                  </div>
                  <div class="card-header">
    <a href="hour/add">

        <button type="button" class="btn btn-primary">Tambah Data</button>
    </a>
                  </div>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md">
                        <tr>
                          <th>No</th>
                          <th>Range Jam</th>
                          
                          <th>Action</th>
                        </tr>
                        @foreach($query as $item)
                        <tr>
                        <td>{{ $loop->index + 1 }}</td>
            <td>{{ $item->range_jam }}</td>
            <td>
                <a href="/hour/edit/{{ $item->kode }}">Edit</a>
                |
                <a href="/hour/hapus/{{ $item->kode }}">Hapus</a>
            </td>
                        </tr>
                       
        @endforeach
        </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block">
                      <ul class="pagination mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
 </div>



    @endauth

    @guest

    <p>guest day</p>
    @endguest
</div>
@endsection
