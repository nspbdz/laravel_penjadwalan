@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Daftar Surat Pemberitahuan</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card" style="width: 100%;">
                    <div class="card-header">
                        <a href="" class="btn btn-primary"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;&nbsp;Tambah</a>
                    </div>
                    <div class="card-body pb-0">
                        <form action="#" id="filterPrice">
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
                        </form>
                    </div>
                    <br>
                    <div class="card-body">
                        <!-- <div class="table-responsive"> -->
                        <table class="table table-bordered" id="suratPemberitahuan">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>No. Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Jenis Surat</th>
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

<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let suratPemberitahuan = $('#suratPemberitahuan').DataTable({
            processing: true,
            serverside: true,
            // responsive: true,
            ajax: {
                url: "",
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
                    data: 'no_surat',
                    name: 'no_surat'
                },
                {
                    data: 'tanggal_surat',
                    name: 'tanggal_surat'
                },
                {
                    data: 'jenis_surat',
                    name: 'jenis_surat'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        })

        $('#btnFilter').click(function(e) {
            e.preventDefault()
            suratMasuk.ajax.reload();
        })
    });


    function deleteSuratPemberitahuan(id) {
        console.log(id)

        swal({
                title: "Yakin ?",
                text: "Anda akan menghapus Surat ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "/suratPemberitahuan/" + id,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            toastr.success('Surat berhasil dihapus', 'Berhasil')
                            table.draw()
                        },
                        error: function(err) {
                            toastr.error(
                                'Terjadi kesalahan saat menghapus Surat',
                                'Perhatian')
                        }
                    })
                    swal("Surat berhasil dihapus", {
                        icon: "success",
                    }).then(() => window.location.reload());
                } else {
                    swal("Surat tidak jadi dihapus");
                }
            });
    }

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

@endpush
