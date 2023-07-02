@extends('layouts.main')

@section('content')

    @auth
    

    <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3>Data Waktu Bersedia Dosen</h3>
                  </div>
                  <div class="card-header">
                    
    <a href="wb/add">

        <button type="button" class="btn btn-primary"><i class="fas fa-plus-square"></i> Tambah Data</button>
    </a>
                  </div>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md">
                      <tr>
            <th>No</th>
            <th>Hari</th>
            <th>Jam</th>
            <th>NIP / NIDN</th>
            <th>Nama dosen</th>
            <th>Matakuliah</th>
            <th>kelas</th>
           
            <th>Ruang</th>
            <th>Action</th>
        </tr>
        @foreach($data as $item)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $item->hr }}</td>
            <td>{{ $item->range_jam }}</td>
            <td>{{ $item->nidn }}</td>
            <td>{{ $item->nm }}</td>
            <td>{{ $item->nmmtk }}</td>
            <td>{{ $item->kelas }}</td>
            <td>{{ $item->ruang }}</td>
           
           
            <td>
                <a href="/wb/edit/{{ $item->kode }}">Edit</a>
                |
                <a href="/wb/hapus/{{ $item->kode }}">Hapus</a>
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
