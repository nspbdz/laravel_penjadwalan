@extends('layouts.main')

@section('content')

@auth


<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Data Waktu Tidak Bersedia Dosen</h3>
            </div>
            <div class="card-header">
                <a href="wtb/add">

                    <button type="button" class="btn btn-primary"><i class="fas fa-plus-square"></i> Tambah Data</button>
                </a>
            </div>


            <div class="card-body">
                <table class="table table-bordered text-center" id="wtb">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th>NIP / NIDN</th>
                            <th>Nama dosen</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        console.log('awad')
        let wtb = $('#wtb').DataTable({
            processing: true,
            serverside: true,
            // responsive: true,
            ajax: {
                url: "{{route('wtb.datatable')}}",
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
                    data: 'nidn',
                    name: 'nidn'
                },
                {
                    data: 'nm',
                    name: 'nm'
                },
                {
                    data: 'hr',
                    name: 'hr'
                },
                {
                    data: 'range_jam',
                    name: 'range_jam'
                },

                {
                    data: 'action',
                    name: 'action'
                },


            ]
        })

        $('#btnFilter').click(function(e) {
            e.preventDefault()
            wtb.ajax.reload();
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
