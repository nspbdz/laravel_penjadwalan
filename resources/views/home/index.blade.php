@extends('layouts.main')

@section('content')
<div class="container-fluid">
    @auth

    <br>
    <!-- Page Heading -->
    <center>
        <div class="d-sm-flex align-center justify-content-between mb-4">
            <h2 class="h3 mb-0 align-center text-gray-800"><strong>Selamat Datang DiPenjadwalan Matakuliah Jurusan Teknik Infotmatika Politeknik Negeri Indramayu</strong></h2>
        </div>


    </center>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pengampu</div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800">Total : {{$support}}</div>

                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Mata Kuliah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> Total : {{$course}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ruangan
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Total : {{$room}}</div>
                                </div>
                                <div class="col">

                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Dosen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Total : {{$lecture}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Data Pengampu</h3>
                    </div>
                    <div class="card-header">
                        <div class="row">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode matakuliah</th>
                                            <th>Nama matakuliah</th>
                                            <th>NIP / NIDN</th>
                                            <th>Nama dosen</th>
                                            <th>Kelas</th>
                                            <th>Tahun Akademik</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($data as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>

                                            <td>{{ $item->kdmk }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->nidn }}</td>
                                            <td>{{ $item->nm }}</td>
                                            <td>{{ $item->kelas }}</td>
                                            <td>{{ $item->tahun_akademik }}</td>
                                            <td>
                                                <a href="/support/edit/{{ $item->kode }}">Edit</a>
                                                |
                                                <a href="/support/hapus/{{ $item->kode }}">Hapus</a>
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


            </div>


            <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>







            @endauth

            @guest
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown button
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
            <h1>Homepage</h1>
            <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
            @endguest
        </div>
        @endsection
