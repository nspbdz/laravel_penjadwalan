@extends('layouts.main')

@section('content')

@auth


<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Data Jadwal Kuliah</h3>
            </div>
            <div class="card-header">
                <form class="form" method="POST" action="{{route('schedule.test')}}">
                    {{ csrf_field() }}
                    <label> Akademik</label>
                    <select id="semester_tipe" name="semester_tipe" class="form-control">
                        <option value="1" <?php echo isset($semester_tipe) ? ($semester_tipe === '1' ? 'selected' : '') : ''; ?> /> GANJIL
                        <option value="0" <?php echo isset($semester_tipe) ? ($semester_tipe === '0' ? 'selected' : '') : ''; ?> /> GENAP
                    </select>
                    <label>Tahun Akademik</label>
                    <select id="tahun_akademik" name="tahun_akademik" class="form-control">
                        <option value="2020-2021" <?php echo isset($tahun_akademik) ? ($tahun_akademik === '2020-2021' ? 'selected' : '') : ''; ?> /> 2020-2021
                        <option value="2021-2022" <?php echo isset($tahun_akademik) ? ($tahun_akademik === '2021-2022' ? 'selected' : '') : ''; ?> /> 2021-2022
                        <option value="2022-2023" <?php echo isset($tahun_akademik) ? ($tahun_akademik === '2022-2023' ? 'selected' : '') : ''; ?> /> 2022-2023

                    </select>

                    <label>Jumlah Populasi</label>
                    <input type="text" class="form-control" name="jumlah_populasi" value="<?php echo isset($jumlah_populasi) ? $jumlah_populasi : '10'; ?>">
            </div>
            <div class=" card-header">
                <label>Probabilitas CrossOver</label>
                <input type="text" class="form-control" name="probabilitas_crossover" value="<?php echo isset($probabilitas_crossover) ? $probabilitas_crossover : '0.70'; ?>">

                <label>Probabilitas Mutasi</label>
                <input type="text" class="form-control" name="probabilitas_mutasi" value="<?php echo isset($probabilitas_mutasi) ? $probabilitas_mutasi : '0.40'; ?>">

                <label>Jumlah Generasi</label>
                <input type="text" class="form-control" name="jumlah_generasi" value="<?php echo isset($jumlah_generasi) ? $jumlah_generasi : '1000'; ?>">
            </div>
            <div class="card-header">
                <button type="submit" class=" btn btn-danger pull-left" onclick="ShowProgressAnimation();">Proses</button>
                <a class="btn btn-info" href="{{ route('schedule.export') }}">Export Excel</a>
            </div>
            <div class="card-header">
                <label> Masukan Prodi</label>

                <select name="prodi" id="prodiDropdown" class="form-control">
                    <option value="">== Pilih Prodi ==</option>
                    <option value="rpl" @selected('rpl'==$prodi)>Rekayasa Perangkat Lunak</option>
                    <option value="ti" @selected('ti'==$prodi)>Teknik Informatika</option>
                </select>
            </div>
            </form>
            <br><br>
        </div>

        <div id="content_ajax">

            <div class="pagination pull-right" id="ajax_paging">
                <ul>

                </ul>
            </div>



        </div>
        @if($prodi == '' || $prodi == 'ti')
        <h3>Ini Data Bentrok TI</h3>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Kode jam</th>
                        <th>Sesi</th>
                        <th>Jam</th>
                        <th>Kelas</th>
                        <th>matakuliah</th>
                        <th>Dosen</th>
                        <th>SKS</th>
                        <th>Semester</th>

                        <th>Ruang</th>

                    </tr>
                    @foreach($bentrokdata as $data)


                    <tr style="background: yellow;">
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data [0] }}</td>
                        <td>
                            <select class="form-control kode-jam-dropdown" id="kode-jam-dropdown" name="kode-jam-dropdown" data-row="{{ $loop->index }}" data-id="{{$data[10]}}">
                                <option value="">{{$data[1]}}</option>
                                <option value="1" {{ $data[1] == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $data[1] == '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $data[1] == '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ $data[1] == '4' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ $data[1] == '5' ? 'selected' : '' }}>5</option>
                                <option value="6" {{ $data[1] == '6' ? 'selected' : '' }}>6</option>
                                <option value="7" {{ $data[1] == '7' ? 'selected' : '' }}>7</option>
                                <option value="8" {{ $data[1] == '8' ? 'selected' : '' }}>8</option>
                                <option value="9" {{ $data[1] == '9' ? 'selected' : '' }}>9</option>
                                <option value="10" {{ $data[1] == '10' ? 'selected' : '' }}>10</option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                            </select>
                        </td>
                        <td>{{ $data [2] }}</td>
                        <td>{{ $data [3] }}</td>
                        <td>{{ $data [8] }}</td>
                        <td>{{ $data [4] }}</td>
                        <td>{{ $data [5] }}</td>
                        <td>{{ $data [6] }}</td>
                        <td>{{ $data [7] }}</td>

                        <td>{{ $data [9] }}</td>

                    </tr>
                    @endforeach
                </table>
            </div>
        </div>


        <h3>Ini Data Tidak Bentrok TI</h3>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Sesi</th>
                        <th>Jam</th>
                        <th>Kelas</th>
                        <th>matakuliah</th>
                        <th>Dosen</th>
                        <th>SKS</th>
                        <th>Semester</th>

                        <th>Ruang</th>

                    </tr>

                    @foreach($tidakBentrok as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data [0] }}</td>
                        <td>{{ $data [1] }}</td>
                        <td>{{ $data [2] }}</td>
                        <td>{{ $data [7] }}</td>
                        <td>{{ $data [3] }}</td>

                        <td>{{ $data [4] }}</td>
                        <td>{{ $data [5] }}</td>
                        <td>{{ $data [6] }}</td>

                        <td>{{ $data [9] }}</td>

                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <h3>Jadwal Kuliah Prodi TI</h3>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>kode jam</th>
                        <th>Sesi</th>
                        @foreach($kelasti as $item)

                        <th>{{$item ->nama}}</th>
                        @endforeach


                    </tr>

                    @foreach($viewti as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data->Hari }}</td>
                        <td>{{ $data->kode_jam }}</td>
                        <td>{{ $data->jam }}</td>
                        <td>{{ $data->D3TI1A }}</td>
                        <td>{{ $data->D3TI1B }}</td>

                        <td>{{ $data->D3TI1C }}</td>
                        <td>{{ $data->D3TI2A }}</td>
                        <td>{{ $data->D3TI2B }}</td>

                        <td>{{ $data->D3TI2C }}</td>
                        <td>{{ $data->D3TI3A }}</td>
                        <td>{{ $data->D3TI3B }}</td>

                        <td>{{ $data->D3TI3C }}</td>

                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endif

        @if($prodi == '' || $prodi == 'rpl')
        <h3>Ini Data Bentrok RPL</h3>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Sesi</th>
                        <th>Jam</th>
                        <th>Kelas</th>
                        <th>matakuliah</th>
                        <th>Dosen</th>
                        <th>SKS</th>
                        <th>Semester</th>

                        <th>Ruang</th>

                    </tr>
                    @foreach($bentrokdatarpl as $data)

                    <tr style="background: yellow;">
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data [0] }}</td>
                        <td>{{ $data [1] }}</td>
                        <td>{{ $data [2] }}</td>
                        <td>{{ $data [7] }}</td>
                        <td>{{ $data [3] }}</td>
                        <td>{{ $data [4] }}</td>
                        <td>{{ $data [5] }}</td>
                        <td>{{ $data [6] }}</td>

                        <td>{{ $data [8] }}</td>

                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <h3>Ini Data Tidak Bentrok RPL</h3>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Sesi</th>
                        <th>Jam</th>
                        <th>Kelas</th>
                        <th>matakuliah</th>
                        <th>Dosen</th>
                        <th>SKS</th>
                        <th>Semester</th>

                        <th>Ruang</th>

                    </tr>

                    @foreach($tidakBentrokrpl as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data [0] }}</td>
                        <td>{{ $data [1] }}</td>
                        <td>{{ $data [2] }}</td>
                        <td>{{ $data [7] }}</td>
                        <td>{{ $data [3] }}</td>

                        <td>{{ $data [4] }}</td>
                        <td>{{ $data [5] }}</td>
                        <td>{{ $data [6] }}</td>

                        <td>{{ $data [8] }}</td>

                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <h3>Jadwal Kuliah Prodi RPL</h3>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>kode jam</th>
                        <th>Sesi</th>
                        @foreach($kelasrpl as $item)

                        <th>{{$item ->nama}}</th>
                        @endforeach


                    </tr>

                    @foreach($viewrpl as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data->Hari }}</td>
                        <td>{{ $data->kode_jam }}</td>
                        <td>{{ $data->jam }}</td>
                        <td>{{ $data->D4RPL1A }}</td>
                        <td>{{ $data->D4RPL1B }}</td>
                        <td>{{ $data->D4RPL1C }}</td>
                        <td>{{ $data->D4RPL2A }}</td>
                        <td>{{ $data->D4RPL2B }}</td>
                        <td>{{ $data->D4RPL3 }}</td>
                        <td>{{ $data->D4RPL4 }}</td>


                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endif
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
<script>

</script>
@endauth

@guest

<p>guest day</p>
@endguest
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.kode-jam-dropdown').on('change', function() {
            var row = $(this).data('row');
            var id = $(this).data('id');
            var kodeJam = $(this).val();
            // Kirim permintaan AJAX ke endpoint untuk mengupdate kode jam dalam database
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route("schedule.updateKodeJam")}}', // Ganti dengan URL endpoint Laravel Anda
                method: 'POST',
                data: {
                    id: id,
                    row: row,
                    kodeJam: kodeJam
                },
                success: function(response) {

                    // Lakukan tindakan lain setelah berhasil mengupdate kode jam
                    if (response.success) {
                        // Refresh halaman setelah menerima respons sukses
                        location.reload();
                    } else {
                        alert('Data Bentrok');
                    }
                }
            });
        });

        $('#prodiDropdown').on('change', function() {
            var prodi = $(this).val();

            var currentUrl = "{{route('schedule.index')}}";

            // Menambahkan query GET yang diinginkan
            var updatedUrl = currentUrl + '?getprodi=' + prodi;

            // Melakukan refresh halaman dengan URL yang diperbarui
            window.location.href = updatedUrl;
        });
    });
</script>
@endpush