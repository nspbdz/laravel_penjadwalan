@extends('layouts.main')

@section('content')

@auth



<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Data Ruangan</h3>
            </div>
            <div class="card-header">
                <a href="room/add">

                    <button type="button" class="btn btn-primary"><i class="fas fa-plus-square"></i> Tambah Data</button>
                </a>
            </div>
            <!-- <th>kapasitas</th>
            <th>jenis</th> -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="room">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th>Nama</th>
                                <th>kapasitas</th>
                                <th>jenis</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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


<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        console.log('awad')
        let room = $('#room').DataTable({
            processing: true,
            serverside: true,
            // responsive: true,
            ajax: {
                url: "{{route('room.datatable')}}",
                data: function(data) {
                    data.awal = $('#awal').val();
                    data.akhir = $('#akhir').val();
                },
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kapasitas',
                    name: 'kapasitas'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'action',
                    name: 'action'
                },


            ]
        })

        $('#btnFilter').click(function(e) {
            e.preventDefault()
            room.ajax.reload();
        })
    });



    // @if(session('success'))
    // swal({
    //     icon: 'success',
    //     title: `{{ session('success') }}`
    // })
    // @endif

    // @if(session('error'))
    // swal({
    //     icon: 'error',
    //     title: `{{ session('error') }}`,
    //     text: `{{ request()->session()->has('error_message')? session('error_message'): null }}`
    // })
    // @endif
</script>

@endauth

@guest

<p>guest day</p>
@endguest
</div>
@endsection
