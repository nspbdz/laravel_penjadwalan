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
                <form class="form" method="GET" action="/algoritma">
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
            <div class="form">
                <button type="submit" class=" btn btn-danger pull-left" onclick="ShowProgressAnimation();">Proses</button>

            </div>
            </form>
            <br><br>
            <div>
                <a class="btn btn-info" href="{{ route('schedule.export') }}">Export Excel</a>

            </div>
            <br>

            <form> <a href="<?php //echo base_url();
                            ?>ProccessController/excel_report"> <button class="btn btn-success pull-right"><i class="icon-plus"></i> Export to Excel</button></a></form>



            <!-- <div id="loading-div-background">
      <div id="loading-div" class="ui-corner-all">
      <img style="height:50px;width:50px;margin:30px;" src="<?php //echo base_url()
                                                            ?>assets/img/please_wait.gif" alt="Loading.."/><br>Sedang Memproses<br>Tunggu Beberapa Menit
      </div>
    </div> -->


            <!--
    <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">�</button>
      Tidak ada data.
        </div>
    -->

        </div>

        <div id="content_ajax">

            <div class="pagination pull-right" id="ajax_paging">
                <ul>
                    <?php //echo $this->pagination->create_links();
                    ?>
                </ul>
            </div>



        </div>

        <h3>Ini Data Bentrok</h3>
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
                    @foreach($bentrokdata as $data)


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
        <h3>Ini Data Tidak Bentrok</h3>
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

                        <td>{{ $data [8] }}</td>

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