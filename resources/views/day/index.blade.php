@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Daftar Surat Masuk</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card" style="width: 100%;">
                    <div class="card-header">
                    </div>
                    <div class="card-body pb-0">
                        <!-- <form action="#" id="filterPrice">
                            <div class="row">
                                <div class="col-xl-3 col-md-3 col-12">
                                    <label class="form-label" for="">Tanggal Awal</label>
                                    <input type="date" data-date-format="yyyy-MM-dd" class="form-control" name="awal" id="awal">
                                </div>
                                <div class="col-xl-3 col-md-3 col-12">
                                    <label class="form-label" for="">Tanggal Akhir</label>
                                    <input type="date" data-date-format="yyyy-MM-dd" class="form-control" name="akhir" id="akhir">
                                </div>
                                <div class="d-flex col-xl-3 col-md-3 align-items-center mt-4 gap-2">
                                    <button type="button" class="btn btn-primary" id="btnFilter"><i data-feather='filter'></i>&nbsp;Filter</button>
                                </div>
                            </div>
                        </form> -->
                    </div>
                    <br>

                    <div class="card-body">
                        <!-- <div class="table-responsive"> -->
                        <table class="table table-bordered text-center" id="day">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>Nama</th>

                                    <th>Opsi</th>
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
</section>

<!-- Datatables -->
<!-- <link rel="stylesheet" href="{{asset('assets/modules/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}"> -->

<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        console.log('awad')
        let day = $('#day').DataTable({
            processing: true,
            serverside: true,
            // responsive: true,
            ajax: {
                url: "{{route('day.datatable')}}",
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
                    data: 'action',
                    name: 'action'
                },


            ]
        })

        $('#btnFilter').click(function(e) {
            e.preventDefault()
            day.ajax.reload();
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

<script>
    console.log('hello');
</script>
@endsection
<!-- @push('scripts') -->

<!-- @endpush -->
